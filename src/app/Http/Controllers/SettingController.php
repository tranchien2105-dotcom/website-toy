<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $setting = Setting::firstOrFail();

        $data = $request->validated();

        if ($request->hasFile('logo')) {

            if ($setting->logo) {

                Storage::disk('public')
                    ->delete($setting->logo);

            }

            $data['logo'] = $request
                ->file('logo')
                ->store('settings', 'public');

        }

        if ($request->hasFile('favicon')) {

            if ($setting->favicon) {

                Storage::disk('public')
                    ->delete($setting->favicon);

            }

            $data['favicon'] = $request
                ->file('favicon')
                ->store('settings', 'public');

        }

        $setting->update($data);

        Cache::forget('settings');

        return response()->json([

            'message' => 'Cập nhật thành công',

            'setting' => $setting

        ]);
    }

    public function show()
    {
        $setting = Setting::firstOrFail();

        return response()->json([
            ...$setting->toArray(),

            'logo_url' => $setting->logo
                ? asset('storage/' . $setting->logo)
                : null,

            'favicon_url' => $setting->favicon
                ? asset('storage/' . $setting->favicon)
                : null,
        ]);
    }
}