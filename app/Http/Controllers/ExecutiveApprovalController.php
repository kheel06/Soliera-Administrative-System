<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContractRequest;
use App\Models\LegalContract;
use App\Models\CompliancePermit;

class ExecutiveApprovalController extends Controller
{
    public function index(Request $request)
    {
        // Filter parameters
        $status = $request->get('status', 'all');
        $priority = $request->get('priority', 'all');
        $type = $request->get('type', 'all');

        // Contract Requests needing approval
        $contractRequestsQuery = ContractRequest::with(['requester'])
            ->when($status !== 'all', function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($priority !== 'all', function ($q) use ($priority) {
                $q->where('priority', $priority);
            });

        $contractRequests = $contractRequestsQuery
            ->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')")
            ->orderBy('created_at', 'desc')
            ->get();

        // Contracts awaiting signature/approval
        $pendingContracts = LegalContract::whereIn('status', ['Pending Signature', 'Pending Review'])
            ->orderBy('contract_value', 'desc')
            ->get();

        // Permits needing renewal approval
        $permitRenewals = CompliancePermit::whereIn('status', ['Renewal in Progress', 'Expiring Soon'])
            ->orderBy('expiration_date')
            ->get();

        // Stats
        $stats = [
            'total_pending' => $contractRequests->where('status', 'Pending')->count() + $pendingContracts->count(),
            'high_priority' => $contractRequests->whereIn('priority', ['high', 'urgent'])->count(),
            'contracts_pending' => $pendingContracts->count(),
            'permits_renewal' => $permitRenewals->count(),
        ];

        return view('executive.approvals.index', compact(
            'contractRequests',
            'pendingContracts',
            'permitRenewals',
            'stats',
            'status',
            'priority',
            'type'
        ));
    }

    public function approve(Request $request, $type, $id)
    {
        switch ($type) {
            case 'contract-request':
                $item = ContractRequest::findOrFail($id);
                $item->update(['status' => 'Approved']);
                $message = 'Contract request approved successfully.';
                break;
            case 'contract':
                $item = LegalContract::findOrFail($id);
                $item->update(['status' => 'Active']);
                $message = 'Contract approved and activated.';
                break;
            default:
                return back()->with('error', 'Invalid approval type.');
        }

        \App\Services\SystemNotificationService::notifyApprovalAction('approved', (object) ['title' => $message, 'id' => $id]);

        return back()->with('success', $message);
    }

    public function reject(Request $request, $type, $id)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        switch ($type) {
            case 'contract-request':
                $item = ContractRequest::findOrFail($id);
                $item->update([
                    'status' => 'Rejected',
                    'notes' => $request->reason
                ]);
                $message = 'Contract request rejected.';
                break;
            case 'contract':
                $item = LegalContract::findOrFail($id);
                $item->update([
                    'status' => 'Rejected',
                    'description' => $item->description . "\n\nRejection Reason: " . $request->reason
                ]);
                $message = 'Contract rejected.';
                break;
            default:
                return back()->with('error', 'Invalid rejection type.');
        }

        \App\Services\SystemNotificationService::notifyApprovalAction('rejected', (object) ['title' => $message, 'id' => $id]);

        return back()->with('success', $message);
    }
}
