<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LegalContract;
use App\Models\ContractRequest;
use App\Models\CompliancePermit;
use App\Models\Facility;
use App\Models\Visitor;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks to allow truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        
        LegalContract::truncate();
        ContractRequest::truncate();
        CompliancePermit::truncate();
        Facility::truncate();
        Visitor::truncate();
        
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Get or Create a User (Admin)
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'department' => 'Administration',
        ]);

        // 2. Seed Legal Contracts
        LegalContract::create([
            'title' => 'SLA - IT Support Services',
            'contract_number' => 'CTR-2024-001',
            'counterparty_name' => 'TechSolutions Inc.',
            'type' => 'Service Agreement',
            'status' => 'Active',
            'effective_date' => now()->subMonths(6),
            'expiration_date' => now()->addMonths(6),
            'contract_value' => 50000.00,
            'user_id' => $user->id,
            'department' => 'IT',
            'description' => 'Annual support contract for server maintenance.'
        ]);

        LegalContract::create([
            'title' => 'Office Lease Renewal',
            'contract_number' => 'CTR-2024-004',
            'counterparty_name' => 'Downtown Properties Ltd.',
            'type' => 'Lease',
            'status' => 'Draft',
            'effective_date' => now()->addMonth(),
            'expiration_date' => now()->addYears(3),
            'contract_value' => 120000.00,
            'user_id' => $user->id,
            'department' => 'Admin',
            'description' => 'Lease renewal for main office building.'
        ]);

        LegalContract::create([
            'title' => 'NDA - Project X',
            'contract_number' => 'CTR-2024-008',
            'counterparty_name' => 'Innovate Corp',
            'type' => 'NDA',
            'status' => 'Pending Signature',
            'effective_date' => now(),
            'expiration_date' => now()->addYears(1),
            'contract_value' => 0.00,
            'user_id' => $user->id,
            'department' => 'R&D',
            'description' => 'Non-disclosure agreement for joint venture discussions.'
        ]);

        // 3. Seed Contract Requests
        ContractRequest::create([
            'title' => 'Marketing Agency NDA',
            'requester_id' => $user->id,
            'department' => 'Marketing',
            'description' => 'NDA for upcoming summer campaign pitch with external agency.',
            'counterparty_name' => 'AdMasters LLC',
            'priority' => 'High',
            'status' => 'Approved',
            'desired_date' => now()->addDays(5),
        ]);

        ContractRequest::create([
            'title' => 'Office Supply Procurement',
            'requester_id' => $user->id,
            'department' => 'Admin',
            'description' => 'Standard procurement contract for Q1 office supplies.',
            'counterparty_name' => 'OfficeDepot',
            'priority' => 'Medium',
            'status' => 'Pending Approval',
            'desired_date' => now()->addDays(10),
        ]);

        // 4. Seed Compliance Permits
        CompliancePermit::create([
            'name' => 'Business Operation Permit',
            'issuing_authority' => 'City Council',
            'reference_number' => 'PER-2024-001',
            'expiration_date' => now()->addYear(),
            'status' => 'Valid',
            'compliance_score' => 100,
            'notes' => 'Renewed last month.'
        ]);

        CompliancePermit::create([
            'name' => 'Environmental Clearance',
            'issuing_authority' => 'Dept. of Environment',
            'reference_number' => 'ENV-2023-055',
            'expiration_date' => now()->addDays(15), // Expiring soon
            'status' => 'Expiring Soon',
            'compliance_score' => 80,
            'notes' => 'Docs pending for renewal.'
        ]);

        // 5. Seed Facilities
        Facility::create([
            'name' => 'Grand Conference Room',
            'location' => 'Building A, Floor 2',
            'description' => 'Main conference room equipped with video conferencing system and whiteboard.',
            'status' => 'Available',
            'capacity' => 20,
            'amenities' => ['WiFi', 'Projector', 'Whiteboard', 'Video Conf'],
            'pricing_type' => 'Free',
            'price_per_hour' => 0.00,
            'is_bookable' => true,
        ]);

        Facility::create([
            'name' => 'Training Room A',
            'location' => 'Building B, Floor 1',
            'description' => 'Ideal for workshops and training sessions. Modular seating arrangement.',
            'status' => 'Occupied',
            'capacity' => 15,
            'amenities' => ['WiFi', 'Whiteboard'],
            'pricing_type' => 'Free',
            'price_per_hour' => 0.00,
            'is_bookable' => true,
        ]);

        Facility::create([
            'name' => 'Portable Projector',
            'location' => 'IT Storage',
            'description' => 'High-definition portable projector for use in non-equipped rooms.',
            'status' => 'Available',
            'capacity' => 0,
            'amenities' => ['Battery', 'HDMI'],
            'pricing_type' => 'Hourly',
            'price_per_hour' => 50.00, // Just for demo
            'is_bookable' => true,
            'facility_type' => 'Equipment'
        ]);

        // 6. Seed Visitors (Pre-registrations)
        Visitor::create([
            'name' => 'Michael Ross',
            'email' => 'mike@consulting.com',
            'phone' => '555-0123',
            'company' => 'Ross Consulting',
            'host_id' => $user->id,
            'purpose' => 'Contract Review',
            'status' => 'pending',
            'scheduled_date' => now()->addDays(1),
            'scheduled_time' => '10:00:00',
        ]);

        Visitor::create([
            'name' => 'Jane Doe',
            'email' => 'jane@audit.com',
            'phone' => '555-0124',
            'company' => 'Audit Firm',
            'host_id' => $user->id,
            'purpose' => 'Annual Audit',
            'status' => 'pending',
            'scheduled_date' => now()->addDays(2),
            'scheduled_time' => '09:00:00',
        ]);

        Visitor::create([
            'name' => 'Delivery Driver',
            'company' => 'FedEx',
            'host_id' => $user->id,
            'purpose' => 'Delivery',
            'status' => 'approved',
            'scheduled_date' => now(),
            'scheduled_time' => '14:00:00',
        ]);
    }
}
