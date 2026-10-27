<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$cacheDir = storage_path('app/pdf_text_cache');
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0777, true);
}

$pdfDirs = [
    public_path('assets/documents'),
    public_path('uploads/documents'),
    public_path('assets/images'),
    storage_path('app/public/whats_new'),
];

$pdfFiles = [];
foreach ($pdfDirs as $dir) {
    if (is_dir($dir)) {
        $matched = glob($dir . '/*.pdf');
        if ($matched) {
            $pdfFiles = array_merge($pdfFiles, $matched);
        }
    }
}
$pdfFiles = array_unique($pdfFiles);

echo "Total PDFs to index: " . count($pdfFiles) . "\n";
$parser = new \Smalot\PdfParser\Parser();
$indexed = 0;
$skipped = 0;

foreach ($pdfFiles as $filePath) {
    $mtime = filemtime($filePath);
    $cacheFile = $cacheDir . '/' . md5($filePath . '_' . $mtime) . '.txt';

    if (file_exists($cacheFile)) {
        $skipped++;
        continue;
    }

    try {
        $pdf = $parser->parseFile($filePath);
        $text = $pdf->getText();
        file_put_contents($cacheFile, $text);
        $indexed++;
    } catch (\Throwable $e) {
        // empty file on failure
        file_put_contents($cacheFile, '');
    }
}

echo "Indexing complete! Newly indexed: $indexed, Already cached: $skipped\n";
