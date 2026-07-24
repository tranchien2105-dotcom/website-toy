<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

        $topSellingProducts = Product::with('category')
            ->where('status', 1)
            ->take(8)
            ->get();


        $blogs = Blog::where('status', 'Published')
            ->whereDate('date_from', '<=', Carbon::today())
            ->whereDate('date_to', '>=', Carbon::today())
            ->take(6)
            ->get();

        return view('layouts.home', compact('products', 'categories', 'tagsCategory', 'banners', 'topSellingProducts', 'blogs'));
    }

    public function detailProduct($slug)
    {
        $product = Product::with('category', 'images')->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $categories = Category::where('status', 1)
            ->select('name', 'slug')
            ->distinct()
            ->get();

        return view('layouts.product_detail', compact('product', 'relatedProducts', 'categories'));
    }

    public function checkout()
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('layout.cart')
                ->with('error', 'Giỏ hàng đang trống.');
        }

        $subtotal = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = 30000;
        $discount = 0;
        $total = $subtotal + $shipping - $discount;

        return view('cart.payment_methods', compact(
            'cartItems',
            'subtotal',
            'shipping',
            'discount',
            'total'
        ));
    }

    public function storeCheckout(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('layout.cart');
        }

        DB::beginTransaction();

        try {

            $subtotal = 0;

            foreach ($cart as $item) {

                $subtotal += $item['price'] * $item['quantity'];

            }

            $shipping = 30000;

            $discount = 0;

            $total = $subtotal + $shipping - $discount;

            $order = Order::create([

                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'note' => $request->note,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'discount' => $discount,
                'total' => $total,
                'status' => 'pending',

            ]);

            foreach ($cart as $item) {

                OrderDetail::create([

                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],

                ]);

            }

            session()->forget('cart');

            DB::commit();

            return redirect()->route('order.success', $order->id)->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());

        }
    }

    public function orderSuccess($id)
    {
        $order = Order::findOrFail($id);
        return view('cart.order_success', compact('order'));
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

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->id;
        $quantity = max(1, (int) $request->quantity);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        $subTotal = $cart[$id]['price'] * $cart[$id]['quantity'];

        $grandTotal = 0;

        foreach ($cart as $item) {
            $grandTotal += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'rowTotal' => number_format($subTotal, 0, ',', '.') . '₫',
            'grandTotal' => number_format($grandTotal, 0, ',', '.') . '₫',
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

        return redirect()->route('layout.cart')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    public function loginLayout()
    {
        return view('layouts.login');
    }

}