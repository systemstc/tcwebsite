<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\IndustryTechIssue;
use App\Models\Scheme;
use App\Models\Announcement;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml for Textiles Committee
     */
    public function sitemap()
    {
        return $this->index();
    }

    public function index()
    {
        $baseUrl = 'https://textilescommittee.gov.in';

        $urls = [];

        // 1. Core Top-Level Routes
        $urls[] = [
            'loc' => $baseUrl,
            'lastmod' => now()->toDateString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        $urls[] = [
            'loc' => $baseUrl . '/industry-tech-issues',
            'lastmod' => now()->toDateString(),
            'changefreq' => 'daily',
            'priority' => '0.9',
        ];

        // 2. All Published Pages
        $pages = Page::where('is_active', true)->get();
        foreach ($pages as $p) {
            $urls[] = [
                'loc' => $baseUrl . '/page/' . $p->slug,
                'lastmod' => $p->updated_at ? $p->updated_at->toDateString() : now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => ($p->slug === 'contact-us' || $p->slug === 'about-us' || $p->slug === 'inspection-service') ? '0.9' : '0.8',
            ];
        }

        // 3. Industry Tech Issues
        $issues = IndustryTechIssue::where('is_active', true)->get();
        foreach ($issues as $i) {
            $urls[] = [
                'loc' => $baseUrl . '/industry-tech-issues/' . $i->slug,
                'lastmod' => $i->updated_at ? $i->updated_at->toDateString() : now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $u['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $u['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $u['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }

    /**
     * Generate dynamic robots.txt
     */
    public function robots()
    {
        $txt = "User-agent: *\n";
        $txt .= "Allow: /\n";
        $txt .= "Disallow: /admin/\n";
        $txt .= "Disallow: /api/\n";
        $txt .= "Disallow: /tcwebsite/public/admin/\n";
        $txt .= "\n";
        $txt .= "Sitemap: https://textilescommittee.gov.in/sitemap.xml\n";

        return response($txt, 200, ['Content-Type' => 'text/plain; charset=utf-8']);
    }
}
