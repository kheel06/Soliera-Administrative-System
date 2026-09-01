@extends('layouts.app')

@section('title', 'Executive | Approvals')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Approvals Queue</h1>
                <p class="text-sm text-gray-500 mt-1">Review and approve pending items across all departments</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                {{-- Dashboard button removed --}}
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Pending</h3>
                        <p class="text-2xl font-bold mt-1 text-gray-900">{{ $stats['total_pending'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="inbox" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">High Priority</h3>
                        <p class="text-2xl font-bold mt-1 text-red-600">{{ $stats['high_priority'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Contracts Pending</h3>
                        <p class="text-2xl font-bold mt-1 text-gray-900">{{ $stats['contracts_pending'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="file-text" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Permits Renewal</h3>
                        <p class="text-2xl font-bold mt-1 text-gray-900">{{ $stats['permits_renewal'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="file-check" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-6">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error mb-6">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Filters & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                <h2 class="text-xs font-bold text-gray-800 uppercase tracking-widest leading-none">Pending Items</h2>
            </div>

            <div class="flex items-center gap-2">
                <form method="GET" class="flex items-center gap-2 w-full md:w-auto">
                    <!-- Search Input -->
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="input input-bordered input-sm w-full pl-9 rounded-xl bg-white border-gray-200 focus:bg-white transition-all text-xs shadow-sm" 
                            placeholder="Search requests...">
                    </div>

                    <!-- Status Select (Visible) -->
                    <select name="status" class="select select-bordered select-sm rounded-xl text-xs bg-white border-gray-200 focus:border-blue-500 focus:ring-0 shadow-sm font-bold text-gray-600 w-32" onchange="this.form.submit()">
                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="Pending" {{ $status === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ $status === 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ $status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>

                    <!-- Filter Icon (Priority Only) -->
                    <div class="dropdown dropdown-end">
                        <button type="button" tabindex="0" class="btn btn-sm btn-circle bg-[#F7B32B] border-[#F7B32B] hover:bg-[#e5a220] transition-all shadow-md" title="Filter Priority">
                            <i data-lucide="filter" class="w-4 h-4 text-[#001F54]"></i>
                        </button>
                        <ul tabindex="0" class="dropdown-content z-[50] menu p-2 shadow-2xl bg-white border border-gray-100 rounded-2xl w-48 mt-2">
                             <!-- Priority Filters -->
                            <li class="menu-title px-4 py-2 text-[10px] uppercase font-bold text-gray-400 tracking-widest border-b border-gray-50 mb-1">Priority</li>
                            <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'all']) }}" class="py-2 rounded-xl text-xs {{ $priority === 'all' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">All Priority</a></li>
                            <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'urgent']) }}" class="py-2 rounded-xl text-xs {{ $priority === 'urgent' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Urgent</a></li>
                            <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'high']) }}" class="py-2 rounded-xl text-xs {{ $priority === 'high' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">High</a></li>
                            <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'medium']) }}" class="py-2 rounded-xl text-xs {{ $priority === 'medium' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Medium</a></li>
                            <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'low']) }}" class="py-2 rounded-xl text-xs {{ $priority === 'low' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Low</a></li>
                        </ul>
                    </div>

                     <!-- Hidden Input for Priority to preserve state if Search/Status changes form submission -->
                     <input type="hidden" name="priority" value="{{ $priority }}">
                </form>
            </div>
        </div>

        <!-- Contract Requests -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800">Contract Requests</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Department</th>
                            <th class="px-4 py-3">Counterparty</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3">Priority</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Submitted</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($contractRequests as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $request->department }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $request->counterparty_name }}</td>
                                <td class="px-4 py-3 text-gray-600 max-w-xs truncate" title="{{ $request->description }}">
                                    {{ Str::limit($request->description, 50) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-0.5 text-xs font-medium rounded-full 
                                                                        {{ $request->priority === 'urgent' ? 'bg-red-100 text-red-700' : '' }}
                                                                        {{ $request->priority === 'high' ? 'bg-amber-100 text-amber-700' : '' }}
                                                                        {{ $request->priority === 'medium' ? 'bg-blue-100 text-blue-700' : '' }}
                                                                        {{ $request->priority === 'low' ? 'bg-gray-100 text-gray-700' : '' }}">
                                        {{ ucfirst($request->priority ?? 'normal') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-0.5 text-xs font-medium rounded-full 
                                                                        {{ $request->status === 'Pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                                        {{ $request->status === 'Approved' ? 'bg-green-100 text-green-700' : '' }}
                                                                        {{ $request->status === 'Rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ $request->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500 text-xs">{{ $request->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    @if($request->status === 'Pending')
                                        <div class="flex gap-2">
                                            <button onclick="approveItem('contract-request', {{ $request->id }})"
                                                class="btn btn-success btn-xs gap-1">
                                                <i data-lucide="check" class="w-3 h-3"></i>
                                                Approve
                                            </button>
                                            <button onclick="openRejectModal('contract-request', {{ $request->id }})"
                                                class="btn btn-error btn-xs btn-outline gap-1">
                                                <i data-lucide="x" class="w-3 h-3"></i>
                                                Reject
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">No action needed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                    <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-2"></i>
                                    <p>No contract requests found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pending Contracts -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800">Contracts Awaiting Signature</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Contract</th>
                            <th class="px-4 py-3">Counterparty</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Value</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingContracts as $contract)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ Str::limit($contract->title, 40) }}</div>
                                    <div class="text-xs text-gray-500">{{ $contract->contract_number }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $contract->counterparty_name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $contract->type }}</td>
                                <td class="px-4 py-3 font-medium">₱{{ number_format($contract->contract_value, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-amber-100 text-amber-700">
                                        {{ $contract->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('legal.contracts.details', $contract->id) }}"
                                            class="btn btn-info btn-xs gap-1">
                                            <i data-lucide="eye" class="w-3 h-3"></i>
                                            View
                                        </a>
                                        <button onclick="approveItem('contract', {{ $contract->id }})"
                                            class="btn btn-success btn-xs gap-1">
                                            <i data-lucide="check" class="w-3 h-3"></i>
                                            Approve
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                    <i data-lucide="file-check" class="w-12 h-12 mx-auto mb-2"></i>
                                    <p>No contracts awaiting signature</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Permit Renewals -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800">Permits Requiring Renewal</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Permit</th>
                            <th class="px-4 py-3">Issuing Authority</th>
                            <th class="px-4 py-3">Expiration</th>
                            <th class="px-4 py-3">Days Left</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($permitRenewals as $permit)
                            @php
                                $daysLeft = $permit->expiration_date ? now()->diffInDays($permit->expiration_date, false) : null;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $permit->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $permit->issuing_authority ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $permit->expiration_date ? $permit->expiration_date->format('M d, Y') : 'No Expiry' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($daysLeft !== null)
                                        <span
                                            class="px-2 py-0.5 text-xs font-medium rounded-full 
                                                                                            {{ $daysLeft <= 14 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $daysLeft }} days
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-amber-100 text-amber-700">
                                        {{ $permit->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('compliance.permits') }}" class="btn btn-primary btn-xs gap-1">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                    <i data-lucide="shield-check" class="w-12 h-12 mx-auto mb-2"></i>
                                    <p>No permits requiring immediate renewal</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeRejectModal()"></div>
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
                <h3 class="text-lg font-bold mb-4">Reject Item</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection</label>
                        <textarea name="reason" required rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                            placeholder="Please provide a reason for rejection..."></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeRejectModal()" class="btn btn-ghost">Cancel</button>
                        <button type="submit" class="btn btn-error">Confirm Rejection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Approve Form (hidden) -->
    <form id="approveForm" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        function approveItem(type, id) {
            if (confirm('Are you sure you want to approve this item?')) {
                const form = document.getElementById('approveForm');
                form.action = `/executive/approvals/${type}/${id}/approve`;
                form.submit();
            }
        }

        function openRejectModal(type, id) {
            document.getElementById('rejectForm').action = `/executive/approvals/${type}/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection