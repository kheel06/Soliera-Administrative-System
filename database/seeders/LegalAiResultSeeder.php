<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegalAiResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\LegalAiResult::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. High Risk Vendor Agreement
        \App\Models\LegalAiResult::create([
            'document_id' => null, // Placeholder, normally linked to a Document
            'analysis_type' => 'risk_assessment',
            'document_type' => 'Vendor Agreement',
            'confidence' => 88.5,
            'risk_level' => 'high',
            'compliance_status' => 'needs_review',
            'summary' => 'Vendor Agreement with TechCorp submitted by John Doe. Contains significant liability risks.',
            'ai_result' => ['title' => 'Vendor Agreement - TechCorp', 'uploader' => 'John Doe', 'time' => '2 hours ago'],
            'detected_violations' => [
                [
                    'issue' => 'Missing Termination for Convenience clause',
                    'severity' => 'Critical',
                    'clause_text' => 'N/A'
                ],
                [
                    'issue' => 'Indemnity Cap is unlimited',
                    'severity' => 'High',
                    'clause_text' => 'Indemnification obligations shall be unlimited...'
                ]
            ],
            'recommendations' => [
                'Negotiate for a liability cap (1x-2x contract value).',
                'Insert standard termination for convenience clause.'
            ],
            'metadata' => [
                'title' => 'Vendor Agreement - TechCorp',
                'uploader' => 'John Doe',
                'uploaded_at' => now()->subHours(2)->toDateTimeString()
            ]
        ]);

        // 2. Low Risk NDA
        \App\Models\LegalAiResult::create([
            'document_id' => null,
            'analysis_type' => 'risk_assessment',
            'document_type' => 'Non-Disclosure Agreement',
            'confidence' => 95.0,
            'risk_level' => 'low',
            'compliance_status' => 'compliant',
            'summary' => 'Standard NDA with Partner X. No major issues found.',
            'ai_result' => ['title' => 'NDA - Partner X', 'uploader' => 'Sarah Lee', 'time' => 'yesterday'],
            'detected_violations' => [], // None
            'recommendations' => [
                'Proceed with signing.'
            ],
            'metadata' => [
                'title' => 'NDA - Partner X',
                'uploader' => 'Sarah Lee',
                'uploaded_at' => now()->subDay()->toDateTimeString()
            ]
        ]);

        // 3. Medium Risk Service Contract
        \App\Models\LegalAiResult::create([
            'document_id' => null,
            'analysis_type' => 'compliance_check',
            'document_type' => 'Service Contract',
            'confidence' => 91.2,
            'risk_level' => 'medium',
            'compliance_status' => 'needs_review',
            'summary' => 'Service Contract with CleaningCo. Payment terms are ambiguous.',
            'ai_result' => ['title' => 'Service Contract - CleaningCo', 'uploader' => 'Admin Assistant', 'time' => '3 days ago'],
            'detected_violations' => [
                [
                    'issue' => 'Ambiguous Payment Terms',
                    'severity' => 'Medium',
                    'clause_text' => 'Payment shall be made within a reasonable time...'
                ]
            ],
            'recommendations' => [
                'Specify exact payment terms (e.g., Net 30).'
            ],
            'metadata' => [
                'title' => 'Service Contract - CleaningCo',
                'uploader' => 'Admin Assistant',
                'uploaded_at' => now()->subDays(3)->toDateTimeString()
            ]
        ]);
    }
}
