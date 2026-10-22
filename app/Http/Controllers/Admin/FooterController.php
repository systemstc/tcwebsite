<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\ActivityLog;

class FooterController extends Controller
{
    /**
     * Default 4-column useful links as per Textiles Committee reference design.
     */
    public static function defaultLinks()
    {
        return [
            [
                'id' => 1,
                'title' => 'Archives',
                'url' => '/archives',
                'col' => 1,
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'title' => 'Help',
                'url' => '/help',
                'col' => 1,
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'title' => 'Website Policies',
                'url' => '/page/website-policies',
                'col' => 2,
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'title' => 'Contact Us',
                'url' => '/page/contact-us',
                'col' => 2,
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'id' => 5,
                'title' => 'Related Links',
                'url' => '/page/office-network',
                'col' => 3,
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'id' => 6,
                'title' => 'Feedback',
                'url' => '#feedbackModal',
                'col' => 3,
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'id' => 7,
                'title' => 'Sitemap',
                'url' => '/page/sitemap',
                'col' => 4,
                'target' => '_self',
                'is_active' => true,
            ],
        ];
    }

    public static function getLinks()
    {
        $stored = Setting::get('footer_useful_links');
        if (!empty($stored)) {
            $decoded = json_decode($stored, true);
            if (is_array($decoded) && count($decoded) > 0) {
                return $decoded;
            }
        }
        return self::defaultLinks();
    }

    public function index()
    {
        $links = self::getLinks();
        $copyrightEn = Setting::get('footer_copyright_en', 'This Website belong to Ministry of Textiles, Government of India');
        $copyrightHi = Setting::get('footer_copyright_hi', 'यह वेबसाइट वस्त्र मंत्रालय, भारत सरकार की है');
        $dateMode = Setting::get('footer_updated_mode', 'auto');
        $customDate = Setting::get('footer_custom_date', date('d.m.Y'));
        
        $twitter = Setting::get('twitter_handle', 'https://x.com/TexMinIndia');
        $youtube = Setting::get('youtube_url', 'https://youtube.com/@ministryoftextiles');
        $facebook = Setting::get('facebook_url', 'https://facebook.com/TexMinIndia');
        $instagram = Setting::get('instagram_url', 'https://instagram.com/ministryoftextiles');
        
        $mygovUrl = Setting::get('mygov_url', 'https://www.mygov.in/');
        $mygovEnabled = Setting::get('mygov_enabled', '1');
        $indiagovUrl = Setting::get('indiagov_url', 'https://www.india.gov.in/');
        $indiagovEnabled = Setting::get('indiagov_enabled', '1');
        $scrollTopEnabled = Setting::get('footer_scroll_top_enabled', '1');

        return view('admin.footer.index', compact(
            'links',
            'copyrightEn',
            'copyrightHi',
            'dateMode',
            'customDate',
            'twitter',
            'youtube',
            'facebook',
            'instagram',
            'mygovUrl',
            'mygovEnabled',
            'indiagovUrl',
            'indiagovEnabled',
            'scrollTopEnabled'
        ));
    }

    public function update(Request $request)
    {
        // 1. Process Useful Links
        $titles = $request->input('link_titles', []);
        $urls = $request->input('link_urls', []);
        $cols = $request->input('link_cols', []);
        $targets = $request->input('link_targets', []);
        $actives = $request->input('link_actives', []);

        $formattedLinks = [];
        for ($i = 0; $i < count($titles); $i++) {
            $t = trim($titles[$i] ?? '');
            $u = trim($urls[$i] ?? '');
            if ($t !== '' && $u !== '') {
                $formattedLinks[] = [
                    'id' => $i + 1,
                    'title' => $t,
                    'url' => $u,
                    'col' => (int)($cols[$i] ?? 1),
                    'target' => $targets[$i] ?? '_self',
                    'is_active' => isset($actives[$i]) && $actives[$i] == '1',
                ];
            }
        }

        Setting::set('footer_useful_links', json_encode($formattedLinks), 'footer');

        // 2. Process General & Social Settings
        Setting::set('footer_copyright_en', $request->input('footer_copyright_en', 'This Website belong to Ministry of Textiles, Government of India'), 'footer');
        Setting::set('footer_copyright_hi', $request->input('footer_copyright_hi', 'यह वेबसाइट वस्त्र मंत्रालय, भारत सरकार की है'), 'footer');
        Setting::set('footer_updated_mode', $request->input('footer_updated_mode', 'auto'), 'footer');
        Setting::set('footer_custom_date', $request->input('footer_custom_date', date('d.m.Y')), 'footer');

        Setting::set('twitter_handle', $request->input('twitter_handle', 'https://x.com/TexMinIndia'), 'social');
        Setting::set('youtube_url', $request->input('youtube_url', 'https://youtube.com/@ministryoftextiles'), 'social');
        Setting::set('facebook_url', $request->input('facebook_url', 'https://facebook.com/TexMinIndia'), 'social');
        Setting::set('instagram_url', $request->input('instagram_url', 'https://instagram.com/ministryoftextiles'), 'social');

        Setting::set('mygov_url', $request->input('mygov_url', 'https://www.mygov.in/'), 'footer');
        Setting::set('mygov_enabled', $request->has('mygov_enabled') ? '1' : '0', 'footer');
        Setting::set('indiagov_url', $request->input('indiagov_url', 'https://www.india.gov.in/'), 'footer');
        Setting::set('indiagov_enabled', $request->has('indiagov_enabled') ? '1' : '0', 'footer');
        Setting::set('footer_scroll_top_enabled', $request->has('footer_scroll_top_enabled') ? '1' : '0', 'footer');

        ActivityLog::record('footer_updated', 'settings', null, 'Footer navigation links and configuration updated by ' . auth()->user()->name);

        return redirect()->back()->with('success', 'Footer links and settings updated successfully.');
    }
}
