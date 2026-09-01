<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalContract;
use App\Models\User; // Assuming we assign to a user
use Illuminate\Support\Facades\DB; // Added this line for DB facade

class LegalContractSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\LegalContract::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ensure we have a user to assign contracts to
        $user = User::first() ?? User::factory()->create();

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
                'expiration_date' => null, // Indefinite
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
            ],
            [
                'title' => 'Consulting Agreement - Marketing Strategy',
                'counterparty_name' => 'Alpha Marketing Group',
                'type' => 'Service Agreement',
                'status' => 'Active',
                'effective_date' => now()->subMonths(1),
                'expiration_date' => now()->addMonths(5),
                'contract_value' => 50000.00,
                'department' => 'Marketing',
                'description' => 'Consulting services for Q3 branding campaign.',
            ],
            [
                'title' => 'Software License Agreement',
                'counterparty_name' => 'SoftWarez LLC',
                'type' => 'Service Agreement',
                'status' => 'Pending Review',
                'effective_date' => now()->addDays(5),
                'expiration_date' => now()->addYears(1),
                'contract_value' => 5000.00,
                'department' => 'IT',
                'description' => 'License for enterprise project management software.',
            ],
            [
                'title' => 'Event Venue Rental',
                'counterparty_name' => 'Grand Hotel',
                'type' => 'Lease',
                'status' => 'Draft',
                'effective_date' => now()->addMonths(2),
                'expiration_date' => now()->addMonths(2)->addDays(3),
                'contract_value' => 12000.00,
                'department' => 'General',
                'description' => 'Venue rental for annual company gala.',
            ],
            [
                'title' => 'Freelance Designer Contract',
                'counterparty_name' => 'Jane Smith',
                'type' => 'Service Agreement',
                'status' => 'Terminated',
                'effective_date' => now()->subMonths(6),
                'expiration_date' => now()->subMonths(1),
                'contract_value' => 3000.00,
                'department' => 'Marketing',
                'description' => 'Freelance graphic design services.',
            ],
            [
                'title' => 'Equipment Lease - Copiers',
                'counterparty_name' => 'Office Solutions',
                'type' => 'Lease',
                'status' => 'Active',
                'effective_date' => now()->subYears(1),
                'expiration_date' => now()->addYears(2),
                'contract_value' => 8000.00,
                'department' => 'Operations',
                'description' => 'Lease of 3 heavy-duty copiers.',
            ],
        ];

        foreach ($contracts as $contractData) {
            LegalContract::create(array_merge($contractData, [
                'user_id' => $user->id,
                'contract_number' => 'CTR-' . now()->year . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            ]));
        }
    }
}
