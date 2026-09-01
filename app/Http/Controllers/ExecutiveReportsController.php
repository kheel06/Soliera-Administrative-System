<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalContract;
use App\Models\LegalCase;
use App\Models\CompliancePermit;
use App\Models\ContractRequest;
use App\Models\Visitor;
use App\Models\VisitorViolation;
use App\Models\Document;
use App\Models\AccessLog;
use Carbon\Carbon;

class ExecutiveReportsController extends Controller
{
    public function kpis()
    {
        // 1. Legal KPIs
        $legalKpis = [
            'total_contracts' => LegalContract::count(),
            'active_contracts' => LegalContract::where('status', 'Active')->count(),
            'contracts_value' => LegalContract::where('status', 'Active')->sum('contract_value'),
            'expiring_30d' => LegalContract::where('status', 'Active')
                ->where('expiration_date', '>=', now())
                ->where('expiration_date', '<=', now()->addDays(30))
                ->count(),
            'open_cases' => LegalCase::whereNotIn('status', ['resolved', 'completed', 'closed'])->count(),
            'urgent_cases' => LegalCase::whereIn('priority', ['high', 'urgent'])
                ->whereNotIn('status', ['resolved', 'completed', 'closed'])
                ->count(),
        ];

        // 2. Compliance KPIs
        $complianceKpis = [
            'total_permits' => CompliancePermit::count(),
            'active_permits' => CompliancePermit::where('status', 'Active')->count(),
            'expired_permits' => CompliancePermit::where('status', 'Expired')->count(),
            'compliance_rate' => CompliancePermit::count() > 0
                ? round((CompliancePermit::where('status', 'Active')->count() / CompliancePermit::count()) * 100, 1)
                : 100,
            'pending_renewals' => CompliancePermit::whereIn('status', ['Expiring Soon', 'Renewal in Progress'])->count(),
        ];

        // 3. Visitor KPIs (last 30 days)
        $visitorKpis = [
            'total_visitors_30d' => Visitor::where('created_at', '>=', now()->subDays(30))->count(),
            'violations_30d' => VisitorViolation::where('created_at', '>=', now()->subDays(30))->count(),
            'avg_daily_visitors' => round(Visitor::where('created_at', '>=', now()->subDays(30))->count() / 30, 1),
        ];

        // 4. Document KPIs
        $documentKpis = [
            'total_documents' => Document::count(),
            'documents_30d' => Document::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        // 5. Monthly Trends (last 6 months)
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyTrends[] = [
                'month' => $month->format('M'),
                'contracts' => LegalContract::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'cases' => LegalCase::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'visitors' => Visitor::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        }

        // 6. Department Performance
        $departmentPerformance = LegalContract::where('status', 'Active')
            ->selectRaw('department, COUNT(*) as contracts, SUM(contract_value) as total_value')
            ->groupBy('department')
            ->orderByDesc('total_value')
            ->get();

        // 7. Audit Activity
        $auditStats = [
            'total_logs_30d' => AccessLog::where('created_at', '>=', now()->subDays(30))->count(),
            'unique_users_30d' => AccessLog::where('created_at', '>=', now()->subDays(30))
                ->distinct('user_id')
                ->count('user_id'),
        ];

        return view('executive.reports.kpis', compact(
            'legalKpis',
            'complianceKpis',
            'visitorKpis',
            'documentKpis',
            'monthlyTrends',
            'departmentPerformance',
            'auditStats'
        ));
    }
}
