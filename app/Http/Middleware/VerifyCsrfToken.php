<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Allow AJAX analysis endpoint without CSRF friction
        'document/analyze-upload',
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, \Closure $next)
    {
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {
            // Log CSRF token mismatch for debugging
            \Log::warning('CSRF token mismatch', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'has_token' => $request->has('_token'),
                'token_value' => $request->input('_token') ? substr($request->input('_token'), 0, 10) . '...' : 'missing',
                'session_token' => $request->session()->token() ? substr($request->session()->token(), 0, 10) . '...' : 'missing',
                'session_id' => $request->session()->getId(),
            ]);
            
            // Re-throw the exception so Laravel handles it normally
            throw $e;
        }
    }
} 