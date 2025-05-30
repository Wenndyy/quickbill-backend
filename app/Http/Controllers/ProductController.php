<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //get data products
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('pages.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $data = $request->all();

        $category = DB::table('categories')->where('id', $request->category_id)->first();

        $product = new \App\Models\Product;
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category = $category->name;
        $product->category_id = $request->category_id;
        $product->image = $filename;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);

        $request->validate([
            'name' => 'nullable|min:3|unique:products,name,' . $id,
            'price' => 'nullable|integer',
            'stock' => 'nullable|integer',
            'category' => 'nullable|in:food,drink,snack',
            'image' => 'nullable|image|mimes:png,jpg,jpeg'
        ]);


        $data = [
            'name' => $request->filled('name') ? $request->name : $product->name,
            'price' => $request->filled('price') ? (int) $request->price : $product->price,
            'stock' => $request->filled('stock') ? (int) $request->stock : $product->stock,
            'category' => $request->filled('category') ? $request->category : $product->category,
            'image' => $product->image,
        ];

        if ($request->hasFile('image')) {

            if ($product->image) {
                $oldImagePath = storage_path("app/public/products/{$product->image}");
                $oldImagePublicPath = public_path("products/{$product->image}");

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                if (file_exists($oldImagePublicPath)) {
                    unlink($oldImagePublicPath);
                }
            }



            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);


            $data['image'] = $filename;
        }


        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }


    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);

        if ($product->image) {
            $imagePath = storage_path("app/public/products/{$product->image}");
            $imagePublicPath = public_path("products/{$product->image}");

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            if (file_exists($imagePublicPath)) {
                unlink($imagePublicPath);
            }
        }

        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
