<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalCase;

class ExecutiveCaseController extends Controller
{
    public function index(Request $request)
    {
        // Filter parameters
        $status = $request->get('status', 'all');
        $priority = $request->get('priority', 'all');
        $search = $request->get('search', '');

        // Base query with relationships
        $query = LegalCase::with(['assignedTo', 'createdBy']);

        // Apply filters
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($priority !== 'all') {
            $query->where('priority', $priority);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('case_title', 'like', "%{$search}%")
                    ->orWhere('case_description', 'like', "%{$search}%");
            });
        }

        $cases = $query
            ->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')")
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Stats
        $stats = [
            'total' => LegalCase::count(),
            'open' => LegalCase::whereIn('status', ['pending', 'ongoing'])->count(),
            'ongoing' => LegalCase::where('status', 'ongoing')->count(),
            'urgent' => LegalCase::where('priority', 'urgent')
                ->whereIn('status', ['pending', 'ongoing'])
                ->count(),
            'high_priority' => LegalCase::where('priority', 'high')
                ->whereIn('status', ['pending', 'ongoing'])
                ->count(),
            'resolved' => LegalCase::whereIn('status', ['completed', 'rejected'])->count(),
        ];

        return view('executive.legal.cases.index', compact(
            'cases',
            'stats',
            'status',
            'priority',
            'search'
        ));
    }
}
