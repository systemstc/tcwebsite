<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title_hi',
        'title_en',
        'link_url',
        'is_new',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'is_active' => 'boolean',
    ];
}
