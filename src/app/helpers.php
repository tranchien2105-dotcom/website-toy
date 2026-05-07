<?php

use App\Models\Category;

if (!function_exists('getCategories')) {

    function getCategories()
    {
        return Category::where('status', 1)
            ->select('id', 'name', 'slug', 'parent_id')
            ->distinct()
            ->get();
    }
}