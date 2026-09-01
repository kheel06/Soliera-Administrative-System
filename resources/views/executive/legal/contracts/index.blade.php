@extends('layouts.app')

@section('title', 'Executive | Legal Governance')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Legal Governance</h1>
                <p class="text-sm text-gray-500 mt-1">Contract portfolio overview and management</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <!-- Export Dropdown -->
                <div class="relative" x-data="{ openExport: false }" @click.away="openExport = false">
                    <button @click="openExport = !openExport" class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200 text-sm">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Export Reports
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    <div x-show="openExport" class="absolute right-0 z-20 mt-2 w-48 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none py-1" style="display: none;">
                        <a href="{{ route('legal.contracts.export') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                            <i data-lucide="file-spreadsheet" class="w-4 h-4 inline mr-2 text-green-600"></i>
                            Export as Excel
                        </a>
                        <a href="{{ route('legal.contracts.export_pdf') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                            <i data-lucide="file" class="w-4 h-4 inline mr-2 text-red-600"></i>
                            Export as PDF
                        </a>
                    </div>
                </div>
                <a href="{{ route('executive.cases') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="briefcase" class="w-4 h-4"></i>
                    View Cases
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total</h3>
                        <p class="text-2xl font-bold mt-1 text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="file-text" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <a href="?status=Active" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Active</h3>
                            <p class="text-2xl font-bold mt-1 text-emerald-600">{{ $stats['active'] }}</p>
                        </div>
                        <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="check-circle" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </a>

            <a href="?status=pending" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Pending</h3>
                            <p class="text-2xl font-bold mt-1 text-amber-600">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="clock" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </a>

            <a href="?filter=expiring" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Expiring Soon</h3>
                            <p class="text-2xl font-bold mt-1 text-red-600">{{ $stats['expiring_soon'] }}</p>
                        </div>
                        <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </a>

            <a href="?status=Expired" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Expired</h3>
                            <p class="text-2xl font-bold mt-1 text-gray-600">{{ $stats['expired'] }}</p>
                        </div>
                        <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="x-circle" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </a>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Value</h3>
                        <p class="text-xl font-bold mt-1 text-blue-600">₱{{ number_format($stats['total_value'], 0) }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="coins" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Header -->
        <div class="flex items-center justify-between mb-4 px-1">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                <h2 class="text-xs font-bold text-gray-800 uppercase tracking-widest leading-none">Contract Records</h2>
            </div>

            <div class="flex items-center gap-3">
                <form method="GET" class="flex items-center gap-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ $search }}"
                            class="input input-bordered input-sm w-48 pl-8 text-[11px] bg-white focus:bg-white transition-all border-gray-200 rounded-lg shadow-sm"
                            placeholder="Search contracts...">
                    </div>

                    <div class="dropdown dropdown-end">
                        <button type="button" tabindex="0"
                            class="btn btn-sm btn-circle bg-[#F7B32B] border-[#F7B32B] hover:bg-[#e5a220] transition-all shadow-sm">
                            <i data-lucide="filter" class="w-4 h-4 text-[#001F54]"></i>
                        </button>
                        <ul tabindex="0"
                            class="dropdown-content z-[50] menu p-2 shadow-2xl bg-white border border-gray-100 rounded-2xl w-52 mt-2">
                            <li
                                class="menu-title px-4 py-2 text-[10px] uppercase font-bold text-gray-400 tracking-wider border-b border-gray-50 mb-1">
                                Status</li>
                            <li><a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}"
                                    class="py-2.5 rounded-xl text-xs {{ $status === 'all' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">All
                                    Status</a></li>
                            <li><a href="{{ request()->fullUrlWithQuery(['status' => 'Active']) }}"
                                    class="py-2.5 rounded-xl text-xs {{ $status === 'Active' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Active</a>
                            </li>
                            <li><a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                                    class="py-2.5 rounded-xl text-xs {{ $status === 'pending' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Pending</a>
                            </li>
                            <li><a href="{{ request()->fullUrlWithQuery(['status' => 'Expired']) }}"
                                    class="py-2.5 rounded-xl text-xs {{ $status === 'Expired' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Expired</a>
                            </li>
                            <li><a href="{{ request()->fullUrlWithQuery(['status' => 'Terminated']) }}"
                                    class="py-2.5 rounded-xl text-xs {{ $status === 'Terminated' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Terminated</a>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contracts Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Contract
                            </th>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Counterparty
                            </th>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Type</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">
                                Value</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">
                                Status</th>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Expiration
                            </th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($contracts as $contract)
                            @php
                                $daysLeft = $contract->expiration_date ? now()->diffInDays($contract->expiration_date, false) : null;
                                $statusStyle = match ($contract->status) {
                                    'Active' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'Pending Signature', 'Pending Review' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'Expired' => 'bg-red-50 text-red-600 border-red-100',
                                    'Terminated' => 'bg-gray-50 text-gray-500 border-gray-100',
                                    default => 'bg-blue-50 text-blue-600 border-blue-100',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-all group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:scale-110 transition-transform shadow-sm border border-blue-100">
                                            <i data-lucide="file-text" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <div
                                                class="text-xs font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition-colors">
                                                {{ Str::limit($contract->title, 40) }}</div>
                                            <div class="text-[10px] text-gray-500 font-medium tracking-tight mt-0.5">
                                                {{ $contract->contract_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-xs font-medium text-gray-600">{{ $contract->counterparty_name }}</td>
                                <td class="px-4 py-4">
                                    <span
                                        class="px-2 py-0.5 text-[10px] font-bold rounded bg-gray-100 text-gray-600 border border-gray-200 uppercase tracking-tighter">
                                        {{ $contract->type }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($contract->contract_value > 0)
                                        <div class="text-xs font-bold text-gray-900 tracking-tight">
                                            ₱{{ number_format($contract->contract_value, 2) }}</div>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-black rounded-lg border {{ $statusStyle }} uppercase tracking-widest shadow-sm">
                                        {{ $contract->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    @if($contract->expiration_date)
                                        <div class="text-[11px] font-bold text-gray-800 leading-none mb-1">
                                            {{ $contract->expiration_date->format('M d, Y') }}</div>
                                        @if($contract->status === 'Active' && $daysLeft !== null)
                                            <div
                                                class="text-[10px] font-bold uppercase tracking-tighter {{ $daysLeft <= 30 ? 'text-red-500' : ($daysLeft <= 60 ? 'text-amber-500' : 'text-emerald-600') }}">
                                                {{ $daysLeft > 0 ? $daysLeft . ' days left' : 'Expired' }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Permanent</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                            <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                                        </button>
                                        <div x-show="open" class="absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                                            <div class="py-1">
                                                <a href="{{ route('legal.contracts.details', $contract->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Details</a>
                                                <a href="{{ route('legal.contracts.edit', $contract->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                                @if($contract->file_path)
                                                <a href="{{ route('legal.contracts.download', $contract->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download</a>
                                                @endif
                                                <form action="{{ route('legal.contracts.destroy', $contract->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contract?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="file-x" class="w-8 h-8 text-gray-300"></i>
                                        </div>
                                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No contracts found
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">Adjust your search or filter settings</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($contracts->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                    {{ $contracts->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection