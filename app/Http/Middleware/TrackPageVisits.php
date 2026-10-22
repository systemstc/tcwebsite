<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteAnalytic;
use App\Models\Setting;
use Illuminate\Support\Str;

class TrackPageVisits
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET requests for public frontend
        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            $this->recordVisit($request);
        }

        return $response;
    }

    protected function recordVisit(Request $request): void
    {
        // 1. Exclude logged-in backend administrators from visitor analytics
        if (auth()->check()) {
            return;
        }

        // 2. Exclude any clicks originating from backend admin portal (e.g. "View Live Website")
        $referer = $request->headers->get('referer', '');
        if (str_contains($referer, '/admin') || str_contains($referer, 'admin/')) {
            return;
        }

        $path = '/' . ltrim($request->path(), '/');

        // 3. Ignore admin routes, assets, api, uploads, storage, and utility paths
        $ignoredPrefixes = [
            '/admin', '/assets', '/uploads', '/css', '/js', '/api',
            '/live_api_data', '/build', '/vendor', '/favicon.ico', '/robots.txt', '/sitemap.xml'
        ];

        foreach ($ignoredPrefixes as $prefix) {
            if (str_starts_with($path, $prefix) || str_contains($path, '/admin/')) {
                return;
            }
        }

        try {
            $userAgent = $request->userAgent() ?: '';
            $deviceType = $this->detectDevice($userAgent);
            $browser = $this->detectBrowser($userAgent);
            $platform = $this->detectPlatform($userAgent);

            $locale = session('locale', 'en');
            $bhashiniLang = $request->cookie('bhashini_language') ?: session('bhashini_lang');
            $isBhashini = !empty($bhashiniLang) && $bhashiniLang !== 'en';

            $sessionId = session()->getId();

            // Guess page title from route or path
            $pageTitle = $this->guessPageTitle($path);

            SiteAnalytic::create([
                'session_id' => $sessionId ? substr($sessionId, 0, 80) : null,
                'ip_address' => substr($request->ip(), 0, 45),
                'url' => substr($request->fullUrl(), 0, 190),
                'path' => substr($path, 0, 190),
                'page_title' => $pageTitle,
                'locale' => substr($locale, 0, 15),
                'bhashini_lang' => $bhashiniLang ? substr($bhashiniLang, 0, 20) : null,
                'is_bhashini' => $isBhashini,
                'device_type' => $deviceType,
                'browser' => $browser,
                'platform' => $platform,
                'referer' => substr($request->headers->get('referer', ''), 0, 190),
                'view_date' => now()->toDateString(),
            ]);

            // Increment visitor counter in settings
            try {
                $count = (int) Setting::get('visitor_count', 8614226);
                Setting::set('visitor_count', $count + 1);
            } catch (\Throwable $e) {}

        } catch (\Throwable $e) {
            // Silently fail without interrupting user request
        }
    }

    protected function detectDevice(string $ua): string
    {
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            return 'Tablet';
        }
        if (preg_match('/(mobile|iphone|ipod|blackberry|iemobile|opera mini|windows phone)/i', $ua)) {
            return 'Mobile';
        }
        return 'Desktop';
    }

    protected function detectBrowser(string $ua): string
    {
        if (str_contains($ua, 'Edg/')) return 'Edge';
        if (str_contains($ua, 'Chrome/')) return 'Chrome';
        if (str_contains($ua, 'Firefox/')) return 'Firefox';
        if (str_contains($ua, 'Safari/') && !str_contains($ua, 'Chrome/')) return 'Safari';
        if (str_contains($ua, 'OPR/') || str_contains($ua, 'Opera/')) return 'Opera';
        return 'Other';
    }

    protected function detectPlatform(string $ua): string
    {
        if (str_contains($ua, 'Windows')) return 'Windows';
        if (str_contains($ua, 'Android')) return 'Android';
        if (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) return 'iOS';
        if (str_contains($ua, 'Macintosh') || str_contains($ua, 'Mac OS')) return 'macOS';
        if (str_contains($ua, 'Linux')) return 'Linux';
        return 'Other';
    }

    protected function guessPageTitle(string $path): string
    {
        if ($path === '/' || $path === '') {
            return 'Home Page';
        }
        if ($path === '/industry-tech-issues') {
            return 'Industry Tech Issues & Troubleshooting';
        }
        if (str_starts_with($path, '/industry-tech-issues/')) {
            return 'Technical Issue Detail';
        }
        if (str_starts_with($path, '/page/')) {
            $slug = substr($path, 6);
            return ucwords(str_replace('-', ' ', $slug));
        }
        return ucwords(trim(str_replace('/', ' - ', $path), ' - '));
    }
}
