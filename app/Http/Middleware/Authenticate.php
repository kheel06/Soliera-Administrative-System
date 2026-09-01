<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // For API routes, always return null to force JSON 401 response
        // Never redirect API routes, even if user is authenticated via session
        if ($request->is('api/*') || $request->expectsJson()) {
            return null;
        }
        
        // For web routes, redirect to login
        return route('login');
    }
}
