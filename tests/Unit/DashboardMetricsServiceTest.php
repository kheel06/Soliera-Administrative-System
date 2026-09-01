<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\DashboardMetricsService;
use App\Models\Visitor;
use App\Models\Document;
use App\Models\LegalCase;
use App\Models\FacilityReservation;
use App\Models\DeptAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class DashboardMetricsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected DashboardMetricsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DashboardMetricsService();
    }

    /** @test */
    public function it_counts_visitors_today_correctly()
    {
        // Create visitors for today
        Visitor::factory()->count(3)->create([
            'time_in' => Carbon::now('Asia/Manila')->setHour(10),
        ]);

        // Create visitors for yesterday (should not be counted)
        Visitor::factory()->count(2)->create([
            'time_in' => Carbon::now('Asia/Manila')->subDay()->setHour(10),
        ]);

        $count = $this->service->getVisitorsToday();

        $this->assertEquals(3, $count);
    }

    /** @test */
    public function it_counts_visitors_today_across_timezone_boundaries()
    {
        // Create visitor at start of day
        Visitor::factory()->create([
            'time_in' => Carbon::now('Asia/Manila')->startOfDay(),
        ]);

        // Create visitor at end of day
        Visitor::factory()->create([
            'time_in' => Carbon::now('Asia/Manila')->endOfDay()->subSecond(),
        ]);

        // Create visitor just after midnight (tomorrow)
        Visitor::factory()->create([
            'time_in' => Carbon::now('Asia/Manila')->endOfDay()->addSecond(),
        ]);

        $count = $this->service->getVisitorsToday();

        $this->assertEquals(2, $count);
    }

    /** @test */
    public function it_counts_archived_documents_correctly()
    {
        // Archived by status
        Document::factory()->count(2)->create(['status' => 'archived', 'archived_at' => null]);

        // Archived by archived_at
        Document::factory()->count(3)->create(['status' => 'active', 'archived_at' => now()]);

        // Not archived
        Document::factory()->count(5)->create(['status' => 'active', 'archived_at' => null]);

        $count = $this->service->getArchivedDocuments();

        $this->assertEquals(5, $count);
    }

    /** @test */
    public function it_counts_total_documents_excluding_archived()
    {
        // Active documents
        Document::factory()->count(10)->create(['status' => 'active', 'archived_at' => null]);

        // Archived documents (should be excluded)
        Document::factory()->count(3)->create(['status' => 'archived', 'archived_at' => now()]);

        // Disposed documents (should be excluded)
        Document::factory()->count(2)->create(['status' => 'disposed', 'archived_at' => null]);

        $count = $this->service->getTotalDocuments();

        $this->assertEquals(10, $count);
    }

    /** @test */
    public function it_counts_total_reservations()
    {
        FacilityReservation::factory()->count(15)->create();

        $count = $this->service->getTotalReservations();

        $this->assertEquals(15, $count);
    }

    /** @test */
    public function it_counts_active_accounts_only()
    {
        // Active accounts
        DeptAccount::factory()->count(8)->create(['status' => 'active']);

        // Inactive accounts
        DeptAccount::factory()->count(3)->create(['status' => 'inactive']);

        $count = $this->service->getActiveAccounts();

        $this->assertEquals(8, $count);
    }

    /** @test */
    public function it_generates_7_day_visitor_trend_with_zero_fill()
    {
        // Create visitors only on specific days
        Visitor::factory()->create([
            'time_in' => Carbon::now('Asia/Manila')->subDays(6)->setHour(10),
        ]);
        Visitor::factory()->count(3)->create([
            'time_in' => Carbon::now('Asia/Manila')->subDays(3)->setHour(10),
        ]);
        Visitor::factory()->count(2)->create([
            'time_in' => Carbon::now('Asia/Manila')->setHour(10),
        ]);

        $trend = $this->service->getVisitorTrend();

        // Should have exactly 7 entries
        $this->assertCount(7, $trend);

        // Check structure
        $this->assertArrayHasKey('date', $trend[0]);
        $this->assertArrayHasKey('label', $trend[0]);
        $this->assertArrayHasKey('count', $trend[0]);

        // Check specific counts
        $this->assertEquals(1, $trend[0]['count']); // 6 days ago
        $this->assertEquals(0, $trend[1]['count']); // 5 days ago (zero-filled)
        $this->assertEquals(3, $trend[3]['count']); // 3 days ago
        $this->assertEquals(2, $trend[6]['count']); // today
    }

    /** @test */
    public function it_maps_legal_cases_by_status_correctly()
    {
        // Pending
        LegalCase::factory()->count(5)->create(['status' => 'pending']);

        // In Progress (various statuses)
        LegalCase::factory()->count(3)->create(['status' => 'under_investigation']);
        LegalCase::factory()->count(2)->create(['status' => 'awaiting_review']);
        LegalCase::factory()->count(1)->create(['status' => 'ongoing']);

        // Completed (various statuses)
        LegalCase::factory()->count(4)->create(['status' => 'resolved']);
        LegalCase::factory()->count(2)->create(['status' => 'completed']);

        // Not counted
        LegalCase::factory()->count(1)->create(['status' => 'not_approved']);

        $result = $this->service->getLegalCasesByStatus();

        $this->assertEquals(5, $result['pending']);
        $this->assertEquals(6, $result['in_progress']); // 3 + 2 + 1
        $this->assertEquals(6, $result['completed']); // 4 + 2
    }

    /** @test */
    public function it_returns_all_metrics_structure()
    {
        $metrics = $this->service->getAllMetrics();

        $this->assertArrayHasKey('kpis', $metrics);
        $this->assertArrayHasKey('visitor_trend', $metrics);
        $this->assertArrayHasKey('legal_cases_by_status', $metrics);
        $this->assertArrayHasKey('last_updated', $metrics);

        // Check KPIs structure
        $this->assertArrayHasKey('visitors_today', $metrics['kpis']);
        $this->assertArrayHasKey('archived_docs', $metrics['kpis']);
        $this->assertArrayHasKey('total_documents', $metrics['kpis']);
        $this->assertArrayHasKey('total_reservations', $metrics['kpis']);
        $this->assertArrayHasKey('active_accounts', $metrics['kpis']);
    }

    /** @test */
    public function it_calculates_legal_case_aging()
    {
        // Create pending cases with different ages
        LegalCase::factory()->create([
            'status' => 'pending',
            'created_at' => Carbon::now()->subDays(10),
        ]);
        LegalCase::factory()->create([
            'status' => 'pending',
            'created_at' => Carbon::now()->subDays(5),
        ]);

        $aging = $this->service->getLegalCaseAging();

        $this->assertArrayHasKey('pending', $aging);
        $this->assertArrayHasKey('in_progress', $aging);
        $this->assertArrayHasKey('completed', $aging);

        // Median of [5, 10] should be 7.5
        $this->assertEquals(7.5, $aging['pending']);
    }

    /** @test */
    public function it_gets_top_facilities()
    {
        $facility1 = \App\Models\Facility::factory()->create(['name' => 'Conference Room A']);
        $facility2 = \App\Models\Facility::factory()->create(['name' => 'Conference Room B']);

        // Create more reservations for facility1
        FacilityReservation::factory()->count(5)->create(['facility_id' => $facility1->id]);
        FacilityReservation::factory()->count(2)->create(['facility_id' => $facility2->id]);

        $topFacilities = $this->service->getTopFacilities(2);

        $this->assertCount(2, $topFacilities);
        $this->assertEquals('Conference Room A', $topFacilities[0]['facility_name']);
        $this->assertEquals(5, $topFacilities[0]['count']);
    }

    /** @test */
    public function it_calculates_document_throughput()
    {
        // Documents created in last 7 days
        Document::factory()->count(5)->create([
            'created_at' => Carbon::now()->subDays(3),
        ]);

        // Documents created in last 30 days (but not in last 7)
        Document::factory()->count(8)->create([
            'created_at' => Carbon::now()->subDays(15),
        ]);

        // Archived documents in last 30 days
        Document::factory()->count(3)->create([
            'status' => 'archived',
            'archived_at' => Carbon::now()->subDays(10),
            'created_at' => Carbon::now()->subDays(20),
        ]);

        $throughput = $this->service->getDocumentThroughput();

        $this->assertEquals(5, $throughput['last_7_days']);
        $this->assertEquals(13, $throughput['last_30_days']); // 5 + 8
        $this->assertIsFloat($throughput['archival_rate']);
    }
}
