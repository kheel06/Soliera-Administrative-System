<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalContract;
use App\Models\CompliancePermit;
use App\Models\LegalCase;
use App\Models\ContractRequest;
use App\Models\AccessLog;
use App\Models\Document;
use App\Models\Visitor;
use App\Models\VisitorViolation;
use Carbon\Carbon;

class ExecutiveController extends Controller
{
    public function overview(Request $request)
    {
        // 1. Fetch KPI Stats with real data
        $stats = [
            'active_contracts' => LegalContract::where('status', 'Active')->count(),
            'expiring_contracts' => LegalContract::where('status', 'Active')
                ->where('expiration_date', '<=', now()->addDays(30))
                ->where('expiration_date', '>=', now())
                ->count(),
            'permits_renewal' => CompliancePermit::where(function ($q) {
                $q->where('status', 'Renewal in Progress')
                    ->orWhere('status', 'Expiring Soon')
                    ->orWhere(function ($q2) {
                        $q2->where('expiration_date', '<=', now()->addDays(60))
                            ->where('expiration_date', '>=', now());
                    });
            })->count(),
            'high_risk_cases' => LegalCase::whereIn('priority', ['high', 'urgent'])
                ->whereIn('status', ['pending', 'ongoing'])
                ->count(),
            'open_obligations' => LegalContract::where('status', 'Active')
                ->whereNotNull('expiration_date')
                ->count(),
        ];

        // 2. Contract Status Distribution for Chart
        $contractStatusData = [
            'active' => LegalContract::where('status', 'Active')->count(),
            'pending' => LegalContract::whereIn('status', ['Pending Signature', 'Pending Review', 'Draft'])->count(),
            'expired' => LegalContract::where('status', 'Expired')->count(),
            'terminated' => LegalContract::where('status', 'Terminated')->count(),
        ];

        // 3. Contracts by Risk Level (based on contract value thresholds)
        $contractRiskData = [
            'low' => LegalContract::where('contract_value', '<', 10000)->count(),
            'medium' => LegalContract::whereBetween('contract_value', [10000, 50000])->count(),
            'high' => LegalContract::where('contract_value', '>', 50000)->count(),
        ];

        // 4. Compliance Status Trend (last 6 months)
        $complianceTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthLabel = $month->format('M');

            $complianceTrend[] = [
                'month' => $monthLabel,
                'active' => CompliancePermit::where('status', 'Active')
                    ->where('created_at', '<=', $month->endOfMonth())
                    ->count(),
                'renewal' => CompliancePermit::whereIn('status', ['Renewal in Progress', 'Expiring Soon'])
                    ->where('updated_at', '>=', $month->startOfMonth())
                    ->where('updated_at', '<=', $month->endOfMonth())
                    ->count(),
                'expired' => CompliancePermit::where('status', 'Expired')
                    ->where('updated_at', '>=', $month->startOfMonth())
                    ->where('updated_at', '<=', $month->endOfMonth())
                    ->count(),
            ];
        }

        // 5. High-Risk Approvals (pending items needing owner decision)
        $highRiskApprovals = ContractRequest::with(['requester'])
            ->whereIn('priority', ['high', 'urgent'])
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Also include contracts awaiting signature
        $contractsAwaitingApproval = LegalContract::where('status', 'Pending Signature')
            ->orderBy('contract_value', 'desc')
            ->take(5)
            ->get();

        // 6. Recent Sensitive Audit Logs
        $auditLogs = AccessLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        // 7. Upcoming Renewals (contracts and permits)
        $expiringContracts = LegalContract::where('status', 'Active')
            ->whereNotNull('expiration_date')
            ->where('expiration_date', '>=', now())
            ->where('expiration_date', '<=', now()->addDays(90))
            ->orderBy('expiration_date')
            ->take(5)
            ->get()
            ->map(function ($c) {
                return [
                    'type' => 'Contract',
                    'title' => $c->title,
                    'counterparty' => $c->counterparty_name,
                    'expiration_date' => $c->expiration_date,
                    'value' => $c->contract_value,
                    'days_remaining' => $c->expiration_date ? now()->diffInDays($c->expiration_date, false) : 999,
                    'url' => route('legal.contracts.details', $c->id),
                ];
            });

        $expiringPermits = CompliancePermit::whereIn('status', ['Active', 'Expiring Soon'])
            ->whereNotNull('expiration_date')
            ->where('expiration_date', '>=', now())
            ->where('expiration_date', '<=', now()->addDays(90))
            ->orderBy('expiration_date')
            ->take(5)
            ->get()
            ->map(function ($p) {
                return [
                    'type' => 'Permit',
                    'title' => $p->name,
                    'counterparty' => $p->issuing_authority ?? 'Regulatory Body',
                    'expiration_date' => $p->expiration_date,
                    'value' => null,
                    'days_remaining' => $p->expiration_date ? now()->diffInDays($p->expiration_date, false) : 999,
                    'url' => route('compliance.permits'),
                ];
            });

        $upcomingRenewals = $expiringContracts->concat($expiringPermits)
            ->sortBy('days_remaining')
            ->take(5)
            ->values();

        // 8. Cases Overview
        $casesOverview = [
            'open' => LegalCase::whereIn('status', ['pending', 'ongoing'])->count(),
            'in_progress' => LegalCase::where('status', 'ongoing')->count(),
            'urgent' => LegalCase::where('priority', 'urgent')
                ->whereIn('status', ['pending', 'ongoing'])
                ->count(),
        ];

        // 9. Department-wise Contract Value
        $departmentContracts = LegalContract::where('status', 'Active')
            ->selectRaw('department, SUM(contract_value) as total_value, COUNT(*) as count')
            ->groupBy('department')
            ->orderByDesc('total_value')
            ->get();

        return view('executive.overview', compact(
            'stats',
            'contractStatusData',
            'contractRiskData',
            'complianceTrend',
            'highRiskApprovals',
            'contractsAwaitingApproval',
            'auditLogs',
            'upcomingRenewals',
            'casesOverview',
            'departmentContracts'
        ));
    }

    public function risk()
    {
        // 1. KPI Stats
        $stats = [
            'compliance_score' => $this->calculateComplianceScore(),
            'open_corrective_actions' => $this->getCorrectiveActionsCount(),
            'visitor_incidents_30d' => VisitorViolation::where('created_at', '>=', now()->subDays(30))->count(),
            'documents_disposed_30d' => \App\Models\DisposalHistory::where('disposed_at', '>=', now()->subDays(30))->count(),
            'overdue_permits' => CompliancePermit::where('status', 'Expired')->count(),
            'pending_renewals' => CompliancePermit::whereIn('status', ['Renewal in Progress', 'Expiring Soon'])->count(),
        ];

        // 2. Compliance Matrix Data by Category
        $categories = ['Environmental', 'Business Operations', 'Safety & Fire', 'Health', 'Financial'];
        $matrix = [];

        foreach ($categories as $category) {
            $query = CompliancePermit::query();

            // Category matching based on permit name patterns
            switch ($category) {
                case 'Environmental':
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%Environment%')
                            ->orWhere('name', 'like', '%Pollution%')
                            ->orWhere('name', 'like', '%Waste%')
                            ->orWhere('name', 'like', '%Emission%');
                    });
                    break;
                case 'Business Operations':
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%Business%')
                            ->orWhere('name', 'like', '%License%')
                            ->orWhere('name', 'like', '%Registration%')
                            ->orWhere('name', 'like', '%Operating%');
                    });
                    break;
                case 'Safety & Fire':
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%Fire%')
                            ->orWhere('name', 'like', '%Safety%')
                            ->orWhere('name', 'like', '%Emergency%');
                    });
                    break;
                case 'Health':
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%Health%')
                            ->orWhere('name', 'like', '%Sanitary%')
                            ->orWhere('name', 'like', '%FDA%');
                    });
                    break;
                case 'Financial':
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%Tax%')
                            ->orWhere('name', 'like', '%BIR%')
                            ->orWhere('name', 'like', '%SEC%');
                    });
                    break;
            }

            $matrix[$category] = [
                'active' => (clone $query)->where('status', 'Active')->count(),
                'renewal' => (clone $query)->whereIn('status', ['Renewal in Progress', 'Expiring Soon'])->count(),
                'expired' => (clone $query)->where('status', 'Expired')->count(),
                'total' => (clone $query)->count(),
            ];
        }

        // 3. Risk Trend (last 6 months)
        $riskTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $riskTrend[] = [
                'month' => $month->format('M'),
                'violations' => VisitorViolation::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'expired_permits' => CompliancePermit::where('status', 'Expired')
                    ->whereYear('updated_at', $month->year)
                    ->whereMonth('updated_at', $month->month)
                    ->count(),
            ];
        }

        // 4. Recent Violations
        $recentViolations = VisitorViolation::with(['visitor'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 5. Expiring Permits (next 30 days)
        $expiringPermits = CompliancePermit::where('expiration_date', '>=', now())
            ->where('expiration_date', '<=', now()->addDays(30))
            ->orderBy('expiration_date')
            ->get();

        return view('executive.risk', compact('stats', 'matrix', 'riskTrend', 'recentViolations', 'expiringPermits'));
    }

    /**
     * Calculate overall compliance score based on permit status
     */
    private function calculateComplianceScore(): int
    {
        $total = CompliancePermit::count();
        if ($total == 0)
            return 100;

        $active = CompliancePermit::where('status', 'Active')->count();
        $expired = CompliancePermit::where('status', 'Expired')->count();

        // Score: active permits contribute positively, expired negatively
        $score = ($active / $total) * 100 - ($expired / $total) * 20;

        return max(0, min(100, round($score)));
    }

    /**
     * Get count of items needing corrective action
     */
    private function getCorrectiveActionsCount(): int
    {
        // Count expired permits and high-priority unresolved cases
        $expiredPermits = CompliancePermit::where('status', 'Expired')->count();
        $urgentCases = LegalCase::where('priority', 'urgent')
            ->whereNotIn('status', ['resolved', 'completed', 'closed'])
            ->count();

        return $expiredPermits + $urgentCases;
    }
}
