<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        // Weekly sales data
        $weeks = [];
        $sales = [];

        for ($i = 11; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->startOfWeek()->subWeeks($i);
            $endOfWeek = Carbon::now()->endOfWeek()->subWeeks($i);

            $totalSales = DB::table('orders')
                ->whereBetween('transaction_time', [$startOfWeek, $endOfWeek])
                ->where('payment_status', 'success')
                ->sum('total_price');

            $weeks[] = 'Minggu ' . (12 - $i);
            $sales[] = $totalSales;
        }

        // Statistics cards
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::where('payment_status', 'success')->count();

        // Prediction data
        $predicted = $this->generateSalesPrediction();

        return view('pages.dashboard', compact(
            'weeks',
            'sales',
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'predicted'
        ));
    }

   protected function generateSalesPrediction()
    {
        try {
            $historicalData = OrderItem::with(['order', 'product'])
                ->whereHas('order', function ($q) {
                    $q->where('payment_status', 'success')
                    ->where('transaction_time', '>=', Carbon::now()->subDays(30));
                })
                ->take(100)
                ->get()
                ->map(function ($item) {
                    // Ensure transaction_time is parsed as Carbon instance
                    $transactionTime = Carbon::parse($item->order->transaction_time);

                    return [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'date' => $transactionTime->toDateString(), // Now properly calling on Carbon
                        'quantity_sold' => $item->quantity,
                    ];
                })
                ->toArray();

            // Save to temporary file
            $filePath = storage_path('app/public/sales_data_'.time().'.json');
            file_put_contents($filePath, json_encode($historicalData));

            // Execute Python script
            $output = [];
            $returnVar = 0;
            $command = escapeshellcmd("python3 ".base_path("gemini_predict.py")." ".escapeshellarg($filePath));
            exec($command, $output, $returnVar);

            // Clean up
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            if ($returnVar !== 0) {
                throw new \Exception("Python script failed with code: {$returnVar}");
            }

            return json_decode(implode("\n", $output), true) ?: [];

        } catch (\Exception $e) {
            Log::error('Prediction Error: '.$e->getMessage());
            return [];
        }
    }
    }
