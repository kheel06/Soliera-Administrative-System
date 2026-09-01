<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Schema;

class ExecutiveVaultController extends Controller
{
    public function export(Request $request)
    {
        $documents = Document::orderBy('created_at', 'desc')->get();
        $filename = "vault-report-" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Document Title', 'Type', 'Status', 'File Size', 'Uploaded Date'];

        $callback = function () use ($documents, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($documents as $doc) {
                $row = [
                    $doc->title ?? $doc->document_name ?? 'Untitled',
                    ucfirst($doc->category ?? $doc->document_type ?? $doc->type ?? 'General'),
                    $doc->status ?? 'Active',
                    $doc->file_size ?? ($doc->metadata['file_size'] ?? 'Unknown'),
                    $doc->created_at->format('Y-m-d')
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $documents = Document::orderBy('created_at', 'desc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('executive.vault.pdf_report', compact('documents'));
        return $pdf->download("vault-report-" . date('Y-m-d') . ".pdf");
    }

    public function policyApprovals(Request $request)
    {
        // Get documents awaiting approval or recently modified
        $documents = Document::orderBy('created_at', 'desc')
            ->paginate(15);

        // Stats
        $stats = [
            'total_documents' => Document::count(),
            'pending_review' => Document::where('status', 'pending')->count(),
            'recent_uploads' => Document::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('executive.vault.policy_approvals', compact('documents', 'stats'));
    }

    public function retentionOverview(Request $request)
    {
        // Get retention policies - handle gracefully if table structure is incomplete
        $policies = collect();
        try {
            if (Schema::hasTable('document_retention_policies') && Schema::hasColumn('document_retention_policies', 'name')) {
                $policies = \App\Models\DocumentRetentionPolicy::orderBy('name')->get();
            } else {
                $policies = collect();
            }
        } catch (\Exception $e) {
            $policies = collect();
        }

        // Get disposal history - handle gracefully if table doesn't exist
        $disposalHistory = collect();
        try {
            if (Schema::hasTable('disposal_history')) {
                $disposalHistory = \App\Models\DisposalHistory::orderBy('disposed_at', 'desc')
                    ->take(20)
                    ->get();
            }
        } catch (\Exception $e) {
            $disposalHistory = collect();
        }

        // Stats
        $stats = [
            'total_policies' => $policies->count(),
            'total_documents' => Document::count(),
            'disposed_30d' => 0,
            'disposed_total' => 0,
        ];

        // Try to get disposal counts if the table exists
        try {
            if (Schema::hasTable('disposal_history') && Schema::hasColumn('disposal_history', 'disposed_at')) {
                $stats['disposed_30d'] = \App\Models\DisposalHistory::where('disposed_at', '>=', now()->subDays(30))->count();
                $stats['disposed_total'] = \App\Models\DisposalHistory::count();
            }
        } catch (\Exception $e) {
            // Keep defaults
        }

        // Documents by category/type
        $documentsByType = collect();
        try {
            if (Schema::hasColumn('documents', 'document_type')) {
                $documentsByType = Document::selectRaw('document_type, COUNT(*) as count')
                    ->whereNotNull('document_type')
                    ->groupBy('document_type')
                    ->orderByDesc('count')
                    ->get();
            }
        } catch (\Exception $e) {
            $documentsByType = collect();
        }

        return view('executive.vault.retention_overview', compact('policies', 'disposalHistory', 'stats', 'documentsByType'));
    }
}
