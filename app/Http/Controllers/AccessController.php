<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessLog;
use App\Models\User;
use App\Models\DeptAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccessController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $allowedRoles = ['administrator', 'admin manager', 'owner'];
            if (!auth()->check() || !in_array(strtolower(auth()->user()->role), $allowedRoles)) {
                abort(403, 'Only Administrators can access user management.');
            }
            return $next($request);
        })->only(['users', 'editRole', 'updateRole']);
    }

    public function users(Request $request)
    {
        // Dynamic filter options
        $roleOptions = \App\Models\DeptAccount::whereNotNull('role')
            ->distinct()->orderBy('role')->pluck('role')->filter()->values();
        $departmentOptions = \App\Models\DeptAccount::whereNotNull('dept_name')
            ->distinct()->orderBy('dept_name')->pluck('dept_name')->filter()->values();

        // Build filters from request
        $search = trim((string) $request->get('q'));
        $role = (string) $request->get('role');
        $department = (string) $request->get('department');
        $status = (string) $request->get('status');

        $query = \App\Models\DeptAccount::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('employee_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }
        if ($role !== '') {
            $query->where('role', $role);
        }
        if ($department !== '') {
            $query->where('dept_name', $department);
        }
        if ($status !== '') {
            $query->where('status', $status);
        }

        $accounts = $query->orderBy('employee_name')
            ->paginate(10)
            ->appends($request->query());
        // Build rows for the table with an optional related Laravel user id
        $rows = $accounts->getCollection()->map(function ($acc) {
            $relatedUserId = null;
            try {
                if (!empty($acc->employee_id)) {
                    $related = User::where('email', $acc->employee_id . '@soliera.local')->first();
                    if ($related) {
                        $relatedUserId = $related->id;
                    }
                }
            } catch (\Throwable $e) { /* ignore lookup errors */
            }

            return [
                'id' => $acc->Dept_no ?? $acc->id,
                'name' => $acc->employee_name ?? ($acc->name ?? 'Unknown User'),
                'email' => $acc->email ?? '—',
                'role' => $acc->role ?? 'Staff',
                'department' => $acc->dept_name ?? '—',
                'status' => ucfirst($acc->status ?? 'inactive'),
                'last_login' => $acc->last_login ?? now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'created_at' => ($acc->created_at ?? now())->format('Y-m-d'),
                'laravel_user_id' => $relatedUserId,
            ];
        });

        $users = $rows; // array rows for blade loop

        return view('access.users', [
            'users' => $users,
            'roleOptions' => $roleOptions,
            'departmentOptions' => $departmentOptions,
            'filters' => [
                'q' => $search,
                'role' => $role,
                'department' => $department,
                'status' => $status,
            ],
        ]);
    }

    /**
     * Show a single user's profile (DeptAccount + related Laravel User if available)
     */
    public function showUser($id)
    {
        // Locate DeptAccount by either Dept_no (PK) or employee_id (business ID)
        $account = \App\Models\DeptAccount::where('Dept_no', $id)
            ->orWhere('employee_id', $id)
            ->firstOrFail();

        $laravelUser = null;
        try {
            if (!empty($account->employee_id)) {
                $laravelUser = User::where('email', $account->employee_id . '@soliera.local')->first();
            }
        } catch (\Throwable $e) { /* ignore lookup errors */
        }

        return view('access.user_profile', [
            'account' => $account,
            'laravelUser' => $laravelUser,
        ]);
    }

    public function roles()
    {
        $roles = [
            [
                'name' => 'Administrator',
                'description' => 'Full system access with all permissions',
                'users_count' => 2,
                'permissions' => ['All Permissions'],
                'created_at' => '2023-06-01'
            ],
            [
                'name' => 'Front Desk Manager',
                'description' => 'Manage reservations, guests, and front desk operations',
                'users_count' => 3,
                'permissions' => ['Reservations', 'Guests', 'Rooms', 'Billing'],
                'created_at' => '2023-06-01'
            ],
            [
                'name' => 'Kitchen Manager',
                'description' => 'Manage restaurant operations, menu, and orders',
                'users_count' => 2,
                'permissions' => ['Menu Management', 'Orders', 'Inventory', 'Staff Schedule'],
                'created_at' => '2023-06-01'
            ],
            [
                'name' => 'Housekeeping Supervisor',
                'description' => 'Manage room cleaning and maintenance schedules',
                'users_count' => 4,
                'permissions' => ['Room Status', 'Maintenance', 'Staff Schedule'],
                'created_at' => '2023-06-01'
            ]
        ];

        return view('access.roles', compact('roles'));
    }

    /**
     * Assign RBAC role to a department account (JSON)
     */
    public function assignRole(Request $request)
    {
        try {
            $validated = $request->validate([
                'account_id' => 'required|integer',
                'role_code' => 'required|string|max:60',
            ]);
            $role = \Illuminate\Support\Facades\DB::table('rbac_roles')->where('code', $validated['role_code'])->first();
            if (!$role) {
                return response()->json(['success' => false, 'message' => 'Role code not found'], 404);
            }
            \Illuminate\Support\Facades\DB::table('rbac_user_roles')->updateOrInsert(
                ['account_id' => $validated['account_id'], 'role_id' => $role->id],
                []
            );
            return response()->json(['success' => true, 'message' => 'Role assigned']);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['success' => false, 'errors' => $ve->errors()], 422);
        } catch (\Throwable $e) {
            \Log::error('assignRole error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }


    /**
     * Create sample access logs for demonstration
     */
    private function createSampleLogs()
    {
        try {
            // Get some sample users from DeptAccount
            $users = \App\Models\DeptAccount::take(3)->get();

            if ($users->count() > 0) {
                $sampleActions = [
                    'Login' => 'User logged in successfully',
                    'Document_uploaded' => 'Document uploaded and processed',
                    'Access_control_check' => 'User passed authorization check',
                    'Logout' => 'User logged out successfully',
                    'Profile_updated' => 'User profile information updated'
                ];

                foreach ($users as $user) {
                    foreach ($sampleActions as $action => $description) {
                        AccessLog::create([
                            'user_id' => $user->Dept_no,
                            'action' => $action,
                            'description' => $description,
                            'ip_address' => '127.0.0.1'
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error creating sample logs: ' . $e->getMessage());
        }
    }

    /**
     * Create sample login and logout logs for demonstration
     */
    private function createSampleLoginLogoutLogs()
    {
        try {
            // Get some sample users from DeptAccount
            $users = \App\Models\DeptAccount::take(3)->get();

            if ($users->count() > 0) {
                $loginLogoutActions = [
                    'Login' => 'User logged in successfully',
                    'Logout' => 'User logged out successfully'
                ];

                foreach ($users as $user) {
                    foreach ($loginLogoutActions as $action => $description) {
                        AccessLog::create([
                            'user_id' => $user->Dept_no,
                            'action' => $action,
                            'description' => $description,
                            'ip_address' => '127.0.0.1'
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error creating sample login/logout logs: ' . $e->getMessage());
        }
    }

    /**
     * Static method to log user actions (can be called from other controllers)
     */
    public static function logAction($userId, $action, $description = '', $ipAddress = null, $details = null)
    {
        try {
            // If userId is an employee_id, find the corresponding Dept_no
            $deptNo = $userId;
            if (is_string($userId) && !is_numeric($userId)) {
                // This might be an employee_id, try to find the Dept_no
                $deptAccount = \App\Models\DeptAccount::where('employee_id', $userId)->first();
                if ($deptAccount) {
                    $deptNo = $deptAccount->Dept_no;
                } else {
                    // If no DeptAccount found, create a temporary one
                    $currentUser = \Illuminate\Support\Facades\Auth::user();
                    $deptAccount = \App\Models\DeptAccount::create([
                        'Dept_id' => 'TEMP_' . time(),
                        'dept_name' => $currentUser->department ?? 'Administrative',
                        'employee_name' => $currentUser->name ?? 'Unknown User',
                        'employee_id' => $userId,
                        'role' => $currentUser->role ?? 'No role',
                        'email' => $currentUser->email ?? '',
                        'status' => 'active',
                        'password' => bcrypt('temp')
                    ]);
                    $deptNo = $deptAccount->Dept_no;
                }
            }

            // Generate details if not provided
            if (empty($details)) {
                if (stripos($action, 'login') !== false) {
                    $details = 'User authenticated successfully via web portal.';
                } elseif (stripos($action, 'logout') !== false) {
                    $details = 'User initiated session termination.';
                } elseif (stripos($action, 'create') !== false) {
                    $details = 'New record creation initiated by user.';
                } elseif (stripos($action, 'update') !== false) {
                    $details = 'Record modification performed by user.';
                } elseif (stripos($action, 'delete') !== false) {
                    $details = 'Record deletion confirmed by user.';
                } else {
                    $details = $description;
                }
            }

            // Ensure IP is IPv4
            $ip = $ipAddress ?? request()->ip();
            if ($ip === '::1') {
                $ip = '127.0.0.1';
            }

            AccessLog::create([
                'user_id' => $deptNo,
                'action' => $action,
                'description' => $description,
                'ip_address' => $ip,
                'details' => $details
            ]);
        } catch (\Exception $e) {
            \Log::error('Error logging action: ' . $e->getMessage());
        }
    }

    public function security()
    {
        // Role restrictions removed - all users can access security settings
        $securitySettings = [
            'password_policy' => [
                'min_length' => 8,
                'require_uppercase' => true,
                'require_lowercase' => true,
                'require_numbers' => true,
                'require_symbols' => true,
                'expiry_days' => 90
            ],
            'session_settings' => [
                'timeout_minutes' => 30,
                'max_concurrent_sessions' => 3,
                'remember_me_days' => 30
            ],
            'security_features' => [
                'two_factor_auth' => true,
                'ip_whitelist' => false,
                'failed_login_lockout' => true,
                'audit_logging' => true
            ]
        ];
        return view('access.security', compact('securitySettings'));
    }

    public function editRole(User $user)
    {
        $roles = ['Administrator', 'Manager', 'Staff', 'Legal', 'Reception', 'Housekeeping', 'Restaurant'];
        return view('access.edit_role', compact('user', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|max:255',
        ]);
        $user->role = $request->role;
        $user->save();
        return redirect()->route('access.users')->with('success', 'User role updated successfully!');
    }

    public function departmentAccounts()
    {
        try {
            // Get department accounts from the database
            $departmentAccounts = \App\Models\DeptAccount::orderBy('dept_name', 'asc')->get();

            // Group accounts by department for better organization
            $departments = $departmentAccounts->groupBy('dept_name');

            // Get statistics
            $totalAccounts = $departmentAccounts->count();
            $activeAccounts = $departmentAccounts->where('status', 'active')->count();
            $inactiveAccounts = $departmentAccounts->where('status', 'inactive')->count();

            $stats = [
                'total' => $totalAccounts,
                'active' => $activeAccounts,
                'inactive' => $inactiveAccounts
            ];

            return view('access.department_accounts', compact('departmentAccounts', 'departments', 'stats'));

        } catch (\Exception $e) {
            \Log::error('Error loading department accounts: ' . $e->getMessage());
            session()->flash('error', 'Error loading department accounts: ' . $e->getMessage());

            // Return empty data on error
            return view('access.department_accounts', [
                'departmentAccounts' => collect([]),
                'departments' => collect([]),
                'stats' => ['total' => 0, 'active' => 0, 'inactive' => 0]
            ]);
        }
    }

    public function storeDepartmentAccount(Request $request)
    {
        try {
            $request->validate([
                'employee_name' => 'required|string|max:255',
                'dept_name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'role' => 'nullable|string|max:255',
                'status' => 'required|in:active,inactive',
            ]);

            // Create new department account
            $deptAccount = new \App\Models\DeptAccount();
            $deptAccount->employee_name = $request->employee_name;
            $deptAccount->dept_name = $request->dept_name;
            $deptAccount->email = $request->email;
            $deptAccount->role = $request->role;
            $deptAccount->status = $request->status;
            $deptAccount->save();

            return redirect()->route('access.department_accounts')->with('success', 'Department account created successfully!');

        } catch (\Exception $e) {
            \Log::error('Error creating department account: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating department account: ' . $e->getMessage())->withInput();
        }
    }

    // View a single department account (JSON)
    // Requires Bearer Token Authentication when accessed via API
    public function showDepartmentAccount(Request $request, $id)
    {
        try {
            // Check if this is an API request (has bearer token)
            if ($request->expectsJson() || $request->hasHeader('Authorization')) {
                $user = $request->user();
                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthenticated. Bearer token required.',
                    ], 401)->header('Content-Type', 'application/json');
                }
            }

            $account = \App\Models\DeptAccount::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $account->Dept_no ?? $account->id,
                    'employee_name' => $account->employee_name,
                    'employee_id' => $account->employee_id,
                    'email' => $account->email,
                    'dept_name' => $account->dept_name,
                    'role' => $account->role,
                    'status' => $account->status,
                    'profile_picture' => $account->profile_picture,
                ],
            ])->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found',
            ], 404)->header('Content-Type', 'application/json');
        }
    }

    // Update a department account (JSON)
    // Requires Bearer Token Authentication when accessed via API
    public function updateDepartmentAccount(Request $request, $id)
    {
        try {
            // Check if this is an API request (has bearer token)
            if ($request->expectsJson() || $request->hasHeader('Authorization')) {
                $user = $request->user();
                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthenticated. Bearer token required.',
                    ], 401)->header('Content-Type', 'application/json');
                }
            }

            $request->validate([
                'employee_name' => 'sometimes|string|max:255',
                'dept_name' => 'sometimes|string|max:255',
                'email' => 'nullable|email|max:255',
                'role' => 'nullable|string|max:255',
                'status' => 'nullable|in:active,inactive',
            ]);

            $account = \App\Models\DeptAccount::findOrFail($id);
            $oldData = $account->toArray();
            $account->fill($request->only(['employee_name', 'dept_name', 'email', 'role', 'status']));
            $account->save();

            // Log the action if API request
            if ($request->expectsJson() || $request->hasHeader('Authorization')) {
                try {
                    $user = $request->user();
                    $deptAccountForLog = \App\Models\DeptAccount::where('employee_id', $user->employee_id ?? null)
                        ->orWhere('email', $user->email ?? null)
                        ->first();
                    $userIdForLog = $deptAccountForLog ? (string) $deptAccountForLog->Dept_no : '0';

                    AccessLog::create([
                        'user_id' => $userIdForLog,
                        'action' => 'department_account_updated',
                        'description' => "Updated department account: {$account->employee_name} ({$account->employee_id})",
                        'ip_address' => $request->ip() ?? '0.0.0.0',
                    ]);
                } catch (\Exception $e) {
                    \Log::warning('Failed to log department account update: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Account updated successfully',
                'data' => [
                    'id' => $account->Dept_no ?? $account->id,
                    'employee_name' => $account->employee_name,
                    'employee_id' => $account->employee_id,
                    'email' => $account->email,
                    'dept_name' => $account->dept_name,
                    'role' => $account->role,
                    'status' => $account->status,
                    'profile_picture' => $account->profile_picture,
                ],
            ])->header('Content-Type', 'application/json');
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $ve->errors(),
            ], 422)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to update account',
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    // Toggle active/inactive status (JSON)
    // Requires Bearer Token Authentication when accessed via API
    public function toggleDepartmentAccountStatus(Request $request, $id)
    {
        try {
            // Check if this is an API request (has bearer token)
            if ($request->expectsJson() || $request->hasHeader('Authorization')) {
                $user = $request->user();
                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthenticated. Bearer token required.',
                    ], 401)->header('Content-Type', 'application/json');
                }
            }

            $account = \App\Models\DeptAccount::findOrFail($id);
            $oldStatus = $account->status;
            $account->status = ($account->status === 'active') ? 'inactive' : 'active';
            $account->save();

            // Log the action if API request
            if ($request->expectsJson() || $request->hasHeader('Authorization')) {
                try {
                    $user = $request->user();
                    $deptAccountForLog = \App\Models\DeptAccount::where('employee_id', $user->employee_id ?? null)
                        ->orWhere('email', $user->email ?? null)
                        ->first();
                    $userIdForLog = $deptAccountForLog ? (string) $deptAccountForLog->Dept_no : '0';

                    AccessLog::create([
                        'user_id' => $userIdForLog,
                        'action' => 'department_account_status_toggled',
                        'description' => "Toggled status of {$account->employee_name} ({$account->employee_id}) from {$oldStatus} to {$account->status}",
                        'ip_address' => $request->ip() ?? '0.0.0.0',
                    ]);
                } catch (\Exception $e) {
                    \Log::warning('Failed to log department account status toggle: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'status' => $account->status,
                'message' => 'Status updated',
            ])->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to toggle status',
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Get department accounts via GET API
     * Requires Bearer Token Authentication
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartmentAccounts(Request $request)
    {
        try {
            // Ensure we're accepting JSON
            $request->headers->set('Accept', 'application/json');

            // Validate query parameters
            $validated = $request->validate([
                'search' => 'nullable|string|max:255',
                'dept_name' => 'nullable|string|max:255',
                'role' => 'nullable|string|max:255',
                'status' => 'nullable|in:active,inactive',
                'limit' => 'nullable|integer|min:1|max:100',
                'offset' => 'nullable|integer|min:0',
                'sort_by' => 'nullable|string|in:employee_name,dept_name,role,status,created_at',
                'sort_order' => 'nullable|string|in:asc,desc',
            ]);

            // Build query
            $query = \App\Models\DeptAccount::query();

            // Apply filters
            if (!empty($validated['search'])) {
                $searchTerm = $validated['search'];
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('employee_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%')
                        ->orWhere('employee_id', 'like', '%' . $searchTerm . '%');
                });
            }

            if (!empty($validated['dept_name'])) {
                $query->where('dept_name', $validated['dept_name']);
            }

            if (!empty($validated['role'])) {
                $query->where('role', $validated['role']);
            }

            if (!empty($validated['status'])) {
                $query->where('status', $validated['status']);
            }

            // Apply sorting
            $sortBy = $validated['sort_by'] ?? 'employee_name';
            $sortOrder = $validated['sort_order'] ?? 'asc';
            $query->orderBy($sortBy, $sortOrder);

            // Get total count before pagination
            $total = $query->count();

            // Apply pagination
            $limit = $validated['limit'] ?? 50;
            $offset = $validated['offset'] ?? 0;
            $accounts = $query->skip($offset)->take($limit)->get();

            // Get statistics
            $totalAccounts = \App\Models\DeptAccount::count();
            $activeAccounts = \App\Models\DeptAccount::where('status', 'active')->count();
            $inactiveAccounts = \App\Models\DeptAccount::where('status', 'inactive')->count();

            return response()->json([
                'success' => true,
                'message' => 'Department accounts retrieved successfully',
                'data' => $accounts->map(function ($account) {
                    return [
                        'id' => $account->Dept_no ?? $account->id,
                        'employee_name' => $account->employee_name,
                        'employee_id' => $account->employee_id,
                        'email' => $account->email,
                        'dept_name' => $account->dept_name,
                        'role' => $account->role,
                        'status' => $account->status,
                        'profile_picture' => $account->profile_picture,
                    ];
                }),
                'statistics' => [
                    'total' => $totalAccounts,
                    'active' => $activeAccounts,
                    'inactive' => $inactiveAccounts,
                ],
                'pagination' => [
                    'total' => $total,
                    'limit' => $limit,
                    'offset' => $offset,
                    'has_more' => ($offset + $limit) < $total,
                    'current_page' => floor($offset / $limit) + 1,
                    'total_pages' => ceil($total / $limit),
                ],
                'filters_applied' => [
                    'search' => $validated['search'] ?? null,
                    'dept_name' => $validated['dept_name'] ?? null,
                    'role' => $validated['role'] ?? null,
                    'status' => $validated['status'] ?? null,
                ]
            ], 200)->header('Content-Type', 'application/json');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error retrieving department accounts: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving department accounts',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while retrieving department accounts.'
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Create department account entry or retrieve department accounts via POST API
     * If required fields (employee_name, dept_name, status) are provided, creates a new department account
     * If required fields are NOT provided, retrieves department accounts with filters
     * Requires Bearer Token Authentication
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDepartmentAccountApi(Request $request)
    {
        try {
            // Ensure we're accepting JSON
            $request->headers->set('Accept', 'application/json');

            // Get authenticated user (middleware ensures authentication)
            $user = $request->user();

            // Check if this is a search/retrieve request (no required fields) or create request
            if (
                !$request->has('employee_name') || empty($request->input('employee_name')) ||
                !$request->has('dept_name') || empty($request->input('dept_name')) ||
                !$request->has('status') || empty($request->input('status'))
            ) {
                // This is a search/retrieve request - delegate to postDepartmentAccounts
                return $this->postDepartmentAccounts($request);
            }

            // This is a create request - validate the incoming request
            $validated = $request->validate([
                'employee_name' => 'required|string|max:255',
                'employee_id' => 'nullable|string|max:255|unique:department_accounts,employee_id',
                'dept_name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'role' => 'nullable|string|max:255',
                'status' => 'required|in:active,inactive',
                'password' => 'nullable|string|min:6',
                'profile_picture' => 'nullable|string|max:255',
            ], [
                'employee_name.required' => 'The employee_name field is required.',
                'employee_name.string' => 'The employee_name must be a string.',
                'employee_name.max' => 'The employee_name may not be greater than 255 characters.',
                'employee_id.unique' => 'The employee_id has already been taken.',
                'dept_name.required' => 'The dept_name field is required.',
                'dept_name.string' => 'The dept_name must be a string.',
                'dept_name.max' => 'The dept_name may not be greater than 255 characters.',
                'email.email' => 'The email must be a valid email address.',
                'email.max' => 'The email may not be greater than 255 characters.',
                'status.required' => 'The status field is required.',
                'status.in' => 'The status must be either active or inactive.',
                'password.min' => 'The password must be at least 6 characters.',
            ]);

            // Create new department account
            $deptAccount = new \App\Models\DeptAccount();
            $deptAccount->employee_name = $validated['employee_name'];
            $deptAccount->dept_name = $validated['dept_name'];
            $deptAccount->email = $validated['email'] ?? null;
            $deptAccount->role = $validated['role'] ?? null;
            $deptAccount->status = $validated['status'];
            $deptAccount->employee_id = $validated['employee_id'] ?? null;
            $deptAccount->profile_picture = $validated['profile_picture'] ?? null;

            // Hash password if provided
            if (!empty($validated['password'])) {
                $deptAccount->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
            } else {
                // Generate a random password if not provided
                $deptAccount->password = \Illuminate\Support\Facades\Hash::make(Str::random(16));
            }

            $deptAccount->save();

            // Log the action
            try {
                $deptAccountForLog = \App\Models\DeptAccount::where('employee_id', $user->employee_id ?? null)
                    ->orWhere('email', $user->email ?? null)
                    ->first();
                $userIdForLog = $deptAccountForLog ? (string) $deptAccountForLog->Dept_no : '0';

                AccessLog::create([
                    'user_id' => $userIdForLog,
                    'action' => 'department_account_created',
                    'description' => "Created department account: {$deptAccount->employee_name} ({$deptAccount->employee_id})",
                    'ip_address' => $request->ip() ?? '0.0.0.0',
                ]);
            } catch (\Exception $e) {
                \Log::warning('Failed to log department account creation: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Department account created successfully',
                'data' => [
                    'id' => $deptAccount->Dept_no ?? $deptAccount->id,
                    'employee_name' => $deptAccount->employee_name,
                    'employee_id' => $deptAccount->employee_id,
                    'email' => $deptAccount->email,
                    'dept_name' => $deptAccount->dept_name,
                    'role' => $deptAccount->role,
                    'status' => $deptAccount->status,
                    'profile_picture' => $deptAccount->profile_picture,
                ],
                'created_by' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ], 201)->header('Content-Type', 'application/json');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error creating department account: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error creating department account',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while creating the department account.'
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Get department accounts via POST API (with filters in request body)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDepartmentAccounts(Request $request)
    {
        try {
            // Ensure we're accepting JSON
            $request->headers->set('Accept', 'application/json');

            // Validate request body parameters
            $validated = $request->validate([
                'search' => 'nullable|string|max:255',
                'dept_name' => 'nullable|string|max:255',
                'role' => 'nullable|string|max:255',
                'status' => 'nullable|in:active,inactive',
                'limit' => 'nullable|integer|min:1|max:100',
                'offset' => 'nullable|integer|min:0',
                'sort_by' => 'nullable|string|in:employee_name,dept_name,role,status',
                'sort_order' => 'nullable|string|in:asc,desc',
            ]);

            // Build query
            $query = \App\Models\DeptAccount::query();

            // Apply filters
            if (!empty($validated['search'])) {
                $searchTerm = $validated['search'];
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('employee_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%')
                        ->orWhere('employee_id', 'like', '%' . $searchTerm . '%');
                });
            }

            if (!empty($validated['dept_name'])) {
                $query->where('dept_name', $validated['dept_name']);
            }

            if (!empty($validated['role'])) {
                $query->where('role', $validated['role']);
            }

            if (!empty($validated['status'])) {
                $query->where('status', $validated['status']);
            }

            // Apply sorting
            $sortBy = $validated['sort_by'] ?? 'employee_name';
            $sortOrder = $validated['sort_order'] ?? 'asc';
            $query->orderBy($sortBy, $sortOrder);

            // Get total count before pagination
            $total = $query->count();

            // Apply pagination
            $limit = $validated['limit'] ?? 50;
            $offset = $validated['offset'] ?? 0;
            $accounts = $query->skip($offset)->take($limit)->get();

            // Get statistics
            $totalAccounts = \App\Models\DeptAccount::count();
            $activeAccounts = \App\Models\DeptAccount::where('status', 'active')->count();
            $inactiveAccounts = \App\Models\DeptAccount::where('status', 'inactive')->count();

            return response()->json([
                'success' => true,
                'message' => 'Department accounts retrieved successfully',
                'data' => $accounts->map(function ($account) {
                    return [
                        'id' => $account->Dept_no ?? $account->id,
                        'employee_name' => $account->employee_name,
                        'employee_id' => $account->employee_id,
                        'email' => $account->email,
                        'dept_name' => $account->dept_name,
                        'role' => $account->role,
                        'status' => $account->status,
                        'profile_picture' => $account->profile_picture,
                    ];
                }),
                'statistics' => [
                    'total' => $totalAccounts,
                    'active' => $activeAccounts,
                    'inactive' => $inactiveAccounts,
                ],
                'pagination' => [
                    'total' => $total,
                    'limit' => $limit,
                    'offset' => $offset,
                    'has_more' => ($offset + $limit) < $total,
                    'current_page' => floor($offset / $limit) + 1,
                    'total_pages' => ceil($total / $limit),
                ],
                'filters_applied' => [
                    'search' => $validated['search'] ?? null,
                    'dept_name' => $validated['dept_name'] ?? null,
                    'role' => $validated['role'] ?? null,
                    'status' => $validated['status'] ?? null,
                ]
            ], 200)->header('Content-Type', 'application/json');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error retrieving department accounts via POST: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving department accounts',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while retrieving department accounts.'
            ], 500)->header('Content-Type', 'application/json');
        }
    }


    public function auditLogs(Request $request)
    {
        try {
            $perPage = 10;
            $query = AccessLog::with('user');

            // Apply Filters
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                        ->orWhere('action', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($uq) use ($search) {
                            $uq->where('employee_name', 'like', "%{$search}%")
                                ->orWhere('dept_name', 'like', "%{$search}%");
                        });
                });
            }

            if ($request->filled('department')) {
                $dept = $request->get('department');
                $query->whereHas('user', function ($uq) use ($dept) {
                    $uq->where('dept_name', $dept);
                });
            }

            if ($request->filled('action')) {
                $query->where('action', $request->get('action'));
            }

            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->get('date'));
            }

            $logs = $query->latest()->paginate($perPage)->appends($request->query());

            if ($request->ajax()) {
                return view('access.partials.audit_logs_table', compact('logs'))->render();
            }

            return view('access.audit_logs', compact('logs'));

        } catch (\Exception $e) {
            \Log::error('Error loading audit logs: ' . $e->getMessage());
            $logs = \Illuminate\Pagination\LengthAwarePaginator::make([], 0, 10);

            if ($request->ajax()) {
                return view('access.partials.audit_logs_table', compact('logs'))->render();
            }

            session()->flash('error', 'Error loading audit logs: ' . $e->getMessage());
            return view('access.audit_logs', compact('logs'));
        }
    }

    /**
     * Create sample department logs for demonstration
     */
    private function createSampleDepartmentLogs()
    {
        try {
            // Get some sample users from DeptAccount
            $users = \App\Models\DeptAccount::take(5)->get();

            if ($users->count() > 0) {
                foreach ($users as $index => $user) {
                    AccessLog::create([
                        'user_id' => $user->Dept_no,
                        'action' => 'Login',
                        'description' => 'Login Successful',
                        'ip_address' => '127.0.0.1'
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error creating sample department logs: ' . $e->getMessage());
        }
    }

    /**
     * Create sample audit logs for demonstration
     */
    private function createSampleAuditLogs()
    {
        try {
            // Get some sample users from DeptAccount
            $users = \App\Models\DeptAccount::take(3)->get();

            if ($users->count() > 0) {
                $sampleActions = [
                    'save_legal_draft' => 'Saved legal document draft: HR Policy Template',
                    'document_view' => 'Document view: Service Agreement - XYZ Ltd (ID: 294)',
                    'Document_uploaded' => 'Document uploaded and processed successfully',
                    'Access_control_check' => 'User passed authorization check for sensitive data',
                    'Profile_updated' => 'User profile information updated',
                    'Table_added' => 'New table configuration added to system',
                    'Facility_reserved' => 'Facility reservation created and approved',
                    'Visitor_registered' => 'New visitor registered in the system',
                    'Report_generated' => 'Monthly report generated and exported',
                    'Settings_updated' => 'System settings updated by administrator',
                    'Data_exported' => 'User data exported to CSV format',
                    'Notification_sent' => 'System notification sent to user',
                    'Backup_created' => 'System backup created successfully',
                    'Permission_granted' => 'User permissions updated and granted',
                    'File_deleted' => 'File deleted from document storage'
                ];

                foreach ($users as $index => $user) {
                    // Create 5-8 random actions per user
                    $randomActions = array_rand($sampleActions, rand(5, 8));
                    if (!is_array($randomActions)) {
                        $randomActions = [$randomActions];
                    }

                    foreach ($randomActions as $actionKey) {
                        $action = array_keys($sampleActions)[$actionKey];
                        $description = $sampleActions[$action];

                        AccessLog::create([
                            'user_id' => $user->Dept_no,
                            'action' => $action,
                            'description' => $description,
                            'ip_address' => '127.0.0.1'
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error creating sample audit logs: ' . $e->getMessage());
        }
    }

    public function createUser()
    {
        $departments = \App\Models\DeptAccount::distinct()->pluck('dept_name')->filter()->sort()->values();
        $roles = \App\Models\DeptAccount::distinct()->pluck('role')->filter()->sort()->values();

        return view('access.create_user', compact('departments', 'roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'employee_id' => 'required|string|max:255|unique:department_accounts,employee_id',
            'email' => 'nullable|email|max:255',
            'dept_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $deptAccount = new \App\Models\DeptAccount();
            $deptAccount->employee_name = $request->employee_name;
            $deptAccount->employee_id = $request->employee_id;
            $deptAccount->email = $request->email;
            $deptAccount->dept_name = $request->dept_name;
            $deptAccount->role = $request->role;
            $deptAccount->status = $request->status;
            $deptAccount->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $deptAccount->save();

            // Create corresponding Laravel User for authentication
            $laravelUser = \App\Models\User::create([
                'name' => $request->employee_name,
                'email' => $request->employee_id . '@soliera.local',
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => $request->role,
                'employee_id' => $request->employee_id,
                'department' => $request->dept_name,
                'email_verified_at' => now(),
            ]);

            return redirect()->route('access.users')->with('success', 'User created successfully!');

        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage())->withInput();
        }
    }

    public function exportUsers(Request $request)
    {
        try {
            // Apply same filters as the users page
            $search = trim((string) $request->get('q'));
            $role = (string) $request->get('role');
            $department = (string) $request->get('department');
            $status = (string) $request->get('status');

            $query = \App\Models\DeptAccount::query();

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('employee_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('employee_id', 'like', "%{$search}%");
                });
            }
            if ($role !== '') {
                $query->where('role', $role);
            }
            if ($department !== '') {
                $query->where('dept_name', $department);
            }
            if ($status !== '') {
                $query->where('status', $status);
            }

            $accounts = $query->orderBy('employee_name')->get();

            $filename = 'users_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\UserExport($accounts), $filename);

        } catch (\Exception $e) {
            \Log::error('Error exporting users: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error exporting users: ' . $e->getMessage());
        }
    }


    /**
     * Search users for autocomplete (AJAX endpoint)
     * Returns JSON with users matching the search query
     */
    public function searchUsers(Request $request)
    {
        try {
            $query = trim((string) $request->get('q', ''));

            // If query is too short, return empty results
            if (strlen($query) < 2) {
                return response()->json([
                    'success' => true,
                    'users' => []
                ]);
            }

            // Search in DeptAccount model
            $users = \App\Models\DeptAccount::where(function ($q) use ($query) {
                $q->where('employee_name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('employee_id', 'like', "%{$query}%");
            })
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->orderBy('employee_name')
                ->limit(10)
                ->get()
                ->map(function ($account) {
                    return [
                        'email' => $account->email ?? '',
                        'name' => $account->employee_name ?? 'Unknown User'
                    ];
                })
                ->filter(function ($user) {
                    return !empty($user['email']);
                })
                ->values();

            return response()->json([
                'success' => true,
                'users' => $users
            ]);

        } catch (\Exception $e) {
            \Log::error('Error searching users: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'users' => [],
                'error' => 'An error occurred while searching users.'
            ], 500);
        }
    }

    public function exportAuditLogs()
    {
        try {
            // Get all audit logs with user information (including login/logout)
            $logs = AccessLog::with('user')
                ->latest()
                ->get();

            $filename = 'audit_logs_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AuditLogExport($logs), $filename);

        } catch (\Exception $e) {
            \Log::error('Error exporting audit logs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error exporting audit logs: ' . $e->getMessage());
        }
    }

    /**
     * Create audit log entry or retrieve audit logs via POST API
     * If 'action' field is provided, creates a new audit log
     * If 'action' field is NOT provided, retrieves audit logs with filters
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAuditLog(Request $request)
    {
        try {
            // Ensure we're accepting JSON
            $request->headers->set('Accept', 'application/json');

            // Check if this is a search/retrieve request (no action field) or create request
            if (!$request->has('action') || empty($request->input('action'))) {
                // This is a search/retrieve request - delegate to postAuditLogs
                return $this->postAuditLogs($request);
            }

            // This is a create request - validate the incoming request
            $validated = $request->validate([
                'user_id' => 'nullable|string|max:255',
                'action' => 'required|string|max:255',
                'description' => 'nullable|string',
                'ip_address' => 'nullable|string|max:45', // IPv4 or IPv6 max length
                'document_id' => 'nullable|integer',
                'metadata' => 'nullable|array',
            ], [
                'action.required' => 'The action field is required.',
                'action.string' => 'The action must be a string.',
                'action.max' => 'The action may not be greater than 255 characters.',
                'user_id.string' => 'The user_id must be a string.',
                'user_id.max' => 'The user_id may not be greater than 255 characters.',
                'ip_address.string' => 'The ip_address must be a string.',
                'ip_address.max' => 'The ip_address may not be greater than 45 characters.',
                'document_id.integer' => 'The document_id must be an integer.',
                'metadata.array' => 'The metadata must be an array.',
            ]);

            // Validate document_id exists only if provided
            if (!empty($validated['document_id'])) {
                $documentExists = \App\Models\Document::where('id', $validated['document_id'])->exists();
                if (!$documentExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => [
                            'document_id' => ['The selected document_id does not exist.']
                        ]
                    ], 422);
                }
            }

            // If user_id is not provided, try to resolve it from current session/auth
            if (empty($validated['user_id'])) {
                $empId = session('emp_id');
                if ($empId) {
                    $deptAccount = \App\Models\DeptAccount::where('employee_id', $empId)->first();
                    if ($deptAccount) {
                        $validated['user_id'] = (string) $deptAccount->Dept_no;
                    }
                } elseif (auth()->check()) {
                    $email = auth()->user()->email ?? '';
                    $empFromEmail = $email ? strstr($email, '@', true) : null;
                    if ($empFromEmail) {
                        $deptAccount = \App\Models\DeptAccount::where('employee_id', $empFromEmail)->first();
                        if ($deptAccount) {
                            $validated['user_id'] = (string) $deptAccount->Dept_no;
                        }
                    }
                }
            }

            // If still no user_id, set to '0' to prevent errors
            if (empty($validated['user_id'])) {
                $validated['user_id'] = '0';
            }

            // Get IP address from request if not provided
            if (empty($validated['ip_address'])) {
                $validated['ip_address'] = $request->ip() ?? '0.0.0.0';
            }
            // Ensure IPv4 for localhost
            if ($validated['ip_address'] === '::1') {
                $validated['ip_address'] = '127.0.0.1';
            }

            // Ensure details are populated if missing
            if (empty($validated['details'])) {
                $action = $validated['action'];
                $desc = $validated['description'] ?? '';
                
                if (stripos($action, 'login') !== false) {
                    $validated['details'] = 'User authenticated successfully via web portal.';
                } elseif (stripos($action, 'logout') !== false) {
                    $validated['details'] = 'User initiated session termination.';
                } elseif (stripos($action, 'create') !== false) {
                    $validated['details'] = 'New record creation initiated by user.';
                } elseif (stripos($action, 'update') !== false) {
                    $validated['details'] = 'Record modification performed by user.';
                } elseif (stripos($action, 'delete') !== false) {
                    $validated['details'] = 'Record deletion confirmed by user.';
                } else {
                    $validated['details'] = $desc ?: 'User performed ' . $action;
                }
            }

            // Ensure metadata is properly formatted
            if (isset($validated['metadata']) && !is_array($validated['metadata'])) {
                $validated['metadata'] = [];
            }

            // Create the audit log entry
            $auditLog = AccessLog::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Audit log created successfully',
                'data' => [
                    'id' => $auditLog->id,
                    'user_id' => $auditLog->user_id,
                    'action' => $auditLog->action,
                    'description' => $auditLog->description,
                    'ip_address' => $auditLog->ip_address,
                    'document_id' => $auditLog->document_id,
                    'metadata' => $auditLog->metadata ?? [],
                    'created_at' => $auditLog->created_at->toISOString(),
                    'updated_at' => $auditLog->updated_at->toISOString(),
                ]
            ], 201)->header('Content-Type', 'application/json');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error creating audit log: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error creating audit log',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while creating the audit log.'
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Get audit logs via GET API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuditLogs(Request $request)
    {
        try {
            // Ensure we're accepting JSON
            $request->headers->set('Accept', 'application/json');

            // Validate query parameters
            $validated = $request->validate([
                'user_id' => 'nullable|string',
                'action' => 'nullable|string|max:255',
                'document_id' => 'nullable|integer',
                'limit' => 'nullable|integer|min:1|max:100',
                'offset' => 'nullable|integer|min:0',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            // Build query
            $query = AccessLog::with('user')->latest();

            // Apply filters
            if (!empty($validated['user_id'])) {
                $query->where('user_id', $validated['user_id']);
            }

            if (!empty($validated['action'])) {
                $query->where('action', 'like', '%' . $validated['action'] . '%');
            }

            if (!empty($validated['document_id'])) {
                $query->where('document_id', $validated['document_id']);
            }

            if (!empty($validated['start_date'])) {
                $query->whereDate('created_at', '>=', $validated['start_date']);
            }

            if (!empty($validated['end_date'])) {
                $query->whereDate('created_at', '<=', $validated['end_date']);
            }

            // Get total count before pagination
            $total = $query->count();

            // Apply pagination
            $limit = $validated['limit'] ?? 50;
            $offset = $validated['offset'] ?? 0;
            $logs = $query->skip($offset)->take($limit)->get();

            return response()->json([
                'success' => true,
                'message' => 'Audit logs retrieved successfully',
                'data' => $logs->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'user_id' => $log->user_id,
                        'user_name' => $log->user->employee_name ?? null,
                        'action' => $log->action,
                        'description' => $log->description,
                        'ip_address' => $log->ip_address,
                        'document_id' => $log->document_id,
                        'metadata' => $log->metadata ?? [],
                        'created_at' => $log->created_at->toISOString(),
                        'updated_at' => $log->updated_at->toISOString(),
                    ];
                }),
                'pagination' => [
                    'total' => $total,
                    'limit' => $limit,
                    'offset' => $offset,
                    'has_more' => ($offset + $limit) < $total,
                ]
            ], 200)->header('Content-Type', 'application/json');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error retrieving audit logs: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving audit logs',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while retrieving audit logs.'
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Get audit logs via POST API (with filters in request body)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAuditLogs(Request $request)
    {
        try {
            // Ensure we're accepting JSON
            $request->headers->set('Accept', 'application/json');

            // Validate request body parameters
            $validated = $request->validate([
                'user_id' => 'nullable|string',
                'action' => 'nullable|string|max:255',
                'document_id' => 'nullable|integer',
                'limit' => 'nullable|integer|min:1|max:100',
                'offset' => 'nullable|integer|min:0',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'search' => 'nullable|string|max:255',
                'sort_by' => 'nullable|string|in:created_at,action,user_id',
                'sort_order' => 'nullable|string|in:asc,desc',
            ], [
                'limit.max' => 'The limit may not be greater than 100.',
                'limit.min' => 'The limit must be at least 1.',
                'offset.min' => 'The offset must be at least 0.',
                'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
                'sort_by.in' => 'The sort_by field must be one of: created_at, action, user_id.',
                'sort_order.in' => 'The sort_order field must be one of: asc, desc.',
            ]);

            // Build query
            $query = AccessLog::with('user');

            // Apply filters
            if (!empty($validated['user_id'])) {
                $query->where('user_id', $validated['user_id']);
            }

            if (!empty($validated['action'])) {
                $query->where('action', 'like', '%' . $validated['action'] . '%');
            }

            if (!empty($validated['document_id'])) {
                $query->where('document_id', $validated['document_id']);
            }

            if (!empty($validated['start_date'])) {
                $query->whereDate('created_at', '>=', $validated['start_date']);
            }

            if (!empty($validated['end_date'])) {
                $query->whereDate('created_at', '<=', $validated['end_date']);
            }

            // Search across multiple fields
            if (!empty($validated['search'])) {
                $searchTerm = $validated['search'];
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('action', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->orWhere('user_id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('ip_address', 'like', '%' . $searchTerm . '%');
                });
            }

            // Apply sorting
            $sortBy = $validated['sort_by'] ?? 'created_at';
            $sortOrder = $validated['sort_order'] ?? 'desc';
            $query->orderBy($sortBy, $sortOrder);

            // Get total count before pagination
            $total = $query->count();

            // Apply pagination
            $limit = $validated['limit'] ?? 50;
            $offset = $validated['offset'] ?? 0;
            $logs = $query->skip($offset)->take($limit)->get();

            return response()->json([
                'success' => true,
                'message' => 'Audit logs retrieved successfully',
                'data' => $logs->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'user_id' => $log->user_id,
                        'user_name' => $log->user->employee_name ?? null,
                        'user_email' => $log->user->email ?? null,
                        'action' => $log->action,
                        'description' => $log->description,
                        'ip_address' => $log->ip_address,
                        'document_id' => $log->document_id,
                        'metadata' => $log->metadata ?? [],
                        'created_at' => $log->created_at->toISOString(),
                        'updated_at' => $log->updated_at->toISOString(),
                    ];
                }),
                'pagination' => [
                    'total' => $total,
                    'limit' => $limit,
                    'offset' => $offset,
                    'has_more' => ($offset + $limit) < $total,
                    'current_page' => floor($offset / $limit) + 1,
                    'total_pages' => ceil($total / $limit),
                ],
                'filters_applied' => [
                    'user_id' => $validated['user_id'] ?? null,
                    'action' => $validated['action'] ?? null,
                    'document_id' => $validated['document_id'] ?? null,
                    'start_date' => $validated['start_date'] ?? null,
                    'end_date' => $validated['end_date'] ?? null,
                    'search' => $validated['search'] ?? null,
                ]
            ], 200)->header('Content-Type', 'application/json');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error retrieving audit logs via POST: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving audit logs',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while retrieving audit logs.'
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Generate API Bearer Token
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateToken(Request $request)
    {
        try {
            // Ensure we're accepting JSON
            $request->headers->set('Accept', 'application/json');

            // Validate request - accept either email or employee_id
            $validated = $request->validate([
                'email' => 'required|string', // Can be email or employee_id
                'password' => 'required|string',
                'token_name' => 'nullable|string|max:255',
            ], [
                'email.required' => 'The email or employee_id field is required.',
                'password.required' => 'The password field is required.',
            ]);

            $identifier = $validated['email'];
            $password = $validated['password'];

            // Try to find user in department_accounts table (primary auth table)
            $deptAccount = DeptAccount::where('employee_id', $identifier)
                ->orWhere('email', $identifier)
                ->first();

            if (!$deptAccount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials - User not found'
                ], 401)->header('Content-Type', 'application/json');
            }

            // Check if account is active (case-insensitive check)
            $status = strtolower(trim($deptAccount->status ?? ''));
            if ($status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Account is not active'
                ], 401)->header('Content-Type', 'application/json');
            }

            // Verify password (supports both hashed and plain text for backward compatibility)
            $validPassword = false;
            $storedPassword = $deptAccount->password ?? '';

            // First, try to verify as hashed password
            if (!empty($storedPassword)) {
                try {
                    // Check if password is hashed (bcrypt/argon2 hashes start with $2y$ or $argon2)
                    if (preg_match('/^\$2[ayb]\$|\$argon2/', $storedPassword)) {
                        $validPassword = Hash::check($password, $storedPassword);
                    } else {
                        // Plain text password - compare directly
                        $validPassword = ($password === $storedPassword);
                    }
                } catch (\Throwable $e) {
                    $validPassword = false;
                }
            }

            if (!$validPassword) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials - Wrong password'
                ], 401)->header('Content-Type', 'application/json');
            }

            // Rehash password if it's stored in plain text (security improvement)
            if (!preg_match('/^\$2[ayb]\$|\$argon2/', $storedPassword)) {
                $deptAccount->password = Hash::make($password);
                $deptAccount->save();
            }

            $tokenName = $validated['token_name'] ?? 'API Token - ' . now()->toDateTimeString();

            // Create token directly on DeptAccount (no User record needed)
            $token = $deptAccount->createToken($tokenName);

            return response()->json([
                'success' => true,
                'message' => 'Token generated successfully',
                'data' => [
                    'token' => $token->plainTextToken,
                    'token_name' => $tokenName,
                    'user' => [
                        'id' => $deptAccount->Dept_no ?? $deptAccount->id,
                        'name' => $deptAccount->employee_name,
                        'email' => $deptAccount->email,
                        'employee_id' => $deptAccount->employee_id,
                        'department' => $deptAccount->dept_name,
                        'role' => $deptAccount->role,
                    ],
                    'expires_at' => null, // Personal access tokens don't expire by default
                ]
            ], 200)->header('Content-Type', 'application/json');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error generating token: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->only('email', 'token_name')
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error generating token',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while generating the token.'
            ], 500)->header('Content-Type', 'application/json');
        }
    }
}
