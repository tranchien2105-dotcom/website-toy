<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class LayoutController extends Controller
{
    public function home()
    {
        $products = Product::with('category')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $categories = Category::where('status', 1)
            ->select('name', 'slug')
            ->distinct()
            ->get();

        return view('layouts.home', compact('products', 'categories'));
    }
}