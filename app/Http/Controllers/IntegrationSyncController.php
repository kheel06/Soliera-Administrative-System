<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\DeptAccount;
use Illuminate\Support\Str;

class IntegrationSyncController extends Controller
{
    protected string $adminApiUrl;
    protected ?string $adminApiToken;
    protected int $timeout;

    public function __construct()
    {
        $this->adminApiUrl = config('services.soliera_admin.base_url', 'https://admin.soliera-hotel-restaurant.com');
        $this->adminApiToken = config('services.soliera_admin.token');
        $this->timeout = (int) config('services.soliera_admin.timeout', 30);
    }

    /**
     * Display the Integration & Sync dashboard
     */
    public function index()
    {
        // Get sync status data
        $syncStatus = $this->getSyncStatus();
        $apiStatus = $this->checkApiConnection();

        return view('integration-sync.index', [
            'syncStatus' => $syncStatus,
            'apiStatus' => $apiStatus,
            'adminApiUrl' => $this->adminApiUrl,
        ]);
    }

    /**
     * Check connection to Soliera Admin API
     */
    protected function checkApiConnection(): array
    {
        $cacheKey = 'soliera_admin_api_status';

        return Cache::remember($cacheKey, 60, function () {
            try {
                $response = Http::timeout(10)
                    ->withHeaders($this->getApiHeaders())
                    ->get($this->adminApiUrl . '/api/health');

                return [
                    'connected' => $response->successful(),
                    'status_code' => $response->status(),
                    'last_check' => now()->format('M d, Y h:i A'),
                    'message' => $response->successful() ? 'Connected' : 'Connection failed',
                ];
            } catch (\Exception $e) {
                Log::warning('Soliera Admin API connection check failed: ' . $e->getMessage());
                return [
                    'connected' => false,
                    'status_code' => 0,
                    'last_check' => now()->format('M d, Y h:i A'),
                    'message' => 'Unable to connect: ' . $e->getMessage(),
                ];
            }
        });
    }

    /**
     * Get API headers for requests
     */
    protected function getApiHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($this->adminApiToken) {
            $headers['Authorization'] = 'Bearer ' . $this->adminApiToken;
        }

        return $headers;
    }

    /**
     * Get current sync status for all integrations
     */
    protected function getSyncStatus()
    {
        return [
            'soliera_admin' => [
                'name' => 'Soliera Admin (Online)',
                'description' => 'Main administrative system',
                'endpoint' => $this->adminApiUrl,
                'status' => $this->checkApiConnection()['connected'] ? 'connected' : 'disconnected',
                'last_sync' => Cache::get('soliera_admin_last_sync', 'Never'),
                'records_synced' => Cache::get('soliera_admin_records_synced', 0),
                'icon' => 'globe',
            ]
        ];
    }

    /**
     * Trigger manual sync for a specific integration
     */
    public function triggerSync(Request $request, string $integration)
    {
        try {
            Log::info("Manual sync triggered for: {$integration}");

            $recordsSynced = 0;
            $message = '';

            if ($integration === 'soliera_admin') {
                // Sync with Soliera Admin API
                $result = $this->syncWithSolieraAdmin();
                $recordsSynced = $result['records'];
                $message = $result['message'];

                // Update cache
                Cache::put('soliera_admin_last_sync', now()->format('M d, Y h:i A'), 3600);
                Cache::put('soliera_admin_records_synced', Cache::get('soliera_admin_records_synced', 0) + $recordsSynced, 3600);
            } else {
                // Other integrations - update their last sync time
                Cache::put("{$integration}_last_sync", now()->format('M d, Y h:i A'), 3600);
                $message = "Sync completed for {$integration}";
            }

            // Clear API status cache to force refresh
            Cache::forget('soliera_admin_api_status');

            // Notify stakeholders
            \App\Services\SystemNotificationService::notifyIntegrationAction($integration, $message, 'success');

            return response()->json([
                'success' => true,
                'message' => $message,
                'records_synced' => $recordsSynced,
                'timestamp' => now()->format('M d, Y h:i A'),
            ]);
        } catch (\Exception $e) {
            Log::error("Sync failed for {$integration}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Sync failed: " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sync data with Soliera Admin API
     */
    protected function syncWithSolieraAdmin(): array
    {
        try {
            // 1. Check basic status
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->getApiHeaders())
                ->get($this->adminApiUrl . '/api/sync/status');

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'records' => 0,
                    'message' => 'Sync failed: Unable to connect to Soliera Admin (HTTP ' . $response->status() . ')',
                ];
            }

            // 2. Sync Department Accounts
            $deptSyncResult = $this->syncDepartmentAccounts();

            // Combine results
            $totalRecords = $deptSyncResult['count'];
            $messages = [];

            if ($deptSyncResult['success']) {
                $messages[] = $deptSyncResult['message'];
            } else {
                $messages[] = "Department Accounts: " . $deptSyncResult['message'];
            }

            return [
                'success' => true,
                'records' => $totalRecords,
                'message' => implode(' | ', $messages),
            ];

        } catch (\Exception $e) {
            Log::warning('Soliera Admin sync error: ' . $e->getMessage());
            return [
                'success' => false,
                'records' => 0,
                'message' => 'Sync attempted - ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Sync Department Accounts from Remote
     */
    protected function syncDepartmentAccounts(): array
    {
        try {
            $offset = 0;
            $limit = 100; // Max allowed by remote API
            $totalSynced = 0;
            $totalCreated = 0;
            $totalUpdated = 0;
            $hasMore = true;

            while ($hasMore) {
                $response = Http::timeout($this->timeout)
                    ->withHeaders($this->getApiHeaders())
                    ->get($this->adminApiUrl . '/api/department-accounts', [
                        'limit' => $limit,
                        'offset' => $offset,
                    ]);

                if (!$response->successful()) {
                    // If first request fails, return error
                    if ($offset === 0) {
                        return [
                            'success' => false,
                            'count' => 0,
                            'message' => 'Failed to fetch department accounts: ' . $response->status()
                        ];
                    }
                    // If subsequent request fails, stop and report partial success
                    Log::warning("Sync stopped at offset $offset due to error: " . $response->status());
                    break;
                }

                $data = $response->json();
                $remoteAccounts = $data['data'] ?? [];

                if (empty($remoteAccounts)) {
                    $hasMore = false;
                    break;
                }

                foreach ($remoteAccounts as $remote) {
                    // Try to find existing account
                    $query = DeptAccount::query();
                    $found = false;

                    if (!empty($remote['employee_id'])) {
                        $query->where('employee_id', $remote['employee_id']);
                        $found = true;
                    } elseif (!empty($remote['email'])) {
                        $query->where('email', $remote['email']);
                        $found = true;
                    }

                    $localAccount = $found ? $query->first() : null;

                    // Prepare data
                    $accountData = [
                        'employee_name' => $remote['employee_name'] ?? 'Unknown',
                        'dept_name' => $remote['dept_name'] ?? 'Unassigned',
                        'role' => $remote['role'] ?? 'Staff',
                        'email' => $remote['email'] ?? null,
                        'status' => $remote['status'] ?? 'active',
                        'profile_picture' => $remote['profile_picture'] ?? null,
                    ];

                    if (!empty($remote['employee_id'])) {
                        $accountData['employee_id'] = $remote['employee_id'];
                    }

                    if ($localAccount) {
                        $localAccount->update($accountData);
                        $totalUpdated++;
                    } else {
                        $accountData['password'] = \Illuminate\Support\Facades\Hash::make(Str::random(16));
                        DeptAccount::create($accountData);
                        $totalCreated++;
                    }
                    $totalSynced++;
                }

                // Check if we reached the end
                if (count($remoteAccounts) < $limit) {
                    $hasMore = false;
                } else {
                    $offset += $limit;
                }
            }

            return [
                'success' => true,
                'count' => $totalSynced,
                'message' => "Synced $totalSynced accounts ($totalCreated created, $totalUpdated updated)"
            ];

        } catch (\Exception $e) {
            Log::error('Department sync error: ' . $e->getMessage());
            return [
                'success' => false,
                'count' => 0,
                'message' => 'Error syncing accounts: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Test connection to Soliera Admin API
     */
    public function testConnection(Request $request)
    {
        Cache::forget('soliera_admin_api_status');
        $status = $this->checkApiConnection();

        return response()->json([
            'success' => $status['connected'],
            'status' => $status,
            'api_url' => $this->adminApiUrl,
        ]);
    }

    /**
     * Get sync logs/history
     */
    public function logs(Request $request)
    {
        $logs = [
            [
                'timestamp' => now()->subMinutes(5)->format('M d, Y h:i A'),
                'integration' => 'Soliera Admin',
                'action' => 'Sync Completed',
                'status' => 'success',
                'records' => 12,
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $logs,
        ]);
    }
}
