<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalCase;

class LegalCaseSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\LegalCase::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $cases = [
            [
                'case_title' => 'Guest Injury Liability - Pool Area',
                'case_description' => 'Guest slipped near the pool area claiming lack of signage. Seeking compensation for medical expenses.',
                'case_type' => 'civil',
                'priority' => 'high',
                'status' => 'ongoing',
                'filing_date' => now()->subDays(15),
            ],
            [
                'case_title' => 'Vendor Contract Breach - Fresh Foods',
                'case_description' => 'Supplier failed to deliver goods as per schedule, causing operational delays in the cafeteria.',
                'case_type' => 'contract',
                'priority' => 'medium',
                'status' => 'pending',
                'filing_date' => now()->subDays(5),
            ],
            [
                'case_title' => 'Employee Misconduct - Theft',
                'case_description' => 'Internal investigation regarding reported theft of office supplies by an employee.',
                'case_type' => 'administrative',
                'priority' => 'urgent',
                'status' => 'ongoing',
                'filing_date' => now()->subDays(2),
            ],
            [
                'case_title' => 'Intellectual Property Dispute',
                'case_description' => 'Competitor claiming our new logo infringes on their trademark.',
                'case_type' => 'civil',
                'priority' => 'urgent',
                'status' => 'ongoing',
                'filing_date' => now()->subMonths(1),
            ],
            [
                'case_title' => 'Noise Complaint - Residential Neighbors',
                'case_description' => 'Local council received complaints about noise levels from the HVAC system at night.',
                'case_type' => 'administrative',
                'priority' => 'low',
                'status' => 'completed',
                'filing_date' => now()->subMonths(3),
            ],
            [
                'case_title' => 'Unfair Dismissal Claim - ex-Manager',
                'case_description' => 'Former manager filed a claim for unfair dismissal after restructuring.',
                'case_type' => 'employment',
                'priority' => 'high',
                'status' => 'ongoing',
                'filing_date' => now()->subWeeks(3),
            ],
            [
                'case_title' => 'Property Damage - Delivery Truck',
                'case_description' => 'Delivery truck backed into the loading bay gate causing structural damage.',
                'case_type' => 'property',
                'priority' => 'medium',
                'status' => 'pending',
                'filing_date' => now()->subDays(1),
            ],
        ];

        foreach ($cases as $index => $case) {
            LegalCase::create(array_merge($case, [
                'case_number' => 'CASE-' . now()->year . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]));
        }
    }
}
