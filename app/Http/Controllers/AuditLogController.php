<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessLog; // Assuming AccessLog is the model for audit logs

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AccessLog::with('user')->latest();

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('action') && $request->action) {
            $query->where('action', 'like', "%{$request->action}%");
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20)->withQueryString();
        
        $users = \App\Models\DeptAccount::orderBy('employee_name')->get(); // For filter dropdown

        return view('reports.audit_logs.index', compact('logs', 'users'));
    }
}
