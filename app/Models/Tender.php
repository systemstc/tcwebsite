<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $fillable = [
        'reference_no',
        'title_hi',
        'title_en',
        'type',
        'published_date',
        'closing_date',
        'document_url',
        'status',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'published_date' => 'date',
        'closing_date' => 'date',
        'is_active' => 'boolean',
    ];
}
