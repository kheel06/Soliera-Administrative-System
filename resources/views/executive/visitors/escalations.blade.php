@extends('layouts.app')

@section('title', 'Executive | Escalations')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Visitor Escalations</h1>
                <p class="text-sm text-gray-500 mt-1">Monitor and manage visitor violations and incidents</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('executive.sensitive_log') }}"
                    class="btn bg-[#F7B32B] border-[#F7B32B] text-[#001F54] hover:bg-[#e5a220] btn-sm gap-2 font-bold shadow-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Visitor Log
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Violations</h3>
                        <p class="text-2xl font-bold mt-1 text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="shield-alert" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">High Severity</h3>
                        <p class="text-2xl font-bold mt-1 text-red-600">{{ $stats['high'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Medium Severity</h3>
                        <p class="text-2xl font-bold mt-1 text-amber-600">{{ $stats['medium'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Low Severity</h3>
                        <p class="text-2xl font-bold mt-1 text-gray-600">{{ $stats['low'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="info" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Last 30 Days</h3>
                        <p class="text-2xl font-bold mt-1 text-blue-600">{{ $stats['last_30d'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="calendar" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Header -->
        <div class="flex items-center justify-between mb-4 px-1">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-6 bg-red-500 rounded-full"></div>
                <h2 class="text-xs font-bold text-gray-800 uppercase tracking-widest leading-none">Escalation Records</h2>
            </div>

            <div class="flex items-center gap-2">
                <div class="dropdown dropdown-end">
                    <button tabindex="0"
                        class="btn btn-sm btn-circle bg-[#F7B32B] border-[#F7B32B] hover:bg-[#e5a220] transition-all"
                        title="Filter by Severity">
                        <i data-lucide="filter" class="w-4 h-4 text-[#001F54]"></i>
                    </button>
                    <ul tabindex="0"
                        class="dropdown-content z-[10] menu p-2 shadow-2xl bg-white border border-gray-100 rounded-2xl w-52 mt-2">
                        <li
                            class="menu-title px-4 py-3 text-[10px] uppercase font-bold text-gray-400 tracking-widest border-b border-gray-50 mb-1">
                            Filter Severity</li>
                        <li>
                            <a href="{{ route('executive.escalations', ['severity' => 'all']) }}"
                                class="py-3 px-4 rounded-xl {{ $severity === 'all' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">
                                <span class="text-[11px] uppercase tracking-wide">All Severity</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('executive.escalations', ['severity' => 'high']) }}"
                                class="py-3 px-4 rounded-xl {{ $severity === 'high' ? 'bg-red-50 text-red-600 font-bold' : 'text-gray-600' }}">
                                <div class="flex items-center justify-between w-full">
                                    <span class="text-[11px] uppercase tracking-wide">High</span>
                                    <div class="w-2 h-2 rounded-full bg-red-500 shadow-sm shadow-red-200"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('executive.escalations', ['severity' => 'medium']) }}"
                                class="py-3 px-4 rounded-xl {{ $severity === 'medium' ? 'bg-amber-50 text-amber-600 font-bold' : 'text-gray-600' }}">
                                <div class="flex items-center justify-between w-full">
                                    <span class="text-[11px] uppercase tracking-wide">Medium</span>
                                    <div class="w-2 h-2 rounded-full bg-amber-500 shadow-sm shadow-amber-200"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('executive.escalations', ['severity' => 'low']) }}"
                                class="py-3 px-4 rounded-xl {{ $severity === 'low' ? 'bg-slate-50 text-slate-600 font-bold' : 'text-gray-600' }}">
                                <div class="flex items-center justify-between w-full">
                                    <span class="text-[11px] uppercase tracking-wide">Low</span>
                                    <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Violations Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[10px] text-gray-400 uppercase bg-gray-50/50 font-bold tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Incident Details</th>
                            <th class="px-4 py-4">Visitor</th>
                            <th class="px-4 py-4 text-center">Severity</th>
                            <th class="px-6 py-4 text-right">Registered On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($violations as $violation)
                                        @php
                                            $sev = $violation->severity ?? 'low';
                                            $rowHighlight = match ($sev) {
                                                'high' => 'bg-red-50/30 hover:bg-red-50/50',
                                                'medium' => 'hover:bg-amber-50/30',
                                                default => 'hover:bg-gray-50/50',
                                            };
                                        @endphp
                                        <tr class="transition-colors {{ $rowHighlight }}">
                                            <td class="px-6 py-4">
                                                <div class="flex items-start gap-4">
                                                    <div
                                                        class="w-10 h-10 rounded-xl shrink-0 flex items-center justify-center 
                                                                                                            {{ $sev === 'high' ? 'bg-red-50 text-red-500 border border-red-100' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">
                                                        <i data-lucide="{{ $sev === 'high' ? 'shield-alert' : 'info' }}"
                                                            class="w-5 h-5"></i>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="font-bold text-gray-900 leading-tight uppercase tracking-tight mb-1">
                                                            {{ $violation->violation_type ?? 'Unknown Incident' }}
                                                        </p>
                                                        <p class="text-[11px] text-gray-500 leading-relaxed max-w-sm truncate"
                                                            title="{{ $violation->description }}">
                                                            {{ $violation->description ?? 'No incident description provided.' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center border border-blue-100 shadow-sm">
                                                        <span class="text-[10px] font-bold text-blue-600">
                                                            {{ strtoupper(substr($violation->visitor->name ?? $violation->visitor->first_name ?? 'V', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-xs font-bold text-gray-800 truncate">
                                                            {{ $violation->visitor->name ?? (($violation->visitor->first_name ?? '') . ' ' . ($violation->visitor->last_name ?? '')) }}
                                                        </p>
                                                        <p class="text-[10px] text-gray-400 font-medium">Verified Visitor</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                @php
                                                    $badgeClasses = match ($sev) {
                                                        'high' => 'bg-red-50 text-red-600 border-red-200',
                                                        'medium' => 'bg-amber-50 text-amber-600 border-amber-200',
                                                        default => 'bg-slate-50 text-slate-600 border-slate-200',
                                                    };
                                                @endphp
                                                <span
                                                    class="px-3 py-1 text-[10px] font-black rounded-lg border {{ $badgeClasses }} uppercase tracking-widest shadow-sm">
                                                    {{ $sev }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <p class="text-[11px] font-black text-gray-900 leading-none mb-1">
                                                    {{ $violation->created_at->format('M d, Y') }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">
                                                    {{ $violation->created_at->format('h:i A') }}
                            </div>
                            </td>
                            </tr>
                        @empty
                <tr>
                    <td colspan="4" class="px-4 py-24 text-center">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-xl shadow-green-100">
                                <i data-lucide="shield-check" class="w-10 h-10 text-green-500"></i>
                            </div>
                            <h3 class="text-lg font-black text-green-600 uppercase tracking-widest">Safe & Secure</h3>
                            <p class="text-gray-400 text-sm font-medium mt-1">All visitor activities are currently within
                                compliance.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
            </table>
        </div>
        @if($violations->hasPages())
            <div class="px-6 py-4 border-t bg-gray-50/50">
                {{ $violations->withQueryString()->links() }}
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