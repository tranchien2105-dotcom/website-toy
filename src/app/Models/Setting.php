<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'slogan',

        'logo',
        'favicon',

        'primary_color',
        'secondary_color',

        'email',
        'phone',
        'address',

        'facebook',
        'youtube',
        'tiktok',
        'instagram',
        'zalo',

        'footer_text',
        'copyright',

        'meta_title',
        'meta_description',
        'meta_keywords',

        'google_map',
        'google_analytics'
    ];
}
