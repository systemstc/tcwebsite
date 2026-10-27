<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// 1. In Pages
$pages = \App\Models\Page::all();
$pagePdfs = [];
foreach ($pages as $p) {
    if (preg_match_all('/(?:href|src)="([^"]+\.pdf)"/i', $p->content_en, $m)) {
        foreach ($m[1] as $url) {
            $pagePdfs[$url][] = $p->slug;
        }
    }
}
echo "Found " . count($pagePdfs) . " distinct PDF URLs inside Pages content.\n";
foreach (array_slice($pagePdfs, 0, 10) as $url => $slugs) {
    echo " - $url (in: " . implode(', ', $slugs) . ")\n";
}

// 2. In Documents table
echo "Documents count: " . \App\Models\Document::count() . "\n";

// 3. In WhatsNew table
echo "WhatsNew count: " . \App\Models\WhatsNew::count() . "\n";

// 4. In Tenders table
echo "Tenders count: " . \App\Models\Tender::count() . "\n";
