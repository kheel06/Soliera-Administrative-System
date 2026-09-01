<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\DashboardActivityService;
use App\Services\DashboardMetricsService;


class DashboardController extends Controller
{
    protected DashboardMetricsService $metricsService;

    public function __construct(DashboardMetricsService $metricsService)
    {
        $this->metricsService = $metricsService;
    }

    public function index()
    {
        // Get metrics from DashboardMetricsService (with caching)
        $metrics = $this->metricsService->getCachedMetrics(60);
        
        // Extract KPI values for the view to match variable names expected by blade
        $kpis = $metrics['kpis'] ?? [];
        $legalCases = $metrics['legal_cases_by_status'] ?? [];

        return view('dashboard', [
            'metrics' => $metrics,
            // KPI Cards
            'visitorsToday' => $kpis['visitors_today'] ?? 0,
            'archivedDocs' => $kpis['archived_docs'] ?? 0,
            'totalDocuments' => $kpis['total_documents'] ?? 0,
            'totalReservations' => $kpis['total_reservations'] ?? 0,
            'activeDeptAccounts' => $kpis['active_accounts'] ?? 0,
            'vaultFolders' => $kpis['vault_folders'] ?? 0,
            // Legal Status
            'legalCasesPending' => $legalCases['pending'] ?? 0,
            'legalCasesInProgress' => $legalCases['in_progress'] ?? 0,
            'legalCasesResolved' => $legalCases['completed'] ?? 0,
        ]);
    }

    /**
     * JSON Endpoint for Polling (Live Updates)
     */
    public function metricsJson(Request $request)
    {
        // Can override cache TTL via query param for fresher data if needed
        $metrics = $this->metricsService->getCachedMetrics(30);
        
        return response()->json([
            'success' => true,
            'data' => $metrics,
        ]);
    }

    /**
     * Recent activity feed for dashboard widgets.
     */
    public function recentActivity(Request $request, DashboardActivityService $activityService)
    {
        try {
            $limit = (int) $request->get('limit', 10);
            $activities = $activityService->recent($limit);

            return response()->json([
                'success' => true,
                'data' => $activities,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Dashboard recentActivity error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to load activity feed',
            ], 500);
        }
    }

    /** Simple active users count for dashboard metrics */
    public function activeUsersCount(Request $request)
    {
        try {
            $count = \App\Models\DeptAccount::where('status', 'active')->count();
            return response()->json(['success' => true, 'active_users' => (int) $count]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'active_users' => 0, 'error' => $e->getMessage()], 200);
        }
    }
    /** Facility Reservations stats for dashboard charts */
    public function facilityStats(Request $request)
    {
        // Last 6 months reservations count
        $months = collect(range(5, 0))->map(function($i){ return now()->subMonths($i)->startOfMonth(); });
        $labels = $months->map(fn($d) => $d->format('M Y'));
        $data = $months->map(function($start){
            $end = (clone $start)->copy()->endOfMonth();
            return (int) \App\Models\FacilityReservation::whereBetween('created_at', [$start, $end])->count();
        });

        // Status breakdown current month
        $cm = now();
        $status = [
            'approved' => (int) \App\Models\FacilityReservation::whereMonth('created_at', $cm->month)->where('status','approved')->count(),
            'pending' => (int) \App\Models\FacilityReservation::whereMonth('created_at', $cm->month)->where('status','pending')->count(),
            'denied' => (int) \App\Models\FacilityReservation::whereMonth('created_at', $cm->month)->where('status','denied')->count(),
        ];

        return response()->json([
            'success' => true,
            'labels' => $labels,
            'data' => $data,
            'status' => $status,
        ]);
    }

    /** User Management stats for dashboard charts */
    public function userMgmtStats(Request $request)
    {
        // Count department accounts by role (top 6)
        $byRole = \App\Models\DeptAccount::query()
            ->select('role', \DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->orderByDesc('count')
            ->limit(6)
            ->get();

        // New users per month (last 6 months)
        $months = collect(range(5, 0))->map(function($i){ return now()->subMonths($i)->startOfMonth(); });
        $labels = $months->map(fn($d) => $d->format('M'));
        $registrations = $months->map(function($start){
            $end = (clone $start)->copy()->endOfMonth();
            return (int) \App\Models\DeptAccount::whereBetween('created_at', [$start, $end])->count();
        });

        return response()->json([
            'success' => true,
            'roles' => $byRole,
            'labels' => $labels,
            'registrations' => $registrations,
        ]);
    }
}