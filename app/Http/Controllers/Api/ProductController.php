<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //all products
        $products = \App\Models\Product::orderBy('id', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Product',
            'data' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $category = \App\Models\Category::where('id', $request->category_id)->first();
        $product = \App\Models\Product::create([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category_id' => $request->category_id,
            'category' => $category->name,
            'image' => $filename,
            'is_best_seller' => $request->is_best_seller
        ]);

        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Product Created',
                'data' => $product
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Failed to Save',
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = \App\Models\Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Product',
            'data' => $product,
        ], 200);
    }



   /**
 * Update the specified resource in storage.
 */
    public function update(Request $request, string $id)
    {
        // Cari produk berdasarkan ID
        $product = \App\Models\Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product Not Found',
            ], 404);
        }

        // Validasi request
        $rules = [
            'name' => 'required|min:3',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required',
        ];

        // Jika ada image baru, tambahkan validasi image
        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:png,jpg,jpeg';
        }

        $request->validate($rules);

        // Jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            Storage::delete('public/products/' . $product->image);

            // Upload gambar baru
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
        } else {
            $filename = $product->image;
        }

        // Ambil nama kategori
        $category = \App\Models\Category::where('id', $request->category_id)->first();

        // Update produk
        $product->update([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category_id' => $request->category_id,
            'category' => $category->name,
            'image' => $filename,
            'is_best_seller' => $request->is_best_seller ?? $product->is_best_seller

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product Updated Successfully',
            'data' => $product->fresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = \App\Models\Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product Not Found',
            ], 404);
        }

        \App\Models\OrderItem::where('product_id', $product->id)->delete();

        // Hapus gambar di storage
        Storage::delete('public/products/' . $product->image);

        // Hapus data product
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product Deleted Successfully',
        ], 200);
    }

}
