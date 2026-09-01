<?php

namespace App\Services;

use App\Models\LegalCase;
use App\Models\Document;
use App\Models\Visitor;
use App\Models\FacilityReservation;
use App\Models\DeptAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

/**
 * Dashboard Metrics Service
 * 
 * Provides centralized, timezone-safe metric calculations for the Admin Dashboard.
 * All metrics use real database data with proper exclusions and aggregations.
 * 
 * Timezone: Asia/Manila (configured in config/app.php)
 * No soft deletes detected in models - using status fields for exclusions
 */
class DashboardMetricsService
{
    /**
     * Get all dashboard metrics in a single call
     * 
     * @return array
     */
    public function getAllMetrics(): array
    {
        return [
            'kpis' => $this->getKPIs(),
            'visitor_trend' => $this->getVisitorTrend(),
            'legal_cases_by_status' => $this->getLegalCasesByStatus(),
            'last_updated' => now()->toIso8601String(),
        ];
    }

    /**
     * Get KPI card values
     * 
     * @return array
     */
    public function getKPIs(): array
    {
        return [
            'visitors_today' => $this->getVisitorsToday(),
            'archived_docs' => $this->getArchivedDocuments(),
            'total_documents' => $this->getTotalDocuments(),
            'total_reservations' => $this->getTotalReservations(),
            'active_accounts' => $this->getActiveAccounts(),
            'vault_folders' => $this->getVaultFoldersCount(),
        ];
    }

    /**
     * VAULT FOLDERS
     * 
     * Definition: Count of all folders in the vault
     * Table: folders
     * 
     * @return int
     */
    public function getVaultFoldersCount(): int
    {
        return \App\Models\Folder::count();
    }

    /**
     * VISITORS TODAY
     * 
     * Definition: Count of visitor check-ins where time_in is within today's date boundaries
     * Table: visitor
     * Field: time_in (datetime)
     * Exclusions: None (all check-ins count regardless of checkout status)
     * Timezone: Asia/Manila
     * 
     * @return int
     */
    public function getVisitorsToday(): int
    {
        $timezone = 'Asia/Manila';
        $todayStart = Carbon::now($timezone)->startOfDay();
        $todayEnd = Carbon::now($timezone)->endOfDay();

        return Visitor::whereBetween('time_in', [$todayStart, $todayEnd])
            ->count();
    }

    /**
     * ARCHIVED DOCUMENTS
     * 
     * Definition: Count of documents with status='archived' OR archived_at IS NOT NULL
     * Table: documents
     * Fields: status (varchar), archived_at (datetime)
     * Exclusions: None (archived means archived regardless of other fields)
     * 
     * @return int
     */
    public function getArchivedDocuments(): int
    {
        return Document::where(function ($query) {
            $query->where('status', 'archived')
                  ->orWhereNotNull('archived_at');
        })->count();
    }

    /**
     * TOTAL DOCUMENTS
     * 
     * Definition: Count of all non-archived, non-disposed documents
     * Rationale: "Total Documents" should represent active/available documents in the system
     * Table: documents
     * Field: status (varchar), archived_at (datetime)
     * Exclusions: status IN ('archived', 'disposed', 'expired') OR archived_at IS NOT NULL
     * 
     * @return int
     */
    public function getTotalDocuments(): int
    {
        return Document::whereNotIn('status', ['archived', 'disposed', 'expired'])
            ->whereNull('archived_at')
            ->count();
    }

    /**
     * UPCOMING RESERVATIONS
     * 
     * Definition: Count of facility reservations where start_time is in the future
     * Rationale: More operationally relevant for admins than "All Time"
     * Table: facility_reservations
     * Field: start_time
     * Condition: start_time >= NOW()
     * 
     * @return int
     */
    public function getTotalReservations(): int
    {
        return FacilityReservation::where('start_time', '>=', now())->count();
    }

    /**
     * ACTIVE ACCOUNTS
     * 
     * Definition: Count of department accounts with status='active'
     * Table: department_accounts
     * Field: status (varchar)
     * Exclusions: status != 'active'
     * 
     * @return int
     */
    public function getActiveAccounts(): int
    {
        return DeptAccount::where('status', 'active')->count();
    }

    /**
     * VISITOR TREND (Last 7 Days)
     * 
     * Definition: Daily visitor check-in counts for the last 7 days (including today)
     * Returns zero-filled series to ensure all 7 days are present
     * Table: visitor
     * Field: time_in (datetime)
     * Timezone: Asia/Manila
     * 
     * @return array [['date' => 'YYYY-MM-DD', 'label' => 'Mon', 'count' => 5], ...]
     */
    public function getVisitorTrend(): array
    {
        $timezone = 'Asia/Manila';
        $series = [];

        // Generate last 7 days (6 days ago to today)
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now($timezone)->subDays($i);
            $dateString = $date->toDateString();
            $dayLabel = $date->format('D'); // Mon, Tue, Wed, etc.

            // Count visitors for this specific date
            // Using whereBetween to be safe with time components
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();
            
            $count = Visitor::whereBetween('time_in', [$startOfDay, $endOfDay])->count();

            $series[] = [
                'date' => $dateString,
                'label' => $dayLabel,
                'count' => $count,
            ];
        }

        return $series;
    }

    /**
     * LEGAL CASES BY STATUS
     * 
     * Definition: Count of legal cases grouped into 3 operational categories
     * Table: legal_cases
     * Field: status (varchar)
     * 
     * Status Mapping:
     * - Pending: 'pending' (Initial stage)
     * - In Progress: 'under_investigation', 'awaiting_review', 'needs_more_info', 'ongoing'
     * - Completed: 'resolved', 'completed', 'closed'
     * 
     * Note: 'not_approved' and 'rejected' are explicitly excluded from these buckets 
     * as they are "dead" states but not "completed" in the sense of success/resolution.
     * 
     * @return array ['pending' => int, 'in_progress' => int, 'completed' => int]
     */
    public function getLegalCasesByStatus(): array
    {
        // Use DB aggregation for performance
        $statusCounts = LegalCase::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // 1. Pending
        $pending = $statusCounts['pending'] ?? 0;

        // 2. In Progress
        // Include 'new' or other active states if they exist, but sticking to known enums
        $inProgress = ($statusCounts['under_investigation'] ?? 0)
                    + ($statusCounts['awaiting_review'] ?? 0)
                    + ($statusCounts['needs_more_info'] ?? 0)
                    + ($statusCounts['ongoing'] ?? 0);

        // 3. Completed
        $completed = ($statusCounts['resolved'] ?? 0)
                   + ($statusCounts['completed'] ?? 0)
                   + ($statusCounts['closed'] ?? 0);

        return [
            'pending' => $pending,
            'in_progress' => $inProgress,
            'completed' => $completed,
        ];
    }

    /**
     * Get cached metrics with TTL
     * 
     * @param int $ttlSeconds Cache duration in seconds (default: 60)
     * @return array
     */
    public function getCachedMetrics(int $ttlSeconds = 60): array
    {
        $cacheKey = 'dashboard_metrics';

        return Cache::remember($cacheKey, $ttlSeconds, function () {
            return $this->getAllMetrics();
        });
    }

    /**
     * Clear metrics cache
     * 
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget('dashboard_metrics');
    }

    /**
     * ADDITIONAL ANALYTICS (Decision-Making Metrics)
     */

    /**
     * Legal Case Aging: Median days since creation per status
     * 
     * @return array ['pending' => float, 'in_progress' => float, 'completed' => float]
     */
    public function getLegalCaseAging(): array
    {
        $now = Carbon::now();

        // Pending cases aging
        $pendingAges = LegalCase::where('status', 'pending')
            ->get()
            ->map(fn($case) => $now->diffInDays($case->created_at))
            ->sort()
            ->values();

        // In Progress cases aging
        $inProgressAges = LegalCase::whereIn('status', ['under_investigation', 'awaiting_review', 'needs_more_info', 'ongoing'])
            ->get()
            ->map(fn($case) => $now->diffInDays($case->created_at))
            ->sort()
            ->values();

        // Completed cases aging (from creation to resolution)
        $completedAges = LegalCase::whereIn('status', ['resolved', 'completed', 'closed'])
            ->whereNotNull('resolved_at')
            ->get()
            ->map(fn($case) => Carbon::parse($case->resolved_at)->diffInDays($case->created_at))
            ->sort()
            ->values();

        return [
            'pending' => $this->calculateMedian($pendingAges),
            'in_progress' => $this->calculateMedian($inProgressAges),
            'completed' => $this->calculateMedian($completedAges),
        ];
    }

    /**
     * Reservations by Facility (Top 5)
     * 
     * @return array [['facility_id' => int, 'facility_name' => string, 'count' => int], ...]
     */
    public function getTopFacilities(int $limit = 5): array
    {
        return FacilityReservation::select('facility_id', DB::raw('COUNT(*) as count'))
            ->with('facility:id,name')
            ->groupBy('facility_id')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'facility_id' => $item->facility_id,
                    'facility_name' => $item->facility->name ?? 'Unknown',
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    /**
     * Document Throughput: Documents created in last 7/30 days
     * 
     * @return array ['last_7_days' => int, 'last_30_days' => int, 'archival_rate' => float]
     */
    public function getDocumentThroughput(): array
    {
        $now = Carbon::now('Asia/Manila');
        $sevenDaysAgo = $now->copy()->subDays(7);
        $thirtyDaysAgo = $now->copy()->subDays(30);

        $last7Days = Document::where('created_at', '>=', $sevenDaysAgo)->count();
        $last30Days = Document::where('created_at', '>=', $thirtyDaysAgo)->count();

        // Archival rate: percentage of documents archived in last 30 days
        $archivedLast30Days = Document::where(function ($query) {
                $query->where('status', 'archived')
                      ->orWhereNotNull('archived_at');
            })
            ->where('archived_at', '>=', $thirtyDaysAgo)
            ->count();

        $archivalRate = $last30Days > 0 ? round(($archivedLast30Days / $last30Days) * 100, 2) : 0;

        return [
            'last_7_days' => $last7Days,
            'last_30_days' => $last30Days,
            'archival_rate' => $archivalRate,
        ];
    }

    /**
     * Calculate median from array of numbers
     * 
     * @param \Illuminate\Support\Collection $values
     * @return float
     */
    private function calculateMedian($values): float
    {
        $count = $values->count();
        
        if ($count === 0) {
            return 0;
        }

        $middle = floor($count / 2);

        if ($count % 2 === 0) {
            return ($values[$middle - 1] + $values[$middle]) / 2;
        }

        return $values[$middle];
    }
}
