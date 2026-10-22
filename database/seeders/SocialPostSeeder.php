<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialPost;

class SocialPostSeeder extends Seeder
{
    public function run(): void
    {
        if (SocialPost::count() > 0) {
            return;
        }

        // 1. Twitter / X Posts
        SocialPost::create([
            'platform' => 'twitter',
            'post_url' => 'https://twitter.com/TexMinIndia/status/19442025',
            'title' => 'Interaction Meeting in Coimbatore',
            'content' => 'Interactive session on textile modernization with industry leaders.',
            'media_image' => 'assets/images/feed_x_crop.png',
            'author_name' => 'Ministry of Textiles',
            'author_handle' => '@TexMinIndia',
            'post_date' => '6:51 AM · Jul 12, 2025',
            'likes_count' => '25',
            'comments_count' => '2',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        SocialPost::create([
            'platform' => 'twitter',
            'post_url' => 'https://twitter.com/TexMinIndia/status/18228392',
            'title' => 'Stakeholders deliberation',
            'content' => 'An interaction meeting was held in Coimbatore with Hon\'ble Union Minister of Textiles Shri Giriraj Singh and textile industry stakeholders to deliberate on accelerating growth in modern textiles and handlooms.',
            'media_image' => null,
            'author_name' => 'Ministry of Textiles',
            'author_handle' => '@TexMinIndia',
            'post_date' => '3:40 PM · Aug 10, 2025',
            'likes_count' => '142',
            'comments_count' => '16',
            'shares_count' => '38',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        SocialPost::create([
            'platform' => 'twitter',
            'post_url' => 'https://twitter.com/TexMinIndia/status/18300291',
            'title' => 'PM MITRA Mega Textile Parks',
            'content' => 'PM MITRA Mega Textile Parks are creating world-class infrastructure and generating massive employment opportunities across the nation. #TextilesInNews #AtmanirbharBharat',
            'media_image' => null,
            'author_name' => 'Ministry of Textiles',
            'author_handle' => '@TexMinIndia',
            'post_date' => '11:15 AM · Sep 2, 2025',
            'likes_count' => '210',
            'comments_count' => '22',
            'shares_count' => '49',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 2. YouTube Videos
        SocialPost::create([
            'platform' => 'youtube',
            'post_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'title' => '#TextilesInNews #MinistryOfTextiles',
            'content' => 'Textiles in news and policy highlights',
            'media_image' => 'assets/images/feed_yt_crop.png',
            'author_name' => 'Ministry of Textiles',
            'post_date' => 'Recent Video',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        SocialPost::create([
            'platform' => 'youtube',
            'post_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'title' => 'The latest from India\'s textile sector - Ministry of Textiles',
            'content' => 'Key milestones and export progress.',
            'media_image' => 'assets/images/HGT-Website-Banner.jpg',
            'author_name' => 'Ministry of Textiles',
            'post_date' => '2 weeks ago',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        SocialPost::create([
            'platform' => 'youtube',
            'post_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'title' => 'Celebrating Kasturi Cotton Bharat - Global Standards',
            'content' => 'Quality benchmarks and global branding for Indian Cotton.',
            'media_image' => 'assets/images/hero_auditorium.png',
            'author_name' => 'Ministry of Textiles',
            'post_date' => '1 month ago',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 3. Facebook Posts
        SocialPost::create([
            'platform' => 'facebook',
            'post_url' => 'https://facebook.com/MinistryofTextiles',
            'title' => 'Textiles Expo Showcase',
            'content' => 'Inauguration ceremony of the International Textile Exposition showcasing indigenous handicrafts and handloom artisans from across India.',
            'media_image' => 'assets/images/feed_fb_crop.png',
            'author_name' => 'Ministry of Textiles, Government of India',
            'post_date' => 'about 2 years ago',
            'likes_count' => '142',
            'comments_count' => '18',
            'shares_count' => '24',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        SocialPost::create([
            'platform' => 'facebook',
            'post_url' => 'https://facebook.com/MinistryofTextiles',
            'title' => 'Empowering weavers under SAMARTH',
            'content' => 'Empowering traditional handloom weavers through direct market linkages, digital skill development, and design interventions under SAMARTH.',
            'media_image' => 'assets/images/hero_auditorium.png',
            'author_name' => 'Ministry of Textiles, Government of India',
            'post_date' => 'June 25, 2025',
            'likes_count' => '98',
            'comments_count' => '12',
            'shares_count' => '15',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 4. Instagram Posts
        SocialPost::create([
            'platform' => 'instagram',
            'post_url' => 'https://instagram.com/ministryoftextiles',
            'title' => 'Celebrating Indian Silk & Textiles',
            'content' => 'Celebrating the heritage and global footprint of Indian Silk & Textiles... #VocalForLocal',
            'media_image' => 'assets/images/feed_ig_crop.png',
            'author_name' => 'texminindia and csb_...',
            'author_handle' => '59.2K followers',
            'post_date' => 'Recent Reel',
            'likes_count' => '1,280',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        SocialPost::create([
            'platform' => 'instagram',
            'post_url' => 'https://instagram.com/ministryoftextiles',
            'title' => 'Threads of Tradition',
            'content' => 'Threads of tradition, woven with pride. #VocalForLocal #TextilesIndia',
            'media_image' => 'assets/images/HGT-Website-Banner.jpg',
            'author_name' => 'texminindia',
            'author_handle' => '59.2K followers',
            'post_date' => '1 week ago',
            'likes_count' => '940',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
}
