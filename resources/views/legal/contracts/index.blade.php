@extends('layouts.app')

@section('title', 'Legal | Contracts Workspace')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Contracts Workspace</h2>
                    <p class="text-sm text-gray-600">Manage lifecycle, drafting, and renewals.</p>
                </div>
                <div class="flex gap-2">
                    <!-- Export Dropdown -->
                    <div class="relative" x-data="{ openExport: false }" @click.away="openExport = false">
                        <button @click="openExport = !openExport"
                            class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                            <i data-lucide="download" class="w-4 h-4"></i>
                            Export Reports
                            <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                        </button>
                        <div x-show="openExport"
                            class="absolute right-0 z-20 mt-2 w-48 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none py-1"
                            style="display: none;">
                            <a href="{{ route('legal.contracts.export') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                                <i data-lucide="file-spreadsheet" class="w-4 h-4 inline mr-2 text-green-600"></i>
                                Export as Excel
                            </a>
                            <a href="{{ route('legal.contracts.export_pdf') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                                <i data-lucide="file" class="w-4 h-4 inline mr-2 text-red-600"></i>
                                Export as PDF
                            </a>
                        </div>
                    </div>

                    @if(in_array(session('user_role'), ['Legal Officer', 'Admin Manager', 'Owner']))
                        <a href="{{ route('legal.contracts.create') }}"
                            class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            New Contract
                        </a>
                    @endif
                </div>
            </div>

            <!-- Metrics/KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Active Contracts -->
                <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between border border-gray-100">
                    <div>
                        <div class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-1">Active Contracts</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['active'] ?? 0 }}</div>
                    </div>
                    <div class="p-3 rounded-lg bg-[#0A1829]">
                        <i data-lucide="file-check" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>

                <!-- Pending Review -->
                <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between border border-gray-100">
                    <div>
                        <div class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-1">Pending Review</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['pending'] ?? 0 }}</div>
                    </div>
                    <div class="p-3 rounded-lg bg-[#0A1829]">
                        <i data-lucide="clock" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>

                <!-- Expiring -->
                <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between border border-gray-100">
                    <div>
                        <div class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-1">Expiring (30 Days)
                        </div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['expiring'] ?? 0 }}</div>
                    </div>
                    <div class="p-3 rounded-lg bg-[#0A1829]">
                        <i data-lucide="alert-triangle" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>

                <!-- Drafts -->
                <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between border border-gray-100">
                    <div>
                        <div class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-1">Drafts</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['drafts'] ?? 0 }}</div>
                    </div>
                    <div class="p-3 rounded-lg bg-[#0A1829]">
                        <i data-lucide="file-edit" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <div class="flex flex-col md:flex-row gap-4 justify-between">
                    <div class="flex gap-2">
                        <a href="{{ route('legal.contracts.workspace', ['tab' => 'all', 'search' => request('search')]) }}"
                            class="px-4 py-2 text-sm font-medium {{ request('tab', 'all') == 'all' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            All Contracts
                        </a>
                        <a href="{{ route('legal.contracts.workspace', ['tab' => 'drafts', 'search' => request('search')]) }}"
                            class="px-4 py-2 text-sm font-medium {{ request('tab') == 'drafts' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            My Drafts
                        </a>
                        <a href="{{ route('legal.contracts.workspace', ['tab' => 'awaiting_approval', 'search' => request('search')]) }}"
                            class="px-4 py-2 text-sm font-medium {{ request('tab') == 'awaiting_approval' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Awaiting Approval
                        </a>
                    </div>
                    <div class="flex gap-2">
                        <form method="GET" action="{{ route('legal.contracts.workspace') }}" class="relative">
                            <input type="hidden" name="tab" value="{{ request('tab', 'all') }}">
                            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search contracts..."
                                class="pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        </form>
                        <!-- Filter Dropdown -->
                        <div class="relative" x-data="{ openFilters: false }" @click.away="openFilters = false">
                            <button @click="openFilters = !openFilters"
                                class="px-3 py-2 rounded-lg bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] flex items-center gap-2 transition-colors duration-200">
                                <i data-lucide="filter" class="w-4 h-4 text-[#0A1829]"></i>
                            </button>

                            <div x-show="openFilters"
                                class="absolute right-0 z-20 mt-2 w-72 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none p-4"
                                style="display: none;">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-sm font-semibold text-gray-700">Filters</h3>
                                    <a href="{{ route('legal.contracts.workspace') }}"
                                        class="text-xs text-[#0A1829] hover:text-gray-900">Clear All</a>
                                </div>

                                <form method="GET" action="{{ route('legal.contracts.workspace') }}">
                                    <input type="hidden" name="tab" value="{{ request('tab', 'all') }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">

                                    <!-- Contract Type -->
                                    <div class="mb-3">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Contract Type</label>
                                        <select name="type"
                                            class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <option value="">All Types</option>
                                            <option value="Service Agreement" {{ request('type') == 'Service Agreement' ? 'selected' : '' }}>Service Agreement</option>
                                            <option value="NDA" {{ request('type') == 'NDA' ? 'selected' : '' }}>NDA</option>
                                            <option value="Lease" {{ request('type') == 'Lease' ? 'selected' : '' }}>Lease
                                            </option>
                                            <option value="Employment" {{ request('type') == 'Employment' ? 'selected' : '' }}>Employment</option>
                                            <option value="Vendor Contract" {{ request('type') == 'Vendor Contract' ? 'selected' : '' }}>Vendor Contract</option>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                                        <select name="status"
                                            class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <option value="">All Statuses</option>
                                            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft
                                            </option>
                                            <option value="Pending Signature" {{ request('status') == 'Pending Signature' ? 'selected' : '' }}>Pending Signature</option>
                                            <option value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }}>
                                                Expired</option>
                                        </select>
                                    </div>

                                    <!-- Date Range (Effective Date) -->
                                    <div class="mb-4">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Effective Date</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                                class="w-full text-xs border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                                class="w-full text-xs border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] text-sm font-medium py-2 rounded-lg transition-colors duration-200">
                                        Apply Filters
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contracts Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contract Title</th>
                                <th
                                    class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Counterparty</th>
                                <th
                                    class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th
                                    class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Effective Date</th>
                                <th
                                    class="px-3 md:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($contracts as $contract)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $contract->title }}</div>
                                        <div class="text-xs text-gray-500">Ref: {{ $contract->contract_number ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $contract->counterparty_name }}
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $contract->type }}
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColor = match ($contract->status) {
                                                'Active' => 'bg-green-100 text-green-800',
                                                'Draft' => 'bg-gray-100 text-gray-800',
                                                'Pending Review' => 'bg-yellow-100 text-yellow-800',
                                                'Pending Signature' => 'bg-blue-100 text-blue-800',
                                                'Expired' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">{{ $contract->status }}</span>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $contract->effective_date ? $contract->effective_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                            <button @click="open = !open" @click.away="open = false"
                                                class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                                            </button>
                                            <div x-show="open"
                                                class="absolute right-0 z-50 mt-2 w-40 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                style="display: none;">
                                                <div class="py-1">
                                                    <a href="{{ route('legal.contracts.details', $contract->id) }}"
                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View
                                                        Details</a>
                                                    <a href="{{ route('legal.contracts.edit', $contract->id) }}"
                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                                    @if($contract->file_path || strtolower($contract->type) === 'employment')
                                                        <a href="{{ route('legal.contracts.download', $contract->id) }}"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                            target="_blank">Download</a>
                                                    @endif
                                                    <form action="{{ route('legal.contracts.destroy', $contract->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this contract?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 md:px-6 py-4 text-center text-gray-500">No contracts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $contracts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection