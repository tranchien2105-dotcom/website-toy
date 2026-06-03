<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'status',
    ];

    // category cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // category con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}