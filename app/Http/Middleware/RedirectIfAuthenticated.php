<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $role = $user->role ?? ''; // Assuming 'role' is a property of the user model

                if (strpos(strtolower($role), 'owner') !== false) {
                    return redirect()->route('executive.overview');
                }

                if (strpos(strtolower($role), 'admin manager') !== false) {
                    return redirect()->route('access.users');
                }

                if (strpos(strtolower($role), 'legal officer') !== false) {
                    return redirect()->route('legal.contracts.workspace');
                }

                if (strpos(strtolower($role), 'compliance lead') !== false) {
                    return redirect()->route('compliance.permits');
                }

                if (strpos(strtolower($role), 'security supervisor') !== false) {
                    return redirect()->route('visitors.check_in_form');
                }

                if (strpos(strtolower($role), 'front office manager') !== false) {
                    return redirect()->route('visitors.pre_registrations');
                }

                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
