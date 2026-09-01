<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\LegalContract;
use App\Models\LegalCase;
use App\Models\Folder;
use App\Models\Document;
use App\Models\LegalTemplate;
use App\Models\LegalClause;
use App\Models\LegalAiResult;
use App\Models\ContractRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RestoreLegalDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Setup Legal User (Alfred Pasinag) to ensure ownership
        $legalEmail = 'khel54337@gmail.com';
        $legalUser = User::where('email', $legalEmail)->first();

        if (!$legalUser) {
            $legalUser = User::create([
                'name' => 'Alfred Pasinag',
                'email' => $legalEmail,
                'password' => Hash::make('password'),
                'role' => 'Legal officer',
                'department' => 'Administrative',
                'employee_id' => 'L250503'
            ]);
        }

        $userId = $legalUser->id;

        // DISABLE FOREIGN KEYS
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // TRUNCATE TABLES
        LegalContract::truncate();
        LegalCase::truncate();
        Folder::where('category', 'legal')->delete();
        Document::where('category', 'legal')->delete();
        LegalTemplate::truncate();
        LegalClause::truncate();
        LegalAiResult::truncate();
        ContractRequest::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. SEED CONTRACTS
        $contracts = [
            [
                'title' => 'Service Agreement - TechSolutions Inc.',
                'counterparty_name' => 'TechSolutions Inc.',
                'type' => 'Service Agreement',
                'status' => 'Active',
                'effective_date' => now()->subMonths(3),
                'expiration_date' => now()->addMonths(9),
                'contract_value' => 12500.00,
                'department' => 'IT',
                'description' => 'Annual maintenance and support contract for internal servers.',
            ],
            [
                'title' => 'NDA - Project X',
                'counterparty_name' => 'Innovate Corp',
                'type' => 'NDA',
                'status' => 'Pending Signature',
                'effective_date' => now()->subDays(2),
                'expiration_date' => now()->addYears(2),
                'contract_value' => 0.00,
                'department' => 'Legal',
                'description' => 'Non-disclosure agreement regarding upcoming joint venture.',
            ],
            [
                'title' => 'Office Lease Renewal',
                'counterparty_name' => 'Downtown Properties Ltd.',
                'type' => 'Lease',
                'status' => 'Draft',
                'effective_date' => now()->addMonths(1),
                'expiration_date' => now()->addYears(5),
                'contract_value' => 240000.00,
                'department' => 'Operations',
                'description' => 'Renewal of lease for the 5th floor office space.',
            ],
            [
                'title' => 'Employment Contract - John Doe',
                'counterparty_name' => 'John Doe',
                'type' => 'Employment',
                'status' => 'Active',
                'effective_date' => now()->subYears(1),
                'expiration_date' => null,
                'contract_value' => 65000.00,
                'department' => 'HR',
                'description' => 'Senior Developer employment contract.',
            ],
            [
                'title' => 'Vendor Supply - Fresh Foods',
                'counterparty_name' => 'Fresh Foods Co.',
                'type' => 'Vendor Contract',
                'status' => 'Expired',
                'effective_date' => now()->subYears(2),
                'expiration_date' => now()->subDays(10),
                'contract_value' => 15000.00,
                'department' => 'Operations',
                'description' => 'Supply of cafeteria ingredients. Needs renewal.',
            ]
        ];

        foreach ($contracts as $c) {
            LegalContract::create(array_merge($c, [
                'user_id' => $userId,
                'contract_number' => 'CTR-' . now()->year . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            ]));
        }

        // 3. SEED CASES
        $cases = [
            [
                'case_title' => 'Guest Injury Liability - Pool Area',
                'case_description' => 'Guest slipped near the pool area claiming lack of signage.',
                'case_type' => 'civil',
                'priority' => 'high',
                'status' => 'ongoing',
                'filing_date' => now()->subDays(15),
            ],
            [
                'case_title' => 'Vendor Contract Breach - Fresh Foods',
                'case_description' => 'Supplier failed to deliver goods as per schedule.',
                'case_type' => 'contract',
                'priority' => 'medium',
                'status' => 'pending',
                'filing_date' => now()->subDays(5),
            ],
            [
                'case_title' => 'Intellectual Property Dispute',
                'case_description' => 'Competitor claiming our new logo infringes on their trademark.',
                'case_type' => 'civil',
                'priority' => 'urgent',
                'status' => 'ongoing',
                'filing_date' => now()->subMonths(1),
            ]
        ];

        foreach ($cases as $index => $case) {
            LegalCase::create(array_merge($case, [
                'case_number' => 'CASE-' . now()->year . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]));
        }

        // 4. SEED VAULT (Folders & Docs)
        $rootFolders = [
            'Contracts Archive' => ['Service Agreements', 'Employment', 'NDAs', 'Leases'],
            'Corporate Governance' => ['Board Resolutions', 'Incorporation Docs'],
            'Case Evidence' => ['Case #2024-001'],
        ];

        foreach ($rootFolders as $rootName => $subFolders) {
            $root = Folder::create([
                'name' => $rootName,
                'description' => $rootName . ' root folder',
                'user_id' => $userId,
                'department' => 'Legal',
                'category' => 'legal',
            ]);

            foreach ($subFolders as $subName) {
                $sub = Folder::create([
                    'name' => $subName,
                    'description' => $subName,
                    'parent_id' => $root->id,
                    'user_id' => $userId,
                    'department' => 'Legal',
                    'category' => 'legal',
                ]);

                // Add dummy doc
                Document::create([
                    'title' => $subName . ' - Doc 1',
                    'document_uid' => Str::uuid(), // Fixed: Required field
                    'description' => 'Sample document',
                    'department' => 'Legal',
                    'folder_id' => $sub->id,
                    'file_path' => 'legal/vault/sample.pdf',
                    'status' => 'released',
                    'uploaded_by' => $userId,
                    'category' => 'legal',
                    'confidentiality' => 'confidential',
                    // 'version' => 1 // Removed as potential missing column
                ]);
            }
        }

        // 5. SEED TEMPLATES & CLAUSES
        LegalTemplate::create([
            'name' => 'Non-Disclosure Agreement (NDA)',
            'code' => 'NDA-2026-MUTUAL',
            'category' => 'nda',
            'description' => 'Standard mutual NDA.',
            'content' => 'STANDARD MUTUAL NDA CONTENT...',
            'version' => '3.2',
            'status' => 'approved',
            'tags' => ['mandatory', 'confidentiality']
        ]);

        LegalTemplate::create([
            'name' => 'Employment Contract',
            'code' => 'EMP-2026-FT',
            'category' => 'employment',
            'description' => 'Standard full-time employment agreement.',
            'content' => 'STANDARD EMPLOYMENT CONTRACT CONTENT...',
            'version' => '2.1',
            'status' => 'approved',
            'tags' => ['labor-code']
        ]);

        LegalClause::create([
            'title' => 'Confidentiality (Standard)',
            'content' => 'The Receiving Party agrees to hold in strict confidence...',
            'category' => 'General',
            'is_mandatory' => true
        ]);

        LegalClause::create([
            'title' => 'Force Majeure',
            'content' => 'Neither party shall be liable for any failure due to acts of God...',
            'category' => 'Risk',
            'is_mandatory' => true
        ]);

        // 6. SEED AI RESULTS
        LegalAiResult::create([
            'analysis_type' => 'risk_assessment',
            'document_type' => 'Vendor Agreement',
            'confidence' => 88.5,
            'risk_level' => 'high',
            'compliance_status' => 'needs_review',
            'summary' => 'Vendor Agreement with TechCorp submitted. Contains significant liability risks.',
            'ai_result' => ['title' => 'Vendor Agreement - TechCorp', 'uploader' => 'John Doe'],
            'detected_violations' => [
                ['issue' => 'Missing Termination clause', 'severity' => 'Critical', 'clause_text' => 'N/A']
            ],
            'recommendations' => ['Negotiate liability cap.'],
            'metadata' => ['title' => 'Vendor Agreement - TechCorp']
        ]);

        LegalAiResult::create([
            'analysis_type' => 'risk_assessment',
            'document_type' => 'Non-Disclosure Agreement',
            'confidence' => 95.0,
            'risk_level' => 'low',
            'compliance_status' => 'compliant',
            'summary' => 'Standard NDA with Partner X. No major issues found.',
            'ai_result' => ['title' => 'NDA - Partner X'],
            'detected_violations' => [],
            'recommendations' => ['Proceed with signing.'],
            'metadata' => ['title' => 'NDA - Partner X']
        ]);

        // 7. SEED CONTRACT REQUESTS
        ContractRequest::create([
            'title' => 'New Vendor - Office Supplies',
            'requester_id' => $userId,
            'department' => 'Administration',
            'description' => 'Need contract for new stationery supplier.',
            'counterparty_name' => 'Officeware PH',
            'priority' => 'medium',
            'status' => 'pending',
            'desired_date' => now()->addDays(15),
            'comments' => 'Please review standard terms.'
        ]);

        ContractRequest::create([
            'title' => 'Lease Renewal - Warehouse',
            'requester_id' => $userId,
            'department' => 'Logistics',
            'description' => 'Renewal for main warehouse lease.',
            'counterparty_name' => 'LogiProp Inc.',
            'priority' => 'high',
            'status' => 'in_review',
            'desired_date' => now()->addDays(30),
            'comments' => 'Urgent.'
        ]);
    }
}
