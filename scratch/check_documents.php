<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$k = $app->make(Illuminate\Contracts\Console\Kernel::class);
$k->bootstrap();

echo "Document columns:\n";
print_r(\Illuminate\Support\Facades\Schema::getColumnListing('documents'));

echo "\nDocument records:\n";
foreach (\App\Models\Document::all() as $d) {
    echo "ID {$d->id} | cat: '{$d->category}' | title: '{$d->title_en}' | desc: '{$d->description_en}' | file: '{$d->file_url}' | active: {$d->is_active}\n";
}
