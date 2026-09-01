<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /**
     * Extend the current session
     */
    public function extend(Request $request)
    {
        try {
            // Check if user is still authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Touch the session to extend its lifetime (don't regenerate - that can cause issues)
            session()->put('last_activity', now()->timestamp);
            
            return response()->json([
                'success' => true,
                'message' => 'Session extended',
                'expires_at' => now()->addMinutes(config('session.lifetime', 10))->toISOString()
            ]);
        } catch (\Exception $e) {
            \Log::error('Session extend error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to extend session'
            ], 500);
        }
    }
}
