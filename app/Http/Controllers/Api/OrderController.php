<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {

        $orders = \App\Models\Order::with('orderItems.product')->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Order',
            'data' => $orders
        ], 200);
    }


    public function show($id)
    {
        $order = \App\Models\Order::with('orderItems.product')->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Order',
            'data' => $order
        ], 200);
    }


    //store order and order item
    public function store(Request $request)
    {
        $request->validate([
            'transaction_time' => 'required',
            'kasir_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'total_item' => 'required|numeric',
            'payment_method' => 'required',
            'nominal_bayar' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|numeric',
            'order_items.*.total_price' => 'required|numeric',
            'card_number' => 'nullable|string|max:25',
            'card_holder' => 'nullable|string|max:100',
        ]);

        // hitung kembalian
        $kembalian = (($request->nominal_bayar - $request->total_price)>=0?$request->nominal_bayar - $request->total_price : 0);
        $paymentStatus = $request->nominal_bayar >= $request->total_price ? 'success' : 'pending';

        $order = \App\Models\Order::create([
            'transaction_time' => $request->transaction_time,
            'kasir_id' => $request->kasir_id,
            'total_price' => $request->total_price,
            'total_item' => $request->total_item,
            'payment_method' => $request->payment_method,
            'nominal_bayar' => $request->nominal_bayar,
            'kembalian' => $kembalian,
            'payment_status' => $paymentStatus,
            'card_number' => $request->card_number,
            'card_holder' => $request->card_holder,
        ]);


        foreach ($request->order_items as $item) {

            $product = \App\Models\Product::find($item['product_id']);


            if ($product->stock < $item['quantity']) {

                $order->delete();

                return response()->json([
                    'success' => false,
                    'message' => "Stok produk '{$product->name}' tidak mencukupi.",
                ], 400);
            }


            $product->decrement('stock', $item['quantity']);

            // Simpan order item
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price'],
            ]);
        }


        //response
        return response()->json([
            'success' => true,
            'message' => 'Order Created',
            'data' => [
                'id' => $order->id
            ]
        ], 201);
    }



    public function storeCheckout(Request $request)
    {
        $request->validate([
            'transaction_time' => 'required',
            'kasir_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'total_item' => 'required|numeric',
            'payment_method' => 'required',
            'nominal_bayar' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|numeric',
            'order_items.*.total_price' => 'required|numeric',
        ]);

        $kembalian = $request->nominal_bayar - $request->total_price;
        $paymentStatus = $request->nominal_bayar >= $request->total_price ? 'success' : 'pending';

        $order = \App\Models\Order::create([
            'transaction_time' => $request->transaction_time,
            'kasir_id' => $request->kasir_id,
            'total_price' => $request->total_price,
            'total_item' => $request->total_item,
            'payment_method' => $request->payment_method,
            'nominal_bayar' => $request->nominal_bayar,
            'kembalian' => $kembalian,
            'payment_status' => $paymentStatus,
        ]);

        foreach ($request->order_items as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Checkout berhasil dibuat',
            'data' => $order
        ], 201);
    }


}
