<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'star',
        'review_count',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'star' => 'decimal:1',
        'status' => 'boolean',
    ];

    // public function brand()
    // {
    //     return $this->belongsTo(Brand::class);
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}