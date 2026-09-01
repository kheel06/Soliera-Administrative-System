<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\AccessLog;

class AuthController extends Controller
{
    /**
     * Handle user login with employee_id
     */
    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|string', // This is actually employee_id
            'password' => 'required|string',
        ]);

        // Key for rate limiting: "login-attempts:<ip>:<employee_id>"
        // Using both IP and Employee ID ensures distinct tracking per user/device
        $throttleKey = 'login-attempts:' . $request->ip() . ':' . $request->email;

        // Check if user is restricted
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Too many failed attempts. Please try again in {$seconds} seconds.")->withInput();
        }

        $employeeId = $request->email;
        $password = $request->password;

        // Check if user exists in department_accounts table
        $user = DB::table('department_accounts')
            ->where('employee_id', $employeeId)
            ->first();

        if (!$user) {
            // Increment allow attempts before returning error (decay 30 seconds)
            \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 30);

            return back()->withErrors([
                'email' => 'Employee ID not found.',
            ])->withInput();
        }

        // Verify password
        // Accept either hashed passwords or plain-text (as currently stored in department_accounts)
        $validPassword = false;
        try {
            $validPassword = Hash::check($password, $user->password);
        } catch (\Throwable $e) {
            $validPassword = false;
        }
        if (!$validPassword && $password !== ($user->password ?? '')) {
            // Increment allow attempts before returning error (decay 30 seconds)
            \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 30);

            // Calculate remaining attempts for user warning
            $attempts = \Illuminate\Support\Facades\RateLimiter::attempts($throttleKey);
            $remaining = 3 - $attempts;

            $msg = 'Invalid password.';
            if ($remaining > 0) {
                $msg .= " You have {$remaining} attempt(s) remaining.";
            } else {
                $msg .= " You are now restricted for 30 seconds.";
            }

            return back()->with('error', $msg)->withInput();
        }

        // Clear restrictions on success
        \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);

        // Generate OTP
        $otp = $this->generateOTP();
        $otpExpiry = Carbon::now()->addMinutes(2);

        // Store OTP in session for verification
        Session::put('login_otp', [
            'otp' => $otp,
            'expiry' => $otpExpiry,
            'employee_id' => $employeeId,
            'user_data' => $user
        ]);

        // For demo purposes, show OTP in alert
        // In production, you would send this via SMS/Email
        Session::flash('otp_info', "Your OTP is: {$otp} (Valid for 2 minutes)");

        return redirect()->route('login.otp')->with('success', 'Please check your device for OTP');
    }

    /**
     * Show OTP verification page
     */
    public function showOTP()
    {
        if (!Session::has('login_otp')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        return view('auth.loginotp');
    }

    /**
     * Verify OTP and complete login
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp1' => 'required|string|max:1',
            'otp2' => 'required|string|max:1',
            'otp3' => 'required|string|max:1',
            'otp4' => 'required|string|max:1',
            'otp5' => 'required|string|max:1',
            'otp6' => 'required|string|max:1',
        ]);

        // Combine OTP digits
        $enteredOTP = $request->otp1 . $request->otp2 . $request->otp3 .
            $request->otp4 . $request->otp5 . $request->otp6;

        // Get stored OTP data
        $otpData = Session::get('login_otp');

        if (!$otpData) {
            return redirect()->route('login')->with('error', 'OTP session expired. Please login again.');
        }

        // Check if OTP is expired
        if (Carbon::now()->isAfter($otpData['expiry'])) {
            Session::forget('login_otp');
            return redirect()->route('login')->with('error', 'OTP expired. Please login again.');
        }

        // Verify OTP
        if ($enteredOTP !== $otpData['otp']) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.'])->withInput();
        }

        // OTP is valid - create user session
        $user = $otpData['user_data'];

        // Get DeptAccount model instance
        $deptAccount = \App\Models\DeptAccount::where('employee_id', $user->employee_id)->first();

        if (!$deptAccount) {
            return redirect()->route('login')->with('error', 'User account not found. Please contact administrator.');
        }

        // Login using DeptAccount directly (no users table needed)
        Auth::login($deptAccount);
        $request->session()->regenerate();

        // Store session ID in cache to prevent concurrent sessions
        // This must be done AFTER session regeneration
        $sessionId = $request->session()->getId();
        $sessionLifetime = config('session.lifetime', 120);
        \Illuminate\Support\Facades\Cache::put('user_session_' . $deptAccount->Dept_no, $sessionId, now()->addMinutes($sessionLifetime));

        // Persist employee_id in session for consistent identity mapping
        Session::put('emp_id', $user->employee_id);

        // Store user role in session for RBAC
        Session::put('user_role', $user->role);

        // Clear OTP session
        Session::forget('login_otp');

        // Redirect based on user role
        $redirectRoute = $this->getRedirectRouteByRole($user->role);
        $userName = $user->employee_name ?? 'Admin';
        return redirect()->intended($redirectRoute)->with('login_success', 'Login successful! Welcome ' . $userName . '!');
    }

    /**
     * Generate 6-digit OTP
     */
    private function generateOTP()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }


    /**
     * Get redirect route based on user role
     */
    private function getRedirectRouteByRole($role)
    {
        // Role-based redirection to the first module in the sidebar
        $roleLower = strtolower($role);

        // Owner -> Governance Overview
        if (strpos($roleLower, 'owner') !== false) {
            return route('executive.overview');
        }

        // Admin Manager -> User Management
        if (strpos($roleLower, 'admin manager') !== false) {
            return route('access.users');
        }

        // Legal Officer -> Contracts Workspace
        if (strpos($roleLower, 'legal officer') !== false) {
            return route('legal.contracts.workspace');
        }

        // Compliance Lead -> Permits
        if (strpos($roleLower, 'compliance lead') !== false) {
            return route('compliance.permits');
        }

        // Security Supervisor -> Visitor Check-in
        if (strpos($roleLower, 'security supervisor') !== false) {
            return route('visitors.check_in_form');
        }

        // Front Office Manager -> Pre-Registrations
        if (strpos($roleLower, 'front office manager') !== false) {
            return route('visitors.pre_registrations');
        }

        // All other roles (Legal, Compliance, Security, Front Office) -> Dashboard
        return route('home');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        try {
            // Get current user info before logout
            $currentUser = Auth::user();
            $userName = 'Unknown User';
            $userRole = 'No role';
            $deptNo = null;

            if ($currentUser) {
                $userName = $currentUser->name ?? $currentUser->employee_name ?? 'Unknown User';
                $userRole = $currentUser->role ?? 'No role';

                // Try to find DeptAccount record
                $empId = Session::get('emp_id') ?? $currentUser->employee_id;
                if ($empId) {
                    $deptAccount = \App\Models\DeptAccount::where('employee_id', $empId)->first();
                    if ($deptAccount) {
                        $deptNo = $deptAccount->Dept_no;
                        $userName = $deptAccount->employee_name;
                        $userRole = $deptAccount->role;
                    }
                }

                // If still no DeptAccount, try to create one or use a fallback
                if (!$deptAccount) {
                    // Create a temporary DeptAccount entry for audit logging
                    $deptAccount = \App\Models\DeptAccount::create([
                        'Dept_id' => 'TEMP_' . time(),
                        'dept_name' => $currentUser->department ?? 'Administrative',
                        'employee_name' => $userName,
                        'employee_id' => $empId ?? 'temp_' . time(),
                        'role' => $userRole,
                        'email' => $currentUser->email,
                        'status' => 'active',
                        'password' => bcrypt('temp')
                    ]);
                    $deptNo = $deptAccount->Dept_no;
                }
            }

            // Log the logout action
            if ($deptNo) {
                AccessLog::create([
                    'user_id' => $deptNo,
                    'action' => 'Logout',
                    'description' => 'User logged out successfully',
                    'ip_address' => $request->ip(),
                ]);
            }
        } catch (\Throwable $e) {
            \Log::error('Error logging logout: ' . $e->getMessage());
            // Silent fail for logging; do not block logout
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show login page
     */
    public function showLogin()
    {
        // Generate math captcha for fallback
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $question = "$num1 + $num2";
        $answer = $num1 + $num2;

        Session::put('math_captcha_answer', $answer);

        return view('auth.login', ['math_captcha_question' => $question]);
    }
}
