<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class SystemSyncToken
{
    /**
     * Allow system sync requests via either a Sanctum token or a shared sync token.
     */
    public function handle(Request $request, Closure $next)
    {
        // Already authenticated (session or sanctum guard)
        if ($request->user()) {
            return $next($request);
        }

        $configuredToken = (string) config('system_sync.token', '');
        $bearerToken = $request->bearerToken();
        $headerToken = (string) $request->header('X-System-Sync-Token', '');

        if ($configuredToken !== '') {
            if ($bearerToken !== '' && hash_equals($configuredToken, $bearerToken)) {
                return $next($request);
            }
            if ($headerToken !== '' && hash_equals($configuredToken, $headerToken)) {
                return $next($request);
            }
        }

        if ($bearerToken !== '') {
            try {
                $personalToken = PersonalAccessToken::findToken($bearerToken);
                if ($personalToken && $personalToken->tokenable) {
                    $request->setUserResolver(fn () => $personalToken->tokenable);
                    return $next($request);
                }
            } catch (\Throwable $e) {
                // Ignore token lookup errors and fall through to unauthorized response.
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Provide a valid system sync token or Sanctum bearer token.',
        ], 401);
    }
}
