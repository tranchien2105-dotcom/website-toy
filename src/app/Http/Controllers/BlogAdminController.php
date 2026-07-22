<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class BlogAdminController extends Controller
{
    public function listBlogsApi(Request $request)
    {
        $blogs = Blog::query()
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->category);
            })
            ->when($request->filled('created_by'), function ($query) use ($request) {
                $query->where('created_by', $request->created_by);
            })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                $query->whereDate('date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                $query->whereDate('date', '<=', $request->date_to);
            })
            ->latest()
            ->paginate($request->input('per_page', 10));

        return response()->json($blogs);
    }

    public function storeBlogApi(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:255',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'comment' => 'nullable|integer|min:0',
            'status' => 'nullable|string|in:Draft,Published,Archived',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(
                public_path('layout/images/blogs'),
                $imageName
            );
        }

        $blog = Blog::create([
            ...$validatedData,
            'image' => $imageName,
            'slug' => Str::slug($request->title, '-'),
            'status' => $request->status ?? 'Draft',
            'created_by' => Auth::user()?->name,
        ]);

        return response()->json($blog, 201);
    }

    public function detailBlog($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    public function updateBlog(Request $request, $id)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'status' => 'required|in:Draft,Published,Archived',
        ]);

        $blog = Blog::findOrFail($id);

        // Upload ảnh mới
        if ($request->hasFile('image')) {

            // Xóa ảnh cũ
            if (
                $blog->image &&
                file_exists(public_path('layout/images/blogs/' . $blog->image))
            ) {
                unlink(public_path('layout/images/blogs/' . $blog->image));
            }

            $image = $request->file('image');

            $fileName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(
                public_path('layout/images/blogs'),
                $fileName
            );

            $validated['image'] = $fileName;
        }

        $blog->update($validated);

        return response()->json([
            'message' => 'Cập nhật blog thành công',
            'data' => $blog
        ]);
    }
}