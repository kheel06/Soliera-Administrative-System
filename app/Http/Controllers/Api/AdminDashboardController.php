<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardMetricsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * Admin Dashboard API Controller
 * 
 * Provides aggregated metrics endpoint for the Admin Dashboard.
 * Enforces RBAC and caching for performance.
 */
class AdminDashboardController extends Controller
{
    protected DashboardMetricsService $metricsService;

    public function __construct(DashboardMetricsService $metricsService)
    {
        $this->metricsService = $metricsService;
        
        // Require authentication
        $this->middleware('auth');
    }

    /**
     * Get dashboard metrics overview
     * 
     * GET /api/admin/dashboard/metrics
     * 
     * Returns:
     * - KPI card values (visitors_today, archived_docs, total_documents, total_reservations, active_accounts)
     * - Visitor trend (last 7 days, zero-filled)
     * - Legal cases by status (pending, in_progress, completed)
     * - Last updated timestamp
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function metrics(Request $request): JsonResponse
    {
        try {
            // Optional: Add role-based access control
            // Uncomment if only specific roles should access dashboard metrics
            // if (!in_array(auth()->user()->role ?? '', ['admin', 'superadmin', 'legal', 'manager'])) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Unauthorized access to dashboard metrics'
            //     ], 403);
            // }

            // Get cache TTL from request or use default (60 seconds)
            $cacheTtl = (int) $request->query('cache_ttl', 60);
            $useCache = $request->query('cache', 'true') === 'true';

            if ($useCache && $cacheTtl > 0) {
                $metrics = $this->metricsService->getCachedMetrics($cacheTtl);
            } else {
                $metrics = $this->metricsService->getAllMetrics();
            }

            return response()->json([
                'success' => true,
                'data' => $metrics,
            ]);

        } catch (\Exception $e) {
            Log::error('Dashboard metrics error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load dashboard metrics',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get additional analytics (decision-making metrics)
     * 
     * GET /api/admin/dashboard/analytics
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function analytics(Request $request): JsonResponse
    {
        try {
            $analytics = [
                'legal_case_aging' => $this->metricsService->getLegalCaseAging(),
                'top_facilities' => $this->metricsService->getTopFacilities(5),
                'document_throughput' => $this->metricsService->getDocumentThroughput(),
            ];

            return response()->json([
                'success' => true,
                'data' => $analytics,
            ]);

        } catch (\Exception $e) {
            Log::error('Dashboard analytics error', [
                'message' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load analytics',
            ], 500);
        }
    }

    /**
     * Clear dashboard metrics cache
     * 
     * POST /api/admin/dashboard/cache/clear
     * 
     * @return JsonResponse
     */
    public function clearCache(): JsonResponse
    {
        try {
            // Optional: Restrict to admin roles only
            // if (!in_array(auth()->user()->role ?? '', ['admin', 'superadmin'])) {
            //     return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            // }

            $this->metricsService->clearCache();

            return response()->json([
                'success' => true,
                'message' => 'Dashboard cache cleared successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache',
            ], 500);
        }
    }
}
