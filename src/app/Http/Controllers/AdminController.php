<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function listProducts()
    {
        $products = Product::with('category')->latest()->get();

        return view('admin.products.list', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->name, '-');

        // nếu slug bị trùng
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . time();
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => null,
            'star' => 0,
            'review_count' => 0,
            'status' => $request->status ?? 1,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('layout/images/products'), $imageName);

            $product->update([
                'image' => $imageName
            ]);
        }

        toastr()->success('Data has been saved successfully!');
        return redirect()->route('admin.products');

    }
}