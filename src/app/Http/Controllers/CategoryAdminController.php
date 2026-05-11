<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryAdminController extends Controller
{
    public function listCategories()
    {
        $categories = Category::with('parent')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.categories.list', compact('categories'));
    }
}
