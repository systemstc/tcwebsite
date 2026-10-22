<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title_hi',
        'title_en',
        'subtitle_hi',
        'subtitle_en',
        'image_url',
        'link_url',
        'link_text_hi',
        'link_text_en',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
