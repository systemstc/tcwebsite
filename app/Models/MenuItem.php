<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'parent_id',
        'title_en',
        'title_hi',
        'type',
        'page_id',
        'url',
        'target',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order', 'asc');
    }

    public function allChildren()
    {
        return $this->children()->with(['allChildren.page', 'page']);
    }

    public function activeChildren()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc');
    }

    public function allActiveChildren()
    {
        return $this->activeChildren()->with(['allActiveChildren.page', 'page']);
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    /**
     * Resolve effective URL
     */
    public function getResolvedUrlAttribute()
    {
        if ($this->type === 'page' && $this->page) {
            if ($this->page->slug === 'industry-tech-issues') {
                return route('industry-tech-issues.index');
            }
            return route('page.show', $this->page->slug);
        }
        if (!empty($this->url)) {
            if (trim($this->url, '/') === 'industry-tech-issues') {
                return route('industry-tech-issues.index');
            }
            if (str_starts_with($this->url, 'http://') || str_starts_with($this->url, 'https://') || str_starts_with($this->url, '#') || str_starts_with($this->url, '/')) {
                return $this->url;
            }
            return url($this->url);
        }
        return '#';
    }
}
