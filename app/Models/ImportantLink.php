<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportantLink extends Model
{
    protected $fillable = [
        'title_hi',
        'title_en',
        'url',
        'target',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
