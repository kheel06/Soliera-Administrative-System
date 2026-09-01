<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\LegalDocument;
use Illuminate\Support\Str;

class SyncLegalDocs extends Command
{
    protected $signature = 'legal:sync-docs';
    protected $description = 'Scan storage legal_documents folder and sync to legal_documents table';

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $files = $disk->files('legal_documents');

        $count = 0;

        foreach ($files as $path) {
            if (!Str::endsWith(Str::lower($path), '.pdf')) continue;

            $filename = basename($path);
            $title = pathinfo($filename, PATHINFO_FILENAME);

            LegalDocument::updateOrCreate(
                ['file_path' => $path],
                [
                    'title' => $title,
                    'status' => 'approved', // Set as approved since these are existing documents
                    'department' => null, // Can be updated later
                    'description' => 'Imported from existing files'
                ]
            );

            $count++;
        }

        $this->info("Synced {$count} PDF(s) to legal_documents table.");
        return self::SUCCESS;
    }
}
