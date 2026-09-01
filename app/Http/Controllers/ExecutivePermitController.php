<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompliancePermit;
use Carbon\Carbon;

class ExecutivePermitController extends Controller
{
    public function export(Request $request)
    {
        $permits = CompliancePermit::orderBy('expiration_date')->get();
        $filename = "permits-report-" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Permit Name', 'Issuing Authority', 'Status', 'Expiration Date', 'Days Left'];

        $callback = function () use ($permits, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($permits as $permit) {
                $daysLeft = $permit->expiration_date ? now()->diffInDays($permit->expiration_date, false) : 'N/A';
                $row = [
                    $permit->name,
                    $permit->issuing_authority,
                    $permit->status,
                    $permit->expiration_date ? $permit->expiration_date->format('Y-m-d') : '',
                    $daysLeft
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $permits = CompliancePermit::orderBy('expiration_date')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('executive.compliance.permits.pdf_report', compact('permits'));
        return $pdf->download("permits-report-" . date('Y-m-d') . ".pdf");
    }

    public function board(Request $request)
    {
        // Filter parameters
        $status = $request->get('status', 'all');
        $search = $request->get('search', '');

        // Base query
        $query = CompliancePermit::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('issuing_authority', 'like', "%{$search}%");
            });
        }

        $permits = $query->orderBy('expiration_date')->paginate(15);

        // Stats
        $stats = [
            'total' => CompliancePermit::count(),
            'active' => CompliancePermit::where('status', 'Active')->count(),
            'expiring_soon' => CompliancePermit::whereIn('status', ['Expiring Soon', 'Renewal in Progress'])->count(),
            'expired' => CompliancePermit::where('status', 'Expired')->count(),
        ];

        // Categorized permits for board view
        $boardData = [
            'active' => CompliancePermit::where('status', 'Active')->get(),
            'expiring' => CompliancePermit::whereIn('status', ['Expiring Soon', 'Renewal in Progress'])->get(),
            'expired' => CompliancePermit::where('status', 'Expired')->get(),
        ];

        return view('executive.compliance.permits.board', compact('permits', 'stats', 'boardData', 'status', 'search'));
    }

    public function calendar()
    {
        // Get all permits with expiration dates for calendar
        $permits = CompliancePermit::whereNotNull('expiration_date')
            ->orderBy('expiration_date')
            ->get()
            ->map(function ($permit) {
                $daysLeft = $permit->expiration_date ? now()->diffInDays($permit->expiration_date, false) : null;
                return [
                    'id' => $permit->id,
                    'name' => $permit->name,
                    'authority' => $permit->issuing_authority,
                    'expiration_date' => $permit->expiration_date,
                    'status' => $permit->status,
                    'days_left' => $daysLeft,
                    'month' => $permit->expiration_date->format('Y-m'),
                ];
            });

        // Group by month
        $calendar = $permits->groupBy('month');

        // Stats
        $stats = [
            'next_30_days' => $permits->filter(fn($p) => $p['days_left'] >= 0 && $p['days_left'] <= 30)->count(),
            'next_60_days' => $permits->filter(fn($p) => $p['days_left'] >= 0 && $p['days_left'] <= 60)->count(),
            'next_90_days' => $permits->filter(fn($p) => $p['days_left'] >= 0 && $p['days_left'] <= 90)->count(),
            'overdue' => $permits->filter(fn($p) => $p['days_left'] < 0)->count(),
        ];

        return view('executive.compliance.renewals.calendar', compact('permits', 'calendar', 'stats'));
    }
}
