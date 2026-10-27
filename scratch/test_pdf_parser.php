<?php
require 'vendor/autoload.php';

$parser = new \Smalot\PdfParser\Parser();
$file = 'public/assets/documents/tc-act-1963.pdf';
if (!file_exists($file)) {
    echo "File not found\n";
    exit;
}

$pdf = $parser->parseFile($file);
$text = $pdf->getText();
echo "Parsed " . basename($file) . ": " . strlen($text) . " characters.\n";
echo "Preview:\n" . substr(trim($text), 0, 300) . "\n";
