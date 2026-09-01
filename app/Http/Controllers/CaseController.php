<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalCase;
use App\Models\CaseActivity;
use App\Models\Document;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LegalCase::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('case_title', 'like', "%{$search}%")
                    ->orWhere('case_number', 'like', "%{$search}%");
            });
        }

        // Tabs
        $tab = $request->input('tab', 'all');
        if ($tab === 'my_cases') {
            $query->where('assigned_to', auth()->id());
        } elseif ($tab === 'high_priority') {
            $query->whereIn('priority', ['high', 'urgent']);
        }

        // Filters
        if ($type = $request->input('type')) {
            $query->where('case_type', $type);
        }
        if ($priority = $request->input('priority')) {
            $query->where('priority', $priority);
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $cases = $query->latest()->paginate(10);

        $stats = [
            'active' => LegalCase::whereIn('status', ['pending', 'ongoing'])->count(),
            'high_risk' => LegalCase::whereIn('priority', ['high', 'urgent'])->whereIn('status', ['pending', 'ongoing'])->count(),
            'hearings' => LegalCase::whereBetween('court_date', [now(), now()->addDays(7)])->count(),
            'settled' => LegalCase::where('status', 'completed')->whereYear('updated_at', now()->year)->count(),
        ];

        return view('legal.cases.index', compact('cases', 'stats'));
    }

    public function export(Request $request)
    {
        $cases = LegalCase::latest()->get();
        $filename = "cases-report-" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Case Title', 'Case Number', 'Type', 'Status', 'Priority', 'Filing Date', 'Court Date', 'Description'];

        $callback = function () use ($cases, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($cases as $case) {
                $row = [
                    $case->case_title,
                    $case->case_number,
                    ucfirst($case->case_type),
                    ucfirst($case->status),
                    ucfirst($case->priority),
                    $case->filing_date ? \Carbon\Carbon::parse($case->filing_date)->format('Y-m-d') : '',
                    $case->court_date ? \Carbon\Carbon::parse($case->court_date)->format('Y-m-d') : '',
                    $case->case_description
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $cases = LegalCase::latest()->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('legal.cases.pdf_report', compact('cases'));
        return $pdf->download("cases-report-" . date('Y-m-d') . ".pdf");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('legal.cases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'case_title' => 'required|string|max:255',
            'case_description' => 'required|string',
            'case_type' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'filing_date' => 'required|date',
        ]);

        $validated['status'] = 'pending';
        $validated['created_by'] = auth()->id();

        $case = LegalCase::create($validated);

        // Send notification
        \App\Services\SystemNotificationService::notifyLegalCaseAction('created', $case);

        return redirect()->route('legal.cases.desk')->with('success', 'Case created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $case = LegalCase::with(['activities', 'documents', 'evidence', 'witnesses'])->findOrFail($id);
        return view('legal.cases.show', compact('case'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $case = LegalCase::findOrFail($id);
        return view('legal.cases.edit', compact('case'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $case = LegalCase::findOrFail($id);

        $validated = $request->validate([
            'case_title' => 'required|string|max:255',
            'case_description' => 'required|string',
            'case_type' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,ongoing,completed,rejected',
            'court_date' => 'nullable|date',
        ]);

        $case->update($validated);

        // Send notification
        \App\Services\SystemNotificationService::notifyLegalCaseAction('updated', $case);

        return redirect()->route('legal.cases.desk.show', $id)->with('success', 'Case updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $case = LegalCase::findOrFail($id);
        $caseTitle = $case->case_title;
        $case->delete();

        // Send notification
        \App\Services\SystemNotificationService::notifyLegalCaseAction('deleted', (object) ['case_title' => $caseTitle, 'id' => $id]);

        return redirect()->route('legal.cases.desk')->with('success', 'Case deleted successfully.');
    }

    /**
     * Add an activity update to the case.
     */
    public function addUpdate(Request $request, $id)
    {
        $case = LegalCase::findOrFail($id);

        $request->validate([
            'description' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        CaseActivity::log(
            $case->id,
            'manual_update',
            $request->description,
            ['notes' => $request->notes]
        );

        return redirect()->route('legal.cases.desk.show', $id)->with('success', 'Case updated successfully.');
    }

    /**
     * Upload a document to the case.
     */
    public function uploadDocument(Request $request, $id)
    {
        $case = LegalCase::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->store('case_documents', 'public');

        Document::create([
            'title' => $request->title,
            'file_path' => $path,
            'status' => 'released',
            'uploaded_by' => auth()->id(),
            'linked_case_id' => $case->id,
            'source' => 'legal_management',
            'category' => 'case_evidence',
        ]);

        CaseActivity::log(
            $case->id,
            'document_uploaded',
            "Uploaded document: {$request->title}",
            ['document_title' => $request->title]
        );

        return redirect()->route('legal.cases.desk.show', $id)->with('success', 'Document uploaded successfully.');
    }
}
