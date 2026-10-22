<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteAnalytic;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', '30');

        $query = SiteAnalytic::query();

        $startDate = match ($period) {
            '1', 'today' => now()->startOfDay(),
            '7', '7days' => now()->subDays(6)->startOfDay(),
            '30', '30days' => now()->subDays(29)->startOfDay(),
            default => null,
        };

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        // Summary Statistics
        $totalViews = (clone $query)->count();
        $uniqueVisitors = (clone $query)->distinct('ip_address')->count('ip_address');
        $uniqueSessions = (clone $query)->distinct('session_id')->count('session_id');
        $bhashiniHits = (clone $query)->where('is_bhashini', true)->count();
        $bhashiniPercent = $totalViews > 0 ? round(($bhashiniHits / $totalViews) * 100, 1) : 0;

        // Top 10 Visited Pages
        $topPages = (clone $query)
            ->select(
                'path',
                'page_title',
                DB::raw('count(*) as total_views'),
                DB::raw('count(distinct ip_address) as unique_ips'),
                DB::raw('sum(case when is_bhashini = 1 then 1 else 0 end) as bhashini_views')
            )
            ->groupBy('path', 'page_title')
            ->orderByDesc('total_views')
            ->take(10)
            ->get();

        // Language & Bhashini Distribution
        $langDistribution = (clone $query)
            ->select(
                DB::raw("COALESCE(NULLIF(bhashini_lang, ''), locale, 'en') as lang"),
                DB::raw('count(*) as views')
            )
            ->groupBy('lang')
            ->orderByDesc('views')
            ->get();

        // Daily Traffic Trend
        $dailyRows = (clone $query)
            ->select(
                'view_date',
                DB::raw('count(*) as total'),
                DB::raw('sum(case when is_bhashini = 1 then 1 else 0 end) as bhashini_count')
            )
            ->groupBy('view_date')
            ->orderBy('view_date', 'asc')
            ->get();

        $dailyTrend = [];
        foreach ($dailyRows as $row) {
            $dateLabel = $row->view_date ? date('M d', strtotime($row->view_date)) : 'N/A';
            $dailyTrend[] = [
                'date' => $dateLabel,
                'views' => (int) $row->total,
                'bhashini_views' => (int) $row->bhashini_count,
            ];
        }

        // Device Breakdown
        $deviceStats = (clone $query)
            ->select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get();

        // Browser Breakdown
        $browserStats = (clone $query)
            ->select('browser', DB::raw('count(*) as count'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // Recent Real-Time Visits Feed
        $recentVisits = SiteAnalytic::orderBy('created_at', 'desc')->take(15)->get();

        return view('admin.analytics.index', compact(
            'period',
            'totalViews',
            'uniqueVisitors',
            'uniqueSessions',
            'bhashiniHits',
            'bhashiniPercent',
            'topPages',
            'langDistribution',
            'deviceStats',
            'browserStats',
            'dailyTrend',
            'recentVisits'
        ));
    }
}
