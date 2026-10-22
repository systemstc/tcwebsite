<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\Page;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        if (MenuItem::count() > 0) {
            return;
        }

        $pages = Page::pluck('id', 'slug');

        // 1. Ministry
        $ministry = MenuItem::create([
            'title_en' => 'Ministry',
            'title_hi' => 'मंत्रालय',
            'type' => 'custom',
            'url' => '#',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $ministry->id,
            'title_en' => 'About Ministry',
            'title_hi' => 'मंत्रालय के बारे में',
            'type' => isset($pages['about-us']) ? 'page' : 'custom',
            'page_id' => $pages['about-us'] ?? null,
            'url' => isset($pages['about-us']) ? null : '/page/about-us',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $ministry->id,
            'title_en' => 'Leadership & Team',
            'title_hi' => 'नेतृत्व एवं टीम',
            'type' => isset($pages['our-team']) ? 'page' : 'custom',
            'page_id' => $pages['our-team'] ?? null,
            'url' => isset($pages['our-team']) ? null : '/page/our-team',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $ministry->id,
            'title_en' => 'Organization Structure',
            'title_hi' => 'संगठनात्मक ढांचा',
            'type' => isset($pages['organization']) ? 'page' : 'custom',
            'page_id' => $pages['organization'] ?? null,
            'url' => isset($pages['organization']) ? null : '/page/organization',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $ministry->id,
            'title_en' => 'Our Dashboard',
            'title_hi' => 'हमारा डैशबोर्ड',
            'type' => isset($pages['dashboard']) ? 'page' : 'custom',
            'page_id' => $pages['dashboard'] ?? null,
            'url' => isset($pages['dashboard']) ? null : '/page/dashboard',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $ministry->id,
            'title_en' => 'Our Division',
            'title_hi' => 'हमारा प्रभाग',
            'type' => isset($pages['our-division']) ? 'page' : 'custom',
            'page_id' => $pages['our-division'] ?? null,
            'url' => isset($pages['our-division']) ? null : '/page/our-division',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        // 2. Offerings
        $offerings = MenuItem::create([
            'title_en' => 'Offerings',
            'title_hi' => 'योजनाएं व सेवाएं',
            'type' => 'custom',
            'url' => '#keyOfferings',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $offerings->id,
            'title_en' => 'Schemes and Services',
            'title_hi' => 'योजनाएं और सेवाएं',
            'type' => 'custom',
            'url' => '#keyOfferings',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $offerings->id,
            'title_en' => 'Production Linked Incentive (PLI)',
            'title_hi' => 'उत्पादन संबद्ध प्रोत्साहन (PLI)',
            'type' => 'custom',
            'url' => '#keyOfferings',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $offerings->id,
            'title_en' => 'PM MITRA Parks',
            'title_hi' => 'पीएम मित्रा पार्क',
            'type' => 'custom',
            'url' => '#keyOfferings',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $offerings->id,
            'title_en' => 'Vacancies & Tenders',
            'title_hi' => 'रिक्तियां व निविदाएं',
            'type' => 'custom',
            'url' => '#keyOfferings',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 3. Documents
        $documents = MenuItem::create([
            'title_en' => 'Documents',
            'title_hi' => 'दस्तावेज़',
            'type' => 'custom',
            'url' => '#recentDocs',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $documents->id,
            'title_en' => 'Gazettes Notifications',
            'title_hi' => 'राजपत्र अधिसूचनाएं',
            'type' => 'custom',
            'url' => '#recentDocs',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $documents->id,
            'title_en' => 'Reports And Publications',
            'title_hi' => 'रिपोर्ट और प्रकाशन',
            'type' => 'custom',
            'url' => '#recentDocs',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $documents->id,
            'title_en' => 'Guidelines & Policies',
            'title_hi' => 'दिशा-निर्देश व नीतियां',
            'type' => 'custom',
            'url' => '#recentDocs',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $documents->id,
            'title_en' => 'Circulars & Office Orders',
            'title_hi' => 'परिपत्र और कार्यालय आदेश',
            'type' => 'custom',
            'url' => '#recentDocs',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 4. Media
        $media = MenuItem::create([
            'title_en' => 'Media',
            'title_hi' => 'मीडिया',
            'type' => 'custom',
            'url' => '#socialSection',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $media->id,
            'title_en' => 'Photo Gallery',
            'title_hi' => 'फोटो गैलरी',
            'type' => isset($pages['photo-gallery']) ? 'page' : 'custom',
            'page_id' => $pages['photo-gallery'] ?? null,
            'url' => isset($pages['photo-gallery']) ? null : '/page/photo-gallery',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $media->id,
            'title_en' => 'Video Gallery',
            'title_hi' => 'वीडियो गैलरी',
            'type' => isset($pages['video-gallery']) ? 'page' : 'custom',
            'page_id' => $pages['video-gallery'] ?? null,
            'url' => isset($pages['video-gallery']) ? null : '/page/video-gallery',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $media->id,
            'title_en' => 'Presentations / Events',
            'title_hi' => 'प्रस्तुतियां / कार्यक्रम',
            'type' => isset($pages['presentation-events']) ? 'page' : 'custom',
            'page_id' => $pages['presentation-events'] ?? null,
            'url' => isset($pages['presentation-events']) ? null : '/page/presentation-events',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $media->id,
            'title_en' => 'In Social Media',
            'title_hi' => 'सोशल मीडिया में',
            'type' => 'custom',
            'url' => '#socialSection',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $media->id,
            'title_en' => "What's New",
            'title_hi' => 'नया क्या है',
            'type' => 'custom',
            'url' => '#whatsNew',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        // 5. Connect
        $connect = MenuItem::create([
            'title_en' => 'Connect',
            'title_hi' => 'संपर्क',
            'type' => 'custom',
            'url' => '#footerContact',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $connect->id,
            'title_en' => 'Contact Directory',
            'title_hi' => 'संपर्क निर्देशिका',
            'type' => 'custom',
            'url' => '#footerContact',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MenuItem::create([
            'parent_id' => $connect->id,
            'title_en' => 'Citizen Feedback & Query',
            'title_hi' => 'नागरिक प्रतिक्रिया एवं प्रश्न',
            'type' => 'custom',
            'url' => '#feedbackModal',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
}
