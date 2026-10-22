<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title_hi',
        'title_en',
        'content_hi',
        'content_en',
        'banner_image',
        'is_active',
        'menu_location',
        'sort_order',
        'template_type',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
