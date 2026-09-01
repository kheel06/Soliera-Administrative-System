<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacilityReservation;
use App\Models\Visitor;
use App\Models\LegalCase;
use App\Models\Contract;
use Carbon\Carbon;

class KpiController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // Facilities KPIs
        $totalReservations = FacilityReservation::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $approvedReservations = FacilityReservation::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                    ->where('status', 'approved')->count();
        $approvalRate = $totalReservations > 0 ? round(($approvedReservations / $totalReservations) * 100, 1) : 0;

        // Visitor KPIs
        $totalVisitors = Visitor::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $activeVisitors = Visitor::whereNotNull('time_in')->whereNull('time_out')->count();
        
        // Legal KPIs
        $activeContracts = Contract::where('status', 'active')->count();
        $pendingCases = LegalCase::where('status', 'open')->orWhere('status', 'pending')->count();

        $kpis = [
            'facilities' => [
                'total_reservations' => $totalReservations,
                'approval_rate' => $approvalRate,
            ],
            'visitors' => [
                'monthly_total' => $totalVisitors,
                'current_active' => $activeVisitors,
            ],
            'legal' => [
                'active_contracts' => $activeContracts,
                'pending_cases' => $pendingCases,
            ]
        ];

        return view('reports.kpis.index', compact('kpis'));
    }
}
