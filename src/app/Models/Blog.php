<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'image',
        'title',
        'slug',
        'description',
        'created_by',
        'category',
        'date_from',
        'date_to',
        'comment',
        'status'
    ];
}