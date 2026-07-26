<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'site_name' => 'Tạp hóa MinhChiến',
            'slogan' => 'Giá tốt mỗi ngày',

            'primary_color' => '#0d8fd8',
            'secondary_color' => '#28a745',

            'email' => 'admin@gmail.com',
            'phone' => '0123456789',
            'address' => 'Hồ Chí Minh',

            'footer_text' => 'Cảm ơn quý khách đã mua hàng.',
            'copyright' => '©2026 MinhChiến Store',

            'facebook' => '',
            'youtube' => '',
            'tiktok' => '',
            'instagram' => '',
            'zalo' => '',

            'meta_title' => 'Tạp hóa MinhChiến',
            'meta_description' => 'Website bán hàng Laravel',
            'meta_keywords' => 'tap hoa,minhchien,laravel'
        ]);
    }
}