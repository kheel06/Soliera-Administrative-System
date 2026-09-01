<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalContract;

class ExecutiveContractController extends Controller
{
    public function index(Request $request)
    {
        // Filter parameters
        $status = $request->get('status', 'all');
        $filter = $request->get('filter', null);
        $department = $request->get('department', 'all');
        $type = $request->get('type', 'all');
        $search = $request->get('search', '');

        // Base query
        $query = LegalContract::query();

        // Apply filters
        if ($status !== 'all') {
            if ($status === 'pending') {
                $query->whereIn('status', ['Pending Signature', 'Pending Review', 'Draft']);
            } else {
                $query->where('status', $status);
            }
        }

        // Special filters
        if ($filter === 'expiring') {
            $query->where('status', 'Active')
                ->where('expiration_date', '>=', now())
                ->where('expiration_date', '<=', now()->addDays(30));
        }

        if ($department !== 'all') {
            $query->where('department', $department);
        }

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('counterparty_name', 'like', "%{$search}%")
                    ->orWhere('contract_number', 'like', "%{$search}%");
            });
        }

        $contracts = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats
        $stats = [
            'total' => LegalContract::count(),
            'active' => LegalContract::where('status', 'Active')->count(),
            'pending' => LegalContract::whereIn('status', ['Pending Signature', 'Pending Review', 'Draft'])->count(),
            'expiring_soon' => LegalContract::where('status', 'Active')
                ->where('expiration_date', '>=', now())
                ->where('expiration_date', '<=', now()->addDays(30))
                ->count(),
            'expired' => LegalContract::where('status', 'Expired')->count(),
            'total_value' => LegalContract::where('status', 'Active')->sum('contract_value'),
        ];

        // Get unique departments and types for filters
        $departments = LegalContract::select('department')->distinct()->pluck('department');
        $types = LegalContract::select('type')->distinct()->pluck('type');

        return view('executive.legal.contracts.index', compact(
            'contracts',
            'stats',
            'status',
            'filter',
            'department',
            'type',
            'search',
            'departments',
            'types'
        ));
    }
}
