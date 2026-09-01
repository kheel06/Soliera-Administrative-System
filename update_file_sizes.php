<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Document;
use Illuminate\Support\Facades\Storage;

// Update file sizes for all documents
$documents = Document::whereNotNull('file_path')->get();

foreach ($documents as $doc) {
    $filePath = storage_path('app/public/' . $doc->file_path);

    if (file_exists($filePath)) {
        $fileSize = filesize($filePath);
        $fileSizeKB = round($fileSize / 1024, 2);

        // Update metadata
        $metadata = $doc->metadata ?? [];
        $metadata['file_size'] = $fileSizeKB . ' KB';

        $doc->update([
            'metadata' => $metadata,
            'file_size' => $fileSizeKB . ' KB' // Also update direct field if exists
        ]);

        echo "✓ Updated file size for: {$doc->title} ({$fileSizeKB} KB)\n";
    } else {
        echo "✗ File not found for: {$doc->title} (Path: {$filePath})\n";
    }
}

echo "\nTotal processed: " . $documents->count() . " documents\n";
