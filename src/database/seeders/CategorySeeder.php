<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // cha
        $phone = Category::create([
            'name' => 'Điện thoại',
            'slug' => 'dien-thoai',
        ]);

        $laptop = Category::create([
            'name' => 'Laptop',
            'slug' => 'laptop',
        ]);

        // con của điện thoại
        Category::create([
            'name' => 'iPhone',
            'slug' => 'iphone',
            'parent_id' => $phone->id,
        ]);

        Category::create([
            'name' => 'Samsung',
            'slug' => 'samsung',
            'parent_id' => $phone->id,
        ]);

        // con của laptop
        Category::create([
            'name' => 'Macbook',
            'slug' => 'macbook',
            'parent_id' => $laptop->id,
        ]);

        Category::create([
            'name' => 'Asus',
            'slug' => 'asus',
            'parent_id' => $laptop->id,
        ]);
    }
}