<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustryTechIssueReply extends Model
{
    protected $fillable = [
        'issue_id',
        'name',
        'industry',
        'email',
        'phone',
        'message',
        'is_official',
        'is_approved',
    ];

    protected $casts = [
        'is_official' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function issue()
    {
        return $this->belongsTo(IndustryTechIssue::class, 'issue_id');
    }
}
