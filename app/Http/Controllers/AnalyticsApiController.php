<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteAnalytic;

class AnalyticsApiController extends Controller
{
    public function trackBhashini(Request $request)
    {
        // Exclude logged in admins & backend admin referrers
        if (auth()->check()) {
            return response()->json(['status' => 'ignored', 'reason' => 'admin_session']);
        }
        $referer = $request->headers->get('referer', '');
        if (str_contains($referer, '/admin') || str_contains($referer, 'admin/')) {
            return response()->json(['status' => 'ignored', 'reason' => 'admin_referer']);
        }

        $lang = strtolower(trim($request->input('lang', '')));
        $path = $request->input('path', '/');

        if ($lang && strlen($lang) <= 10) {
            session(['bhashini_lang' => $lang]);

            try {
                // Update the most recent page hit for this session if within 5 minutes
                $recent = SiteAnalytic::where('session_id', session()->getId())
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($recent && $recent->created_at->diffInMinutes(now()) < 5) {
                    $recent->update([
                        'bhashini_lang' => $lang,
                        'is_bhashini' => true,
                    ]);
                } else {
                    SiteAnalytic::create([
                        'session_id' => session()->getId(),
                        'ip_address' => substr($request->ip(), 0, 45),
                        'url' => substr($request->fullUrl(), 0, 190),
                        'path' => substr($path, 0, 190),
                        'page_title' => 'Bhashini Language Switch (' . strtoupper($lang) . ')',
                        'locale' => 'bhashini',
                        'bhashini_lang' => $lang,
                        'is_bhashini' => true,
                        'device_type' => 'Desktop',
                        'view_date' => now()->toDateString(),
                    ]);
                }
            } catch (\Throwable $e) {}

            return response()->json(['success' => true, 'lang' => $lang])
                ->cookie('bhashini_language', $lang, 60 * 24 * 30);
        }

        return response()->json(['success' => false], 400);
    }
}
