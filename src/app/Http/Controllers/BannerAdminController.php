<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerAdminController extends Controller
{
    public function listBanners()
    {
        $banners = Banner::all();
        return view('admin.banners.list', compact('banners'));
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
}
