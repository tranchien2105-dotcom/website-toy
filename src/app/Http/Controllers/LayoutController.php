<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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

        $tagsCategory = Category::with('products')
            ->where('status', 1)
            ->distinct()
            ->take(6)
            ->get();

        $banners = Banner::where('status', 1)   
            ->orderBy('position', 'asc')
            ->get();


        return view('layouts.home', compact('products', 'categories', 'tagsCategory', 'banners'));
    }

    public function addCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        session(['cart' => $cart]);

        $totalQty = 0;
        $grandTotal = 0;

        foreach ($cart as $item) {
            $totalQty += $item['quantity'];
            $grandTotal += $item['price'] * $item['quantity'];
        }

        $html = view('cart.mini_cart_items', compact('cart'))->render();

        return response()->json([
            'qty' => $totalQty,
            'total' => number_format($grandTotal, 0, ',', '.') . '₫',
            'html' => $html
        ]);
    }
    public function cart()
    {
        $cartItems = session()->get('cart', []);
        return view('cart.shopping_cart', compact('cartItems'));
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('layout.cart')->with('success', 'Product removed from cart successfully!');
    }

}