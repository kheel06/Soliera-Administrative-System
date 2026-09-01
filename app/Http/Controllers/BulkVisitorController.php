<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BulkVisitSession;
use App\Models\Visitor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BulkVisitorController extends Controller
{

    /**
     * Store a new bulk visit session
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'host_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'visit_date' => 'required|date',
            'expected_headcount' => 'required|integer|min:1',
            'visitors' => 'nullable|array',
        ]);

        // Filter out empty rows from visitors array if provided
        $visitorData = [];
        if ($request->has('visitors')) {
            foreach ($request->input('visitors') as $v) {
                if (!empty($v['name'])) {
                    $visitorData[] = [
                        'name' => $v['name'],
                        'email' => $v['email'] ?? null,
                        'phone' => $v['phone'] ?? null,
                        'company' => $v['company'] ?? null,
                        'host' => $v['host'] ?? null,
                    ];
                }
            }
        }

        $session = BulkVisitSession::create([
            'group_name' => $validated['group_name'],
            'host_name' => $validated['host_name'],
            'department' => $validated['department'],
            'purpose' => $validated['purpose'],
            'visit_date' => $validated['visit_date'],
            'expected_headcount' => $validated['expected_headcount'],
            'visitor_data' => $visitorData,
            'qr_code_token' => Str::random(32),
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bulk session created successfully',
            'data' => $session
        ]);
    }

    /**
     * Get session details by QR token
     */
    public function showByToken($token)
    {
        $session = BulkVisitSession::where('qr_code_token', $token)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $session
        ]);
    }

    /**
     * Process Scan: Validate token and return session data for review
     */
    public function processScan(Request $request)
    {
        $validated = $request->validate([
            'qr_code_token' => 'required|exists:bulk_visit_sessions,qr_code_token',
        ]);

        $session = BulkVisitSession::where('qr_code_token', $validated['qr_code_token'])->first();

        if ($session->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'This bulk session has already been completed.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Session found',
            'data' => [
                'session' => $session,
                'visitors_count' => count($session->visitor_data ?? []) ?: $session->expected_headcount
            ]
        ]);
    }

    /**
     * Approve all: Create actual visitor records from session data and mark as completed
     */
    public function approveAll(Request $request, $sessionId)
    {
        $session = BulkVisitSession::findOrFail($sessionId);

        if ($session->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Session already completed'
            ]);
        }

        $visitorRows = $session->visitor_data;

        // If no specifically entered rows, use headcount as fallback (should not happen with new UI but for safety)
        if (empty($visitorRows)) {
            $visitorRows = [];
            for ($i = 1; $i <= $session->expected_headcount; $i++) {
                $visitorRows[] = ['name' => 'Guest ' . $i];
            }
        }

        DB::beginTransaction();
        try {
            foreach ($visitorRows as $v) {
                Visitor::create([
                    'name' => $v['name'],
                    'email' => $v['email'] ?? null,
                    'contact' => $v['phone'] ?? null,
                    'company' => $v['company'] ?? null,
                    'purpose' => $session->purpose,
                    'department' => $session->department,
                    'host_employee' => $v['host'] ?? $session->host_name,
                    'status' => 'active',
                    'approval_status' => 'APPROVED',
                    'bulk_session_id' => $session->id,
                    'arrival_date' => now()->toDateString(),
                    'arrival_time' => now()->toTimeString(),
                    'time_in' => now(),
                    'pass_type' => 'Visitor',
                    'access_level' => 'Standard',
                    'pass_id' => 'PASS-' . strtoupper(Str::random(8)),
                    'pass_valid_from' => now(),
                    'pass_valid_until' => now()->endOfDay(),
                ]);
            }

            $session->update(['status' => 'completed']);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'All visitors created and approved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error approving visitors: ' . $e->getMessage()
            ], 500);
        }
    }
}
