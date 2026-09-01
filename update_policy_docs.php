<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Document;

// Update the recently imported documents with proper types
$updates = [
    'Suspension Policy' => ['category' => 'policy', 'department' => 'Human Resources'],
    'Absent Without Leave Policy' => ['category' => 'policy', 'department' => 'Human Resources'],
    'Procurement Contract Agreement' => ['category' => 'contract', 'department' => 'Legal'],
    'Table & Event Reservation Terms and Conditions' => ['category' => 'policy', 'department' => 'Operations'],
    'Employee Contract & HR Policy Agreement' => ['category' => 'contract', 'department' => 'Human Resources'],
];

foreach ($updates as $title => $data) {
    $doc = Document::where('title', $title)->first();
    if ($doc) {
        $doc->update($data);
        echo "✓ Updated: $title\n";
    }
}

// Display all documents
echo "\n--- All Documents in Vault ---\n";
$documents = Document::orderBy('created_at', 'desc')->take(10)->get(['id', 'title', 'category', 'department', 'status']);
foreach ($documents as $doc) {
    echo "ID: {$doc->id} | {$doc->title} | Type: {$doc->category} | Dept: {$doc->department} | Status: {$doc->status}\n";
}

echo "\nTotal Documents: " . Document::count() . "\n";
