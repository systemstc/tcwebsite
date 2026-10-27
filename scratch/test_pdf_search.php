<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

class PdfSearchHelper {
    public static function searchInPdfs($keyword, $maxResults = 10) {
        $keyword = trim($keyword);
        if (strlen($keyword) < 2) return [];

        $cacheDir = storage_path('app/pdf_text_cache');
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        // Collect all PDFs
        $pdfFiles = array_merge(
            glob(public_path('assets/documents/*.pdf')),
            glob(public_path('uploads/documents/*.pdf')),
            glob(public_path('assets/images/*.pdf'))
        );

        $parser = new \Smalot\PdfParser\Parser();
        $results = [];

        foreach ($pdfFiles as $filePath) {
            if (!is_file($filePath)) continue;

            $fileMtime = filemtime($filePath);
            $cacheKey = md5($filePath . '_' . $fileMtime) . '.txt';
            $cacheFile = $cacheDir . '/' . $cacheKey;

            $text = '';
            if (file_exists($cacheFile)) {
                $text = file_get_contents($cacheFile);
            } else {
                try {
                    $pdf = $parser->parseFile($filePath);
                    $text = $pdf->getText();
                    file_put_contents($cacheFile, $text);
                } catch (\Throwable $e) {
                    continue;
                }
            }

            if (empty($text)) continue;

            // Search inside text (case insensitive)
            $pos = stripos($text, $keyword);
            if ($pos !== false) {
                // Extract snippet
                $start = max(0, $pos - 100);
                $snippet = substr($text, $start, 220);
                $snippet = preg_replace('/\s+/', ' ', trim($snippet));
                
                // Format title from filename
                $filename = basename($filePath);
                $title = ucwords(str_replace(['-', '_', '.pdf'], [' ', ' ', ''], $filename));
                if (str_starts_with($filename, 'doc_')) {
                    $title = "Official Document (" . substr($filename, 0, 14) . ")";
                }

                $size = round(filesize($filePath) / 1048576, 2) . ' MB';

                // Relative URL
                $relUrl = str_replace(public_path(), '', $filePath);
                $relUrl = '/' . ltrim(str_replace('\\', '/', $relUrl), '/');

                $results[] = [
                    'file' => $filename,
                    'title' => $title,
                    'url' => $relUrl,
                    'size' => $size,
                    'snippet' => $snippet,
                ];

                if (count($results) >= $maxResults) break;
            }
        }

        return $results;
    }
}

$startTime = microtime(true);
$results = PdfSearchHelper::searchInPdfs('textiles');
$duration = round((microtime(true) - $startTime) * 1000, 2);

echo "Search for 'textiles' completed in {$duration} ms. Found " . count($results) . " matches:\n";
foreach ($results as $r) {
    echo " - " . $r['title'] . " (" . $r['size'] . ")\n";
    echo "   URL: " . $r['url'] . "\n";
    echo "   Snippet: " . substr($r['snippet'], 0, 120) . "...\n\n";
}
