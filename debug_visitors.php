<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$visitors = App\Models\Visitor::latest()->take(5)->get();
foreach ($visitors as $v) {
    echo "ID: {$v->id} | Name: {$v->name} | Photo: " . ($v->profile_photo_url ?? 'NULL') . "\n";
}
