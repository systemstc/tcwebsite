<?php
require 'vendor/autoload.php';

$parser = new \Smalot\PdfParser\Parser();
$files = glob('public/uploads/documents/*.pdf');
echo "Total uploaded documents: " . count($files) . "\n";

foreach (array_slice($files, 0, 10) as $f) {
    try {
        $pdf = $parser->parseFile($f);
        $text = $pdf->getText();
        echo basename($f) . ": " . strlen($text) . " chars | First 80: " . preg_replace('/\s+/', ' ', substr(trim($text), 0, 80)) . "\n";
    } catch (\Throwable $e) {
        echo basename($f) . " ERROR: " . $e->getMessage() . "\n";
    }
}
