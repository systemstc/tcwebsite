<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Announcement;
use App\Models\Scheme;
use App\Models\Tender;
use App\Models\Document;
use App\Models\Inquiry;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Setting;
use App\Models\SiteAnalytic;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'banners' => Banner::count(),
            'announcements' => Announcement::count(),
            'schemes' => Scheme::count(),
            'tenders' => Tender::count(),
            'documents' => Document::count(),
            'inquiries' => Inquiry::count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
            'users' => User::count(),
            'visitor_count' => Setting::get('visitor_count', 8614226),
        ];

        // Site Analytics & Bhashini Metrics for Main Dashboard
        $totalViews = SiteAnalytic::count();
        $uniqueVisitors = SiteAnalytic::distinct('ip_address')->count('ip_address');
        $bhashiniHits = SiteAnalytic::where('is_bhashini', true)->count();
        $bhashiniPercent = $totalViews > 0 ? round(($bhashiniHits / $totalViews) * 100, 1) : 0;

        $analyticsStats = [
            'total_views' => $totalViews,
            'unique_visitors' => $uniqueVisitors,
            'bhashini_hits' => $bhashiniHits,
            'bhashini_percent' => $bhashiniPercent,
        ];

        $topPages = SiteAnalytic::select('path', 'page_title', DB::raw('COUNT(*) as total_views'))
            ->groupBy('path', 'page_title')
            ->orderByDesc('total_views')
            ->take(5)
            ->get();

        $topLanguages = SiteAnalytic::select(
                DB::raw("COALESCE(NULLIF(bhashini_lang, ''), locale, 'en') as lang"),
                DB::raw('COUNT(*) as views')
            )
            ->groupBy('lang')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        $recentLogs = ActivityLog::orderBy('created_at', 'desc')->take(8)->get();
        $recentInquiries = Inquiry::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'analyticsStats', 'topPages', 'topLanguages', 'recentLogs', 'recentInquiries'));
    }
}
