<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    protected $fillable = [
        'platform',
        'post_url',
        'title',
        'content',
        'media_image',
        'author_name',
        'author_handle',
        'post_date',
        'likes_count',
        'comments_count',
        'shares_count',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get human-readable platform label
     */
    public function getPlatformLabel(): string
    {
        return match ($this->platform) {
            'twitter', 'x' => 'X (Twitter)',
            'youtube' => 'YouTube',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            default => ucfirst($this->platform),
        };
    }

    /**
     * Extract YouTube Video ID from URL
     */
    public function getYoutubeId(): ?string
    {
        if ($this->platform !== 'youtube' || empty($this->post_url)) {
            return null;
        }

        $url = $this->post_url;
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get displayable image URL
     */
    public function getDisplayImage(): string
    {
        if (!empty($this->media_image)) {
            if (str_starts_with($this->media_image, 'http://') || str_starts_with($this->media_image, 'https://')) {
                return $this->media_image;
            }
            if (file_exists(public_path($this->media_image))) {
                return asset($this->media_image);
            }
            if (file_exists(public_path('storage/' . $this->media_image))) {
                return asset('storage/' . $this->media_image);
            }
        }

        // Auto thumbnail for YouTube
        $ytId = $this->getYoutubeId();
        if ($ytId) {
            return "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg";
        }

        // Defaults based on platform
        return match ($this->platform) {
            'twitter', 'x' => asset('assets/images/feed_x_crop.png'),
            'youtube' => asset('assets/images/feed_yt_crop.png'),
            'facebook' => asset('assets/images/feed_fb_crop.png'),
            'instagram' => asset('assets/images/feed_ig_crop.png'),
            default => asset('assets/images/hero_auditorium.png'),
        };
    }
}
