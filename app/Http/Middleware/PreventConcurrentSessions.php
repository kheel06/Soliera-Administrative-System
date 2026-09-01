<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PreventConcurrentSessions
{
    /**
     * Handle an incoming request.
     *
     * This middleware prevents users from having multiple active sessions.
     * If a user logs in from another tab/device, their previous session
     * will be invalidated and they'll be redirected to login.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check for authenticated users
        if (Auth::check()) {
            try {
                $user = Auth::user();
                if (!$user) {
                    return $next($request);
                }
                
                $currentSessionId = $request->session()->getId();
                // Support both User and DeptAccount models
                // DeptAccount has getIdAttribute() that returns Dept_no, so $user->id should work
                // But also check Dept_no directly as fallback
                $userId = $user->id ?? ($user->Dept_no ?? null);
                if (!$userId) {
                    return $next($request);
                }
                $cacheKey = 'user_session_' . $userId;

            // Get the stored session ID for this user
            $storedSessionId = Cache::get($cacheKey);

            // If there's a stored session ID and it doesn't match current session
            if ($storedSessionId && $storedSessionId !== $currentSessionId) {
                // Another session is active - invalidate this session
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Redirect to login with a message
                return redirect()->route('login')
                    ->with('error', 'Your account is being used in another tab or browser. Please log in again.');
            }

            // If no session ID is stored yet, store the current one
            // This happens on first login or if cache expired
            $sessionLifetime = config('session.lifetime', 120); // Get from config, default 120 minutes
            
            if (!$storedSessionId) {
                // Store session ID with expiration matching session lifetime
                Cache::put($cacheKey, $currentSessionId, now()->addMinutes($sessionLifetime));
            } else {
                // Update the cache expiration time on each request
                // This keeps the session active as long as user is using it
                Cache::put($cacheKey, $currentSessionId, now()->addMinutes($sessionLifetime));
            }
            } catch (\Exception $e) {
                // If there's an error (e.g., table doesn't exist), log it but don't block the request
                \Log::warning('PreventConcurrentSessions middleware error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                // Continue with the request even if session checking fails
            }
        }

        return $next($request);
    }
}
