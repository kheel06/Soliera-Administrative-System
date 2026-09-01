<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ID Validation API Route (no auth required for public form)
Route::post('/validate-id-document', [App\Http\Controllers\IdValidationController::class, 'validateDocument'])->name('api.validate.id.document');

// API Token Generation (requires login credentials)
Route::post('/auth/token', [App\Http\Controllers\AccessController::class, 'generateToken'])->name('api.auth.token');
Route::post('/login', [App\Http\Controllers\AccessController::class, 'generateToken'])->name('api.login');

// Audit Logs API (Protected with Bearer Token Authentication)
Route::middleware('auth:sanctum')->prefix('audit-logs')->group(function () {
    // Create audit log
    Route::post('/', [App\Http\Controllers\AccessController::class, 'storeAuditLog'])->name('api.audit_logs.store');
    // Get audit logs via GET
    Route::get('/', [App\Http\Controllers\AccessController::class, 'getAuditLogs'])->name('api.audit_logs.index');
    // Get audit logs via POST (with filters in body)
    Route::post('/search', [App\Http\Controllers\AccessController::class, 'postAuditLogs'])->name('api.audit_logs.search');
});

// Department Accounts API (Protected with Bearer Token Authentication)
Route::middleware('auth:sanctum')->prefix('department-accounts')->group(function () {
    // Create department account
    Route::post('/', [App\Http\Controllers\AccessController::class, 'storeDepartmentAccountApi'])->name('api.department_accounts.store');
    // Get department accounts via GET
    Route::get('/', [App\Http\Controllers\AccessController::class, 'getDepartmentAccounts'])->name('api.department_accounts.index');
    // Get department accounts via POST (with filters in body)
    Route::post('/search', [App\Http\Controllers\AccessController::class, 'postDepartmentAccounts'])->name('api.department_accounts.search');
    // Get a single department account
    Route::get('/{id}', [App\Http\Controllers\AccessController::class, 'showDepartmentAccount'])->name('api.department_accounts.show');
    // Update a department account (PUT and PATCH both use the same handler)
    Route::match(['put', 'patch'], '/{id}', [App\Http\Controllers\AccessController::class, 'updateDepartmentAccount'])->name('api.department_accounts.update');
    // Toggle department account status
    Route::post('/{id}/toggle', [App\Http\Controllers\AccessController::class, 'toggleDepartmentAccountStatus'])->name('api.department_accounts.toggle');
});

// External Document Import API (Microservice-enabled)
Route::middleware('auth:sanctum')->prefix('external')->group(function () {
    // Import document from external system
    Route::post('/documents/import', [App\Http\Controllers\Api\ExternalDocumentImportController::class, 'import'])->name('api.external.documents.import');
    // Get import statistics
    Route::get('/documents/stats', [App\Http\Controllers\Api\ExternalDocumentImportController::class, 'stats'])->name('api.external.documents.stats');
});

// Admin Dashboard API
Route::middleware('auth:sanctum')->prefix('admin/dashboard')->group(function () {
    // Get dashboard metrics
    Route::get('/metrics', [App\Http\Controllers\Api\AdminDashboardController::class, 'metrics'])->name('api.admin.dashboard.metrics');
    // Get additional analytics
    Route::get('/analytics', [App\Http\Controllers\Api\AdminDashboardController::class, 'analytics'])->name('api.admin.dashboard.analytics');
    // Clear dashboard cache
    Route::post('/cache/clear', [App\Http\Controllers\Api\AdminDashboardController::class, 'clearCache'])->name('api.admin.dashboard.cache.clear');
});

// Microservice Management API
Route::middleware('auth:sanctum')->prefix('microservices')->group(function () {
    // Health check for all services
    Route::get('/health', [App\Http\Controllers\Api\MicroserviceController::class, 'health'])->name('api.microservices.health');
    // Get service registry information
    Route::get('/registry', [App\Http\Controllers\Api\MicroserviceController::class, 'registry'])->name('api.microservices.registry');
    // Execute service operation
    Route::post('/execute', [App\Http\Controllers\Api\MicroserviceController::class, 'executeOperation'])->name('api.microservices.execute');
    
    // Service-specific endpoints
    Route::prefix('services')->group(function () {
        // Document service metrics
        Route::get('/document/metrics', [App\Http\Controllers\Api\MicroserviceController::class, 'serviceMetrics'])->name('api.microservices.document.metrics');
        // Test document service
        Route::post('/document/test', [App\Http\Controllers\Api\MicroserviceController::class, 'testService'])->name('api.microservices.document.test');
        // Reset document service circuit breaker
        Route::post('/document/reset-circuit-breaker', [App\Http\Controllers\Api\MicroserviceController::class, 'resetCircuitBreaker'])->name('api.microservices.document.reset_circuit_breaker');
        
        // Similar endpoints can be added for other services...
    });
});

// System Data Sync API
Route::middleware('system.sync')->prefix('system-sync')->group(function () {
    // List all tables (optional include=columns,counts,primary_key,timestamps)
    Route::get('/tables', [App\Http\Controllers\Api\SystemDataController::class, 'getTables'])->name('api.system_sync.tables');
    // Get table data (mode=paginate|cursor)
    Route::get('/data/{table}', [App\Http\Controllers\Api\SystemDataController::class, 'getTableData'])->name('api.system_sync.data');
    // Import table data (bulk insert/upsert)
    Route::post('/import/{table}', [App\Http\Controllers\Api\SystemDataController::class, 'importTableData'])->name('api.system_sync.import');
});

// Sync Health & Status Routes (for IntegrationSync)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toISOString()
        ]);
    });

    Route::get('/sync/status', function () {
        // Simple count of potential syncable records
        // Adjust these models based on what data is actually synced
        $counts = [
            'department_accounts' => \Illuminate\Support\Facades\DB::table('department_accounts')->count(),
            'users' => \Illuminate\Support\Facades\DB::table('users')->count(),
        ];
        
        return response()->json([
            'records_available' => array_sum($counts),
            'details' => $counts
        ]);
    });
}); 
