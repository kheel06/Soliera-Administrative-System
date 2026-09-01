<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Document;
use App\Models\FacilityReservation;
use App\Models\LegalCase;
use App\Models\DeptAccount;
use Carbon\Carbon;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup a user for authentication
        $this->user = User::factory()->create([
            'email' => 'admin@example.com',
            // Assuming role logic relies on DeptAccount or similar, minimal setup here
        ]);
        $this->actingAs($this->user);
    }

    /** @test */
    public function dashboard_metrics_endpoint_returns_json_structure()
    {
        $response = $this->getJson(route('dashboard.metrics_json'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'kpis' => [
                        'visitors_today',
                        'archived_docs',
                        'total_documents',
                        'total_reservations',
                        'active_accounts',
                    ],
                    'visitor_trend',
                    'legal_cases_by_status',
                    'last_updated',
                ]
            ]);
    }

    /** @test */
    public function kpis_reflect_database_state()
    {
        // Setup parent records
        $facility = \App\Models\Facility::create(['name' => 'Test Facility', 'status' => 'active']);
        $user = DeptAccount::create(['employee_name' => 'Test User', 'status' => 'active', 'email' => 'test@example.com', 'role' => 'user']);

        // 1. Visitors Today
        // Create 2 visitors for today
        Visitor::create([
            'first_name' => 'John', 'last_name' => 'Doe', 
            'time_in' => now(), 
            'purpose' => 'Visit', 
            'facility_id' => $facility->id
        ]);
        Visitor::create([
            'first_name' => 'Jane', 'last_name' => 'Doe', 
            'time_in' => now(), 
            'purpose' => 'Visit', 
            'facility_id' => $facility->id
        ]);
        // Create 1 visitor for yesterday
        Visitor::create([
            'first_name' => 'Old', 'last_name' => 'Visitor', 
            'time_in' => now()->subDay(), 
            'purpose' => 'Visit', 
            'facility_id' => $facility->id
        ]);

        // 2. Archived Docs
        Document::create(['title' => 'Doc 1', 'status' => 'archived', 'reference_number' => 'DOC-001', 'type' => 'memo']);
        Document::create(['title' => 'Doc 2', 'status' => 'active', 'archived_at' => now(), 'reference_number' => 'DOC-002', 'type' => 'memo']);
        
        // 3. Total Documents (Active)
        Document::create(['title' => 'Active 1', 'status' => 'active', 'archived_at' => null, 'reference_number' => 'DOC-003', 'type' => 'memo']);
        Document::create(['title' => 'Active 2', 'status' => 'active', 'archived_at' => null, 'reference_number' => 'DOC-004', 'type' => 'memo']);
        Document::create(['title' => 'Active 3', 'status' => 'active', 'archived_at' => null, 'reference_number' => 'DOC-005', 'type' => 'memo']);
        
        // 4. Upcoming Reservations
        FacilityReservation::create(['purpose' => 'Meeting', 'start_time' => now()->addDay(), 'end_time' => now()->addDay()->addHour(), 'facility_id' => $facility->id, 'reserved_by' => $user->id, 'status' => 'approved']);
        FacilityReservation::create(['purpose' => 'Event', 'start_time' => now()->addHour(), 'end_time' => now()->addHours(2), 'facility_id' => $facility->id, 'reserved_by' => $user->id, 'status' => 'approved']);
        FacilityReservation::create(['purpose' => 'Old', 'start_time' => now()->subDay(), 'end_time' => now()->subDay()->addHour(), 'facility_id' => $facility->id, 'reserved_by' => $user->id, 'status' => 'completed']);

        // 5. Active Accounts
        // $user is already created and active. Create one inactive.
        DeptAccount::create(['employee_name' => 'Inactive User', 'status' => 'inactive', 'email' => 'inactive@test.com', 'role' => 'user']);
        
        $response = $this->getJson(route('dashboard.metrics_json'));
        // Debug if fails
        if ($response->status() !== 200) {
            dump($response->json());
        }

        $response->assertStatus(200);
        $data = $response->json('data.kpis');

        $this->assertEquals(2, $data['visitors_today'], 'Visitors Today count mismatch');
        $this->assertEquals(2, $data['archived_docs'], 'Archived Docs count mismatch');
        $this->assertEquals(3, $data['total_documents'], 'Total Documents count mismatch');
        $this->assertEquals(2, $data['total_reservations'], 'Upcoming Reservations count mismatch');
        $this->assertEquals(2, $data['active_accounts'], 'Active Accounts count mismatch (Includes setup user)');
    }

    /** @test */
    public function legal_case_status_grouping_is_correct()
    {
        // Common required fields for LegalCase
        $base = ['case_title' => 'Test Case', 'case_description' => 'Test', 'priority' => 'low'];

        // Pending
        LegalCase::create(array_merge($base, ['status' => 'pending', 'case_number' => 'LC-001']));
        
        // In Progress (various statuses)
        LegalCase::create(array_merge($base, ['status' => 'under_investigation', 'case_number' => 'LC-002']));
        LegalCase::create(array_merge($base, ['status' => 'awaiting_review', 'case_number' => 'LC-003']));
        
        // Completed
        LegalCase::create(array_merge($base, ['status' => 'resolved', 'case_number' => 'LC-004']));
        LegalCase::create(array_merge($base, ['status' => 'completed', 'case_number' => 'LC-005']));
        LegalCase::create(array_merge($base, ['status' => 'closed', 'case_number' => 'LC-006']));

        // Excluded
        LegalCase::create(array_merge($base, ['status' => 'rejected', 'case_number' => 'LC-007']));

        $response = $this->getJson(route('dashboard.metrics_json'));
        $legal = $response->json('data.legal_cases_by_status');

        $this->assertEquals(1, $legal['pending'], 'Pending cases mismatch');
        $this->assertEquals(2, $legal['in_progress'], 'In Progress cases mismatch');
        $this->assertEquals(3, $legal['completed'], 'Completed cases mismatch');
    }
}
