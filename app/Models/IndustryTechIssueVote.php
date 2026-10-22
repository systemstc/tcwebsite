<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustryTechIssueVote extends Model
{
    protected $fillable = [
        'issue_id',
        'ip_address',
        'session_id',
    ];

    public function issue()
    {
        return $this->belongsTo(IndustryTechIssue::class, 'issue_id');
    }
}
