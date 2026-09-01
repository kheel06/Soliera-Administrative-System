<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContractRequest;
use Illuminate\Http\Request;

class ContractRequestController extends Controller
{
    public function index()
    {
        $requests = ContractRequest::with('requester')->latest()->paginate(10);
        
        $stats = [
            'pending' => ContractRequest::where('status', 'Pending Approval')->count(),
            'drafting' => ContractRequest::where('status', 'In Drafting')->count(),
            'completed' => ContractRequest::where('status', 'Completed')->count(),
        ];

        return view('legal.contract_requests.index', compact('requests', 'stats'));
    }

    public function create()
    {
        return view('legal.contract_requests.create');
    }
}
