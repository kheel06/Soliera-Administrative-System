<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RequireDatabaseConnection
{
    /**
     * Ensure the default database connection is available for each request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!config('database.require_connection')) {
            return $next($request);
        }

        try {
            DB::connection()->getPdo();
        } catch (Throwable $exception) {
            if (config('app.debug')) {
                throw $exception;
            }

            abort(503, 'Database connection failed.');
        }

        return $next($request);
    }
}
