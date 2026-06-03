<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'link_url',
        'status',
        'position',
        'type',
        'device',
        'start_at',
        'end_at',
        'click_count'
    ];
}
