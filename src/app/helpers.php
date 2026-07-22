<?php

use App\Models\Category;

if (!function_exists('getCategories')) {

    function getCategories($isRoot = false)
    {
        $query = Category::where('status', 1);

        if ($isRoot) {
            $query->whereNull('parent_id');
        }

        return $query
            ->select('id', 'name', 'slug', 'parent_id')
            ->distinct()
            ->get();
    }
}