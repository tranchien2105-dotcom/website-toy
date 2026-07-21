<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

class OrderAdminController extends Controller
{
    public function listOrdersApi(Request $request)
    {
        $query = Order::query();

        // Tìm theo tên hoặc số điện thoại
        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        $orders = $query
            ->latest()
            ->paginate(10);

        return response()->json([
            'orders' => $orders
        ]);
    }

    public function detailOrder($id)
    {
        $order = Order::with([
            'details.product'
        ])->find($id);

        if (!$order) {

            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng.'
            ], 404);

        }

        return response()->json([
            'success' => true,
            'order' => $order
        ]);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng.'
            ], 404);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,completed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        // Gửi email
        Mail::to($order->email)->send(new OrderStatusUpdated($order));

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái đơn hàng thành công.',
            'order' => $order
        ]);
    }
}