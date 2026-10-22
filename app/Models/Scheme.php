<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    protected $fillable = [
        'title_hi',
        'title_en',
        'description_hi',
        'description_en',
        'category',
        'link_url',
        'guidelines_doc',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
