<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class ProductCommentController extends Controller
{
    public function listComments(Request $request)
    {
        $query = ProductComment::with('product');

        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->keyword) {
            $keyword = $request->keyword;
            $query->where('comment', 'like', "%$keyword%")
                ->orWhere('name', 'like', "%$keyword%");
        }

        $comments = $query->latest()->paginate($request->per_page ?? 15);

        $products = Product::select('id', 'name')->get();

        return view('admin.product_comments.list', compact('comments', 'products'));
    }

    public function toggleHidden($id)
    {
        $comment = ProductComment::findOrFail($id);
        $comment->is_hidden = !$comment->is_hidden;
        $comment->save();

        toastr()->success('Comment has been updated successfully!');

        return back();
    }

    public function listCommentsApi(Request $request)
    {
        $query = ProductComment::with('product');

        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->keyword) {
            $keyword = $request->keyword;
            $query->where('comment', 'like', "%$keyword%")
                ->orWhere('name', 'like', "%$keyword%");
        }

        $comments = $query->latest()->paginate($request->per_page ?? 15);

        return response()->json($comments);
    }

    public function toggleHiddenApi($id)
    {
        $comment = ProductComment::findOrFail($id);
        $comment->is_hidden = !$comment->is_hidden;
        $comment->save();

        return response()->json([
            'message' => 'Comment updated successfully.',
            'is_hidden' => $comment->is_hidden,
        ]);
    }
}
