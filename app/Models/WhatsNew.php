<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsNew extends Model
{
    protected $fillable = [
        'title_hi',
        'title_en',
        'category',
        'content_hi',
        'content_en',
        'date',
        'link_url',
        'document_url',
        'file_size',
        'is_new',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'is_new' => 'boolean',
        'is_active' => 'boolean',
    ];
}
