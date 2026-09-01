@extends('layouts.app')

@section('title', 'Executive | Compliance Center')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Compliance Center</h1>
                <p class="text-sm text-gray-500 mt-1">Permit and license management board</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">

                <!-- Export Dropdown -->
                <div class="relative" x-data="{ openExport: false }" @click.away="openExport = false">
                    <button @click="openExport = !openExport"
                        class="bg-[#F7B32B] hover:bg-[#e5a220] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200 text-sm">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Export Reports
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    <div x-show="openExport"
                        class="absolute right-0 z-20 mt-2 w-48 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none py-1"
                        style="display: none;">
                        <a href="{{ route('executive.permits.export') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                            <i data-lucide="file-spreadsheet" class="w-4 h-4 inline mr-2 text-green-600"></i>
                            Export as Excel
                        </a>
                        <a href="{{ route('executive.permits.export_pdf') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                            <i data-lucide="file" class="w-4 h-4 inline mr-2 text-red-600"></i>
                            Export as PDF
                        </a>
                    </div>
                </div>

                <a href="{{ route('executive.renewals') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    Renewal Calendar
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Permits</h3>
                        <p class="text-2xl font-bold mt-1 text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="shield" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Active</h3>
                        <p class="text-2xl font-bold mt-1 text-emerald-600">{{ $stats['active'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="check-circle" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Expiring Soon</h3>
                        <p class="text-2xl font-bold mt-1 text-amber-600">{{ $stats['expiring_soon'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Expired</h3>
                        <p class="text-2xl font-bold mt-1 text-red-600">{{ $stats['expired'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="x-circle" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Board View -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Active Column -->
            <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-200">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                    <h3 class="font-bold text-emerald-800">Active ({{ $boardData['active']->count() }})</h3>
                </div>
                <div class="space-y-3 max-h-[500px] overflow-y-auto">
                    @forelse($boardData['active'] as $permit)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-emerald-100 hover:shadow-md transition">
                            <h4 class="font-medium text-gray-900 text-sm">{{ $permit->name }}</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $permit->issuing_authority ?? 'N/A' }}</p>
                            @if($permit->expiration_date)
                                <p class="text-xs text-emerald-600 mt-2">
                                    <i data-lucide="calendar" class="w-3 h-3 inline"></i>
                                    Expires: {{ $permit->expiration_date->format('M d, Y') }}
                                </p>
                            @else
                                <p class="text-xs text-gray-400 mt-2">No expiration</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center text-emerald-600 py-4">
                            <p class="text-sm">No active permits</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Expiring Soon Column -->
            <div class="bg-amber-50 rounded-xl p-4 border border-amber-200">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                    <h3 class="font-bold text-amber-800">Expiring / In Renewal ({{ $boardData['expiring']->count() }})</h3>
                </div>
                <div class="space-y-3 max-h-[500px] overflow-y-auto">
                    @forelse($boardData['expiring'] as $permit)
                        @php
                            $daysLeft = $permit->expiration_date ? now()->diffInDays($permit->expiration_date, false) : null;
                        @endphp
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-amber-100 hover:shadow-md transition">
                            <h4 class="font-medium text-gray-900 text-sm">{{ $permit->name }}</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $permit->issuing_authority ?? 'N/A' }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-amber-100 text-amber-700">
                                    {{ $permit->status }}
                                </span>
                                @if($daysLeft !== null)
                                    <span class="text-xs {{ $daysLeft <= 14 ? 'text-red-600' : 'text-amber-600' }} font-medium">
                                        {{ $daysLeft }} days left
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-amber-600 py-4">
                            <p class="text-sm">No expiring permits</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Expired Column -->
            <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                    <h3 class="font-bold text-red-800">Expired ({{ $boardData['expired']->count() }})</h3>
                </div>
                <div class="space-y-3 max-h-[500px] overflow-y-auto">
                    @forelse($boardData['expired'] as $permit)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-red-100 hover:shadow-md transition">
                            <h4 class="font-medium text-gray-900 text-sm">{{ $permit->name }}</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $permit->issuing_authority ?? 'N/A' }}</p>
                            @if($permit->expiration_date)
                                <p class="text-xs text-red-600 mt-2">
                                    <i data-lucide="alert-circle" class="w-3 h-3 inline"></i>
                                    Expired: {{ $permit->expiration_date->format('M d, Y') }}
                                </p>
                            @endif
                            <a href="{{ route('compliance.permits') }}"
                                class="mt-2 inline-block text-xs text-red-600 hover:underline">
                                Initiate Renewal →
                            </a>
                        </div>
                    @empty
                        <div class="text-center text-red-600 py-4">
                            <i data-lucide="check-circle" class="w-8 h-8 mx-auto mb-2 text-green-500"></i>
                            <p class="text-sm text-green-600">No expired permits!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- All Permits Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800">All Permits</h3>
                <div class="flex items-center gap-3">
                    <form method="GET" class="flex items-center gap-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ $search }}"
                                class="input input-bordered input-sm w-48 pl-9 rounded-lg bg-gray-50/50 border-gray-200 focus:bg-white transition-all shadow-inner text-xs"
                                placeholder="Search permits...">
                        </div>

                        <div class="dropdown dropdown-end">
                            <button type="button" tabindex="0"
                                class="btn btn-sm btn-circle bg-[#F7B32B] border-[#F7B32B] hover:bg-[#e5a220] transition-all"
                                title="Filter by Status">
                                <i data-lucide="filter" class="w-4 h-4 text-[#001F54]"></i>
                            </button>
                            <ul tabindex="0"
                                class="dropdown-content z-[50] menu p-2 shadow-2xl bg-white border border-gray-100 rounded-2xl w-60 mt-2">
                                <li
                                    class="menu-title px-4 py-3 text-[10px] uppercase font-bold text-gray-400 tracking-widest border-b border-gray-50 mb-1">
                                    Filter by Status</li>
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}"
                                        class="py-3 px-4 rounded-xl {{ $status === 'all' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">
                                        <span class="text-[11px] uppercase tracking-wide">All Status</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Active']) }}"
                                        class="py-3 px-4 rounded-xl {{ $status === 'Active' ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-600' }}">
                                        <div class="flex items-center justify-between w-full">
                                            <span class="text-[11px] uppercase tracking-wide">Active</span>
                                            <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-200">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Expiring Soon']) }}"
                                        class="py-3 px-4 rounded-xl {{ $status === 'Expiring Soon' ? 'bg-amber-50 text-amber-600 font-bold' : 'text-gray-600' }}">
                                        <div class="flex items-center justify-between w-full">
                                            <span class="text-[11px] uppercase tracking-wide">Expiring Soon</span>
                                            <div class="w-2 h-2 rounded-full bg-amber-500 shadow-sm shadow-amber-200"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Renewal in Progress']) }}"
                                        class="py-3 px-4 rounded-xl {{ $status === 'Renewal in Progress' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">
                                        <div class="flex items-center justify-between w-full">
                                            <span class="text-[11px] uppercase tracking-wide">In Renewal</span>
                                            <div class="w-2 h-2 rounded-full bg-blue-500 shadow-sm shadow-blue-200"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Expired']) }}"
                                        class="py-3 px-4 rounded-xl {{ $status === 'Expired' ? 'bg-red-50 text-red-600 font-bold' : 'text-gray-600' }}">
                                        <div class="flex items-center justify-between w-full">
                                            <span class="text-[11px] uppercase tracking-wide">Expired</span>
                                            <div class="w-2 h-2 rounded-full bg-red-500 shadow-sm shadow-red-200"></div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[10px] text-gray-400 uppercase bg-gray-50/50 font-bold tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Permit Details</th>
                            <th class="px-4 py-4">Issuing Authority</th>
                            <th class="px-4 py-4 text-center">Status</th>
                            <th class="px-4 py-4 text-center">Days Left</th>
                            <th class="px-6 py-4 text-right">Expiration</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($permits as $permit)
                            @php
                                $daysLeft = $permit->expiration_date ? now()->diffInDays($permit->expiration_date, false) : null;
                                $statusColor = match ($permit->status) {
                                    'Active' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'Expiring Soon' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'Renewal in Progress' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'Expired' => 'bg-red-50 text-red-600 border-red-100',
                                    default => 'bg-gray-50 text-gray-600 border-gray-100',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100 shadow-sm text-slate-400">
                                            <i data-lucide="file-text" class="w-4 h-4"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-900 leading-none mb-1 uppercase tracking-tight">
                                                {{ $permit->name }}
                                            </p>
                                            <p class="text-[10px] text-gray-400 font-bold tracking-tighter uppercase">ID:
                                                PER-{{ str_pad($permit->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="text-xs text-gray-500 font-medium">{{ $permit->issuing_authority ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-black rounded-lg border {{ $statusColor }} uppercase tracking-widest shadow-sm">
                                        {{ $permit->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($daysLeft !== null)
                                        @php
                                            $dayColor = match (true) {
                                                $daysLeft < 0 => 'text-red-600 bg-red-50',
                                                $daysLeft <= 30 => 'text-amber-600 bg-amber-50',
                                                default => 'text-gray-500 bg-gray-50',
                                            };
                                        @endphp
                                        <span class="px-2 py-0.5 text-[11px] font-bold rounded-md {{ $dayColor }}">
                                            {{ $daysLeft < 0 ? 'Overdue' : $daysLeft . 'd rem.' }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <p class="text-[11px] font-black text-gray-900 leading-none">
                                        {{ $permit->expiration_date ? $permit->expiration_date->format('M d, Y') : 'N/A' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('compliance.permits') }}"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all mx-auto shadow-sm border border-gray-100 hover:border-blue-100">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                            <i data-lucide="file-x" class="w-8 h-8 text-gray-300"></i>
                                        </div>
                                        <p class="text-gray-400 text-sm font-medium uppercase tracking-widest">No matching
                                            permits found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($permits->hasPages())
                <div class="px-6 py-4 border-t bg-gray-50/50">
                    {{ $permits->withQueryString()->links() }}
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