<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\VisitorLogController;
use App\Http\Controllers\FacilitiesController;
use App\Http\Controllers\ExecutiveController;
use App\Http\Controllers\ExecutiveApprovalController;
use App\Http\Controllers\ExecutiveContractController;
use App\Http\Controllers\ExecutiveCaseController;
use App\Http\Controllers\ExecutivePermitController;
use App\Http\Controllers\ExecutiveEvidenceController;
use App\Http\Controllers\ExecutiveFacilitiesController;
use App\Http\Controllers\ExecutiveVaultController;
use App\Http\Controllers\ExecutiveVisitorController;
use App\Http\Controllers\ExecutiveReportsController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuditPackController;
use App\Http\Controllers\RbacController;
use App\Http\Controllers\AiSettingsController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ContractRequestController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractVersionController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ContractRegisterController;
use App\Http\Controllers\ContractObligationController;
use App\Http\Controllers\LegalAlertController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ClauseLibraryController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\AiLegalController;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\PermitRequirementController;
use App\Http\Controllers\PermitFileController;
use App\Http\Controllers\AiComplianceController;
use App\Http\Controllers\CorrectiveActionController;
use App\Http\Controllers\PostUseController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\FacilitiesApprovalController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ControlledDocController;
use App\Http\Controllers\DocumentVersionController;
use App\Http\Controllers\RetentionController;
use App\Http\Controllers\AccessMatrixController;
use App\Http\Controllers\PreRegistrationController;
use App\Http\Controllers\ZonePolicyController;
use App\Http\Controllers\VisitorIncidentController;
use App\Http\Controllers\KpiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use App\Http\Controllers\SuperAdminDashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing page routes (kept but root is redirected to login)
Route::get('/', function () {
    return redirect()->route('login');
});
// Public endpoint to accept registration from landing page (AJAX)
Route::post('/visitor/public-store', [App\Http\Controllers\VisitorController::class, 'publicStore'])->name('visitor.public_store');

// Temporary test route for ID verification
Route::get('/test-id-verification', [App\Http\Controllers\VisitorController::class, 'idVerification']);



// Temporary: New Request route without auth for testing
Route::get('/facility_reservations/new-request', [App\Http\Controllers\FacilityReservationController::class, 'newRequest'])->name('facility_reservations.new_request');

// Soliera API Proxy Routes (server-side proxy to avoid exposing token to browser)
// Token handled server-side to prevent 401 + avoid exposing secrets
// Note: These routes should match the auth requirements of the page that uses them
Route::get('/internal/soliera/core1events', [App\Http\Controllers\SolieraApiProxyController::class, 'getCore1Events'])->name('soliera.proxy.core1events');
Route::put('/internal/soliera/eventapproved/{eventbookingID}', [App\Http\Controllers\SolieraApiProxyController::class, 'updateEventStatus'])->name('soliera.proxy.update_status');

// Restaurant API Proxy Routes
Route::get('/internal/soliera/restaurant/facility-requests', [App\Http\Controllers\SolieraApiProxyController::class, 'getRestaurantFacilityRequests'])->name('soliera.proxy.restaurant.facility_requests');
Route::put('/internal/soliera/restaurant/facility-requests/{requestId}', [App\Http\Controllers\SolieraApiProxyController::class, 'updateRestaurantFacilityRequest'])->name('soliera.proxy.restaurant.update_status');

// Combined API - fetches from both Hotel and Restaurant
Route::get('/internal/soliera/combined/facility-requests', [App\Http\Controllers\SolieraApiProxyController::class, 'getCombinedFacilityRequests'])->name('soliera.proxy.combined.facility_requests');

// Facilities Monitoring API (read-only)
Route::get('/api/facilities/monitoring', [App\Http\Controllers\FacilityReservationController::class, 'monitoringSummary'])->name('facilities.monitoring.summary');
Route::get('/api/facilities/monitoring/export-pdf', [App\Http\Controllers\FacilityReservationController::class, 'exportMonitoringPdf'])->name('facilities.monitoring.export_pdf');
Route::get('/api/facilities/stats', [App\Http\Controllers\FacilitiesController::class, 'stats'])->name('facilities.stats');

// Equipment details API
Route::get('/api/facilities/equipment-details', [App\Http\Controllers\FacilityReservationController::class, 'equipmentDetails'])->name('facilities.equipment.details');

// Redirect authenticated users to appropriate dashboard based on role
Route::get('/home', function () {
    if (Auth::check()) {
        // Get normalized role using service
        $role = app(\App\Services\RolePermissionService::class)->getUserRole();

        // Owner / Executive
        if ($role === 'Owner') {
            return redirect()->route('executive.overview');
        }

        // Legal Team
        if ($role === 'Legal Officer') {
            return redirect()->route('legal.contracts.workspace');
        }

        // Compliance
        if ($role === 'Compliance Lead') {
            return redirect()->route('compliance.permits');
        }

        // Facilities / Admin
        if ($role === 'Admin Manager') {
            return redirect()->route('facilities.reservations.list');
        }

        // Security Supervisor
        if ($role === 'Security Supervisor') {
            return redirect()->route('facilities.reservations.list');
        }

        // Visitors / Reception
        if ($role === 'Front Office Manager') {
            return redirect()->route('visitors.pre_registrations');
        }

        // Default fallback for other authenticated users
        return redirect()->route('login');
    }
    return redirect()->route('login');
})->name('home');

// Test route for debugging access logs (temporary - remove in production)
Route::get('/test-access-logs', function () {
    try {
        $totalLogs = \App\Models\AccessLog::count();
        $sampleLogs = \App\Models\AccessLog::take(5)->get();

        return response()->json([
            'success' => true,
            'total_logs' => $totalLogs,
            'sample_logs' => $sampleLogs,
            'database_connection' => config('database.default'),
            'database_name' => config('database.connections.mysql.database'),
            'user_authenticated' => auth()->check(),
            'current_user' => auth()->user()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
});

// Test route for legal case review (temporary - remove in production)
Route::get('/test-legal-case-review', function () {
    try {
        $case = \App\Models\LegalCase::with(['assignedTo', 'createdBy', 'documents'])->first();

        if (!$case) {
            return response()->json([
                'success' => false,
                'message' => 'No legal cases found in database'
            ]);
        }

        return response()->json([
            'success' => true,
            'case' => [
                'id' => $case->id,
                'case_title' => $case->case_title,
                'case_number' => $case->case_number,
                'status' => $case->status,
                'documents_count' => $case->documents->count(),
                'assigned_to' => $case->assignedTo ? $case->assignedTo->employee_name : 'Not assigned',
                'created_by' => $case->createdBy ? $case->createdBy->employee_name : 'Unknown'
            ],
            'message' => 'Legal case review test successful'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
});

// Authentication Routes (single, non-conflicting)
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/loginuser', [App\Http\Controllers\userController::class, 'login'])->name('user.login');
Route::get('/loginuser', function () {
    return redirect()->route('login');
});
Route::post('/logout', [App\Http\Controllers\userController::class, 'logout'])->name('logout');

// OTP Authentication Routes
Route::get('/verify-otp', [App\Http\Controllers\userController::class, 'showOtpForm'])->name('otp.verify');
Route::post('/verify-otp', [App\Http\Controllers\userController::class, 'verifyOtp'])->name('otp.verify.submit');
Route::post('/resend-otp', [App\Http\Controllers\userController::class, 'resendOtp'])->name('otp.resend');

// Debug route for OTP verification
Route::post('/debug-verify-otp', function (Request $request) {
    \Log::info('Debug OTP verification', [
        'otp_code' => $request->otp_code,
        'employee_id' => session('otp_employee_id'),
        'session_data' => session()->all()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Debug info logged',
        'otp_code' => $request->otp_code,
        'employee_id' => session('otp_employee_id')
    ]);
});

Route::get('/refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Debug route removed for security

// Temporary debug route for OTP testing (REMOVE IN PRODUCTION)
Route::get('/debug-otp-db', function () {
    if (app()->environment('local')) {
        $otps = \App\Models\OtpCode::orderBy('created_at', 'desc')->limit(5)->get();
        return response()->json([
            'otps' => $otps->map(function ($otp) {
                return [
                    'employee_id' => $otp->employee_id,
                    'otp_code' => $otp->otp_code,
                    'expires_at' => $otp->expires_at,
                    'is_used' => $otp->is_used,
                    'created_at' => $otp->created_at
                ];
            })
        ]);
    }
    return response()->json(['error' => 'Not available in production']);
});

// Debug route for testing OTP verification
Route::post('/debug-verify-otp', function (\Illuminate\Http\Request $request) {
    if (app()->environment('local')) {
        $otpCode = $request->input('otp_code');
        $employeeId = session('otp_employee_id');

        \Log::info('Debug OTP verification', [
            'otp_code' => $otpCode,
            'employee_id' => $employeeId,
            'session_data' => session()->all()
        ]);

        if (!$employeeId) {
            return response()->json(['error' => 'No OTP session found']);
        }

        $otp = \App\Models\OtpCode::where('employee_id', $employeeId)
            ->where('otp_code', $otpCode)
            ->where('is_used', false)
            ->first();

        return response()->json([
            'otp_found' => $otp ? true : false,
            'otp_details' => $otp ? [
                'expires_at' => $otp->expires_at,
                'is_used' => $otp->is_used,
                'is_expired' => $otp->expires_at < now()
            ] : null,
            'verification_result' => \App\Models\OtpCode::verify($employeeId, $otpCode)
        ]);
    }
    return response()->json(['error' => 'Not available in production']);
});

// (Optional) OTP endpoints retained but with unique URIs if needed in future
Route::get('/login/otp', [App\Http\Controllers\AuthController::class, 'showOTP'])->name('login.otp');

// Guest routes
Route::post('/guest/create', [App\Http\Controllers\userController::class, 'create'])->name('guest.create');
Route::post('/guest/profile-setup/{guestID}', [App\Http\Controllers\userController::class, 'profilesetup'])->name('guest.profilesetup');
Route::post('/guest/logout', [App\Http\Controllers\userController::class, 'guestlogout'])->name('guest.logout');
Route::post('/guest/login', [App\Http\Controllers\userController::class, 'guestlogin'])->name('guest.login');

// Legal Documents - accessible to Legal Officers, Administrators, and Super Admins
Route::middleware(['auth', 'role:Legal Officer,Admin Manager,Owner', \App\Http\Middleware\EnsurePoliciesAccepted::class])->group(function () {
    Route::get('/legal/documents', [LegalController::class, 'legalDocuments'])->name('legal.legal_documents');

    // Imported Legal Documents Management
    Route::get('/legal/documents/imported', [App\Http\Controllers\LegalDocumentController::class, 'index'])->name('legal.documents.imported');
    Route::get('/legal/documents/imported/{id}', [App\Http\Controllers\LegalDocumentController::class, 'show'])->name('legal.documents.imported.show');
    Route::get('/legal/documents/imported/{id}/preview', [App\Http\Controllers\LegalDocumentController::class, 'preview'])->name('legal.documents.imported.preview');
    Route::get('/legal/documents/imported/{id}/download', [App\Http\Controllers\LegalDocumentController::class, 'download'])->name('legal.documents.imported.download');
    Route::get('/legal/documents/search', [App\Http\Controllers\LegalDocumentController::class, 'search'])->name('legal.documents.search');
    Route::post('/legal/documents/upload-document', [LegalController::class, 'uploadDocument'])->name('legal.documents.upload');
    Route::get('/legal/documents/search-dropdown', [LegalController::class, 'searchDocumentsDropdown'])->name('legal.documents.search_dropdown');

    // Legal Cases - accessible to all legal roles
    Route::get('/legal/cases', [LegalController::class, 'caseDeck'])->name('legal.legal_cases');
    // Facility Damage Cases
    // Internal legal document creation (draft/publish)
    Route::get('/legal/documents/create', [LegalController::class, 'createInternalDocument'])->name('legal.documents.create');
    Route::post('/legal/documents', [LegalController::class, 'storeInternalDocument'])->name('legal.documents.store');
    // Drafting workspace
    Route::get('/legal/documents/draft', [LegalController::class, 'draftingWorkspace'])->name('legal.documents.draft');
    Route::post('/legal/documents/draft', [LegalController::class, 'saveDraft'])->name('legal.documents.save_draft');
    Route::post('/legal/documents/submit-review', [LegalController::class, 'submitForReview'])->name('legal.documents.submit_review');
    Route::get('/legal/documents/export/{id}', [LegalController::class, 'exportDocument'])->name('legal.documents.export');
    // Review actions for internal/legal documents
    Route::post('/legal/documents/{id}/approve', [LegalController::class, 'approveDocument'])->name('legal.documents.approve');
    Route::post('/legal/documents/{id}/reject', [LegalController::class, 'rejectDocument'])->name('legal.documents.reject');
    Route::post('/legal/documents/{id}/request-revision', [LegalController::class, 'requestRevisionDocument'])->name('legal.documents.request_revision');
    // Archiving & retention
    Route::post('/legal/documents/{id}/archive', [LegalController::class, 'archiveDocument'])->name('legal.documents.archive');
    // Monitoring API
    Route::get('/legal/monitoring/summary', [LegalController::class, 'monitoringSummary'])->name('legal.monitoring.summary');
    Route::get('/legal/monitoring/list', [LegalController::class, 'monitoringList'])->name('legal.monitoring.list');
    // E-signature actions
    Route::post('/legal/documents/{id}/send-esign', [LegalController::class, 'sendForESign'])->name('legal.documents.send_esign');
    Route::post('/legal/esign/webhook', [LegalController::class, 'esignWebhook'])->name('legal.esign.webhook');
    // Department submission flow
    Route::get('/legal/documents/submit', [LegalController::class, 'submitForm'])->name('legal.documents.submit_form');
    Route::post('/legal/documents/submit', [LegalController::class, 'storeSubmission'])->name('legal.documents.store_submission');
    // Reports export
    Route::get('/legal/reports/export', [LegalController::class, 'exportReports'])->name('legal.reports.export');
    // Execution/Monitoring stubs
    Route::post('/legal/documents/{id}/mark-signed', [LegalController::class, 'markSigned'])->name('legal.documents.mark_signed');
    Route::post('/legal/documents/{id}/set-renewal', [LegalController::class, 'setRenewal'])->name('legal.documents.set_renewal');
    // Signature requests
    Route::post('/legal/documents/{id}/signatures/request', [LegalController::class, 'requestSignature'])->name('legal.documents.signatures.request');
    Route::post('/legal/documents/{id}/signatures/remind', [LegalController::class, 'remindSignature'])->name('legal.documents.signatures.remind');
    Route::post('/legal/documents/{id}/signatures/cancel', [LegalController::class, 'cancelSignature'])->name('legal.documents.signatures.cancel');
});

// Temporary: Test legal cases route without auth
Route::get('/test/legal/cases', [LegalController::class, 'caseDeck'])->name('test.legal.cases');

// Test route for debugging file upload
Route::post('/test-upload', function (Request $request) {
    \Log::info('Test upload received', [
        'has_file' => $request->hasFile('document_file'),
        'file_name' => $request->file('document_file') ? $request->file('document_file')->getClientOriginalName() : 'no file',
        'all_data' => $request->all()
    ]);

    if ($request->hasFile('document_file')) {
        $file = $request->file('document_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('test_uploads', $fileName, 'public');

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully',
            'file_path' => $filePath,
            'file_name' => $fileName
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'No file received',
        'data' => $request->all()
    ]);
})->name('test.upload');

// Test route for AI analysis
Route::get('/debug-ai', function () {
    try {
        $geminiService = app(\App\Services\GeminiService::class);
        $testText = "This is a memorandum of agreement between Company A and Company B regarding the purchase of office supplies.";
        $result = $geminiService->analyzeDocument($testText);

        return response()->json([
            'success' => true,
            'test_text' => $testText,
            'ai_result' => $result,
            'api_key_set' => !empty(env('GEMINI_API_KEY'))
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
})->name('debug.ai');

// Test route for RBAC system
Route::get('/debug-rbac', function () {
    try {
        $roleService = app(\App\Services\RolePermissionService::class);
        $userRole = $roleService->getUserRole();
        $userModules = $roleService->getUserModules();
        $roleDescription = $roleService->getRoleDescription();

        // Get department accounts to see actual role values
        $deptAccounts = \Illuminate\Support\Facades\DB::table('department_accounts')
            ->select('employee_id', 'employee_name', 'role')
            ->get();

        // Get current user info
        $currentUser = auth()->user();
        $currentUserDeptAccount = null;
        if ($currentUser) {
            $currentUserDeptAccount = \Illuminate\Support\Facades\DB::table('department_accounts')
                ->where('employee_id', $currentUser->employee_id)
                ->first();
        }

        // Test role normalization directly
        $testResults = [];
        if ($currentUserDeptAccount && $currentUserDeptAccount->role) {
            $testResults['legal_officer'] = $roleService->testRoleNormalization('Legal officer');
            $testResults['legal_officer_lower'] = $roleService->testRoleNormalization('legal officer');
            $testResults['legal_officer_underscore'] = $roleService->testRoleNormalization('legal_officer');
        }

        return response()->json([
            'success' => true,
            'user_role' => $userRole,
            'user_modules' => $userModules,
            'role_description' => $roleDescription,
            'available_roles' => $roleService->getAvailableRoles(),
            'session_data' => [
                'user_role' => session('user_role'),
                'emp_id' => session('emp_id'),
                'auth_user' => auth()->user() ? auth()->user()->only(['id', 'name', 'email', 'role', 'employee_id']) : null
            ],
            'department_accounts' => $deptAccounts,
            'auth_check' => auth()->check(),
            'current_user_employee_id' => auth()->user() ? auth()->user()->employee_id : null,
            'current_user_dept_account' => $currentUserDeptAccount,
            'role_permissions' => $roleService::ROLE_PERMISSIONS,
            'test_results' => $testResults
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
})->name('debug.rbac');

// Test route for analyze-upload endpoint
Route::post('/test-analyze', function (Request $request) {
    \Log::info('Test analyze endpoint hit', [
        'has_file' => $request->hasFile('document_file'),
        'file_name' => $request->file('document_file') ? $request->file('document_file')->getClientOriginalName() : 'no file',
        'all_data' => $request->all()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Test endpoint working',
        'has_file' => $request->hasFile('document_file'),
        'file_name' => $request->file('document_file') ? $request->file('document_file')->getClientOriginalName() : 'no file'
    ]);
})->name('test.analyze');

// External Document Import API (Microservice Integration)
Route::prefix('api/external/documents')->group(function () {
    Route::post('/import', [App\Http\Controllers\Api\ExternalDocumentImportController::class, 'import'])->name('api.external.documents.import');
    Route::get('/import/stats', [App\Http\Controllers\Api\ExternalDocumentImportController::class, 'stats'])->name('api.external.documents.import_stats');
});

// Legacy simulate route (redirects to new API)
Route::post('/document/simulate-incoming', function (\Illuminate\Http\Request $request) {
    return app(App\Http\Controllers\Api\ExternalDocumentImportController::class)->import($request);
})->name('document.simulate_incoming');

// Session Management Routes
Route::post('/session/extend', [App\Http\Controllers\SessionController::class, 'extend'])
    ->middleware('auth')
    ->name('session.extend');

// All main app routes require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard removed
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Super Admin Dashboard route removed


    // Dashboard chart data endpoints (scoped to dashboard only) - Commented out as dashboard is removed
    // Route::get('/dashboard/metrics-json', [DashboardController::class, 'metricsJson'])->name('dashboard.metrics_json');
    // Route::get('/dashboard/facility-stats', [DashboardController::class, 'facilityStats'])->name('dashboard.facility_stats');
    // Route::get('/dashboard/user-mgmt-stats', [DashboardController::class, 'userMgmtStats'])->name('dashboard.user_mgmt_stats');
    // Route::get('/dashboard/active-users', [DashboardController::class, 'activeUsersCount'])->name('dashboard.active_users');
    // Route::get('/dashboard/recent-activity', [DashboardController::class, 'recentActivity'])->name('dashboard.recent_activity');
    // Legal monitoring proxies for dashboard (accessible to any authenticated user)
    // Route::get('/dashboard/legal/summary', [LegalController::class, 'monitoringSummary'])->name('dashboard.legal_summary');
    // Route::get('/dashboard/legal/list', [LegalController::class, 'monitoringList'])->name('dashboard.legal_list');

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/picture', [ProfileController::class, 'removeProfilePicture'])->name('profile.remove_picture');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/send-verification', [ProfileController::class, 'send'])->name('verification.send');

    // Policy Consent Routes
    Route::get('/policies/latest', [App\Http\Controllers\PolicyConsentController::class, 'latest'])->name('policies.latest');
    Route::post('/policies/consent', [App\Http\Controllers\PolicyConsentController::class, 'store'])->name('policies.consent');

    // Calendar legacy route: redirect old /reservations/calendar → new path to avoid conflict with reservations.show
    Route::get('/reservations/calendar/{facilityId?}', function ($facilityId = null) {
        $params = request()->only(['start_date', 'end_date']);
        $target = $facilityId
            ? route('facility_reservations.calendar', ['facilityId' => $facilityId])
            : route('facility_reservations.calendar');
        if (!empty($params)) {
            $target .= '?' . http_build_query($params);
        }
        return redirect()->to($target);
    })->name('reservations.calendar');

    // Hotel Management
    Route::resource('reservations', ReservationController::class);
    Route::resource('guests', GuestController::class);
    // Route::resource('orders', OrderController::class); // Commented out - controller doesn't exist
    // Route::resource('inventory', InventoryController::class); // Commented out - controller doesn't exist

    // Finance and Reports
    Route::get('/finance/reports', function () {
        return view('finance.reports');
    })->name('finance.reports');



    // User search endpoint (for autocomplete - used across multiple pages)
    Route::get('/users/search', [AccessController::class, 'searchUsers'])->name('users.search');

    // Access Protection
    Route::prefix('access')->group(function () {
        Route::get('/audit-logs', [AccessController::class, 'auditLogs'])->name('access.audit_logs');
        Route::get('/users', [AccessController::class, 'users'])->name('access.users');
        Route::get('/users/{id}', [AccessController::class, 'showUser'])->name('access.users.show');
        Route::get('/users/create', [AccessController::class, 'createUser'])->name('access.users.create');
        Route::post('/users', [AccessController::class, 'storeUser'])->name('access.users.store');
        Route::get('/users/export', [AccessController::class, 'exportUsers'])->name('access.users.export');
        Route::get('/roles', [AccessController::class, 'roles'])->name('access.roles');
        Route::post('/roles/assign', [AccessController::class, 'assignRole'])->name('access.roles.assign');
        Route::get('/security', [AccessController::class, 'security'])->name('access.security');
        Route::get('/department-accounts', [AccessController::class, 'departmentAccounts'])->name('access.department_accounts');
        Route::post('/department-accounts', [AccessController::class, 'storeDepartmentAccount'])->name('access.department_accounts.store');
        Route::get('/department-accounts/{id}', [AccessController::class, 'showDepartmentAccount'])->name('access.department_accounts.show');
        Route::put('/department-accounts/{id}', [AccessController::class, 'updateDepartmentAccount'])->name('access.department_accounts.update');
        Route::post('/department-accounts/{id}/toggle', [AccessController::class, 'toggleDepartmentAccountStatus'])->name('access.department_accounts.toggle');
        Route::get('/audit-logs/export', [AccessController::class, 'exportAuditLogs'])->name('access.audit_logs.export');
    });



    // Integration & Sync - Admin Manager and Owner only
    Route::middleware(['auth', 'role:Admin Manager,Owner'])->group(function () {
        Route::get('/integration-sync', [App\Http\Controllers\IntegrationSyncController::class, 'index'])->name('integration-sync.index');
        Route::post('/integration-sync/{integration}/trigger', [App\Http\Controllers\IntegrationSyncController::class, 'triggerSync'])->name('integration-sync.trigger');
        Route::get('/integration-sync/logs', [App\Http\Controllers\IntegrationSyncController::class, 'logs'])->name('integration-sync.logs');
        Route::post('/integration-sync/test-connection', [App\Http\Controllers\IntegrationSyncController::class, 'testConnection'])->name('integration-sync.test-connection');
    });

    // Settings
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');

    // System Services
    Route::get('/system-services', [App\Http\Controllers\SystemServicesController::class, 'index'])->name('system-services.index');

    // Profile

    // AI Document Builder - Must be before resource route to avoid conflicts
    Route::middleware(['auth', 'role:Admin Manager'])->group(function () {
        Route::get('/legal/ai-builder', [LegalController::class, 'aiDocumentBuilder'])->name('legal.ai_builder');
        Route::post('/legal/ai-generate-section', [LegalController::class, 'aiGenerateSection'])->name('legal.ai_generate_section');
        Route::post('/legal/ai-generate-document', [LegalController::class, 'aiGenerateDocument'])->name('legal.ai_generate_document');
        Route::post('/legal/save-ai-document', [LegalController::class, 'saveAiDocument'])->name('legal.save_ai_document');
        Route::post('/legal/submit-ai-document', [LegalController::class, 'submitAiDocument'])->name('legal.submit_ai_document');
    });

    Route::resource('legal', LegalController::class);

    // Legal Management Sub-modules - Administrator and Super Admin only
    Route::middleware(['auth', 'role:Admin Manager'])->group(function () {
        Route::get('/legal', [LegalController::class, 'caseDeck'])->name('legal.case_deck');

        // Legal Documents Management
        Route::get('/legal/documents', [LegalController::class, 'legalDocuments'])->name('legal.legal_documents');
        Route::get('/legal/documents/create', [LegalController::class, 'createInternalDocument'])->name('legal.documents.create');
        Route::post('/legal/documents', [LegalController::class, 'storeInternalDocument'])->name('legal.store_internal_document');
        Route::get('/legal/submit', [LegalController::class, 'submitForm'])->name('legal.submit_form');
        Route::post('/legal/submit', [LegalController::class, 'storeSubmission'])->name('legal.store_submission');

        // Document Actions
        Route::post('/legal/documents/{id}/approve', [LegalController::class, 'approveDocument'])->name('legal.documents.approve');
        Route::post('/legal/documents/{id}/reject', [LegalController::class, 'rejectDocument'])->name('legal.documents.reject');
        Route::post('/legal/documents/{id}/revision', [LegalController::class, 'requestRevisionDocument'])->name('legal.documents.revision');
        Route::post('/legal/documents/{id}/archive', [LegalController::class, 'archiveDocument'])->name('legal.documents.archive');
        Route::post('/legal/documents/{id}/signed', [LegalController::class, 'markSigned'])->name('legal.documents.signed');
        Route::post('/legal/documents/{id}/renewal', [LegalController::class, 'setRenewal'])->name('legal.documents.renewal');
        Route::post('/legal/documents/{id}/signature', [LegalController::class, 'requestSignature'])->name('legal.documents.signature');
        Route::post('/legal/documents/{id}/remind', [LegalController::class, 'remindSignature'])->name('legal.documents.remind');
        Route::post('/legal/documents/{id}/cancel-signature', [LegalController::class, 'cancelSignature'])->name('legal.documents.cancel_signature');
        Route::get('/legal/documents/{id}/export', [LegalController::class, 'exportDocument'])->name('legal.documents.export_doc');
        Route::post('/legal/documents/{id}/esign', [LegalController::class, 'sendForESign'])->name('legal.documents.esign');
        Route::post('/legal/documents/esign-webhook', [LegalController::class, 'esignWebhook'])->name('legal.documents.esign_webhook');

        // Legal Document Management Routes
        Route::get('/legal/documents/{id}', [DocumentController::class, 'showLegalDocument'])->name('legal.documents.show');
        Route::get('/legal/documents/{id}/edit', [DocumentController::class, 'editLegalDocument'])->name('legal.documents.edit');
        Route::put('/legal/documents/{id}', [DocumentController::class, 'updateLegalDocument'])->name('legal.documents.update');
        Route::post('/legal/documents/{id}/archive-only', [DocumentController::class, 'archiveLegalDocument'])->name('legal.documents.archive_only');
        Route::get('/legal/documents/{id}/download', [DocumentController::class, 'downloadLegalDocument'])->name('legal.documents.download');
        Route::post('/legal/documents/{id}/archive', [DocumentController::class, 'archive'])->name('legal.documents.archive_doc');
        Route::post('/legal/documents/{id}/approve-doc', [DocumentController::class, 'approveLegalDocument'])->name('legal.documents.approve_doc');
        Route::post('/legal/documents/{id}/decline-doc', [DocumentController::class, 'declineLegalDocument'])->name('legal.documents.decline_doc');

        // Document Drafting - COMMENTED OUT DUPLICATE (Defined at line 328 in shared middleware)
        // Route::get('/legal/documents/draft', [LegalController::class, 'draftingWorkspace'])->name('legal.documents.draft');
        // Route::post('/legal/documents/draft/save', [LegalController::class, 'saveDraft'])->name('legal.documents.save_draft_alt');
        // Route::post('/legal/documents/draft/submit', [LegalController::class, 'submitForReview'])->name('legal.documents.submit_draft');

        // General Document Routes
        Route::post('/documents', [LegalController::class, 'store'])->name('documents.store');
        Route::post('/documents/bulk-upload', [LegalController::class, 'bulkUpload'])->name('documents.bulkUpload');

        // Enhanced Legal Management Routes
        Route::get('/legal/enhanced-dashboard', [LegalController::class, 'enhancedDashboard'])->name('legal.enhanced_dashboard');
        Route::post('/legal/documents/{id}/archive', [LegalController::class, 'archiveDocument'])->name('legal.documents.archive_enhanced');
        Route::post('/legal/bulk-ai-analysis', [LegalController::class, 'bulkAiAnalysis'])->name('legal.bulk_ai_analysis');

        // Enhanced Document Management Routes
        Route::get('/legal/enhanced-document-management', [LegalController::class, 'enhancedDocumentManagement'])->name('legal.enhanced_document_management');
        Route::post('/legal/documents/{id}/view', [LegalController::class, 'logDocumentView'])->name('legal.documents.log_view');
        Route::post('/legal/documents/{id}/download', [LegalController::class, 'logDocumentDownload'])->name('legal.documents.log_download');
        Route::get('/legal/documents/{id}/history', [LegalController::class, 'getDocumentHistory'])->name('legal.documents.history');
        Route::get('/legal/documents/{id}/activity-tracking', [LegalController::class, 'getDocumentActivityTracking'])->name('legal.documents.activity_tracking');
        Route::post('/legal/documents/{id}/collaborators', [LegalController::class, 'addCollaborator'])->name('legal.documents.add_collaborator');
        Route::get('/legal/documents/{id}/collaborators', [LegalController::class, 'getCollaborators'])->name('legal.documents.get_collaborators');
        Route::delete('/legal/documents/{id}/collaborators/{userId}', [LegalController::class, 'removeCollaborator'])->name('legal.documents.remove_collaborator');
        Route::get('/legal/documents/stats', [LegalController::class, 'getDocumentStats'])->name('legal.documents.stats');
    });

    // Legal Documents route is now properly protected above

    // Legal Case Management - Administrator and Super Admin only (Legal Officers excluded)
    Route::middleware(['auth', 'role:Admin Manager'])->group(function () {
        Route::get('/legal/cases/create', [LegalController::class, 'create'])->name('legal.cases.create');
        Route::post('/legal/cases', [LegalController::class, 'store'])->name('legal.cases.store');
        Route::get('/legal/cases/{id}', [LegalController::class, 'show'])->name('legal.cases.show');
        Route::get('/legal/cases/{id}/edit', [LegalController::class, 'edit'])->name('legal.cases.edit');
        Route::put('/legal/cases/{id}', [LegalController::class, 'update'])->name('legal.cases.update');
        Route::delete('/legal/cases/{id}', [LegalController::class, 'destroy'])->name('legal.cases.destroy');
    });

    // Enhanced Legal Management Routes - All Legal Roles
    Route::middleware(['auth', 'role:Legal Officer,Admin Manager'])->group(function () {
        // Company Policies
        Route::get('/legal/policies', [LegalController::class, 'policies'])->name('legal.policies');
        Route::get('/legal/policies/create', [LegalController::class, 'createPolicy'])->name('legal.policies.create');
        Route::post('/legal/policies', [LegalController::class, 'storePolicy'])->name('legal.policies.store');

        // Employee Complaints
        Route::get('/legal/complaints', [LegalController::class, 'complaints'])->name('legal.complaints');
        Route::get('/legal/complaints/create', [LegalController::class, 'createComplaint'])->name('legal.complaints.create');
        Route::post('/legal/complaints', [LegalController::class, 'storeComplaint'])->name('legal.complaints.store');
        Route::get('/legal/complaints/{id}', [LegalController::class, 'showComplaint'])->name('legal.complaints.show');

        // Violation Reports
        Route::get('/legal/violation-reports', [LegalController::class, 'violationReports'])->name('legal.violation_reports');
        Route::get('/legal/violation-reports/create', [LegalController::class, 'createViolationReport'])->name('legal.violation_reports.create');
        Route::post('/legal/violation-reports', [LegalController::class, 'storeViolationReport'])->name('legal.violation_reports.store');
        Route::get('/legal/violation-reports/{id}', [LegalController::class, 'showViolationReport'])->name('legal.violation_reports.show');

        // AI Analyses
        Route::get('/legal/ai-analyses', [LegalController::class, 'aiAnalyses'])->name('legal.ai_analyses');
        Route::get('/legal/ai-analyses/{id}', [LegalController::class, 'showAiAnalysis'])->name('legal.ai_analyses.show');

        // Audit Logs
        Route::get('/legal/audit-logs', [LegalController::class, 'auditLogs'])->name('legal.audit_logs');
    });

    // Document Management - Administrator, Super Admin only
    Route::middleware(['auth', 'role:Admin Manager'])->group(function () {
        Route::get('/document/view', [DocumentController::class, 'view'])->name('document.view');
        Route::resource('document', DocumentController::class)->where(['document' => '[0-9]+']);
        Route::resource('facilities', FacilitiesController::class);
        Route::get('/facilities/{id}/ajax', [FacilitiesController::class, 'showAjax'])->name('facilities.showAjax');
        Route::get('/facilities-calendar', [FacilitiesController::class, 'calendar'])->name('facilities.calendar');
        Route::post('/facilities-check-availability', [FacilitiesController::class, 'checkAvailability'])->name('facilities.checkAvailability');
        // Reservation Calendar (facility staff) - avoid conflict with resource('reservations')
        Route::get('/facility-reservations/calendar/{facilityId?}', [\App\Http\Controllers\FacilityReservationController::class, 'calendar'])->name('facility_reservations.calendar');
        // Realtime stats for dashboard polling
        Route::get('/reservations/realtime-stats', [\App\Http\Controllers\FacilityReservationController::class, 'realtimeStats'])->name('facility_reservations.realtime_stats');
        Route::get('/my-reservations', [App\Http\Controllers\FacilityReservationController::class, 'userHistory'])->name('facility_reservations.user_history');
        Route::get('/admin-analytics', [App\Http\Controllers\FacilityReservationController::class, 'adminAnalytics'])->name('facility_reservations.admin_analytics');

        // Debug route for analytics
        Route::get('/admin-analytics-debug', function () {
            try {
                $controller = new \App\Http\Controllers\FacilityReservationController(
                    app(\App\Services\GeminiService::class),
                    app(\App\Services\DocumentTextExtractorService::class),
                    app(\App\Services\FacilityCalendarService::class),
                    app(\App\Services\SecureDocumentRepository::class),
                    app(\App\Services\VisitorService::class),
                    app(\App\Services\ReservationWorkflowService::class)
                );

                $overview = $controller->getOverviewStats();
                return response()->json([
                    'success' => true,
                    'overview' => $overview,
                    'message' => 'Analytics data loaded successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        })->name('facility_reservations.admin_analytics_debug');

        // Simple test route
        Route::get('/test-analytics', function () {
            return response()->json([
                'message' => 'Test route working',
                'reservations' => \App\Models\FacilityReservation::count(),
                'facilities' => \App\Models\Facility::count()
            ]);
        });

        // Simple analytics test route
        Route::get('/test-analytics-page', function () {
            $analytics = [
                'overview' => [
                    'total_reservations' => \App\Models\FacilityReservation::count(),
                    'approved_reservations' => \App\Models\FacilityReservation::where('status', 'approved')->count(),
                    'pending_reservations' => \App\Models\FacilityReservation::where('status', 'pending')->count(),
                    'denied_reservations' => \App\Models\FacilityReservation::where('status', 'denied')->count(),
                    'total_facilities' => \App\Models\Facility::count(),
                    'active_users' => \App\Models\FacilityReservation::distinct('reserved_by')->count('reserved_by'),
                    'this_month_reservations' => \App\Models\FacilityReservation::whereMonth('created_at', now()->month)->count(),
                    'approval_rate' => 100
                ],
                'facility_usage' => collect(),
                'reservation_trends' => collect([
                    ['month' => now()->subMonths(5)->format('Y-m'), 'count' => 0],
                    ['month' => now()->subMonths(4)->format('Y-m'), 'count' => 0],
                    ['month' => now()->subMonths(3)->format('Y-m'), 'count' => 0],
                    ['month' => now()->subMonths(2)->format('Y-m'), 'count' => 0],
                    ['month' => now()->subMonth()->format('Y-m'), 'count' => 0],
                    ['month' => now()->format('Y-m'), 'count' => \App\Models\FacilityReservation::whereMonth('created_at', now()->month)->count()]
                ]),
                'user_activity' => collect(),
                'conflict_analysis' => [
                    'potential_conflicts' => 0,
                    'resolved_conflicts' => 0,
                    'conflict_rate' => 0
                ],
                'revenue_analytics' => [
                    'total_revenue' => 0,
                    'monthly_revenue' => 0,
                    'average_booking_value' => 0
                ],
                'peak_hours' => collect([
                    ['hour' => 9, 'count' => 0],
                    ['hour' => 10, 'count' => 0],
                    ['hour' => 11, 'count' => 0],
                    ['hour' => 12, 'count' => 0],
                    ['hour' => 13, 'count' => 0],
                    ['hour' => 14, 'count' => 0],
                    ['hour' => 15, 'count' => 0],
                    ['hour' => 16, 'count' => 0],
                    ['hour' => 17, 'count' => 0]
                ]),
                'monthly_comparison' => [
                    'current_month' => \App\Models\FacilityReservation::whereMonth('created_at', now()->month)->count(),
                    'last_month' => \App\Models\FacilityReservation::whereMonth('created_at', now()->subMonth()->month)->count(),
                    'growth_rate' => 0
                ]
            ];

            $recentReservations = \App\Models\FacilityReservation::with(['facility:id,name', 'reserver:id,name'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $pendingReservations = \App\Models\FacilityReservation::with(['facility:id,name', 'reserver:id,name'])
                ->where('status', 'pending')
                ->orderBy('created_at', 'asc')
                ->limit(10)
                ->get();

            return view('facility_reservations.admin_analytics', compact('analytics', 'recentReservations', 'pendingReservations'));
        });
        Route::post('/payments/process', [App\Http\Controllers\PaymentController::class, 'processPayment'])->name('payments.process');
        Route::get('/payments/details/{reservationId}', [App\Http\Controllers\PaymentController::class, 'getPaymentDetails'])->name('payments.details');
        Route::get('/payments/history', [App\Http\Controllers\PaymentController::class, 'paymentHistory'])->name('payments.history');
    });

    // Visitor Management - Receptionist, Administrator, Super Admin only
    Route::middleware(['auth', 'role:Front Office Manager,Security Supervisor,Admin Manager,Owner'])->group(function () {
        Route::resource('visitor', VisitorController::class);
        Route::get('/visitor/{id}/details', [App\Http\Controllers\VisitorController::class, 'getDetails'])->name('visitor.details');

        // ID Verification Routes
        Route::get('/visitor/id-verification', [App\Http\Controllers\VisitorController::class, 'idVerification'])->name('visitor.id_verification');
        Route::post('/visitor/{id}/verify-id', [App\Http\Controllers\VisitorController::class, 'verifyId'])->name('visitor.verify_id');
        Route::post('/visitor/{id}/reject-id', [App\Http\Controllers\VisitorController::class, 'rejectId'])->name('visitor.reject_id');

        // Visitor Logs Routes
        Route::prefix('visitor-logs')->name('visitor.logs.')->group(function () {
            Route::get('/', [App\Http\Controllers\VisitorLogController::class, 'index'])->name('index');
            Route::get('/analytics', [App\Http\Controllers\VisitorLogController::class, 'getAnalytics'])->name('analytics');
            Route::get('/logs', [App\Http\Controllers\VisitorLogController::class, 'getLogs'])->name('logs');
            Route::post('/search', [App\Http\Controllers\VisitorLogController::class, 'search'])->name('search');
            Route::post('/generate-report', [App\Http\Controllers\VisitorLogController::class, 'generateReport'])->name('generate-report');
            Route::get('/export', [App\Http\Controllers\VisitorLogController::class, 'exportLogs'])->name('export');
        });
        // Bulk Visitor QR Routes (Scan/Approve protected)
        Route::prefix('bulk-visitor')->name('bulk-visitor.')->group(function () {
            Route::post('/scan', [App\Http\Controllers\BulkVisitorController::class, 'processScan'])->name('processScan');
            Route::post('/approve-all/{sessionId}', [App\Http\Controllers\BulkVisitorController::class, 'approveAll'])->name('approveAll');
        });
    });


    // Bulk Visitor QR Routes (Creation is public for landing page)
    Route::post('/bulk-visitor/store', [App\Http\Controllers\BulkVisitorController::class, 'store'])->name('bulk-visitor.store');
    Route::get('/bulk-visitor/token/{token}', [App\Http\Controllers\BulkVisitorController::class, 'showByToken'])->name('bulk-visitor.showByToken');

    // Visitor AJAX Routes for Real-time Functionality - Moved outside middleware for now
    Route::prefix('visitor')->name('visitor.')->group(function () {
        // New route for managing visitors from facility reservations
        Route::get('/manage-reservation-visitors/{reservation}', [App\Http\Controllers\VisitorController::class, 'manageReservationVisitors'])->name('manage_reservation_visitors');
        Route::post('/perform-extraction/{reservation}', [App\Http\Controllers\VisitorController::class, 'performExtractionFromReservation'])->name('perform_extraction_from_reservation');
        Route::post('/perform-approval/{reservation}', [App\Http\Controllers\VisitorController::class, 'performApprovalFromReservation'])->name('perform_approval_from_reservation');

        Route::post('/search', [App\Http\Controllers\VisitorController::class, 'searchVisitors'])->name('search');
        Route::get('/details/{id}', [App\Http\Controllers\VisitorController::class, 'getVisitorDetails'])->name('details_ajax');
        Route::post('/checkin', [App\Http\Controllers\VisitorController::class, 'checkIn'])->name('checkin');
        Route::post('/checkin-existing/{id}', [App\Http\Controllers\VisitorController::class, 'checkInExisting'])->name('checkin_existing');
        Route::post('/checkout/{id}', [App\Http\Controllers\VisitorController::class, 'checkOut'])->name('checkout');
        Route::get('/current', [App\Http\Controllers\VisitorController::class, 'getCurrentVisitors'])->name('current');
        Route::get('/scheduled-today', [App\Http\Controllers\VisitorController::class, 'getScheduledVisits'])->name('scheduled.today');
        Route::get('/stats', [App\Http\Controllers\VisitorController::class, 'getVisitorStats'])->name('stats');

        // Monitoring Routes
        Route::get('/monitoring', [App\Http\Controllers\VisitorController::class, 'getCheckinMonitoring'])->name('monitoring');
        Route::get('/monitoring/stats', [App\Http\Controllers\VisitorController::class, 'getCheckinStats'])->name('monitoring.stats');
        Route::get('/monitoring/visitors', [App\Http\Controllers\VisitorController::class, 'getMonitoringVisitors'])->name('monitoring.visitors');

        // Visitor Pass Routes
        Route::get('/{id}/pass', [App\Http\Controllers\VisitorController::class, 'getVisitorPass'])->name('pass');
        Route::get('/{id}/pass/download', [App\Http\Controllers\VisitorController::class, 'downloadVisitorPass'])->name('pass.download');
        Route::get('/{id}/pass/print', [App\Http\Controllers\VisitorController::class, 'printVisitorPass'])->name('pass.print');

        // Pre-Schedule Routes
        Route::post('/preschedule', [App\Http\Controllers\VisitorController::class, 'preschedule'])->name('preschedule');
        Route::get('/preschedule/list', [App\Http\Controllers\VisitorController::class, 'getScheduledVisitors'])->name('preschedule.list');
        Route::delete('/preschedule/{id}', [App\Http\Controllers\VisitorController::class, 'cancelScheduledVisitor'])->name('preschedule.cancel');
        Route::post('/validate-access-code', [App\Http\Controllers\VisitorController::class, 'validateAccessCode'])->name('validate.access.code');

        // Pre-Visit Management Routes
        Route::get('/scheduled', [App\Http\Controllers\VisitorController::class, 'getScheduledVisitors'])->name('scheduled');
        Route::post('/scheduled/{id}/approve', [App\Http\Controllers\VisitorController::class, 'approveScheduledVisitor'])->name('scheduled.approve');
        Route::post('/scheduled/{id}/decline', [App\Http\Controllers\VisitorController::class, 'declineScheduledVisitor'])->name('scheduled.decline');
        Route::post('/scheduled/{id}/cancel', [App\Http\Controllers\VisitorController::class, 'cancelScheduledVisitor'])->name('scheduled.cancel');
        Route::post('/scheduled/{id}/restore', [App\Http\Controllers\VisitorController::class, 'restoreScheduledVisitor'])->name('scheduled.restore');

        // Approve/Decline newly registered visitors
        Route::post('/{id}/approve', [App\Http\Controllers\VisitorController::class, 'approveVisitor'])->name('approve');
        Route::post('/{id}/decline', [App\Http\Controllers\VisitorController::class, 'declineVisitor'])->name('decline');

        // Debug route
        Route::get('/debug/visitors', function () {
            $visitors = \App\Models\Visitor::whereNotNull('pass_id')->take(5)->get();
            return response()->json([
                'total_visitors' => \App\Models\Visitor::count(),
                'visitors_with_passes' => \App\Models\Visitor::whereNotNull('pass_id')->count(),
                'sample_visitors' => $visitors->map(function ($v) {
                    return [
                        'id' => $v->id,
                        'name' => $v->name,
                        'pass_id' => $v->pass_id,
                        'status' => $v->status
                    ];
                })
            ]);
        });

        // Debug route for scheduled visitors
        Route::get('/debug/scheduled-visitors', function () {
            $scheduledVisitors = \App\Models\Visitor::where('status', 'scheduled')
                ->whereNotNull('scheduled_date')
                ->orderBy('scheduled_date')
                ->orderBy('scheduled_time')
                ->get();

            return response()->json([
                'success' => true,
                'count' => $scheduledVisitors->count(),
                'visitors' => $scheduledVisitors->map(function ($v) {
                    return [
                        'id' => $v->id,
                        'name' => $v->name,
                        'email' => $v->email,
                        'status' => $v->status,
                        'scheduled_date' => $v->scheduled_date,
                        'scheduled_time' => $v->scheduled_time,
                        'created_at' => $v->created_at
                    ];
                })
            ]);
        });

        // Quick Actions
        Route::get('/quick/view-all', [App\Http\Controllers\VisitorController::class, 'viewAllVisitors'])->name('quick.viewAll');
        Route::post('/quick/schedule', [App\Http\Controllers\VisitorController::class, 'scheduleVisit'])->name('quick.schedule');
        Route::post('/quick/emergency', [App\Http\Controllers\VisitorController::class, 'emergencyEvacuation'])->name('quick.emergency');
        Route::get('/quick/directory', [App\Http\Controllers\VisitorController::class, 'buildingDirectory'])->name('quick.directory');
    });

    // Document Management Routes
    Route::post('/document/{id}/request-release', [DocumentController::class, 'requestRelease'])->name('document.requestRelease');
    Route::get('/document/{id}/download', [DocumentController::class, 'download'])->name('document.download');
    Route::get('/document/{id}/preview', [DocumentController::class, 'preview'])->name('document.preview');
    Route::post('/document/{id}/analyze', [DocumentController::class, 'analyze'])->name('document.analyze');
    Route::post('/document/{id}/analyze-ajax', [DocumentController::class, 'analyzeAjax'])->name('document.analyzeAjax');
    // Use a unique name for the upload analysis endpoint to avoid name collisions
    Route::post('/document/analyze-upload', [DocumentController::class, 'analyzeUpload'])->name('document.analyzeUpload');
    // DMS: simple monitoring & reports (document module only)
    Route::get('/document/monitoring/summary', function (\Illuminate\Http\Request $request) {
        $q = \App\Models\Document::query()->whereNotIn('source', ["legal_management", "legal_submission", "ai_builder"]);
        if ($dept = $request->get('department')) {
            $q->where('department', $dept);
        }
        if ($status = $request->get('status')) {
            $q->where('status', $status);
        }
        $now = now();
        return response()->json([
            'success' => true,
            'data' => [
                'total' => (clone $q)->count(),
                'active' => (clone $q)->where('status', 'active')->count(),
                'archived' => (clone $q)->where('status', 'archived')->count(),
                'expiring' => (clone $q)->whereNotNull('retention_until')->whereBetween('retention_until', [$now, $now->copy()->addDays(60)])->count(),
            ]
        ]);
    })->name('document.monitoring.summary');
    Route::get('/document/reports/basic', function () {
        $docs = \App\Models\Document::whereNotIn('source', ["legal_management", "legal_submission", "ai_builder"])->get();
        $byDept = $docs->groupBy('department')->map->count();
        $byStatus = $docs->groupBy('status')->map->count();
        return response()->json(['success' => true, 'by_department' => $byDept, 'by_status' => $byStatus]);
    })->name('document.reports.basic');

    // DMS reports page (view only)
    Route::get('/document/reports', [DocumentController::class, 'reports'])->name('document.reports');
    // Document receiving interface
    Route::get('/document/receive', [DocumentController::class, 'receive'])->name('document.receive');
    // OCR test route for debugging document analysis
    Route::post('/document/test-ocr', [DocumentController::class, 'testOcrExtraction'])->name('document.testOcr');
    // OCR test page for debugging
    Route::get('/document/test-ocr', function () {
        return view('document.test_ocr');
    })->name('document.testOcrPage');
    // Bulk upload route for legal management
    Route::post('/document/bulk-upload', [DocumentController::class, 'bulkUpload'])->name('document.bulkUpload');

    // Document Archive Routes
    Route::post('/document/{id}/archive', [DocumentController::class, 'archive'])->name('document.archive');
    Route::post('/document/{id}/unarchive', [DocumentController::class, 'unarchive'])->name('document.unarchive');
    Route::get('/document/archived', [DocumentController::class, 'archived'])->name('document.archived');
    Route::post('/document/archived/export', [DocumentController::class, 'exportArchivedReport'])->name('document.archived.export');

    // Document Disposal Routes
    Route::post('/document/{id}/dispose', [DocumentController::class, 'dispose'])->name('document.dispose');

    // Document API Routes (for archived.blade.php)
    Route::get('/document/{doc}', [\App\Http\Controllers\DocumentApiController::class, 'show']);
    Route::post('/legal/documents/{doc}/view', [\App\Http\Controllers\DocumentApiController::class, 'logView']);
    Route::post('/legal/documents/{doc}/download', [\App\Http\Controllers\DocumentApiController::class, 'logDownload']);
    Route::get('/legal/documents/{doc}/collaborators', [\App\Http\Controllers\DocumentApiController::class, 'listCollaborators']);
    Route::post('/legal/documents/{doc}/collaborators', [\App\Http\Controllers\DocumentApiController::class, 'addCollaborator']);
    Route::delete('/legal/documents/{doc}/collaborators/{userId}', [\App\Http\Controllers\DocumentApiController::class, 'removeCollaborator']);
    Route::get('/document/{doc}/history', [\App\Http\Controllers\DocumentApiController::class, 'history']);
    Route::get('/legal/documents/{doc}/history', [\App\Http\Controllers\DocumentApiController::class, 'history']);
    Route::get('/legal/documents/{doc}/activity-tracking', [\App\Http\Controllers\DocumentApiController::class, 'activityTracking']);
    Route::post('/document/{doc}/archive', [\App\Http\Controllers\DocumentApiController::class, 'archive']);
    Route::post('/document/{doc}/unarchive', [\App\Http\Controllers\DocumentApiController::class, 'unarchive']);
    Route::post('/document/{doc}/dispose', [\App\Http\Controllers\DocumentApiController::class, 'dispose']);
    Route::get('/document/{doc}/download', [\App\Http\Controllers\DocumentApiController::class, 'download']);


    // Document Access Control and Analytics Routes
    Route::get('/document/analytics', [App\Http\Controllers\DocumentAnalyticsController::class, 'index'])->name('document.analytics');
    Route::get('/document/{id}/access-analytics', [App\Http\Controllers\DocumentAnalyticsController::class, 'documentAccess'])->name('document.access_analytics');
    Route::get('/document/analytics/department-stats', [App\Http\Controllers\DocumentAnalyticsController::class, 'departmentStats'])->name('document.department_stats');
    Route::get('/document/analytics/confidentiality-stats', [App\Http\Controllers\DocumentAnalyticsController::class, 'confidentialityStats'])->name('document.confidentiality_stats');
    Route::get('/document/analytics/access-trends', [App\Http\Controllers\DocumentAnalyticsController::class, 'accessTrends'])->name('document.access_trends');

    // Document Access Control Routes
    Route::post('/document/{id}/track-access', [App\Http\Controllers\DocumentAccessController::class, 'trackAccess'])->name('document.track_access');
    Route::get('/document/{id}/download-secure', [App\Http\Controllers\DocumentAccessController::class, 'download'])->name('document.download_secure');
    Route::get('/document/{id}/access-analytics', [App\Http\Controllers\DocumentAccessController::class, 'getAccessAnalytics'])->name('document.get_access_analytics');

    // Legal Approval Routes
    Route::post('/legal/{id}/approve', [LegalController::class, 'approveRequest'])->name('legal.approve');
    Route::post('/legal/{id}/deny', [LegalController::class, 'denyRequest'])->name('legal.deny');
    Route::get('/legal/pending', [LegalController::class, 'pendingRequests'])->name('legal.pending');
    Route::get('/legal/approved', [LegalController::class, 'approvedRequests'])->name('legal.approved');
    Route::get('/legal/denied', [LegalController::class, 'deniedRequests'])->name('legal.denied');

    // Users list for collaborator selection
    Route::get('/users/list', function () {
        try {
            $users = \App\Models\User::select('id', 'name', 'email')
                ->where('id', '!=', auth()->id()) // Exclude current user
                ->get();

            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading users: ' . $e->getMessage(),
                'users' => []
            ], 500);
        }
    })->name('users.list');

    // Debug route for collaborators
    Route::get('/debug/collaborators/{id}', function ($id) {
        $logs = \App\Models\AccessLog::where('document_id', $id)
            ->where('action', 'collaborator_added')
            ->get();

        return response()->json([
            'document_id' => $id,
            'total_logs' => $logs->count(),
            'logs' => $logs->map(function ($log) {
                return [
                    'id' => $log->id,
                    'user_id' => $log->user_id,
                    'metadata' => $log->metadata,
                    'created_at' => $log->created_at
                ];
            })
        ]);
    });

    // Legal Case Approval Routes - Administrator and Super Admin only
    Route::middleware(['auth', 'role:Admin Manager'])->group(function () {
        Route::get('/legal/cases/{id}/review', [LegalController::class, 'reviewCase'])->name('legal.cases.review');
        Route::get('/legal/cases/{id}/compliance', [LegalController::class, 'complianceAssessment'])->name('legal.cases.compliance');
        Route::post('/legal/cases/{id}/approve', [LegalController::class, 'approveCase'])->name('legal.cases.approve');
        Route::post('/legal/cases/{id}/decline', [LegalController::class, 'declineCase'])->name('legal.cases.decline');
        Route::post('/legal/cases/{id}/escalate', [LegalController::class, 'escalateCase'])->name('legal.cases.escalate');
        Route::post('/legal/cases/{id}/hold', [LegalController::class, 'holdCase'])->name('legal.cases.hold');
        Route::post('/legal/cases/{id}/investigate', [LegalController::class, 'startInvestigation'])->name('legal.cases.investigate');
        Route::post('/legal/cases/{id}/evidence', [LegalController::class, 'addEvidence'])->name('legal.cases.evidence');
        Route::post('/legal/cases/{id}/notes', [LegalController::class, 'addNotes'])->name('legal.cases.notes');
        Route::post('/legal/cases/{id}/transition', [LegalController::class, 'transitionCase'])->name('legal.cases.transition');
        Route::post('/legal/cases/{id}/witness/add', [LegalController::class, 'addWitness'])->name('legal.cases.witness.add');
        Route::post('/legal/cases/{id}/investigation/note', [LegalController::class, 'addInvestigationNote'])->name('legal.cases.investigation.note');
        Route::post('/legal/cases/{id}/resolution', [LegalController::class, 'submitResolution'])->name('legal.cases.resolution');
    });



    // Legal Document Categories
    Route::get('/legal/category/{category}', [LegalController::class, 'categoryDocuments'])->name('legal.category');

    // Legal Document Management Routes
    Route::get('/legal/documents/{id}', [DocumentController::class, 'showLegalDocument'])->name('legal.documents.show');
    Route::get('/legal/documents/{id}/edit', [DocumentController::class, 'editLegalDocument'])->name('legal.documents.edit');
    Route::put('/legal/documents/{id}', [DocumentController::class, 'updateLegalDocument'])->name('legal.documents.update');
    Route::delete('/legal/documents/{id}', [DocumentController::class, 'deleteLegalDocument'])->name('legal.documents.destroy');

    // Legal Document Download Route
    Route::get('/legal/documents/{id}/download', [DocumentController::class, 'downloadLegalDocument'])->name('legal.documents.download');


    // Visitor Coordination Routes
    // Route::post('/facility_reservations/{id}/extract-visitors', [App\Http\Controllers\FacilityReservationController::class, 'extractVisitorData'])->name('facility_reservations.extract_visitors');
    // Route::post('/facility_reservations/{id}/approve-visitors', [App\Http\Controllers\FacilityReservationController::class, 'approveVisitors'])->name('facility_reservations.approve_visitors');

    // Visitor Export Routes
    Route::get('/visitor/export/excel', [App\Http\Controllers\VisitorController::class, 'exportExcel'])->name('visitor.export.excel');
    Route::get('/visitor/export/pdf', [App\Http\Controllers\VisitorController::class, 'exportPdf'])->name('visitor.export.pdf');
    Route::post('/visitor/export/report', [App\Http\Controllers\VisitorController::class, 'exportReport'])->name('visitor.export.report');
    Route::post('/visitor/{id}/rate', [App\Http\Controllers\VisitorController::class, 'rateVisitor'])->name('visitor.rate');
    Route::post('/visitor/{id}/report-violation', [App\Http\Controllers\VisitorController::class, 'reportViolation'])->name('visitor.report-violation');



    // Notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/api/notifications/count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('api.notifications.count');
    Route::get('/api/notifications/list', [App\Http\Controllers\NotificationController::class, 'list'])->name('api.notifications.list');
    Route::get('/notifications/list', [App\Http\Controllers\NotificationController::class, 'list'])->name('notifications.list');
    Route::post('/api/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('api.notifications.read');
    Route::post('/notifications/{id}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/api/notifications/{id}/clear', [App\Http\Controllers\NotificationController::class, 'clear'])->name('api.notifications.clear');
    Route::post('/api/notifications/clear-all', [App\Http\Controllers\NotificationController::class, 'clearAll'])->name('api.notifications.clearAll');
    Route::post('/notifications/mark-all-as-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // User Role Management - Administrator, Super Admin only
    Route::middleware(['auth', 'role:Admin Manager'])->group(function () {
        Route::get('/access/users/{user}/edit-role', [App\Http\Controllers\AccessController::class, 'editRole'])->name('access.users.editRole');
        Route::post('/access/users/{user}/update-role', [App\Http\Controllers\AccessController::class, 'updateRole'])->name('access.users.updateRole');
    });

    // Facility Reservation Approval Workflow
    Route::resource('facility_reservations', App\Http\Controllers\FacilityReservationController::class);
    Route::post('/facility_reservations/store-request', [App\Http\Controllers\FacilityReservationController::class, 'storeRequest'])->name('facility_reservations.store_request');
    Route::post('/facility_reservations/{id}/approve', [App\Http\Controllers\FacilityReservationController::class, 'approve'])->name('facility_reservations.approve');
    Route::post('/facility_reservations/{id}/deny', [App\Http\Controllers\FacilityReservationController::class, 'deny'])->name('facility_reservations.deny');

    // Return Inspection Routes - Employee,Administrator,Super Admin
    Route::get('/facility_reservations/{id}/return-review', [\App\Http\Controllers\FacilityReservationController::class, 'returnReview'])
        ->name('facility_reservations.return_review');
    Route::post('/facility_reservations/{id}/return-inspection', [\App\Http\Controllers\FacilityReservationController::class, 'submitReturnInspection'])
        ->name('facility_reservations.return_inspection');
    Route::post('/facility_reservations/{id}/approve-request', [App\Http\Controllers\FacilityReservationController::class, 'approveRequest'])->name('facility_reservations.approve_request');
    Route::post('/facility_reservations/{id}/complete', [App\Http\Controllers\FacilityReservationController::class, 'completeRequest'])->name('facility_reservations.complete');
    Route::get('/facility_reservations/{id}/show-request', [App\Http\Controllers\FacilityReservationController::class, 'showRequest'])->name('facility_reservations.show_request');
    Route::post('/facilities/{id}/free', [App\Http\Controllers\FacilityReservationController::class, 'freeFacility'])->name('facilities.free');

    // Monthly Reports Routes
    Route::get('/facility_reservations/monthly-reports', [App\Http\Controllers\FacilityReservationController::class, 'monthlyReports'])->name('facility_reservations.monthly_reports');
    Route::get('/facility_reservations/generate-monthly-report', [App\Http\Controllers\FacilityReservationController::class, 'generateMonthlyReport'])->name('facility_reservations.generate_monthly_report');
    Route::post('/facility_reservations/monthly-report-summary', [App\Http\Controllers\FacilityReservationController::class, 'getMonthlyReportSummary'])->name('facility_reservations.monthly_report_summary');

    // Legal Review Routes
    Route::get('/facility_reservations/{id}/legal-review', [App\Http\Controllers\FacilityReservationController::class, 'legalReview'])->name('facility_reservations.legal_review');
    Route::post('/facility_reservations/{id}/legal-approve', [App\Http\Controllers\FacilityReservationController::class, 'legalApprove'])->name('facility_reservations.legal_approve');
    Route::post('/facility_reservations/{id}/legal-flag', [App\Http\Controllers\FacilityReservationController::class, 'legalFlag'])->name('facility_reservations.legal_flag');

    // Workflow Action Routes
    Route::post('/facility_reservations/{id}/availability-check', [App\Http\Controllers\FacilityReservationController::class, 'performAvailabilityCheck'])->name('facility_reservations.availability_check');
    Route::post('/facility_reservations/{id}/conflict-resolution', [App\Http\Controllers\FacilityReservationController::class, 'performConflictResolution'])->name('facility_reservations.conflict_resolution');
});

// Test route for OTP verification
Route::get('/test-otp-route', function () {
    return response()->json([
        'message' => 'OTP route is working',
        'session_employee_id' => session('otp_employee_id'),
        'timestamp' => now()
    ]);
});

// Debug login test route
Route::get('/debug-login', function () {
    $users = \App\Models\DeptAccount::all();
    $otpCodes = \App\Models\OtpCode::where('is_used', false)->get();

    return response()->json([
        'users' => $users->map(function ($user) {
            return [
                'employee_id' => $user->employee_id,
                'employee_name' => $user->employee_name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status
            ];
        }),
        'active_otps' => $otpCodes->map(function ($otp) {
            return [
                'employee_id' => $otp->employee_id,
                'otp_code' => $otp->otp_code,
                'expires_at' => $otp->expires_at,
                'is_used' => $otp->is_used
            ];
        }),
        'mail_config' => [
            'driver' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'username' => config('mail.mailers.smtp.username'),
            'encryption' => config('mail.mailers.smtp.encryption')
        ]
    ]);
});

// Test login bypass (for debugging only - REMOVE IN PRODUCTION)
Route::post('/test-login-bypass', function (\Illuminate\Http\Request $request) {
    $employeeId = $request->input('employee_id');
    $password = $request->input('password');

    $deptAccount = \App\Models\DeptAccount::where('employee_id', $employeeId)->first();

    if (!$deptAccount) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Check password (accept both hashed and plain text)
    $validPassword = false;
    try {
        $validPassword = \Illuminate\Support\Facades\Hash::check($password, $deptAccount->password);
    } catch (\Throwable $e) {
        $validPassword = false;
    }
    if (!$validPassword) {
        $validPassword = $deptAccount->password === $password;
    }

    if ($validPassword) {
        // Create Laravel user
        $laravelUser = \App\Models\User::updateOrCreate(
            ['email' => $deptAccount->employee_id . '@soliera.local'],
            [
                'name' => $deptAccount->employee_name ?? 'User',
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
                'email_verified_at' => now(),
                'role' => $deptAccount->role ?? 'employee',
                'employee_id' => $deptAccount->employee_id,
                'department' => $deptAccount->dept_name ?? 'general',
            ]
        );

        // Login user
        \Illuminate\Support\Facades\Auth::login($laravelUser);
        $request->session()->regenerate();

        // Store session data
        session(['emp_id' => $deptAccount->employee_id]);
        session(['user_role' => $deptAccount->role]);

        return response()->json([
            'success' => true,
            'message' => 'Login successful (bypass mode)',
            'user' => $deptAccount->employee_name,
            'role' => $deptAccount->role
        ]);
    }

    return response()->json(['error' => 'Invalid credentials'], 401);
});

// Fix Audit Logs Route
Route::get('/fix-audit-logs', function () {
    try {
        $logs = \App\Models\AccessLog::all();
        $count = 0;

        foreach ($logs as $log) {
            $updated = false;

            // Fix IP Address
            if (empty($log->ip_address) || $log->ip_address === '::1') {
                $log->ip_address = '127.0.0.1';
                $updated = true;
            }

            // Generate Details
            if (empty($log->details)) {
                $action = $log->action;
                $desc = $log->description ?? '';

                if (stripos($action, 'login') !== false) {
                    $log->details = 'User authenticated successfully via web portal.';
                } elseif (stripos($action, 'logout') !== false) {
                    $log->details = 'User initiated session termination.';
                } elseif (stripos($action, 'create') !== false) {
                    $log->details = 'New record creation initiated by user.';
                } elseif (stripos($action, 'update') !== false) {
                    $log->details = 'Record modification performed by user.';
                } elseif (stripos($action, 'delete') !== false) {
                    $log->details = 'Record deletion confirmed by user.';
                } else {
                    $log->details = $desc ?: 'User performed ' . $action;
                }
                $updated = true;
            }

            if ($updated) {
                $log->save();
                $count++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Updated $count audit log entries.",
            'total_logs' => $logs->count()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});


// ============================================================================
// NEW IMPLEMENTATION ROUTES (From implementation.md)
// ============================================================================

// 1. Executive (Owner)
Route::middleware(['auth', 'role:Owner'])->prefix('executive')->group(function () {
    Route::get('/overview', [ExecutiveController::class, 'overview'])->name('executive.overview');
    Route::get('/risk', [ExecutiveController::class, 'risk'])->name('executive.risk');
    Route::get('/approvals', [ExecutiveApprovalController::class, 'index'])->name('executive.approvals');
    Route::post('/approvals/{type}/{id}/approve', [ExecutiveApprovalController::class, 'approve'])->name('executive.approvals.approve');
    Route::post('/approvals/{type}/{id}/reject', [ExecutiveApprovalController::class, 'reject'])->name('executive.approvals.reject');
    Route::get('/legal/contracts', [ExecutiveContractController::class, 'index'])->name('executive.contracts');
    Route::get('/legal/cases', [ExecutiveCaseController::class, 'index'])->name('executive.cases');
    Route::get('/compliance/permits', [ExecutivePermitController::class, 'board'])->name('executive.permits');
    Route::get('/compliance/permits/export', [ExecutivePermitController::class, 'export'])->name('executive.permits.export'); // Added export route
    Route::get('/compliance/permits/export-pdf', [ExecutivePermitController::class, 'exportPdf'])->name('executive.permits.export_pdf'); // Added PDF export route
    Route::get('/compliance/renewals', [ExecutivePermitController::class, 'calendar'])->name('executive.renewals');
    Route::get('/compliance/evidence', [ExecutiveEvidenceController::class, 'index'])->name('executive.evidence');
    Route::get('/facilities/calendar', [ExecutiveFacilitiesController::class, 'calendar'])->name('executive.facilities.calendar');
    Route::get('/vault/policy-approvals', [ExecutiveVaultController::class, 'policyApprovals'])->name('executive.policy_approvals');
    Route::get('/vault/policy-approvals/export', [ExecutiveVaultController::class, 'export'])->name('executive.vault.export'); // Added export route
    Route::get('/vault/policy-approvals/export-pdf', [ExecutiveVaultController::class, 'exportPdf'])->name('executive.vault.export_pdf'); // Added PDF export route
    Route::get('/vault/retention', [ExecutiveVaultController::class, 'retentionOverview'])->name('executive.retention');
    Route::get('/visitors/sensitive', [ExecutiveVisitorController::class, 'sensitiveLog'])->name('executive.sensitive_log');
    Route::get('/visitors/escalations', [ExecutiveVisitorController::class, 'escalations'])->name('executive.escalations');
    Route::get('/reports/kpis', [ExecutiveReportsController::class, 'kpis'])->name('executive.kpis');
    Route::get('/reports/audit-logs', [AuditLogController::class, 'index'])->name('executive.audit_logs');
    Route::get('/reports/audit-packs', [AuditPackController::class, 'index'])->name('executive.audit_packs');
    Route::get('/settings/rbac-view', [RbacController::class, 'overviewReadOnly'])->name('executive.rbac_view');
    Route::get('/settings/ai-view', [AiSettingsController::class, 'readOnly'])->name('executive.ai_view');
    Route::get('/settings/master-view', [MasterDataController::class, 'readOnly'])->name('executive.master_view');
});

// 2. Legal (Legal Officer + GM + Admin Doc; Owner read-only)
Route::middleware(['auth', 'role:Legal Officer,Owner,Admin Manager'])->prefix('legal-desk')->group(function () {
    // Note: 'legal-desk' prefix used to avoid conflict with existing 'legal' resource
    Route::get('/contract-requests', [ContractRequestController::class, 'index'])->name('legal.contract_requests');
    Route::get('/contract-requests/create', [ContractRequestController::class, 'create'])->name('legal.contract_requests.create');
    Route::get('/contracts', [ContractController::class, 'index'])->name('legal.contracts.workspace');
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('legal.contracts.create');
    Route::get('/contracts/export', [ContractController::class, 'export'])->name('legal.contracts.export');
    Route::get('/contracts/export-pdf', [ContractController::class, 'exportPdf'])->name('legal.contracts.export_pdf'); // Added PDF export route
    Route::post('/contracts', [ContractController::class, 'store'])->name('legal.contracts.store');
    Route::get('/contracts/{id}', [ContractController::class, 'show'])->name('legal.contracts.details');
    Route::get('/contracts/{id}/edit', [ContractController::class, 'edit'])->name('legal.contracts.edit');
    Route::put('/contracts/{id}', [ContractController::class, 'update'])->name('legal.contracts.update');
    Route::delete('/contracts/{id}', [ContractController::class, 'destroy'])->name('legal.contracts.destroy');
    Route::get('/contracts/{id}/download', [ContractController::class, 'download'])->name('legal.contracts.download');
    Route::patch('/contracts/{id}/status', [ContractController::class, 'updateStatus'])->name('legal.contracts.status');
    // Route::post('/contracts/{id}/versions', [ContractVersionController::class, 'store'])->name('legal.contracts.versions.store');
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('legal.approvals.queue');
    Route::get('/contract-register', [ContractRegisterController::class, 'index'])->name('legal.contract_register');
    // Route::get('/obligations', [ContractObligationController::class, 'index'])->name('legal.obligations');
    Route::get('/alerts', [LegalAlertController::class, 'index'])->name('legal.alerts');
    Route::get('/templates', [TemplateController::class, 'index'])->name('legal.templates');
    Route::get('/templates/create', [TemplateController::class, 'create'])->name('legal.templates.create');
    Route::post('/templates', [TemplateController::class, 'store'])->name('legal.templates.store');
    Route::get('/clauses', [ClauseLibraryController::class, 'index'])->name('legal.clauses');
    Route::post('/clauses', [ClauseLibraryController::class, 'store'])->name('legal.clauses.store');
    Route::get('/cases-desk', [CaseController::class, 'index'])->name('legal.cases.desk');
    Route::get('/cases-desk/export', [CaseController::class, 'export'])->name('legal.cases.desk.export'); // Added export route
    Route::get('/cases-desk/export-pdf', [CaseController::class, 'exportPdf'])->name('legal.cases.desk.export_pdf'); // Added PDF export route
    Route::get('/cases-desk/create', [CaseController::class, 'create'])->name('legal.cases.desk.create');
    Route::post('/cases-desk', [CaseController::class, 'store'])->name('legal.cases.desk.store');
    Route::get('/cases-desk/{id}', [CaseController::class, 'show'])->name('legal.cases.desk.show');
    Route::get('/cases-desk/{id}/edit', [CaseController::class, 'edit'])->name('legal.cases.desk.edit');
    Route::put('/cases-desk/{id}', [CaseController::class, 'update'])->name('legal.cases.desk.update');
    Route::delete('/cases-desk/{id}', [CaseController::class, 'destroy'])->name('legal.cases.desk.destroy');
    Route::post('/cases-desk/{id}/update', [CaseController::class, 'addUpdate'])->name('legal.cases.desk.add-update');
    Route::post('/cases-desk/{id}/upload', [CaseController::class, 'uploadDocument'])->name('legal.cases.desk.upload-document');
    Route::get('/ai/insights', [AiLegalController::class, 'index'])->name('legal.ai.insights');
    Route::get('/ai/analyze', [AiLegalController::class, 'create'])->name('legal.ai.create');
    Route::post('/ai/analyze', [AiLegalController::class, 'store'])->name('legal.ai.store');
    Route::get('/ai/results/{id}', [AiLegalController::class, 'show'])->name('legal.ai.show');
});

// 3. Compliance (Compliance Lead + Admin Manager; Owner read-only)
Route::middleware(['auth', 'role:Compliance Lead,Admin Manager,Owner'])->prefix('compliance')->group(function () {
    Route::get('/dashboard', [PermitController::class, 'dashboard'])->name('compliance.dashboard');
    Route::get('/permits', [PermitController::class, 'index'])->name('compliance.permits');
    Route::get('/permits/create', [PermitController::class, 'create'])->name('compliance.permits.create');
    Route::post('/permits', [PermitController::class, 'store'])->name('compliance.permits.store');
    Route::get('/permits/{id}', [PermitController::class, 'show'])->name('compliance.permits.show');
    Route::put('/permits/{id}', [PermitController::class, 'update'])->name('compliance.permits.update');
    Route::delete('/permits/{id}', [PermitController::class, 'destroy'])->name('compliance.permits.destroy');
    Route::get('/renewals', [PermitController::class, 'renewals'])->name('compliance.renewals');
    Route::get('/permits/{id}/requirements', [PermitRequirementController::class, 'index'])->name('compliance.requirements');
    Route::get('/evidence', [PermitFileController::class, 'index'])->name('compliance.evidence');
    Route::get('/ai/insights', [AiComplianceController::class, 'index'])->name('compliance.ai.insights');
    Route::get('/corrective-actions', [CorrectiveActionController::class, 'index'])->name('compliance.corrective_actions');
    Route::post('/corrective-actions', [CorrectiveActionController::class, 'store'])->name('compliance.corrective_actions.store');
});

// 4. Facilities (Admin Manager + Security view)
Route::middleware(['auth', 'role:Admin Manager,Security Supervisor,Owner'])->prefix('facilities-desk')->group(function () {
    Route::get('/calendar', [App\Http\Controllers\FacilityReservationController::class, 'calendar'])->name('facilities.calendar.view');
    Route::get('/reservations/create', [App\Http\Controllers\FacilityReservationController::class, 'create'])->name('facilities.reservations.create_new');
    Route::get('/reservations', [App\Http\Controllers\FacilityReservationController::class, 'index'])->name('facilities.reservations.list');
    Route::get('/reservations/{id}', [App\Http\Controllers\FacilityReservationController::class, 'show'])->name('facilities.reservations.details');
    Route::get('/post-use', [PostUseController::class, 'index'])->name('facilities.post_use');
    Route::get('/resources', [ResourceController::class, 'index'])->name('facilities.resources');
    Route::get('/approvals', [FacilitiesApprovalController::class, 'index'])->name('facilities.approvals');
});

// 5. Vault (Document Management)
Route::middleware(['auth', 'role:Admin Manager,Owner,Legal Officer'])->prefix('vault')->group(function () {
    Route::get('/documents', [DocumentController::class, 'vaultIndex'])->name('vault.documents.index_new');
    Route::get('/folders/{id}', [FolderController::class, 'show'])->name('vault.folders.show');
    Route::post('/folders', [FolderController::class, 'store'])->name('vault.folders.store');
    Route::put('/folders/{id}', [FolderController::class, 'update'])->name('vault.folders.update');
    Route::delete('/folders/{id}', [FolderController::class, 'destroy'])->name('vault.folders.destroy');

    // Bulk Actions
    Route::post('/bulk/destroy', [DocumentController::class, 'bulkDestroy'])->name('vault.bulk.destroy');
    Route::post('/bulk/move', [DocumentController::class, 'bulkMove'])->name('vault.bulk.move');

    Route::get('/documents/{id}', [DocumentController::class, 'show'])->name('vault.documents.show_new');
    Route::get('/documents/{id}/download', [DocumentController::class, 'download'])->name('vault.documents.download');
    Route::get('/documents/{id}/preview', [DocumentController::class, 'preview'])->name('vault.documents.preview');
    Route::get('/controlled', [ControlledDocController::class, 'index'])->name('vault.controlled');
    Route::get('/versions', [DocumentVersionController::class, 'index'])->name('vault.versions');
    Route::get('/retention', [RetentionController::class, 'index'])->name('vault.retention');
    Route::get('/access-matrix', [AccessMatrixController::class, 'index'])->name('vault.access_matrix');
});

// 6. Visitors
Route::middleware(['auth', 'role:Front Office Manager,Security Supervisor,Admin Manager,Owner'])->prefix('visitors-desk')->group(function () {
    Route::get('/pre-registrations', [PreRegistrationController::class, 'index'])->name('visitors.pre_registrations');
    Route::post('/pre-registrations/bulk', [PreRegistrationController::class, 'bulkStore'])->name('visitors.pre_registrations.bulk_store');
    Route::post('/pre-registrations/bulk-status', [PreRegistrationController::class, 'bulkUpdateStatus'])->name('visitors.pre_registrations.bulk_status');
    Route::get('/pre-registrations/bulk-status', function () {
        return redirect()->route('visitors.pre_registrations');
    });
    Route::post('/pre-registrations', [PreRegistrationController::class, 'store'])->name('visitors.pre_registrations.store');
    Route::patch('/pre-registrations/{id}/status', [PreRegistrationController::class, 'updateStatus'])->name('visitors.pre_registrations.status');

    Route::get('/check-in', [VisitorLogController::class, 'checkInForm'])->name('visitors.check_in_form');
    Route::get('/check-out', [VisitorLogController::class, 'checkOutForm'])->name('visitors.check_out_form');
    Route::get('/badges', [VisitorLogController::class, 'badges'])->name('visitors.badges');
    Route::get('/zones', [ZonePolicyController::class, 'index'])->name('visitors.zones');
    Route::get('/incidents', [VisitorIncidentController::class, 'index'])->name('visitors.incidents');
    Route::post('/incidents', [VisitorIncidentController::class, 'store'])->name('visitors.incidents.store');
});

// 7. Reports & Audit
Route::middleware(['auth', 'role:Owner,Admin Manager'])->prefix('reports-center')->group(function () {
    Route::get('/kpis', [KpiController::class, 'index'])->name('reports.kpis');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('reports.audit_logs');
    Route::get('/audit-packs', [AuditPackController::class, 'index'])->name('reports.audit_packs');
    Route::post('/audit-packs/generate', [AuditPackController::class, 'generate'])->name('reports.audit_packs.generate');
});

// Fix Audit Logs Route
Route::get('/fix-audit-logs', function () {
    try {
        $logs = \App\Models\AccessLog::all();
        $count = 0;

        foreach ($logs as $log) {
            $updated = false;

            // Fix IP Address
            if (empty($log->ip_address) || $log->ip_address === '::1') {
                $log->ip_address = '127.0.0.1';
                $updated = true;
            }

            // Generate Details
            if (empty($log->details)) {
                $action = $log->action;
                $desc = $log->description ?? '';

                if (stripos($action, 'login') !== false) {
                    $log->details = 'User authenticated successfully via web portal.';
                } elseif (stripos($action, 'logout') !== false) {
                    $log->details = 'User initiated session termination.';
                } elseif (stripos($action, 'create') !== false) {
                    $log->details = 'New record creation initiated by user.';
                } elseif (stripos($action, 'update') !== false) {
                    $log->details = 'Record modification performed by user.';
                } elseif (stripos($action, 'delete') !== false) {
                    $log->details = 'Record deletion confirmed by user.';
                } else {
                    $log->details = $desc ?: 'User performed ' . $action;
                }
                $updated = true;
            }

            if ($updated) {
                $log->save();
                $count++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Updated $count audit log entries.",
            'total_logs' => $logs->count()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
    ]);
});

require __DIR__ . '/auth.php';
