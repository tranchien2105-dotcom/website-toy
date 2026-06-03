<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryAdminController extends Controller
{
    public function listCategories()
    {
        $categories = Category::with('parent')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.categories.list', compact('categories'));
    }

    public function listCategoriesApi(Request $request)
    {
        $query = Category::where('parent_id', null)
            ->with('children');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->get();

        return response()->json($categories);
    }

    public function createCategory()
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.categories.create', compact('categories'));
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:1,0',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Category created successfully.');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('parent_id', null)
            ->where('id', '!=', $id)
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:1,0',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Category updated successfully.');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        // Kiểm tra có category con không
        $hasChildren = Category::where('parent_id', $category->id)->exists();

        if ($hasChildren) {
            return redirect()
                ->route('admin.categories')
                ->with('error', 'Cannot delete category because it has child categories.');
        }

        // Kiểm tra có sản phẩm thuộc category không
        $hasProducts = Product::where('category_id', $category->id)->exists();

        if ($hasProducts) {
            return redirect()
                ->route('admin.categories')
                ->with('error', 'Cannot delete category because products belong to this category.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Category deleted successfully.');
    }
}
