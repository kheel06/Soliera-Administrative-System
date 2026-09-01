<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get user role from session or fetch from database
        $userRole = $this->getUserRole();
        
        if (!$userRole) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'User role not found. Please contact administrator.');
        }

        // If no specific roles are required, allow access
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user has any of the required roles
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // User doesn't have required role - redirect with error
        return redirect()->route('home')->with('error', 'Access denied. You do not have permission to access this module.');
    }

    /**
     * Get user role from session or database
     */
    private function getUserRole()
    {
        // First try to get from session (check both keys for compatibility)
        if (Session::has('user_role')) {
            return Session::get('user_role');
        }
        
        if (Session::has('role')) {
            return Session::get('role');
        }

        // If not in session, fetch from database
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        // Get role from department_accounts table
        $deptAccount = DB::table('department_accounts')
            ->where('employee_id', $user->employee_id)
            ->first();

        // Try RBAC mapping first if available
        if ($deptAccount && isset($deptAccount->Dept_no)) {
            $rbac = DB::table('rbac_user_roles')
                ->join('rbac_roles', 'rbac_roles.id', '=', 'rbac_user_roles.role_id')
                ->where('rbac_user_roles.account_id', $deptAccount->Dept_no)
                ->select('rbac_roles.code', 'rbac_roles.name')
                ->first();
            if ($rbac) {
                $mapped = $this->mapRbacCodeToRoleName($rbac->code, $rbac->name);
                $normalized = app(\App\Services\RolePermissionService::class)->testRoleNormalization($mapped) ?: $mapped;
                Session::put('user_role', $normalized);
                Session::put('role', $normalized);
                return $normalized;
            }
        }

        if ($deptAccount && $deptAccount->role) {
            // Normalize via RolePermissionService
            $normalized = app(\App\Services\RolePermissionService::class)->testRoleNormalization($deptAccount->role) ?: $deptAccount->role;
            // Store in session for future use (use both keys for compatibility)
            Session::put('user_role', $normalized);
            Session::put('role', $normalized);
            return $normalized;
        }

        return null;
    }

    private function mapRbacCodeToRoleName(string $code, ?string $fallbackName = null): string
    {
        $map = [
            'OWNER' => 'Owner',
            'GM' => 'Owner', // Fallback
            'ADMIN_DOC' => 'Admin Manager',
            'ADMIN_MANAGER' => 'Admin Manager', // New code support
            'LEGAL' => 'Legal Officer',
            'COMPLIANCE' => 'Compliance Lead',
            'SECURITY' => 'Security Supervisor',
            'FRONT_OFFICE' => 'Front Office Manager',
            'ADMIN' => 'Admin Manager', // Fallback
            'SUPER_ADMIN' => 'Admin Manager', // Fallback
            'RECEPTIONIST' => 'Front Office Manager', // Fallback
        ];
        return $map[$code] ?? ($fallbackName ?: $code);
    }
}
