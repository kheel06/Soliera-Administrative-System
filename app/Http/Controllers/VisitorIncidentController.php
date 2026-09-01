<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisitorIncidentController extends Controller
{
    public function index()
    {
        $incidents = \App\Models\VisitorIncident::with(['reporter', 'visitor'])
            ->latest()
            ->paginate(10);

        $stats = [
            'open' => \App\Models\VisitorIncident::where('status', 'Open')->count(),
            'critical' => \App\Models\VisitorIncident::where('severity', 'Critical')->count(),
            'resolved_month' => \App\Models\VisitorIncident::where('status', 'Resolved')
                ->whereMonth('updated_at', now()->month)
                ->count()
        ];

        return view('visitors.incidents.index', compact('incidents', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'severity' => 'required|string',
            'location' => 'required|string',
            'incident_date' => 'required|date',
            'description' => 'required|string',
            'visitor_id' => 'nullable|exists:visitor,id'
        ]);

        $validated['status'] = 'Open';
        $validated['reported_by'] = auth()->id();

        $incident = \App\Models\VisitorIncident::create($validated);

        // Send notification
        \App\Services\SystemNotificationService::notifyVisitorIncidentAction('reported', $incident);

        return redirect()->back()->with('success', 'Incident reported successfully.');
    }
}
