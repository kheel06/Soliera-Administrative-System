<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitorViolation;
use App\Models\AccessLog;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ExecutiveVisitorController extends Controller
{
    public function sensitiveLog(Request $request)
    {
        // Filter parameters
        $period = $request->get('period', '30');
        $search = $request->get('search', '');

        // Get recent visitors
        $query = Visitor::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                if (Schema::hasColumn('visitor', 'name')) {
                    $q->where('name', 'like', "%{$search}%");
                } elseif (Schema::hasColumn('visitor', 'first_name')) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                }

                if (Schema::hasColumn('visitor', 'company')) {
                    $q->orWhere('company', 'like', "%{$search}%");
                }
            });
        }

        $visitors = $query
            ->where('created_at', '>=', now()->subDays((int) $period))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Stats
        $stats = [
            'total_visitors' => Visitor::where('created_at', '>=', now()->subDays((int) $period))->count(),
            'vip_visitors' => 0,
            'contractor_visitors' => 0,
            'violations' => 0,
        ];

        // Conditional Stats based on columns
        if (Schema::hasColumn('visitor', 'visitor_type')) {
            $stats['vip_visitors'] = Visitor::where('created_at', '>=', now()->subDays((int) $period))
                ->where('visitor_type', 'VIP')
                ->count();
            $stats['contractor_visitors'] = Visitor::where('created_at', '>=', now()->subDays((int) $period))
                ->where('visitor_type', 'Contractor')
                ->count();
        } elseif (Schema::hasColumn('visitor', 'pass_type')) {
            $stats['vip_visitors'] = Visitor::where('created_at', '>=', now()->subDays((int) $period))
                ->where('pass_type', 'like', '%VIP%')
                ->count();
            $stats['contractor_visitors'] = Visitor::where('created_at', '>=', now()->subDays((int) $period))
                ->where('pass_type', 'like', '%Contractor%')
                ->count();
        }

        if (Schema::hasTable('visitor_violations')) {
            $stats['violations'] = VisitorViolation::where('created_at', '>=', now()->subDays((int) $period))->count();
        }

        // Recent Access Logs related to visitors
        $accessLogs = collect();
        if (Schema::hasTable('access_logs')) {
            $accessLogs = AccessLog::with('user')
                ->where('action', 'like', '%Visitor%')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        }

        return view('executive.visitors.sensitive', compact('visitors', 'stats', 'accessLogs', 'period', 'search'));
    }

    public function escalations(Request $request)
    {
        // Get all violations
        $violations = collect();
        $stats = [
            'total' => 0,
            'high' => 0,
            'medium' => 0,
            'low' => 0,
            'last_30d' => 0,
        ];
        $severity = $request->get('severity', 'all');

        if (Schema::hasTable('visitor_violations')) {
            $query = VisitorViolation::with('visitor');

            if ($severity !== 'all' && Schema::hasColumn('visitor_violations', 'severity')) {
                $query->where('severity', $severity);
            }

            $violations = $query
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            // Stats
            $stats['total'] = VisitorViolation::count();
            if (Schema::hasColumn('visitor_violations', 'severity')) {
                $stats['high'] = VisitorViolation::where('severity', 'high')->count();
                $stats['medium'] = VisitorViolation::where('severity', 'medium')->count();
                $stats['low'] = VisitorViolation::where('severity', 'low')->count();
            }
            $stats['last_30d'] = VisitorViolation::where('created_at', '>=', now()->subDays(30))->count();
        }

        return view('executive.visitors.escalations', compact('violations', 'stats', 'severity'));
    }
}
