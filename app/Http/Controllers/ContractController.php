<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LegalContract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $query = LegalContract::with('owner')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('contract_number', 'like', "%{$search}%")
                    ->orWhere('counterparty_name', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Only apply status filter if 'tab' logic doesn't already cover it, or if it refines it
        $statusFilter = $request->input('status');

        $tab = $request->input('tab', 'all');
        if ($tab === 'drafts') {
            $query->where('status', 'Draft')->where('user_id', auth()->id());
        } elseif ($tab === 'awaiting_approval') {
            $query->whereIn('status', ['Pending Review', 'Pending Signature']);
            if ($statusFilter) {
                $query->where('status', $statusFilter);
            }
        } else {
            if ($statusFilter) {
                $query->where('status', $statusFilter);
            }
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('effective_date', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('effective_date', '<=', $dateTo);
        }

        $contracts = $query->paginate(10);

        $stats = [
            'active' => LegalContract::where('status', 'Active')->count(),
            'pending' => LegalContract::whereIn('status', ['Pending Review', 'Pending Signature'])->count(),
            'expiring' => LegalContract::where('status', 'Active')
                ->where('expiration_date', '<=', now()->addDays(30))
                ->count(),
            'drafts' => LegalContract::where('status', 'Draft')->count(),
        ];

        return view('legal.contracts.index', compact('contracts', 'stats'));
    }

    public function show($id)
    {
        $contract = LegalContract::findOrFail($id);
        return view('legal.contracts.show', compact('contract'));
    }

    public function create(Request $request)
    {
        $template = null;
        if ($template_id = $request->query('template_id')) {
            $template = \App\Models\LegalTemplate::find($template_id);
        }
        return view('legal.contracts.create', compact('template'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'contract_number' => 'nullable|string|max:255|unique:legal_contracts',
            'counterparty_name' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|string',
            'effective_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'contract_value' => 'nullable|numeric',
            'department' => 'required|string',
            'description' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,docx|max:10240',
        ]);

        $contract = new LegalContract($validated);
        $contract->user_id = auth()->id();

        // Generate contract number if not provided
        if (empty($contract->contract_number)) {
            $contract->contract_number = 'CTR-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('contracts', 'public');
            $contract->file_path = $path;
        }

        $contract->save();

        \App\Services\SystemNotificationService::notifyContractAction('created', $contract);

        return redirect()->route('legal.contracts.workspace')->with('success', 'Contract created successfully.');
    }

    public function edit($id)
    {
        $contract = LegalContract::findOrFail($id);
        return view('legal.contracts.edit', compact('contract'));
    }

    public function update(Request $request, $id)
    {
        $contract = LegalContract::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'counterparty_name' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|string',
            'effective_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'contract_value' => 'nullable|numeric',
            'department' => 'required|string',
            'description' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,docx|max:10240',
        ]);

        $contract->fill($validated);

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('contracts', 'public');
            $contract->file_path = $path;
        }

        $contract->save();

        \App\Services\SystemNotificationService::notifyContractAction('updated', $contract);

        return redirect()->route('legal.contracts.details', $contract->id)->with('success', 'Contract updated successfully.');
    }

    public function destroy($id)
    {
        $contract = LegalContract::findOrFail($id);

        // Delete file if exists
        if ($contract->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($contract->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($contract->file_path);
        }

        $contract->delete();

        return redirect()->route('legal.contracts.workspace')->with('success', 'Contract deleted successfully.');
    }

    public function export(Request $request)
    {
        $contracts = LegalContract::with('owner')->latest()->get();

        $filename = "contracts-report-" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Title', 'Contract Number', 'Counterparty', 'Type', 'Status', 'Effective Date', 'Expiration Date', 'Value', 'Department', 'Owner', 'Description'];

        $callback = function () use ($contracts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($contracts as $contract) {
                $row = [
                    $contract->title,
                    $contract->contract_number,
                    $contract->counterparty_name,
                    $contract->type,
                    $contract->status,
                    $contract->effective_date ? $contract->effective_date->format('Y-m-d') : '',
                    $contract->expiration_date ? $contract->expiration_date->format('Y-m-d') : '',
                    $contract->contract_value,
                    $contract->department,
                    $contract->owner ? $contract->owner->name : 'N/A',
                    $contract->description
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $contracts = LegalContract::with('owner')->latest()->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('legal.contracts.pdf_report', compact('contracts'));
        return $pdf->download("contracts-report-" . date('Y-m-d') . ".pdf");
    }

    public function download($id)
    {
        $contract = LegalContract::findOrFail($id);

        // Check if this is an employment contract - serve the template PDF
        if (strtolower($contract->type) === 'employment') {
            $templatePath = storage_path('app/templates/contracts/employment_contract_template.pdf');

            if (file_exists($templatePath)) {
                return response()->file($templatePath, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="EMPLOYEE CONTRACT & HR POLICY AGREEMENT.pdf"'
                ]);
            }
        }

        // For other contract types, use the regular file_path
        if (!$contract->file_path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($contract->file_path)) {
            return back()->with('error', 'File not found.');
        }

        return response()->download(storage_path('app/public/' . $contract->file_path));
    }

    public function updateStatus(Request $request, $id)
    {
        $contract = LegalContract::findOrFail($id);
        $request->validate([
            'status' => 'required|in:Draft,Pending Review,Pending Signature,Active,Expired,Rejected'
        ]);

        $oldStatus = $contract->status;
        $contract->status = $request->status;
        $contract->save();

        if ($request->status === 'Pending Review' && $oldStatus === 'Draft') {
            \App\Services\SystemNotificationService::notifyContractAction('review_requested', $contract);
            return back()->with('success', 'Contract sent for executive review.');
        }

        return back()->with('success', 'Contract status updated.');
    }
}
