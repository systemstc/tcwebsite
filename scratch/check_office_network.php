<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$page = \App\Models\Page::find(11);
file_put_contents('scratch/page_11_full.html', $page->content_en);
echo "Full page 11 saved to scratch/page_11_full.html (" . strlen($page->content_en) . " bytes)\n";
