<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Folder;
use App\Models\Document;
use App\Models\User;

class LegalVaultSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Folder::where('category', 'legal')->delete();
        \App\Models\Document::where('category', 'legal')->delete();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::first() ?? User::factory()->create();

        // 1. Create Root Category Folders
        $rootFolders = [
            'Contracts Archive' => ['Service Agreements', 'Employment', 'NDAs', 'Leases'],
            'Corporate Governance' => ['Board Resolutions', 'Incorporation Docs', 'By-Laws'],
            'Case Evidence' => ['Case #2024-001', 'Case #2024-002', 'Case #2024-003'],
            'Compliance & Policies' => ['Permits', 'GDPR', 'Company Policies'],
            'Intellectual Property' => ['Trademarks', 'Patents', 'Copyrights'],
        ];

        foreach ($rootFolders as $rootName => $subFolders) {
            $root = Folder::create([
                'name' => $rootName,
                'description' => $rootName . ' root folder',
                'user_id' => $user->id,
                'department' => 'Legal',
                'category' => 'legal',
            ]);

            foreach ($subFolders as $subName) {
                $sub = Folder::create([
                    'name' => $subName,
                    'description' => $subName . ' subfolder',
                    'parent_id' => $root->id,
                    'user_id' => $user->id,
                    'department' => 'Legal',
                    'category' => 'legal',
                ]);

                // 2. Populate Documents in Subfolders
                $this->createDocumentsForFolder($sub, $user);
            }
        }
    }

    private function createDocumentsForFolder($folder, $user)
    {
        $docTypes = [
            ['Suffix' => '_v1.pdf', 'Status' => 'released'],
            ['Suffix' => '_signed.pdf', 'Status' => 'archived'],
            ['Suffix' => '_draft.docx', 'Status' => 'pending_release'],
        ];

        for ($i = 0; $i < rand(2, 5); $i++) {
            $docType = $docTypes[array_rand($docTypes)];
            $title = $folder->name . ' - Document ' . ($i + 1);

            Document::create([
                'title' => $title,
                'description' => 'Legal document relating to ' . $folder->name,
                'department' => 'Legal',
                'folder_id' => $folder->id,
                'file_path' => 'legal/vault/' . \Illuminate\Support\Str::slug($title) . $docType['Suffix'],
                'status' => $docType['Status'],
                'uploaded_by' => $user->id,
                'category' => 'legal',
                'confidentiality' => 'confidential',
                'version' => 1,
                'view_count' => rand(0, 50),
                'download_count' => rand(0, 10),
                'created_at' => now()->subDays(rand(1, 100)),
            ]);
        }
    }
}
