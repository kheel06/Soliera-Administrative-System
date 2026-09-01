<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LegalContract;
use App\Models\LegalCase;
use App\Models\CompliancePermit;
use App\Models\ContractRequest;
use App\Models\AccessLog;
use App\Models\VisitorViolation;
use App\Models\Visitor;
use Carbon\Carbon;

class ExecutiveDashboardSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create the Owner user
        $owner = User::where('role', 'Owner')->first();
        if (!$owner) {
            $owner = User::first();
        }

        // Seed Contracts with realistic data
        $this->seedContracts($owner);

        // Seed Compliance Permits
        $this->seedPermits();

        // Seed Legal Cases
        $this->seedCases($owner);

        // Seed Contract Requests
        $this->seedContractRequests($owner);

        // Seed Access Logs
        $this->seedAccessLogs($owner);

        // Seed Visitor Violations
        $this->seedVisitorViolations();
    }

    private function seedContracts($owner)
    {
        // Only seed if we have few contracts
        if (LegalContract::count() >= 10) {
            return;
        }

        $contracts = [
            // High-value contracts
            [
                'title' => 'Building Maintenance Agreement',
                'counterparty_name' => 'Premier Facilities Management',
                'type' => 'Service Agreement',
                'status' => 'Active',
                'effective_date' => now()->subMonths(6),
                'expiration_date' => now()->addMonths(18),
                'contract_value' => 450000.00,
                'department' => 'Operations',
                'description' => 'Comprehensive building maintenance and janitorial services.',
            ],
            [
                'title' => 'IT Infrastructure Support',
                'counterparty_name' => 'TechPro Solutions Inc.',
                'type' => 'Service Agreement',
                'status' => 'Active',
                'effective_date' => now()->subMonths(3),
                'expiration_date' => now()->addDays(25), // Expiring soon!
                'contract_value' => 180000.00,
                'department' => 'IT',
                'description' => 'Network infrastructure and IT support services.',
            ],
            [
                'title' => 'Corporate Insurance Policy',
                'counterparty_name' => 'Global Insurance Corp',
                'type' => 'Insurance',
                'status' => 'Active',
                'effective_date' => now()->subMonths(8),
                'expiration_date' => now()->addMonths(4),
                'contract_value' => 85000.00,
                'department' => 'Finance',
                'description' => 'Comprehensive corporate liability and property insurance.',
            ],
            [
                'title' => 'Office Lease Agreement - Tower A',
                'counterparty_name' => 'Metro Commercial Properties',
                'type' => 'Lease',
                'status' => 'Active',
                'effective_date' => now()->subYears(2),
                'expiration_date' => now()->addYears(3),
                'contract_value' => 2400000.00,
                'department' => 'Operations',
                'description' => 'Primary office space lease for floors 15-17.',
            ],
            // Medium-value contracts
            [
                'title' => 'Marketing Campaign - Q1 2026',
                'counterparty_name' => 'Creative Digital Agency',
                'type' => 'Service Agreement',
                'status' => 'Pending Signature',
                'effective_date' => now()->addDays(10),
                'expiration_date' => now()->addMonths(6),
                'contract_value' => 75000.00,
                'department' => 'Marketing',
                'description' => 'Digital marketing campaign for new product launch.',
            ],
            [
                'title' => 'HR Consulting Services',
                'counterparty_name' => 'PeopleFirst Consulting',
                'type' => 'Consulting',
                'status' => 'Pending Review',
                'effective_date' => now()->addDays(5),
                'expiration_date' => now()->addMonths(12),
                'contract_value' => 48000.00,
                'department' => 'HR',
                'description' => 'Organizational development and HR process consulting.',
            ],
            [
                'title' => 'Cloud Services Agreement',
                'counterparty_name' => 'Azure Cloud Philippines',
                'type' => 'Service Agreement',
                'status' => 'Active',
                'effective_date' => now()->subMonths(10),
                'expiration_date' => now()->addDays(45),
                'contract_value' => 36000.00,
                'department' => 'IT',
                'description' => 'Cloud hosting and storage services.',
            ],
            // Low-value contracts
            [
                'title' => 'Office Supplies Agreement',
                'counterparty_name' => 'National Bookstore Corp',
                'type' => 'Vendor Contract',
                'status' => 'Active',
                'effective_date' => now()->subMonths(4),
                'expiration_date' => now()->addMonths(8),
                'contract_value' => 15000.00,
                'department' => 'Operations',
                'description' => 'Annual office supplies procurement.',
            ],
            [
                'title' => 'NDA - Strategic Partnership',
                'counterparty_name' => 'InnovatePH Corp',
                'type' => 'NDA',
                'status' => 'Active',
                'effective_date' => now()->subMonths(2),
                'expiration_date' => now()->addYears(2),
                'contract_value' => 0.00,
                'department' => 'Legal',
                'description' => 'Non-disclosure for potential joint venture.',
            ],
            [
                'title' => 'Catering Services',
                'counterparty_name' => 'Gourmet Events Catering',
                'type' => 'Service Agreement',
                'status' => 'Expired',
                'effective_date' => now()->subYears(1),
                'expiration_date' => now()->subDays(15),
                'contract_value' => 25000.00,
                'department' => 'Operations',
                'description' => 'Corporate event catering services. Needs renewal.',
            ],
            [
                'title' => 'Security Services Contract',
                'counterparty_name' => 'Sentinel Security Group',
                'type' => 'Service Agreement',
                'status' => 'Active',
                'effective_date' => now()->subMonths(9),
                'expiration_date' => now()->addMonths(3),
                'contract_value' => 120000.00,
                'department' => 'Operations',
                'description' => '24/7 building security and access control.',
            ],
            [
                'title' => 'Employee Benefits Package',
                'counterparty_name' => 'HealthPlus Insurance',
                'type' => 'Insurance',
                'status' => 'Draft',
                'effective_date' => now()->addMonths(1),
                'expiration_date' => now()->addYears(1)->addMonths(1),
                'contract_value' => 350000.00,
                'department' => 'HR',
                'description' => 'Comprehensive employee health and life insurance.',
            ],
        ];

        foreach ($contracts as $data) {
            LegalContract::create(array_merge($data, [
                'user_id' => $owner->id,
                'contract_number' => 'CTR-' . now()->year . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
            ]));
        }
    }

    private function seedPermits()
    {
        // Seed comprehensive permits if table is empty
        if (CompliancePermit::count() < 5) {
            $permits = [
                [
                    'name' => 'Business Permit - City of Manila',
                    'status' => 'Active',
                    'expiration_date' => now()->addMonths(10),
                    'issuing_authority' => 'City of Manila Business Bureau',
                ],
                [
                    'name' => 'Fire Safety Inspection Certificate',
                    'status' => 'Active',
                    'expiration_date' => now()->addMonths(8),
                    'issuing_authority' => 'Bureau of Fire Protection',
                ],
                [
                    'name' => 'Environmental Compliance Certificate',
                    'status' => 'Expiring Soon',
                    'expiration_date' => now()->addDays(45),
                    'issuing_authority' => 'DENR',
                ],
                [
                    'name' => 'Sanitary Permit',
                    'status' => 'Active',
                    'expiration_date' => now()->addMonths(11),
                    'issuing_authority' => 'City Health Office',
                ],
                [
                    'name' => 'Building Occupancy Permit',
                    'status' => 'Active',
                    'expiration_date' => now()->addYears(2),
                    'issuing_authority' => 'Office of the Building Official',
                ],
                [
                    'name' => 'SEC Registration',
                    'status' => 'Active',
                    'expiration_date' => null,
                    'issuing_authority' => 'Securities and Exchange Commission',
                ],
                [
                    'name' => 'BIR Certificate of Registration',
                    'status' => 'Active',
                    'expiration_date' => null,
                    'issuing_authority' => 'Bureau of Internal Revenue',
                ],
                [
                    'name' => 'SSS Employer Registration',
                    'status' => 'Active',
                    'expiration_date' => null,
                    'issuing_authority' => 'Social Security System',
                ],
                [
                    'name' => 'PhilHealth Employer Registration',
                    'status' => 'Renewal in Progress',
                    'expiration_date' => now()->addDays(15),
                    'issuing_authority' => 'Philippine Health Insurance Corporation',
                ],
                [
                    'name' => 'Pag-IBIG Employer Registration',
                    'status' => 'Active',
                    'expiration_date' => null,
                    'issuing_authority' => 'Home Development Mutual Fund',
                ],
                [
                    'name' => 'FDA LTO - Food Service',
                    'status' => 'Expired',
                    'expiration_date' => now()->subDays(10),
                    'issuing_authority' => 'Food and Drug Administration',
                ],
                [
                    'name' => 'DOLE Registration',
                    'status' => 'Active',
                    'expiration_date' => now()->addMonths(6),
                    'issuing_authority' => 'Department of Labor and Employment',
                ],
            ];

            foreach ($permits as $data) {
                CompliancePermit::create($data);
            }
        }
    }

    private function seedCases($owner)
    {
        // Add sample legal cases if table is empty
        if (LegalCase::count() < 3) {
            $cases = [
                [
                    'case_title' => 'Supplier Contract Dispute - Late Delivery',
                    'priority' => 'high',
                    'status' => 'in_progress',
                    'description' => 'Dispute with vendor regarding consistent late deliveries affecting operations.',
                    'assigned_to' => $owner->id,
                    'created_by' => $owner->id,
                ],
                [
                    'case_title' => 'Employee Wrongful Termination Claim',
                    'priority' => 'urgent',
                    'status' => 'pending',
                    'description' => 'Former employee filed wrongful termination lawsuit.',
                    'assigned_to' => $owner->id,
                    'created_by' => $owner->id,
                ],
                [
                    'case_title' => 'Trademark Infringement Investigation',
                    'priority' => 'medium',
                    'status' => 'in_progress',
                    'description' => 'Investigation of potential trademark infringement by competitor.',
                    'assigned_to' => $owner->id,
                    'created_by' => $owner->id,
                ],
                [
                    'case_title' => 'Property Boundary Dispute',
                    'priority' => 'low',
                    'status' => 'resolved',
                    'description' => 'Resolved boundary dispute with adjacent property owner.',
                    'assigned_to' => $owner->id,
                    'created_by' => $owner->id,
                ],
            ];

            foreach ($cases as $data) {
                LegalCase::create($data);
            }
        }
    }

    private function seedContractRequests($owner)
    {
        // Add sample contract requests for approvals
        if (ContractRequest::count() < 3) {
            $requests = [
                [
                    'title' => 'Enterprise Software Licensing',
                    'counterparty_name' => 'Global Tech Partners',
                    'department' => 'IT',
                    'priority' => 'high',
                    'status' => 'Pending',
                    'description' => 'Request for enterprise software licensing agreement.',
                    'requester_id' => $owner->id,
                ],
                [
                    'title' => 'Logistics Partnership Agreement',
                    'counterparty_name' => 'Pacific Logistics Inc',
                    'department' => 'Operations',
                    'priority' => 'urgent',
                    'status' => 'Pending',
                    'description' => 'Urgent logistics partnership for Q1 expansion.',
                    'requester_id' => $owner->id,
                ],
                [
                    'title' => 'Office Renovation Contract',
                    'counterparty_name' => 'Manila Construction Co',
                    'department' => 'Operations',
                    'priority' => 'high',
                    'status' => 'Pending',
                    'description' => 'Office renovation project contract.',
                    'requester_id' => $owner->id,
                ],
            ];

            foreach ($requests as $data) {
                ContractRequest::create($data);
            }
        }
    }

    private function seedAccessLogs($owner)
    {
        // Skip if there are already access logs OR if we can't properly seed them
        // (AccessLog model has special user_id requirements with DeptAccount)
        if (AccessLog::count() >= 5) {
            return;
        }

        try {
            $actions = [
                ['action' => 'Contract Signed', 'metadata' => ['module' => 'Legal', 'contract_id' => 1]],
                ['action' => 'User Login', 'metadata' => ['module' => 'Auth', 'ip' => '192.168.1.100']],
                ['action' => 'Document Downloaded', 'metadata' => ['module' => 'Vault', 'document' => 'Policy Manual']],
                ['action' => 'Permit Updated', 'metadata' => ['module' => 'Compliance', 'permit' => 'Business Permit']],
                ['action' => 'Contract Created', 'metadata' => ['module' => 'Legal', 'title' => 'New Vendor Agreement']],
            ];

            foreach ($actions as $log) {
                AccessLog::create([
                    'user_id' => 0, // Let the model handle this via booted()
                    'action' => $log['action'],
                    'metadata' => $log['metadata'],
                    'ip_address' => '192.168.1.' . rand(1, 255),
                    'created_at' => now()->subHours(rand(1, 72)),
                ]);
            }
        } catch (\Exception $e) {
            // Silently ignore access log seeding errors
        }
    }

    private function seedVisitorViolations()
    {
        // Only seed if we have visitors and few violations
        try {
            $visitor = Visitor::first();
            if ($visitor && VisitorViolation::count() < 3) {
                $violations = [
                    [
                        'visitor_id' => $visitor->id,
                        'violation_type' => 'Unauthorized Area Access',
                        'description' => 'Visitor attempted to access restricted server room.',
                        'severity' => 'high',
                        'created_at' => now()->subDays(5),
                    ],
                    [
                        'visitor_id' => $visitor->id,
                        'violation_type' => 'Overstayed Visit',
                        'description' => 'Visitor remained in premises after scheduled departure.',
                        'severity' => 'low',
                        'created_at' => now()->subDays(12),
                    ],
                ];

                foreach ($violations as $data) {
                    VisitorViolation::create($data);
                }
            }
        } catch (\Exception $e) {
            // Silently ignore visitor violation seeding errors (table may have different structure)
        }
    }
}
