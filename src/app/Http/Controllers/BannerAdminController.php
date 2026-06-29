<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerAdminController extends Controller
{
    public function listBanners()
    {
        $banners = Banner::all();
        return view('admin.banners.list', compact('banners'));
    }

    public function listBannerApi(Request $request)
    {
        $query = Banner::query();

        // Search theo title
        if ($request->search) {
            $query->where(
                'title',
                'like',
                '%' . $request->search . '%'
            );
        }

        // Sort
        switch ($request->sort_by) {

            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;

            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'position_asc':
                $query->orderBy('position', 'asc');
                break;

            default:
                $query->latest();
                break;
        }

        // Pagination
        $banners = $query->paginate(
            $request->per_page ?? 5
        );

        return response()->json($banners);
    }


    public function getBannerApi($id)
    {
        $banner = Banner::findOrFail($id);

        return response()->json($banner);
    }



    public function updateBannerApi(Request $request, $id)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Validate
            |--------------------------------------------------------------------------
            */

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'link_url' => 'nullable|string|max:500',
                'type' => 'required|string|max:50',
                'device' => 'required|string|max:50',
                'status' => 'required|integer',
                'position' => 'nullable|integer',
                'start_at' => 'nullable|date',
                'end_at' => 'nullable|date',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Find Banner
            |--------------------------------------------------------------------------
            */

            $banner = Banner::findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | Upload New Image
            |--------------------------------------------------------------------------
            */

            $imageName = $banner->image_url;

            if ($request->hasFile('image')) {

                // Xóa ảnh cũ
                $oldPath = public_path(
                    'layout/images/banners/' . $banner->image_url
                );

                if (
                    $banner->image_url &&
                    File::exists($oldPath)
                ) {
                    File::delete($oldPath);
                }

                // Upload ảnh mới
                $file = $request->file('image');

                $imageName =
                    time() . '_' .
                    $file->getClientOriginalName();

                $file->move(
                    public_path('layout/images/banners'),
                    $imageName
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Update Banner
            |--------------------------------------------------------------------------
            */

            $banner->update([
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $imageName,
                'link_url' => $request->link_url,
                'type' => $request->type,
                'device' => $request->device,
                'status' => $request->status,
                'position' => $request->position ?? 0,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at
            ]);

            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'message' => 'Cập nhật banner thành công',
                'data' => $banner
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Có lỗi xảy ra',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createBanner()
    {
        return view('admin.banners.create');
    }

    public function addBanner(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'link_url' => 'nullable|url',
            'type' => 'nullable|string',
            'device' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'status' => 'required|boolean',
            'position' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            // Tạo folder nếu chưa có
            $destinationPath = public_path('layout/images/banners');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Tạo tên file mới
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Upload ảnh
            $image->move($destinationPath, $imageName);

            // Lưu DB
            $data['image_url'] = $imageName;
        }

        Banner::create($data);

        return redirect()
            ->route('admin.banners')
            ->with('success', 'Banner created successfully.');
    }

    public function editBanner($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'link_url' => 'nullable|url',
            'type' => 'nullable|string',
            'device' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'status' => 'required|boolean',
            'position' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            // Xóa file ảnh cũ nếu tồn tại
            if ($banner->image_url) {
                $oldImagePath = public_path('layout/images/banners/' . $banner->image_url);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');

            // Tạo folder nếu chưa có
            $destinationPath = public_path('layout/images/banners');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Tạo tên file mới
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Upload ảnh
            $image->move($destinationPath, $imageName);

            // Lưu DB
            $data['image_url'] = $imageName;
        }

        $banner->update($data);

        return redirect()
            ->route('admin.banners')
            ->with('success', 'Banner updated successfully.');
    }

    public function deleteBanner($id)
    {
        $banner = Banner::findOrFail($id);

        // Xóa file ảnh nếu tồn tại
        if ($banner->image_url) {
            $imagePath = public_path('layout/images/banners/' . $banner->image_url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $banner->delete();

        return redirect()
            ->route('admin.banners')
            ->with('success', 'Banner deleted successfully.');
    }

    public function storeBannerApi(Request $request)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Validate
            |--------------------------------------------------------------------------
            */

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'link_url' => 'nullable|string|max:500',
                'type' => 'required|string|max:50',
                'device' => 'required|string|max:50',
                'status' => 'required|integer',
                'position' => 'nullable|integer',
                'start_at' => 'nullable|date',
                'end_at' => 'nullable|date',

                // create thì bắt buộc có ảnh
                'image' => 'required|image|mimes:jpg,jpeg,png,webp'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Upload Image
            |--------------------------------------------------------------------------
            */

            $imageName = null;

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $imageName =
                    time() . '_' .
                    $file->getClientOriginalName();

                $file->move(
                    public_path('layout/images/banners'),
                    $imageName
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Create Banner
            |--------------------------------------------------------------------------
            */

            $banner = Banner::create([
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $imageName,
                'link_url' => $request->link_url,
                'type' => $request->type,
                'device' => $request->device,
                'status' => $request->status,
                'position' => $request->position ?? 0,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,

                // mặc định chưa click
                'click_count' => 0
            ]);

            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'message' => 'Thêm banner thành công',
                'data' => $banner
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
