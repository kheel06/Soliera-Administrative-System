<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CompliancePermit;
use Illuminate\Http\Request;

class PermitController extends Controller
{
    public function dashboard()
    {
        // Calculate real compliance score
        $totalPermits = CompliancePermit::count();
        $activePermits = CompliancePermit::where('status', 'Active')->where('expiration_date', '>', now())->count();
        $complianceScore = $totalPermits > 0 ? round(($activePermits / $totalPermits) * 100) : 100;

        $stats = [
            'total_permits' => $totalPermits,
            'critical_permits' => CompliancePermit::where('status', 'Critical')
                ->orWhere('status', 'Expired')
                ->orWhere('expiration_date', '<', now())
                ->count(),
            'upcoming_renewals' => CompliancePermit::whereBetween('expiration_date', [now(), now()->addDays(30)])->count(), // Matched to UI "Next 30 Days"
            'compliance_score' => $complianceScore
        ];

        $recent_permits = CompliancePermit::latest()->take(5)->get();
        $expiring_soon = CompliancePermit::where('expiration_date', '>', now())
            ->where('expiration_date', '<=', now()->addDays(30))
            ->orderBy('expiration_date')
            ->take(5)
            ->get();

        return view('compliance.dashboard', compact('stats', 'recent_permits', 'expiring_soon'));
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $search = $request->get('search');

        $query = CompliancePermit::query();

        if ($filter === 'critical') {
            $query->where(function ($q) {
                $q->whereIn('status', ['Expired', 'Expiring Soon'])
                    ->orWhere('expiration_date', '<=', now()->addDays(14));
            });
        } elseif ($filter === 'archived') {
            $query->where('status', 'Archived');
        } else {
            // By default, exclude archived unless specifically requested via the status filter
            if ($request->status !== 'Archived') {
                $query->where('status', '!=', 'Archived');
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('issuing_authority', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%");
            });
        }

        // Advanced Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('authority')) {
            $query->where('issuing_authority', $request->authority);
        }

        $permits = $query->orderBy('expiration_date', 'asc')->paginate(10);

        // Calculate stats
        $total = CompliancePermit::where('status', '!=', 'Archived')->count();
        $expiring = CompliancePermit::where('status', '!=', 'Archived')
            ->where('expiration_date', '<=', now()->addDays(30))
            ->count();
        $renewing = CompliancePermit::where('status', 'Renewal in Progress')->count();

        // Compliant percentage: (Active/Total) * 100
        $active = CompliancePermit::whereIn('status', ['Active', 'Valid'])->count();
        $compliantPct = $total > 0 ? round(($active / $total) * 100) : 0;

        $stats = [
            'total' => $total,
            'expiring' => $expiring,
            'renewing' => $renewing,
            'compliant_pct' => $compliantPct,
        ];

        $authorities = CompliancePermit::distinct()->pluck('issuing_authority')->filter()->values();

        return view('compliance.permits.index', compact('permits', 'stats', 'authorities'));
    }

    public function create()
    {
        return view('compliance.permits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_authority' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'expiration_date' => 'required|date',
            'status' => 'required|string',
            'compliance_score' => 'nullable|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $permit = CompliancePermit::create($validated);

        // Handle File Upload
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('compliance/evidence', 'public');

            \App\Models\Document::create([
                'title' => 'Evidence: ' . $permit->name,
                'description' => 'Supporting document for ' . $permit->name,
                'file_path' => $path,
                'category' => 'compliance',
                'status' => 'active',
                'uploaded_by' => auth()->id(),
                'metadata' => ['permit_id' => $permit->id]
            ]);
        }

        \App\Services\SystemNotificationService::notifyComplianceAction('created', $permit);

        return redirect()->route('compliance.permits')->with('success', 'Permit and evidence added successfully.');
    }

    public function show($id)
    {
        $permit = CompliancePermit::findOrFail($id);
        return response()->json($permit);
    }

    public function update(Request $request, $id)
    {
        $permit = CompliancePermit::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_authority' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'expiration_date' => 'required|date',
            'status' => 'required|string',
            'compliance_score' => 'nullable|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $permit->update($validated);

        \App\Services\SystemNotificationService::notifyComplianceAction('updated', $permit);

        return redirect()->route('compliance.permits')->with('success', 'Permit updated successfully.');
    }

    public function destroy($id)
    {
        $permit = CompliancePermit::findOrFail($id);
        $permitName = $permit->name;
        $permit->delete();

        \App\Services\SystemNotificationService::notifyComplianceAction('deleted', (object)['name' => $permitName, 'id' => $id]);

        return redirect()->route('compliance.permits')->with('success', 'Permit deleted successfully.');
    }

    public function renewals()
    {
        $permits = CompliancePermit::whereNotNull('expiration_date')
            ->orderBy('expiration_date', 'asc')
            ->get();
        return view('compliance.renewals.index', compact('permits'));
    }
}
