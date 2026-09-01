<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = Schema::getColumnListing('visitor');
echo "Columns in 'visitor' table:\n";
print_r($columns);

echo "\n\nColumns in 'visitors' table (if exists):\n";
$columnsPlural = Schema::getColumnListing('visitors');
print_r($columnsPlural);
