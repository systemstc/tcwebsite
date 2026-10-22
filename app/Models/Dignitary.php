<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dignitary extends Model
{
    protected $fillable = [
        'name_hi',
        'name_en',
        'designation_hi',
        'designation_en',
        'type',
        'photo_url',
        'quote_hi',
        'quote_en',
        'quote_date',
        'profile_link',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
