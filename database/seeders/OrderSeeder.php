<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = ['Cash', 'Debit', 'Qris'];
        $productIds = \App\Models\Product::pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {

            $totalPrice = 50000;
            $nominalBayar = 60000;

            // Insert Order
            $order = Order::create([
                'transaction_time' => Carbon::now()->subDays(10 - $i),
                'kasir_id' => 1,
                'total_price' => $totalPrice,
                'total_item' => 2,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)], // Random metode
                'nominal_bayar' => $nominalBayar,
                'kembalian' => $nominalBayar - $totalPrice,
            ]);

            // Insert 2 Order Item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productIds[array_rand($productIds)],
                'quantity' => 1,
                'total_price' => 25000,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productIds[array_rand($productIds)],
                'quantity' => 1,
                'total_price' => 25000,
            ]);
        }
    }
}
