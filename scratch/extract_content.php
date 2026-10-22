<?php
$html = file_get_contents('scratch/live_tefc.html');
$dom = new DOMDocument();
@$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
$xpath = new DOMXPath($dom);

$contentNode = $xpath->query('//div[contains(@class, "entry-content")]')->item(0);

if ($contentNode) {
    // Save inner HTML
    $innerHTML = '';
    foreach ($contentNode->childNodes as $child) {
        $innerHTML .= $dom->saveHTML($child);
    }
    file_put_contents('scratch/tefc_content_raw.html', $innerHTML);
    file_put_contents('scratch/tefc_content_text.txt', strip_tags($innerHTML));
    echo "Saved tefc_content_raw.html (" . strlen($innerHTML) . " bytes) and text (" . strlen(strip_tags($innerHTML)) . " bytes)\n";
} else {
    echo "Content node not found\n";
}
