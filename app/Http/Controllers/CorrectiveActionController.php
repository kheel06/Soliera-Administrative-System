<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CorrectiveActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actions = \App\Models\CorrectiveAction::with(['assignee', 'permit'])
            ->latest()
            ->paginate(10);

        $stats = [
            'open' => \App\Models\CorrectiveAction::where('status', 'Open')->count(),
            'critical' => \App\Models\CorrectiveAction::where('priority', 'Critical')->where('status', '!=', 'Closed')->count(),
            'resolved_month' => \App\Models\CorrectiveAction::where('status', 'Resolved')->whereMonth('updated_at', now()->month)->count()
        ];

        return view('compliance.corrective_actions.index', compact('actions', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'priority' => 'required|string',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string'
        ]);

        $validated['status'] = 'Open';
        $validated['created_by'] = auth()->id();

        $action = \App\Models\CorrectiveAction::create($validated);

        \App\Services\SystemNotificationService::notifyObligationAction('created', $action);

        return redirect()->back()->with('success', 'Action created successfully.');
    }
}
