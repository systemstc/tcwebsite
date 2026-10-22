<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title_hi',
        'title_en',
        'category',
        'description_hi',
        'description_en',
        'file_url',
        'file_size',
        'published_date',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_active' => 'boolean',
    ];
}
