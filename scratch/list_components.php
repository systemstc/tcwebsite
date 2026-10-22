<?php
$content = file_get_contents('resources/views/admin/pages/visual-editor.blade.php');
preg_match_all('/data-component="([^"]+)"/', $content, $m);
$unique = array_unique($m[1]);
sort($unique);
echo "Unique components (" . count($unique) . "):\n";
foreach ($unique as $c) {
    echo " - " . $c . "\n";
}
