<?php
require 'vendor/autoload.php';

$parser = new \Smalot\PdfParser\Parser();
$files = glob('public/assets/documents/*.pdf');

foreach ($files as $f) {
    try {
        $pdf = $parser->parseFile($f);
        $text = $pdf->getText();
        echo basename($f) . ": " . strlen($text) . " chars | First 100: " . preg_replace('/\s+/', ' ', substr(trim($text), 0, 100)) . "\n";
    } catch (\Throwable $e) {
        echo basename($f) . " ERROR: " . $e->getMessage() . "\n";
    }
}
