<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function listProducts(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Sort
        switch ($request->sort) {
            case 'oldest':
                $query->oldest();
                break;

            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            default:
                $query->latest();
                break;
        }


        $perPage = $request->per_page ?? 10;

        $products = $query->paginate($perPage);

        return view('admin.products.list', compact('products'));
    }

    public function searchProducts(Request $request)
    {
        $keyword = $request->keyword;

        $products = Product::where('name', 'like', "%$keyword%")
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($products);
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

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function updateProduct(Request $request, $id)
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

        $product = Product::findOrFail($id);

        $slug = Str::slug($request->name, '-');

        // nếu slug bị trùng
        $count = Product::where('slug', $slug)->where('id', '<>', $id)->count();
        if ($count > 0) {
            $slug .= '-' . time();
        }

        $product->update([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status ?? 1,
        ]);

        if ($request->hasFile('image')) {
            // xóa ảnh cũ nếu có
            if ($product->image) {
                @unlink(public_path('layout/images/products/' . $product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('layout/images/products'), $imageName);

            $product->update([
                'image' => $imageName
            ]);
        }

        toastr()->success('Data has been updated successfully!');
        return redirect()->route('admin.products');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        toastr()->success('Data has been deleted successfully!');
        return redirect()->route('admin.products');
    }

    public function productGallery($id)
    {
        $product = Product::with('images')->findOrFail($id);

        return view('admin.products.gallery', compact('product'));
    }

    public function addProductGallery(Request $request, $id)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $folderPath = public_path('layout/images/products/' . $product->slug);

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        foreach ($request->file('images') as $image) {

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move($folderPath, $imageName);

            $product->images()->create([
                'image' => $product->slug . '/' . $imageName,
            ]);
        }

        toastr()->success('Gallery images uploaded successfully!');

        return redirect()->route('admin.products.gallery', $id);
    }

    public function deleteProductGallery($productId, $galleryId)
    {
        $product = Product::findOrFail($productId);

        $gallery = ProductImage::where('id', $galleryId)
            ->where('product_id', $productId)
            ->firstOrFail();

        $filePath = public_path(
            'layout/images/products/' .
            $product->slug . '/' .
            basename($gallery->image)
        );

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $gallery->delete();

        toastr()->success('Gallery image deleted successfully!');

        return back();
    }
}