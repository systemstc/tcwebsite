<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$tables = ['pages', 'documents', 'whats_news', 'schemes', 'tenders', 'industry_tech_issues'];
foreach ($tables as $t) {
    echo $t . ": " . implode(', ', \Illuminate\Support\Facades\Schema::getColumnListing($t)) . "\n";
}
