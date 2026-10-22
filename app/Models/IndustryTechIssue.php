<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IndustryTechIssue extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'urgency',
        'status',
        'industry_name',
        'contact_person',
        'email',
        'phone',
        'description',
        'solution',
        'solution_provided_at',
        'solution_by',
        'tags',
        'upvotes_count',
        'replies_count',
        'is_active',
    ];

    protected $casts = [
        'solution_provided_at' => 'datetime',
        'is_active' => 'boolean',
        'upvotes_count' => 'integer',
        'replies_count' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($issue) {
            if (empty($issue->slug)) {
                $baseSlug = Str::slug($issue->title);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }
                $issue->slug = $slug;
            }
        });
    }

    public function replies()
    {
        return $this->hasMany(IndustryTechIssueReply::class, 'issue_id')->orderBy('created_at', 'asc');
    }

    public function approvedReplies()
    {
        return $this->hasMany(IndustryTechIssueReply::class, 'issue_id')->where('is_approved', true)->orderBy('created_at', 'asc');
    }

    public function votes()
    {
        return $this->hasMany(IndustryTechIssueVote::class, 'issue_id');
    }

    public function hasVotedByIp($ip)
    {
        return $this->votes()->where('ip_address', $ip)->exists();
    }
}
