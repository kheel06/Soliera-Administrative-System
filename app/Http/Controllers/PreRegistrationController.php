<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PreRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        $search = $request->query('search');

        $query = Visitor::with('host')->where('status', $status);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('purpose', 'like', "%{$search}%");
            });
        }

        // Apply date filters if present
        if ($request->date_from) {
            $query->whereDate('scheduled_date', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('scheduled_date', '<=', $request->date_to);
        }

        $allVisitors = $query->orderBy('created_at', 'desc')->get();

        // Group by attributes that define a bulk registration session
        $grouped = $allVisitors->groupBy(function ($item) {
            // Visitors registered together share these attributes
            return ($item->company ?? 'single_' . uniqid()) . '_' .
                $item->host_id . '_' .
                ($item->scheduled_date ? $item->scheduled_date->toDateString() : '') . '_' .
                ($item->scheduled_time ? $item->scheduled_time->toTimeString() : '') . '_' .
                $item->purpose;
        });

        $pendingRequests = $grouped->map(function ($members) {
            $first = $members->first();
            return (object) [
                'group_name' => $first->company ?: $first->name,
                'is_bulk' => $members->count() > 1 || !empty($first->company),
                'host' => $first->host,
                'host_id' => $first->host_id,
                'purpose' => $first->purpose,
                'scheduled_date' => $first->scheduled_date,
                'scheduled_time' => $first->scheduled_time,
                'status' => $first->status,
                'expected_time_out' => $first->expected_time_out,
                'pass_id' => $first->pass_id, // Added this line
                'visitors' => $members->map(fn($v) => [
                    'id' => $v->id,
                    'name' => $v->name,
                    'phone' => $v->phone,
                    'status' => $v->status,
                    'time_out' => $v->expected_time_out,
                    'pass_id' => $v->pass_id, // Added this line
                ]),
                'visitor_count' => $members->count(),
                'created_at' => $first->created_at,
                'member_ids' => $members->pluck('id')->toArray()
            ];
        })->sortByDesc('created_at')->values();

        $stats = [
            'pending' => Visitor::where('status', 'pending')->count(),
            'approved' => Visitor::where('status', 'approved')->count(),
            'denied' => Visitor::where('status', 'denied')->orWhere('status', 'cancelled')->count(),
        ];

        $hosts = \App\Models\User::orderBy('name')->get();

        return view('visitors.pre_registrations.index', compact('pendingRequests', 'stats', 'hosts'));
    }

    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:visitor,id',
            'status' => 'required|in:approved,denied,cancelled'
        ]);

        Visitor::whereIn('id', $validated['ids'])->update(['status' => $validated['status']]);

        // Send notifications
        $visitors = Visitor::whereIn('id', $validated['ids'])->get();
        foreach ($visitors as $visitor) {
            \App\Services\SystemNotificationService::notifyVisitorAction($validated['status'], $visitor);
        }

        return redirect()->route('visitors.badges')->with('success', "Group " . count($request->ids) . " visitor(s) marked as {$request->status}.");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'host_id' => 'required|exists:users,id',
            'purpose' => 'required|string|max:255',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required',
            'special_instructions' => 'nullable|string'
        ]);

        $visitor = new Visitor();
        $visitor->name = $validated['name'];
        $visitor->company = $validated['company'];
        $visitor->email = $validated['email'];
        $visitor->phone = $validated['phone'];
        $visitor->host_id = $validated['host_id'];
        $visitor->purpose = $validated['purpose'];
        $visitor->scheduled_date = $validated['scheduled_date'];
        $visitor->scheduled_time = $validated['scheduled_time'];
        $visitor->special_instructions = $validated['special_instructions'];
        $visitor->room = $request->room;
        $visitor->status = 'pending';
        $visitor->save();

        // Send notification
        \App\Services\SystemNotificationService::notifyVisitorAction('scheduled', $visitor);

        // Ideally send email to host here

        return redirect()->back()->with('success', 'Visitor pre-registration created successfully.');
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'groupName' => 'required|string|max:255',
            'hostId' => 'required|exists:users,id',
            'purpose' => 'required|string|max:255',
            'timeIn' => 'required',
            'timeOut' => 'required',
            'notes' => 'nullable|string',
            'visitors' => 'required|array|min:1',
            'visitors.*.name' => 'required|string|max:255',
            'visitors.*.phone' => 'required|string|max:20',
        ]);

        foreach ($validated['visitors'] as $vData) {
            $visitor = new Visitor();
            $visitor->name = $vData['name'];
            $visitor->phone = $vData['phone'];
            $visitor->company = $validated['groupName']; // Use group name as company
            $visitor->host_id = $validated['hostId'];
            $visitor->purpose = $validated['purpose'];

            // Parse timeIn for scheduled_date and scheduled_time
            $dtIn = Carbon::parse($validated['timeIn']);
            $visitor->setAttribute('scheduled_date', $dtIn);
            $visitor->setAttribute('scheduled_time', $dtIn);

            $dtOut = Carbon::parse($validated['timeOut']);
            $visitor->expected_time_out = $dtOut;

            $visitor->special_instructions = $validated['notes'];
            $visitor->status = 'pending';
            $visitor->pass_id = 'PASS-' . strtoupper(Str::random(8)); // Added this line
            $visitor->save();

            // Send notification
            \App\Services\SystemNotificationService::notifyVisitorAction('scheduled', $visitor);
        }

        return response()->json([
            'success' => true,
            'message' => 'Group registered successfully.',
            'redirect' => route('visitors.pre_registrations')
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,denied,cancelled'
        ]);

        $visitor = Visitor::findOrFail($id);
        $visitor->status = $request->status;
        $visitor->save();

        // Send notification
        $action = $request->status;
        if ($action === 'approved')
            $action = 'approved';
        if ($action === 'denied')
            $action = 'denied';
        \App\Services\SystemNotificationService::notifyVisitorAction($action, $visitor);

        // If approved, maybe generate a pass code or email the visitor
        if ($request->status === 'approved') {
            // Generate access code logic if needed
        }

        return redirect()->back()->with('success', "Visitor request marked as {$request->status}.");
    }
}
