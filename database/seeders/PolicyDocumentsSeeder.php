<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PolicyDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the PDF files to import
        $pdfFiles = [
            [
                'filename' => 'SUSPENSION-POLICY_20260206_042021_0000.pdf',
                'title' => 'Suspension Policy',
                'category' => 'policy',
                'department' => 'Human Resources',
                'description' => 'Company policy regarding employee suspension procedures and guidelines.',
            ],
            [
                'filename' => 'ABSENT-WITHOUT-LEAVE-POLICY_20260206_041555_0000.pdf',
                'title' => 'Absent Without Leave Policy',
                'category' => 'policy',
                'department' => 'Human Resources',
                'description' => 'Policy covering absenteeism and unauthorized leave procedures.',
            ],
            [
                'filename' => 'PROCUREMENT-CONTRACT-AGREEMENT_20260206_041017_0000.pdf',
                'title' => 'Procurement Contract Agreement',
                'category' => 'contract',
                'department' => 'Legal',
                'description' => 'Standard procurement contract agreement template.',
            ],
            [
                'filename' => 'TABLE-RESERVATION-AND-EVENT-RESERVATION-TERMS-CONDITIONS_20260206_035741_0000.pdf',
                'title' => 'Table & Event Reservation Terms and Conditions',
                'category' => 'policy',
                'department' => 'Operations',
                'description' => 'Terms and conditions for table and event reservations.',
            ],
            [
                'filename' => 'EMPLOYEE CONTRACT & HR POLICY AGREEMENT_20260205_111351_0000.pdf',
                'title' => 'Employee Contract & HR Policy Agreement',
                'category' => 'contract',
                'department' => 'Human Resources',
                'description' => 'Standard employee contract and HR policy agreement document.',
            ],
        ];

        $sourceDir = base_path(); // Root directory where PDFs are located
        $destinationDir = 'documents/policies'; // Storage destination

        foreach ($pdfFiles as $pdfData) {
            $sourcePath = $sourceDir . '/' . $pdfData['filename'];

            // Check if file exists in root directory
            if (!File::exists($sourcePath)) {
                $this->command->warn("File not found: {$pdfData['filename']}");
                continue;
            }

            // Get file size
            $fileSize = File::size($sourcePath);
            $fileSizeKB = round($fileSize / 1024, 2);

            // Copy file to storage
            $storagePath = $destinationDir . '/' . $pdfData['filename'];
            Storage::disk('public')->put($storagePath, File::get($sourcePath));

            // Create document record with only basic required fields
            $document = Document::create([
                'title' => $pdfData['title'],
                'description' => $pdfData['description'],
                'file_path' => $storagePath,
                'status' => 'Draft',
                'uploaded_by' => 1,
            ]);

            $this->command->info("✓ Imported: {$pdfData['title']} ({$fileSizeKB} KB)");
        }

        $this->command->info("Successfully imported " . count($pdfFiles) . " policy documents.");
    }
}
