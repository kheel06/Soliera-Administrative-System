<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AccessLog;
use App\Models\FacilityReservation;
use App\Models\Visitor;
use App\Models\Contract;

class AuditPackController extends Controller
{
    public function index()
    {
        return view('reports.audit_packs.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'module' => 'required|in:all,facilities,visitors,legal,access',
            'month' => 'required|date_format:Y-m',
        ]);

        $month = $request->month;
        $start = \Carbon\Carbon::parse($month)->startOfMonth();
        $end = \Carbon\Carbon::parse($month)->endOfMonth();

        $data = [
            'month' => $month,
            'generated_at' => now(),
            'module' => $request->module,
        ];

        if ($request->module === 'all' || $request->module === 'facilities') {
            $data['facilities'] = FacilityReservation::whereBetween('created_at', [$start, $end])->get();
        }
        if ($request->module === 'all' || $request->module === 'visitors') {
            $data['visitors'] = Visitor::whereBetween('created_at', [$start, $end])->get();
        }
        if ($request->module === 'all' || $request->module === 'legal') {
            $data['contracts'] = Contract::whereBetween('created_at', [$start, $end])->get();
        }
        if ($request->module === 'all' || $request->module === 'access') {
            $data['logs'] = AccessLog::whereBetween('created_at', [$start, $end])->limit(500)->get();
        }

        // In a real app, we would load a PDF view here.
        // For now, we'll just simulate a download or return a view.
        // $pdf = Pdf::loadView('reports.audit_packs.pdf', $data);
        // return $pdf->download("audit-pack-{$month}.pdf");

        return back()->with('success', "Audit Pack for {$month} generated successfully (Simulated Download).");
    }
}
