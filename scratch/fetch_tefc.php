<?php
$context = stream_context_create([
    'http' => [
        'timeout' => 15,
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
]);

$url = 'https://textilescommittee.gov.in/textile-export-facilitation-center/';
$html = @file_get_contents($url, false, $context);

if ($html) {
    file_put_contents('scratch/live_tefc.html', $html);
    echo "Saved " . strlen($html) . " bytes\n";
} else {
    echo "Failed to fetch directly, let's try with curl\n";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "Curl status: $httpCode, length: " . strlen($html) . "\n";
    if ($html) {
        file_put_contents('scratch/live_tefc.html', $html);
    }
}
