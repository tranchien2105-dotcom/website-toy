<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function listProductsApi(Request $request)
    {
        $query = Product::with('category');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Sort
        |--------------------------------------------------------------------------
        */

        switch ($request->sort_by) {

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            default:
                $query->latest();
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $products = $query->paginate($request->per_page ?? 10);

        return response()->json($products);
    }

    public function getProductApi($id)
    {
        $product = Product::with('category')->findOrFail($id);
 
        return response()->json($product);
    }

    public function createProductsApi(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',

            'brand_id' => 'nullable|exists:brands,id',

            'name' => 'required|string|max:255',

            'price' => 'required|numeric|min:0',

            'stock' => 'required|integer|min:0',

            'description' => 'nullable|string',

            'status' => 'required|boolean',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $imageName = null;

        if ($request->hasFile('image')) {

            $imageName = time() . '.' .
                $request->image->extension();

            $request->image->move(
                public_path('layout/images/products'),
                $imageName
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */
        $slug = Str::slug($request->name, '-');
        $product = Product::create([
            'category_id' => $request->category_id,
            'brand_id' => 1,

            'name' => $request->name,
            'slug' => $slug,
            'price' => $request->price,
            'stock' => $request->stock,

            'description' => $request->description,

            'status' => $request->status,

            'image' => $imageName,
        ]);

        return response()->json([
            'message' => 'Thêm sản phẩm thành công',
            'data' => $product
        ], 201);
    }

    public function deleteProductApi($id)
    {
        $product = Product::findOrFail($id);

        $product->delete(); 

        return response()->json([
            'message' => 'Xóa sản phẩm thành công'
        ]);
    }
}
