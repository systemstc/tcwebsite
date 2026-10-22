<?php
$content = file_get_contents('resources/views/admin/pages/visual-editor.blade.php');

$components = [
    'dbim_full_layout',
    'dbim_vision_box',
    'dbim_objectives_3col',
    'dbim_image_with_text',
    'dbim_data_table',
    'dbim_advanced_table',
    'dbim_directory_table',
    'dbim_faq_component',
    'dbim_contact_us_section',
    'dbim_single_doc_card'
];

foreach ($components as $comp) {
    echo "==========================================\n";
    echo "COMPONENT: $comp\n";
    echo "==========================================\n";
    if (preg_match('/case\s+[\'"]' . preg_quote($comp, '/') . '[\'"]:\s*return\s*`([\s\S]*?)`;/i', $content, $m)) {
        echo trim($m[1]) . "\n\n";
    } elseif (preg_match('/data-component="' . preg_quote($comp, '/') . '"[\s\S]*?(?:<\/div>|<\/section>)/i', $content, $m)) {
        echo substr($m[0], 0, 500) . "\n\n";
    } else {
        echo "Not matched via case\n";
    }
}
