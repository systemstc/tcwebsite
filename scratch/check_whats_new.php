<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$k = $app->make(Illuminate\Contracts\Console\Kernel::class);
$k->bootstrap();

echo "whats_news columns:\n";
print_r(\Illuminate\Support\Facades\Schema::getColumnListing('whats_news'));

echo "\nwhats_news records:\n";
foreach (\App\Models\WhatsNew::all() as $item) {
    print_r($item->toArray());
}
