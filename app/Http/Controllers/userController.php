<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DeptAccount;
use App\Models\Guest;
use App\Models\OtpCode;
use App\Notifications\OtpCodeNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class userController extends Controller
{
    public function login(Request $request)
    {
        // Check if reCAPTCHA is enabled
        $recaptchaSiteKey = config('services.recaptcha.site_key', env('RECAPTCHA_SITE_KEY', ''));
        $hasRecaptcha = !empty($recaptchaSiteKey) && strlen(trim($recaptchaSiteKey)) > 0;

        // Check if user is trying to use math captcha fallback
        $useMathCaptcha = $request->filled('math_captcha');
        if ($useMathCaptcha) {
            $hasRecaptcha = false;
        }

        // Handle input mapping: Form sends 'email', controller expects 'employee_id'
        if ($request->has('email') && !$request->has('employee_id')) {
            $request->merge(['employee_id' => $request->input('email')]);
        }

        // Build validation rules
        $validationRules = [
            'employee_id' => 'required',
            'password' => 'required',
        ];

        // Only require reCAPTCHA if it's enabled and not using fallback
        if ($hasRecaptcha) {
            $validationRules['g-recaptcha-response'] = ['required'];
        }

        $form = $request->validate($validationRules);

        // Rate Limiting: Check if user is locked out
        // Use 3 attempts, 30 seconds decay
        $throttleKey = 'login|' . $request->ip() . '|' . Str::lower($form['employee_id']);

        if (RateLimiter::tooManyAttempts($throttleKey, 2)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Too many failed attempts. Please try again in {$seconds} seconds.")->withInput();
        }

        // Math Captcha Verification (Fallback)
        if ($useMathCaptcha) {
            if ($request->input('math_captcha') != Session::get('math_captcha_answer')) {
                return back()->withErrors(['math_captcha' => 'Incorrect math answer.'])->with('use_math_captcha', true)->withInput();
            }
        }
        // Verify Google reCAPTCHA (server-side) only if enabled
        elseif ($hasRecaptcha) {
            try {
                $secret = config('services.recaptcha.secret_key', env('RECAPTCHA_SECRET_KEY'));
                if (empty($secret)) {
                    \Log::warning('reCAPTCHA secret key not configured - falling back to math captcha');
                    return back()
                        ->withErrors(['captcha_error' => 'Captcha configuration missing. Please solve the math check below.'])
                        ->with('use_math_captcha', true)
                        ->withInput();
                }

                $resp = (new \GuzzleHttp\Client(['timeout' => 5]))->post('https://www.recaptcha.net/recaptcha/api/siteverify', [
                    'form_params' => [
                        'secret' => $secret,
                        'response' => $request->input('g-recaptcha-response'),
                        'remoteip' => $request->ip(),
                    ]
                ]);
                $body = json_decode((string) $resp->getBody(), true);
                if (!($body['success'] ?? false)) {
                    return back()
                        ->withErrors(['captcha_error' => 'Captcha verification failed. Please solve the math check below.'])
                        ->with('use_math_captcha', true)
                        ->withInput();
                }
            } catch (\Throwable $e) {
                \Log::error('reCAPTCHA verify error: ' . $e->getMessage());
                // Fallback to Math Captcha
                return back()->withErrors(['captcha_error' => 'Connection to captcha service failed. Please solve the math problem below.'])
                    ->with('use_math_captcha', true)
                    ->withInput();
            }
        }

        // Clear any existing session AFTER validation (to avoid CSRF issues)
        // Only logout if someone is already logged in
        if (Auth::check()) {
            Auth::logout();
        }

        // Find the department account by employee ID
        $deptAccount = DeptAccount::where('employee_id', $form['employee_id'])->first();

        // Validate password: accept either hashed or plain text (temporary)
        $validPassword = false;
        if ($deptAccount) {
            try {
                $validPassword = Hash::check($form['password'], $deptAccount->password);
            } catch (\Throwable $e) {
                $validPassword = false;
            }
            if (!$validPassword) {
                $validPassword = $deptAccount->password === $form['password'];
            }
        }

        if ($deptAccount && $validPassword) {
            // Clear rate limiter on successful login
            RateLimiter::clear($throttleKey);

            // Check if 2FA is enabled
            $is2faEnabled = \App\Models\SystemSetting::where('key', 'security.enable_2fa')->value('value') === 'true';

            if (!$is2faEnabled) {
                // Direct Login Logic (Skip OTP)
                \Illuminate\Support\Facades\Auth::login($deptAccount);
                $request->session()->regenerate();

                // Store session ID in cache
                $sessionId = $request->session()->getId();
                $sessionLifetime = config('session.lifetime', 120);
                $cacheKey = 'user_session_' . $deptAccount->Dept_no;
                Cache::put($cacheKey, $sessionId, now()->addMinutes($sessionLifetime));

                // Persist employee_id for UI display
                Session::put('emp_id', $deptAccount->employee_id);

                // Store user role in session
                Session::put('user_role', $deptAccount->role);

                // Log the successful login
                \App\Http\Controllers\AccessController::logAction(
                    $deptAccount->Dept_no,
                    'Login',
                    'User logged in successfully (2FA Disabled)',
                    $request->ip()
                );

                // Redirect based on user role
                $redirectRoute = $this->getRedirectRouteByRole($deptAccount->role);
                $userName = $deptAccount->employee_name ?? 'Admin';

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Login successful!',
                        'redirect' => $redirectRoute
                    ]);
                }

                return redirect($redirectRoute)
                    ->with('login_success', 'Login successful! Welcome ' . $userName . '!');
            }

            // Generate and send OTP
            $otp = OtpCode::createForEmployee(
                $deptAccount->employee_id,
                $deptAccount->email,
                $request->ip()
            );

            // Store employee data in session for OTP verification FIRST (before email sending)
            session(['otp_employee_id' => $deptAccount->employee_id]);
            session(['otp_user_data' => $deptAccount->toArray()]);
            session(['debug_otp_code' => $otp->otp_code]); // Store OTP for debugging

            // Ensure session is saved before redirect
            $request->session()->save();

            // Send OTP email (non-blocking - don't wait for it)
            $employeeName = !empty($deptAccount->employee_name) ? $deptAccount->employee_name : 'User';

            // Check email validity
            $emailValid = !empty($deptAccount->email) && filter_var($deptAccount->email, FILTER_VALIDATE_EMAIL);

            if ($emailValid) {
                // Try to send email using Mail facade directly
                try {
                    \Illuminate\Support\Facades\Mail::to($deptAccount->email)
                        ->send(new \App\Mail\OtpCodeMail($otp->otp_code, $employeeName));

                    if ($request->wantsJson()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'OTP sent to your email address.',
                            'redirect' => route('otp.verify')
                        ]);
                    }

                    return redirect()->route('otp.verify')->with('success', 'OTP sent to your email address. Please check your inbox.');
                } catch (\Exception $e) {
                    if ($request->wantsJson()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'OTP generated. Email sending failed.',
                            'redirect' => route('otp.verify')
                        ]);
                    }
                    return redirect()->route('otp.verify')->with('warning', 'OTP generated. Email sending failed. OTP code: ' . $otp->otp_code);
                }
            } else {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Email address not configured.',
                        'redirect' => route('otp.verify')
                    ]);
                }
                return redirect()->route('otp.verify')->with('warning', 'Email address not configured. OTP code: ' . $otp->otp_code);
            }
        }

        if ($deptAccount && $validPassword) {
            // ... (successful login logic handled below)
        }

        // Log failed login attempt
        if ($deptAccount) {
            \Log::info('Login failed for user: ' . $form['employee_id']);
            \App\Http\Controllers\AccessController::logAction(
                $deptAccount->Dept_no,
                'Login_failed',
                'Invalid password provided',
                $request->ip()
            );
        } else {
            \Log::info('Login failed: User not found for employee_id: ' . $form['employee_id']);
        }

        // Increment login attempts counter
        // 30 seconds decay
        RateLimiter::hit($throttleKey, 30);

        // Check if we just hit the limit (3rd attempt failed)
        if (RateLimiter::attempts($throttleKey) >= 3) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $msg = "Too many failed attempts. You are now restricted for 30 seconds.";

            \Log::info('Login restricted. Attempts: ' . RateLimiter::attempts($throttleKey) . '. Seconds wait: ' . $seconds);

            if ($request->wantsJson()) {
                return response()->json(['error' => $msg], 429);
            }

            return back()->with('error', $msg)->withInput();
        }

        $attempts = RateLimiter::attempts($throttleKey);
        $remaining = 3 - $attempts;

        $msg = "Invalid password. {$remaining} attempt(s) remaining.";

        \Log::info('Returning validation error: ' . $msg);

        if ($request->wantsJson()) {
            return response()->json(['errors' => ['password' => [$msg]]], 422);
        }

        // Return field specific error so the input turns red
        return back()->withErrors([
            'password' => $msg,
        ])->withInput();
    }

    public function logout(Request $request)
    {
        // Log the logout action before clearing the session
        if (Auth::check()) {
            $deptNo = null;
            $empId = Session::get('emp_id');
            if ($empId) {
                $deptNo = DeptAccount::where('employee_id', $empId)->value('Dept_no');
            }
            \App\Http\Controllers\AccessController::logAction(
                $deptNo ?? (string) Auth::id(),
                'Logout',
                'User logged out successfully',
                $request->ip()
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }



    // for guest
    public function create(Request $request)
    {
        $form = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|unique:core1_guest,guest_email',
            'guest_address' => 'required|string|max:255',
            'guest_mobile' => 'required|string|max:20',
            'guest_password' => 'required|string|confirmed',
            'guest_birthday' => 'required|date',
        ]);

        // Hash password before saving
        $form['guest_password'] = Hash::make($form['guest_password']);

        $guestAccount = Guest::create($form);

        // Auto login the new guest
        Auth::guard('guest')->login($guestAccount);

        // Store session data
        session(['guestSession' => $guestAccount]);

        return redirect('/photoupload');
    }

    public function profilesetup(Request $request, Guest $guestID)
    {
        $form = $request->validate([
            'guest_photo' => 'required',
        ]);

        $filename = time() . '_' . $request->file('guest_photo')->getClientOriginalName();
        $filepath = 'images/profiles/' . $filename;
        $request->file('guest_photo')->move(public_path('images/profiles/'), $filename);
        $form['guest_photo'] = $filepath;

        $guestID->update($form);

        return redirect('/guestdashboard');
    }

    public function guestlogout()
    {
        Auth::guard('guest')->logout();

        return redirect('/loginguest');
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm()
    {
        if (!session('otp_employee_id')) {
            \Log::info('No OTP session found, redirecting to login');
            return redirect()->route('login')->with('error', 'No active OTP session. Please login first.');
        }

        \Log::info('Showing OTP form for employee: ' . session('otp_employee_id'));

        return view('auth.verify-otp');
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        \Log::info('=== OTP VERIFICATION START ===');
        \Log::info('OTP Verification attempt for employee: ' . session('otp_employee_id'));
        \Log::info('Request data: ' . json_encode($request->all()));
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request URL: ' . $request->fullUrl());

        // Check if otp_code is present in request
        if (!$request->has('otp_code')) {
            \Log::error('OTP code not found in request data');
            return back()->withErrors([
                'otp_code' => 'OTP code is required.',
            ])->onlyInput('otp_code');
        }

        $request->validate([
            'otp_code' => 'required|string|size:6|regex:/^[0-9]{6}$/',
        ]);

        \Log::info('Validation passed. OTP Code: ' . $request->otp_code);

        $employeeId = session('otp_employee_id');
        $otpCode = $request->otp_code;

        // Check if session data exists
        if (!$employeeId) {
            \Log::error('No OTP session found during verification');
            return redirect()->route('login')->withErrors([
                'otp_code' => 'Session expired. Please login again.'
            ]);
        }

        // Check if user data exists in session
        $userData = session('otp_user_data');
        if (!$userData) {
            \Log::error('No user data found in OTP session');
            return redirect()->route('login')->withErrors([
                'otp_code' => 'Session expired. Please login again.'
            ]);
        }

        \Log::info('Verifying OTP: ' . $otpCode . ' for employee: ' . $employeeId);

        // Check if OTP exists in database
        $existingOtp = OtpCode::where('employee_id', $employeeId)
            ->where('otp_code', $otpCode)
            ->where('is_used', false)
            ->first();

        \Log::info('Existing OTP found: ' . ($existingOtp ? 'Yes' : 'No'));
        if ($existingOtp) {
            \Log::info('OTP details: expires_at=' . $existingOtp->expires_at . ', is_used=' . ($existingOtp->is_used ? 'true' : 'false'));
        }

        // Verify OTP
        $verificationResult = OtpCode::verify($employeeId, $otpCode);
        \Log::info('OTP verification result: ' . ($verificationResult ? 'SUCCESS' : 'FAILED'));

        if ($verificationResult) {
            \Log::info('OTP verification successful for employee: ' . $employeeId);
            // Get user data from session
            $userData = session('otp_user_data');

            // Use employee_id to find the account (more reliable than Dept_no from session)
            $deptAccount = DeptAccount::where('employee_id', $employeeId)->first();

            // Fallback: if employee_id lookup fails, try using Dept_no from session
            if (!$deptAccount && isset($userData['Dept_no'])) {
                $deptAccount = DeptAccount::find($userData['Dept_no']);
            }

            if ($deptAccount) {
                // Login using DeptAccount as it is the configured auth provider
                \Illuminate\Support\Facades\Auth::login($deptAccount);
                $request->session()->regenerate();

                // Store session ID in cache to prevent concurrent sessions
                // This must be done AFTER session regeneration
                // Use id (which maps to Dept_no via accessor) for consistency with middleware
                $sessionId = $request->session()->getId();
                $sessionLifetime = config('session.lifetime', 120);
                $cacheKey = 'user_session_' . $deptAccount->Dept_no;
                Cache::put($cacheKey, $sessionId, now()->addMinutes($sessionLifetime));
                \Log::info('Session stored in cache with key: ' . $cacheKey . ' and session ID: ' . $sessionId);

                // Persist employee_id for UI display (navbar pulls from this)
                Session::put('emp_id', $deptAccount->employee_id);

                // Store user role in session for RBAC system
                Session::put('user_role', $deptAccount->role);

                // Clear login attempts on successful login
                $throttleKey = 'login|' . $request->ip() . '|' . $employeeId;
                RateLimiter::clear($throttleKey);

                // Log the successful login
                \App\Http\Controllers\AccessController::logAction(
                    $deptAccount->Dept_no,
                    'Login',
                    'User logged in successfully with OTP',
                    $request->ip()
                );

                // Clear OTP session data
                session()->forget(['otp_employee_id', 'otp_user_data']);

                // Ensure session is saved before redirect
                $request->session()->save();

                // Verify authentication one more time before redirect
                if (!Auth::check()) {
                    \Log::error('Authentication lost before redirect!');
                    return back()->withErrors([
                        'otp_code' => 'Authentication failed. Please try again.',
                    ])->onlyInput('otp_code');
                }

                // Redirect based on user role
                $redirectRoute = $this->getRedirectRouteByRole($deptAccount->role);
                \Log::info('Redirecting to: ' . $redirectRoute . ' for role: ' . $deptAccount->role);
                \Log::info('User authenticated: ' . (Auth::check() ? 'YES' : 'NO'));
                \Log::info('User ID: ' . (Auth::id() ?? 'NULL'));
                \Log::info('Session user_role: ' . Session::get('user_role', 'NOT_SET'));
                \Log::info('Redirect URL: ' . $redirectRoute);

                $userName = $deptAccount->employee_name ?? 'Admin';

                // Force a fresh redirect - don't use intended() as it might cause issues
                // Use a 302 redirect to ensure it's not cached
                return redirect($redirectRoute, 302)
                    ->with('login_success', 'Login successful! Welcome ' . $userName . '!')
                    ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
            } else {
                \Log::error('DeptAccount not found for user data: ' . json_encode($userData));
                return back()->withErrors([
                    'otp_code' => 'User account not found. Please login again.',
                ])->onlyInput('otp_code');
            }
        } else {
            \Log::error('OTP verification failed for employee: ' . $employeeId . ' with code: ' . $otpCode);
            return back()->withErrors([
                'otp_code' => 'Invalid or expired OTP code.',
            ])->onlyInput('otp_code');
        }
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        \Log::info('Resend OTP requested for employee: ' . session('otp_employee_id'));

        $employeeId = session('otp_employee_id');

        if (!$employeeId) {
            \Log::error('No OTP session found during resend');
            return response()->json([
                'success' => false,
                'message' => 'No active OTP session found.'
            ], 400);
        }

        $deptAccount = DeptAccount::where('employee_id', $employeeId)->first();

        if (!$deptAccount) {
            \Log::error('DeptAccount not found for employee: ' . $employeeId);
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Generate new OTP
        $otp = OtpCode::createForEmployee(
            $deptAccount->employee_id,
            $deptAccount->email,
            $request->ip()
        );

        \Log::info('New OTP generated: ' . $otp->otp_code . ' for employee: ' . $employeeId);

        // Send OTP email
        try {
            // Ensure employee_name is not empty
            $employeeName = !empty($deptAccount->employee_name) ? $deptAccount->employee_name : 'User';

            // Ensure email is valid before sending
            if (empty($deptAccount->email) || !filter_var($deptAccount->email, FILTER_VALIDATE_EMAIL)) {
                \Log::warning('Invalid or empty email address for employee: ' . $deptAccount->employee_id);
                // Still return success but with warning - OTP is generated and can be checked in logs
                return response()->json([
                    'success' => true,
                    'message' => 'OTP generated. Email not configured. OTP code: ' . $otp->otp_code . ' (check logs)'
                ]);
            }

            // Send email using Mail facade directly to avoid notification issues
            try {
                \Illuminate\Support\Facades\Mail::to($deptAccount->email)
                    ->send(new \App\Mail\OtpCodeMail($otp->otp_code, $employeeName));

                \Log::info('OTP resend email sent successfully to: ' . $deptAccount->email . ' for employee: ' . $employeeName);

                return response()->json([
                    'success' => true,
                    'message' => 'New OTP sent to your email successfully.'
                ]);
            } catch (\Exception $mailException) {
                \Log::error('Mail sending failed: ' . $mailException->getMessage());
                \Log::error('Mail error trace: ' . $mailException->getTraceAsString());

                // Still return success with OTP code since email failed but OTP is valid
                return response()->json([
                    'success' => true,
                    'message' => 'OTP generated. Email sending failed. OTP code: ' . $otp->otp_code . ' (check logs)'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to resend OTP email to ' . ($deptAccount->email ?? 'unknown') . ': ' . $e->getMessage());
            \Log::error('Resend email error details: ' . $e->getTraceAsString());

            // Return success anyway with OTP code - don't fail the request
            return response()->json([
                'success' => true,
                'message' => 'OTP generated successfully. OTP code: ' . $otp->otp_code . ' (email failed, check logs)'
            ]);
        }
    }

    public function guestlogin(Request $request)
    {
        $form = $request->validate([
            'guest_email' => 'required',
            'guest_password' => 'required',
        ]);

        if (Auth::guard('guest')->attempt(['guest_email' => $form['guest_email'], 'password' => $form['guest_password']])) {
            $request->session()->regenerate();

            return redirect('/guestdashboard');
        }
    }

    /**
     * Get redirect route based on user role
     */
    private function getRedirectRouteByRole($role)
    {
        // Role-based redirection to the first module in the sidebar
        $roleLower = strtolower($role);

        // Owner -> Governance Overview (First sidebar item)
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

        // Legal Officer -> Legal Dashboard
        // Compliance Lead -> Compliance Dashboard
        // Security Supervisor -> Security Dashboard
        // Front Office Manager -> Front Desk Dashboard
        // All others default to generic dashboard
        return route('home');
    }

}
