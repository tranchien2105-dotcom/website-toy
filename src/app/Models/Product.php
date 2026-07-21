<?php

namespace App\Models;

use App\Models\OrderDetail;
use App\Models\ProductImage;
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

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}