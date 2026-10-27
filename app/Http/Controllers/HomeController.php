<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Banner;
use App\Models\Announcement;
use App\Models\Dignitary;
use App\Models\Scheme;
use App\Models\Tender;
use App\Models\WhatsNew;
use App\Models\Document;
use App\Models\Persona;
use App\Models\ImportantLink;
use App\Models\Campaign;
use App\Models\SocialPost;
use App\Models\Page;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Models\Inquiry;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();
        $announcements = Announcement::where('is_active', true)->orderBy('sort_order')->get();
        
        $pm = Dignitary::where('type', 'prime_minister')->where('is_active', true)->first();
        $ministers = Dignitary::whereIn('type', ['minister', 'secretary'])->where('is_active', true)->orderBy('sort_order')->get();
        
        $schemes = Scheme::where('is_active', true)->where('category', 'scheme')->orderBy('sort_order')->take(6)->get();
        $tenders = Tender::where('is_active', true)->where('type', 'tender')->orderBy('sort_order')->take(6)->get();
        $vacancies = Tender::where('is_active', true)->where('type', 'vacancy')->orderBy('sort_order')->take(6)->get();
        
        $whatsNews = WhatsNew::where('is_active', true)->orderBy('sort_order')->take(5)->get();
        $documents = Document::where('is_active', true)->orderBy('sort_order')->take(6)->get();
        $personas = Persona::where('is_active', true)->orderBy('sort_order')->get();
        $importantLinks = ImportantLink::where('is_active', true)->orderBy('sort_order')->take(8)->get();
        
        // Dynamic Campaign Banners integrating CCPS and DBIM APIs with robust fallback
        $campaigns = $this->getCampaignBanners();

        $socialPosts = SocialPost::where('is_active', true)->orderBy('sort_order')->get()->groupBy('platform');
        
        $aboutPage = Page::where('slug', 'history')->first() ?? Page::where('slug', 'about-us')->first();
        
        // Visitor count increment is handled by TrackPageVisits middleware (genuine frontend visitors only)
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // 300 character clean narrative text for About Us section
        $rawAbout = $settings['about_us_text_en'] ?? (
            !empty($aboutPage) && !empty($aboutPage->content_en)
                ? preg_replace('/\s+/', ' ', trim(strip_tags($aboutPage->content_en)))
                : "The Textiles Committee is a statutory body established by an Act of Parliament (The Textiles Committee Act, 1963) under the Ministry of Textiles, Government of India. The primary functions of the Committee are to ensure the quality of textiles and textile machinery produced in India for domestic consumption and export, and to establish laboratories and test houses across the country."
        );
        $cleanAbout = trim($rawAbout, " \"'");
        // Exact 300 characters limit
        $aboutExcerpt = Str::limit($cleanAbout, 300, '...');

        return view('front.home', compact(
            'banners',
            'announcements',
            'pm',
            'ministers',
            'schemes',
            'tenders',
            'vacancies',
            'whatsNews',
            'documents',
            'personas',
            'importantLinks',
            'campaigns',
            'socialPosts',
            'aboutPage',
            'aboutExcerpt',
            'settings'
        ));
    }

    /**
     * Get campaign banners integrating CCPS and DBIM APIs with robust local fallback
     */
    protected function getCampaignBanners()
    {
        return Cache::remember('site_campaign_banners_v1', 1800, function () {
            $campaigns = collect();

            // 1. Fetch from CCPS API (or local snapshot ccms_top_banner.json)
            $ccpsData = null;
            try {
                $ctx = stream_context_create(['http' => ['timeout' => 2, 'ignore_errors' => true]]);
                $ccpsRaw = @file_get_contents('https://ccps.digifootprint.gov.in/?post_type=top_banner', false, $ctx);
                if ($ccpsRaw && str_starts_with(trim($ccpsRaw), '{')) {
                    $ccpsData = json_decode($ccpsRaw, true);
                }
            } catch (\Throwable $e) {}

            if (!$ccpsData && file_exists(public_path('assets/live_api_data/ccms_top_banner.json'))) {
                $ccpsData = json_decode(file_get_contents(public_path('assets/live_api_data/ccms_top_banner.json')), true);
            }

            if (!empty($ccpsData['posts'])) {
                foreach ($ccpsData['posts'] as $post) {
                    $img = $post['acf_data']['image_1']['url'] ?? $post['acf_data']['image']['url'] ?? null;
                    $link = $post['acf_data']['image_url_1'] ?? $post['acf_data']['image_url'] ?? null;
                    $title = $post['acf_data']['image_1']['alt'] ?? $post['post_title'] ?? 'Mann Ki Baat';
                    if ($img) {
                        $campaigns->push((object)[
                            'id' => 'ccps_' . ($post['ID'] ?? 1),
                            'title_en' => $title ?: 'CCPS Campaign',
                            'image_url' => $img,
                            'link_url' => $link ?: 'https://www.mygov.in',
                            'source' => 'ccps'
                        ]);
                    }
                }
            }

            // 2. Fetch from DBIM API (or local snapshot cms_top_banner.json)
            $dbimData = null;
            try {
                $ctx = stream_context_create(['http' => ['timeout' => 2, 'ignore_errors' => true]]);
                $dbimRaw = @file_get_contents('https://cms-texmin.digifootprint.gov.in/?post_type=top_banner', false, $ctx);
                if ($dbimRaw && str_starts_with(trim($dbimRaw), '{')) {
                    $dbimData = json_decode($dbimRaw, true);
                }
            } catch (\Throwable $e) {}

            if (!$dbimData && file_exists(public_path('assets/live_api_data/cms_top_banner.json'))) {
                $dbimData = json_decode(file_get_contents(public_path('assets/live_api_data/cms_top_banner.json')), true);
            }

            if (!empty($dbimData['posts'])) {
                foreach ($dbimData['posts'] as $post) {
                    $img = $post['acf_data']['image']['url'] ?? $post['acf_data']['image_1']['url'] ?? null;
                    $link = $post['acf_data']['image_url'] ?? $post['acf_data']['image_url_1'] ?? null;
                    $title = $post['acf_data']['image']['alt'] ?? $post['post_title'] ?? 'Textiles Campaign';
                    if ($img) {
                        $campaigns->push((object)[
                            'id' => 'dbim_' . ($post['ID'] ?? rand(100, 999)),
                            'title_en' => $title ?: 'DBIM Campaign',
                            'image_url' => $img,
                            'link_url' => $link ?: 'https://www.texmin.gov.in',
                            'source' => 'dbim'
                        ]);
                    }
                }
            }

            // 3. Database custom campaigns
            $dbCampaigns = Campaign::where('is_active', true)->orderBy('sort_order')->get();
            foreach ($dbCampaigns as $camp) {
                $campaigns->push((object)[
                    'id' => 'db_' . $camp->id,
                    'title_en' => $camp->title_en,
                    'image_url' => asset($camp->image_url),
                    'link_url' => $camp->link_url ?: '#',
                    'source' => 'db'
                ]);
            }

            // Filter for unique images and pick the top featured banners
            $uniqueBanners = $campaigns->unique('image_url');

            // Select priority banners: Swachhta Hi Seva (DBIM), Mann Ki Baat (CCPS), Make in India (DB), National Handloom / Dashboard
            $curated = collect();

            // First: Swachhta Hi Seva (from DBIM)
            $swachh = $uniqueBanners->first(fn($b) => stripos($b->title_en, 'swach') !== false);
            if ($swachh) $curated->push($swachh);

            // Second: Mann Ki Baat (from CCPS)
            $ccpsItem = $uniqueBanners->first(fn($b) => $b->source === 'ccps' || stripos($b->title_en, 'mann ki') !== false);
            if ($ccpsItem && !$curated->contains('image_url', $ccpsItem->image_url)) $curated->push($ccpsItem);

            // Third: Make in India
            $makeInIndia = $uniqueBanners->first(fn($b) => stripos($b->title_en, 'make in india') !== false);
            if ($makeInIndia && !$curated->contains('image_url', $makeInIndia->image_url)) $curated->push($makeInIndia);

            // Fourth: Dashboard or Handloom
            $handloomOrDash = $uniqueBanners->first(fn($b) => (stripos($b->title_en, 'dashboard') !== false || stripos($b->title_en, 'handloom') !== false) && !$curated->contains('image_url', $b->image_url));
            if ($handloomOrDash) $curated->push($handloomOrDash);

            // If we have fewer than 3, fill with other unique banners
            foreach ($uniqueBanners as $b) {
                if ($curated->count() >= 4) break;
                if (!$curated->contains('image_url', $b->image_url)) {
                    $curated->push($b);
                }
            }

            return $curated->isNotEmpty() ? $curated : $uniqueBanners->take(4);
        });
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->first();
        if (!$page) {
            $altSlug = str_ends_with($slug, 's') ? substr($slug, 0, -1) : ($slug . 's');
            $page = Page::where('slug', $altSlug)->where('is_active', true)->first();
            if ($page) {
                return redirect()->route('page.show', $page->slug);
            }
            abort(404);
        }
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $importantLinks = ImportantLink::where('is_active', true)->orderBy('sort_order')->take(8)->get();

        // 1. Locate the MenuItem corresponding to this page
        $currentMenuItem = MenuItem::where('page_id', $page->id)->first();
        if (!$currentMenuItem) {
            $currentMenuItem = MenuItem::where(function($q) use ($slug) {
                $q->where('url', 'like', "%/{$slug}")
                  ->orWhere('url', $slug)
                  ->orWhere('url', "/page/{$slug}")
                  ->orWhere('url', "page/{$slug}");
            })->first();
        }

        // 2. Identify the Parent Menu Item
        $parentMenu = null;
        if ($currentMenuItem) {
            if ($currentMenuItem->parent_id) {
                $parentMenu = MenuItem::with(['activeChildren.page'])->find($currentMenuItem->parent_id);
            } elseif ($currentMenuItem->activeChildren()->count() > 0) {
                $parentMenu = $currentMenuItem;
                $parentMenu->load(['activeChildren.page']);
            }
        }

        // Auto-detect menu_location if not explicitly set
        if (!$page->menu_location || $page->menu_location === 'none') {
            if ($parentMenu) {
                $pTitle = strtolower(trim($parentMenu->title_en));
                if (str_contains($pTitle, 'about') || str_contains($pTitle, 'ministry')) {
                    $page->menu_location = 'ministry';
                } elseif (str_contains($pTitle, 'offering')) {
                    $page->menu_location = 'offerings';
                } elseif (str_contains($pTitle, 'doc')) {
                    $page->menu_location = 'documents';
                } elseif (str_contains($pTitle, 'media')) {
                    $page->menu_location = 'media';
                }
            }
        }

        // Fallback: If parentMenu not found, use page->menu_location to find the top menu
        if (!$parentMenu && $page->menu_location && $page->menu_location !== 'none') {
            $loc = strtolower($page->menu_location);
            $parentMenu = MenuItem::with(['activeChildren.page'])
                ->whereNull('parent_id')
                ->where(function($q) use ($loc) {
                    if (str_contains($loc, 'ministry') || str_contains($loc, 'about')) {
                        $q->where('title_en', 'like', '%About%')->orWhere('title_en', 'like', '%Ministry%');
                    } elseif (str_contains($loc, 'offering')) {
                        $q->where('title_en', 'like', '%Offer%');
                    } elseif (str_contains($loc, 'doc')) {
                        $q->where('title_en', 'like', '%Doc%');
                    } elseif (str_contains($loc, 'media')) {
                        $q->where('title_en', 'like', '%Media%');
                    }
                })->first();
        }

        // 3. Build Navigation Pills from Parent's Active Children
        $navPills = collect();
        if ($parentMenu && $parentMenu->activeChildren && $parentMenu->activeChildren->count() > 0) {
            foreach ($parentMenu->activeChildren as $item) {
                $isActive = false;
                if ($item->page_id && $item->page_id == $page->id) {
                    $isActive = true;
                } elseif ($item->type === 'page' && $item->page && $item->page->slug === $page->slug) {
                    $isActive = true;
                } elseif (!empty($item->url) && (str_ends_with($item->url, '/' . $page->slug) || $item->url === $page->slug || $item->url === "/page/{$page->slug}")) {
                    $isActive = true;
                }

                $navPills->push((object)[
                    'id' => $item->id,
                    'title_en' => $item->title_en,
                    'title_hi' => $item->title_hi ?: $item->title_en,
                    'url' => $item->resolved_url,
                    'slug' => ($item->page ? $item->page->slug : ''),
                    'is_active' => $isActive,
                    'page_id' => $item->page_id,
                ]);
            }
        }

        // If none is active yet, match by page id or slug
        if (!$navPills->contains('is_active', true) && $navPills->isNotEmpty()) {
            foreach ($navPills as $pill) {
                if ($pill->page_id == $page->id || ($pill->slug && $pill->slug == $page->slug)) {
                    $pill->is_active = true;
                    break;
                }
            }
        }

        // Fallback: If no menu hierarchy found, query Page table directly
        if ($navPills->isEmpty() && $page->menu_location && $page->menu_location !== 'none') {
            $siblings = Page::where('is_active', true)
                ->where('menu_location', $page->menu_location)
                ->orderBy('sort_order', 'asc')
                ->orderBy('id', 'asc')
                ->get();
            foreach ($siblings as $sib) {
                $navPills->push((object)[
                    'id' => $sib->id,
                    'title_en' => $sib->title_en,
                    'title_hi' => $sib->title_hi ?: $sib->title_en,
                    'url' => route('page.show', $sib->slug),
                    'slug' => $sib->slug,
                    'is_active' => ($sib->id == $page->id),
                    'page_id' => $sib->id,
                ]);
            }
        }

        // 4. Breadcrumb Parent Info
        $breadcrumbParent = null;
        if ($parentMenu) {
            $breadcrumbParent = (object)[
                'title_en' => $parentMenu->title_en,
                'title_hi' => $parentMenu->title_hi ?: $parentMenu->title_en,
                'url' => $parentMenu->resolved_url ?: '#',
            ];
        }

        // Dynamically normalize uploads URLs and sanitize frontend HTML (read-only, no editor artifacts)
        $cleanFrontendContent = function($html) {
            if (empty($html)) return $html;
            $assetUploads = asset('uploads');
            // Normalize any localhost/domain/root uploads paths to current environment asset('uploads')
            $html = preg_replace(
                '#(?<=href=["\']|src=["\'])(?:https?://[^/"\']+(?:/[^/"\']*)*/uploads|/uploads)(/[^"\']*)#i',
                $assetUploads . '$1',
                $html
            );
            // STRICT FRONTEND READ-ONLY: Strip all contenteditable attributes so pages cannot be edited on frontend
            $html = preg_replace('/\s*contenteditable(?:\s*=\s*["\']?[^"\'\s>]*["\']?)?/i', '', $html);
            
            // Strip draggable and dropzone editor attributes
            $html = preg_replace('/\s*draggable(?:\s*=\s*["\']?[^"\'\s>]*["\']?)?/i', '', $html);
            
            // Strip any backend visual editor control panels, toolbars, and action overlays
            $html = preg_replace('#<div[^>]*class=["\'][^"\']*(?:editor-book-grid-ctrl|editor-photo-grid-ctrl|editor-video-grid-ctrl|editor-pres-grid-ctrl)[^"\']*["\'][^>]*>.*?</div>\s*(?=(?:<!--|<div class="text-center|<div class="row|<div class="dbim-gallery-filter-bar))#si', '', $html);
            $html = preg_replace('#<div[^>]*class=["\'][^"\']*(?:editor-pro-table-ctrl|editor-img-ctrl|editor-table-ctrl|editor-action-bar|floating-component-toolbar|section-action-overlay|editor-floating-toolbar|component-resize-handle|drop-indicator-line|editor-book-btn-bar|editor-photo-btn-bar|editor-video-btn-bar|editor-pres-btn-bar)[^"\']*["\'][^>]*>.*?</div>#si', '', $html);
            
            // Strip any backend visual editor buttons
            $html = preg_replace('#<button[^>]*class=["\'][^"\']*(?:editor-table-btn|editor-img-btn|editor-doc-btn|editor-avatar-btn|editor-faq-btn|section-ctrl-btn|toolbar-btn|editor-book-btn|editor-photo-btn|editor-video-btn|editor-pres-btn)[^"\']*["\'][^>]*>.*?</button>#si', '', $html);
            
            // Strip editor-only onclick handlers (retaining public table sorting/pagination and gallery preview functions)
            $html = preg_replace('/\s*onclick\s*=\s*["\'](?:openAvatarModal|openDocMediaModal|openProCellSettingsModal|quickAdjustProCellSpan|addProTableRow|deleteProTableRow|addProTableColumn|deleteProTableColumn|duplicateProTableRow|duplicateProTableColumn|deleteProCell|clearProCellSpans|setDbimImageShape|setDbimImageSize|setDbimImageAlign|toggleDbimImageCaption|openDbimImageSizeModal|flipDbimImageTextLayout|setDbimImageTextProportion|addDbimTable|removeDbimTable|deleteActiveSection|openSizeModal|createLinkPrompt|cleanActiveFormatting|applyFontFamily|applyFontSize|toggleFormatPainter|execCmd|openPdfUploader|openImagePicker|addBookCard|deleteBookCard|duplicateBookCard|moveBookCard|setBookGridCols|addPhotoCard|deletePhotoCard|duplicatePhotoCard|movePhotoCard|setPhotoGridCols|addVideoCard|deleteVideoCard|duplicateVideoCard|moveVideoCard|setVideoGridCols|addPresCard|deletePresCard|duplicatePresCard|movePresCard|setPresGridCols)\([^"\']*\)["\']/i', '', $html);

            // Strip editor-only image upload tooltips
            $html = preg_replace('/\s*title=["\'](?:Click to upload\/change|Change Photo|Change Thumbnail|Change Slide)[^"\']*["\']/i', '', $html);
            return $html;
        };
        $page->content_en = $cleanFrontendContent($page->content_en);
        $page->content_hi = $cleanFrontendContent($page->content_hi);

        $siblingPages = $navPills;

        return view('front.page', compact('page', 'settings', 'importantLinks', 'navPills', 'siblingPages', 'breadcrumbParent'));
    }

    public function submitInquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        $inquiry = Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'Website Inquiry',
            'message' => $validated['message'],
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        ActivityLog::record('submit_inquiry', 'inquiries', $inquiry->id, 'New feedback submitted by ' . $inquiry->name);

        return redirect()->back()->with('success', 'आपकी प्रतिक्रिया/पूछताछ सफलतापूर्वक प्राप्त हो गई है। धन्यवाद! / Your inquiry has been submitted successfully.');
    }

    public function search(Request $request, \App\Services\GlobalSearchService $searchService)
    {
        $q = trim($request->input('q'));
        if (!$q) {
            return redirect()->route('home');
        }

        $results = $searchService->search($q);
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('front.search', array_merge($results, [
            'q' => $q,
            'settings' => $settings,
        ]));
    }

    public function toggleLocale($lang)
    {
        if (in_array($lang, ['hi', 'en'])) {
            Session::put('locale', $lang);
        }
        return redirect()->back();
    }

    public function whatsNew(Request $request)
    {
        $whatsNews = WhatsNew::where('is_active', true)->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        $schemes = Scheme::where('is_active', true)->orderBy('sort_order')->get();
        $documents = Document::where('is_active', true)->orderBy('published_date', 'desc')->get();

        return view('front.whats-new', compact('whatsNews', 'schemes', 'documents'));
    }
}
