<?php
$html = file_get_contents('scratch/live_tefc.html');

// Load HTML in DOMDocument
$dom = new DOMDocument();
@$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
$xpath = new DOMXPath($dom);

// Look for article, main content, entry-content, content, etc.
$nodes = $xpath->query('//article | //div[contains(@class, "entry-content")] | //div[contains(@class, "content")] | //main');

echo "Found content nodes: " . $nodes->length . "\n";

foreach ($nodes as $i => $node) {
    echo "--- Node $i (" . $node->nodeName . " class: " . $node->getAttribute('class') . ") ---\n";
    echo substr(strip_tags($node->textContent), 0, 800) . "\n\n";
}
