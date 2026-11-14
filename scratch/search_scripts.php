<?php
$html = file_get_contents('scratch/instagram_raw.html');
preg_match_all('#<script[^>]*>(.*?)</script>#is', $html, $scripts);
foreach ($scripts[1] as $idx => $s) {
    if (preg_match_all('/https?:\\\\\/\\\\\/[^"\'\s]+\.(?:jpg|png|webp)/i', $s, $imgs)) {
        echo "Script $idx has " . count($imgs[0]) . " image urls\n";
    }
    if (strpos($s, 'post') !== false || strpos($s, 'timeline') !== false || strpos($s, 'media') !== false) {
        // check if user media is present
        if (strpos($s, 'edge_felix_video_timeline') !== false || strpos($s, 'edge_owner_to_timeline_media') !== false) {
            echo "Script $idx HAS TIMELINE MEDIA!\n";
        }
    }
}
