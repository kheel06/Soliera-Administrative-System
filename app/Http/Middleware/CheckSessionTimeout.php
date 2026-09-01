<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\SystemSetting;
use App\Http\Controllers\AccessController;

class CheckSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $isEnabled = SystemSetting::where('key', 'security.session_timeout_enabled')->value('value') === 'true';

            if ($isEnabled) {
                $lastActivity = Session::get('last_activity');
                $timeoutMinutes = (int) SystemSetting::where('key', 'security.session_timeout_minutes')->value('value') ?: 120;

                if ($lastActivity && (time() - $lastActivity > $timeoutMinutes * 60)) {
                    
                    // Log the timeout
                    $user = Auth::user();
                    $deptNo = null;
                    // Try to find Dept_no
                    if ($user instanceof \App\Models\DeptAccount) {
                        $deptNo = $user->Dept_no;
                    } elseif ($user instanceof \App\Models\User) {
                         // Try to map back if needed, or just use ID
                         $deptNo = $user->id;
                    }

                    AccessController::logAction(
                        $deptNo ?? '0',
                        'Session_timeout',
                        'User logged out due to inactivity',
                        $request->ip()
                    );

                    Auth::logout();
                    Session::forget('last_activity');
                    Session::invalidate();
                    Session::regenerateToken();

                    return redirect()->route('login')->with('error', 'Your session has expired due to inactivity.');
                }

                Session::put('last_activity', time());
            }
        }

        return $next($request);
    }
}
