@extends('layouts.app')

@section('title', 'Executive | Visitor Oversight')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Visitor Oversight</h1>
                <p class="text-sm text-gray-500 mt-1">Monitor visitor access and sensitive area logs</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('executive.escalations') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                    View Escalations
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Visitors</h3>
                        <p class="text-2xl font-bold mt-1 text-blue-600">{{ $stats['total_visitors'] }}</p>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-tight font-medium">Last {{ $period }}
                            days</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="users" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">VIP Visitors</h3>
                        <p class="text-2xl font-bold mt-1 text-purple-600">{{ $stats['vip_visitors'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="star" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Contractors</h3>
                        <p class="text-2xl font-bold mt-1 text-amber-600">{{ $stats['contractor_visitors'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="hard-hat" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Violations</h3>
                        <p
                            class="text-2xl font-bold mt-1 {{ $stats['violations'] > 0 ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $stats['violations'] }}
                        </p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="alert-octagon" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Header -->
        <div class="flex items-center justify-between mb-4 px-1">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                <h2 class="text-xs font-bold text-gray-800 uppercase tracking-widest leading-none">Visitor Activity</h2>
            </div>

            <div class="flex items-center gap-3">
                <form method="GET" class="flex items-center gap-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ $search }}" 
                            class="input input-bordered input-sm w-48 pl-9 rounded-lg bg-white border-gray-200 focus:bg-white transition-all shadow-sm text-xs" 
                            placeholder="Search records...">
                    </div>
                    
                    <div class="dropdown dropdown-end">
                        <button type="button" tabindex="0" class="btn btn-sm btn-circle bg-[#F7B32B] border-[#F7B32B] hover:bg-[#e5a220] transition-all shadow-sm" title="Filter by Period">
                            <i data-lucide="filter" class="w-4 h-4 text-[#001F54]"></i>
                        </button>
                        <ul tabindex="0" class="dropdown-content z-[50] menu p-2 shadow-2xl bg-white border border-gray-100 rounded-2xl w-52 mt-2">
                            <li class="menu-title px-4 py-3 text-[10px] uppercase font-bold text-gray-400 tracking-widest border-b border-gray-50 mb-1">Time Period</li>
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['period' => '7']) }}" class="py-3 px-4 rounded-xl {{ $period == '7' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">
                                    <span class="text-[11px] uppercase tracking-wide">Last 7 Days</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['period' => '30']) }}" class="py-3 px-4 rounded-xl {{ $period == '30' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">
                                    <span class="text-[11px] uppercase tracking-wide">Last 30 Days</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['period' => '60']) }}" class="py-3 px-4 rounded-xl {{ $period == '60' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">
                                    <span class="text-[11px] uppercase tracking-wide">Last 60 Days</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['period' => '90']) }}" class="py-3 px-4 rounded-xl {{ $period == '90' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">
                                    <span class="text-[11px] uppercase tracking-wide">Last 90 Days</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Visitor Log Table -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <div class="w-1 h-4 bg-blue-500 rounded-full"></div>
                        Recent Visitor Log
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] text-gray-400 uppercase bg-gray-50/50 font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Visitor</th>
                                <th class="px-4 py-4">Type</th>
                                <th class="px-4 py-4 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($visitors as $visitor)
                                                <tr class="hover:bg-gray-50/50 transition-colors">
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-3">
                                                            <div
                                                                class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100 shadow-sm">
                                                                <span class="text-sm font-bold text-blue-600">
                                                                    {{ strtoupper(substr($visitor->name ?? $visitor->first_name ?? 'V', 0, 1)) }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <p class="font-bold text-gray-900 leading-none mb-1">
                                                                    {{ $visitor->name ?? (($visitor->first_name ?? '') . ' ' . ($visitor->last_name ?? '')) }}
                                                                </p>
                                                                <p class="text-[11px] text-gray-400 font-medium whitespace-nowrap">
                                                                    {{ Str::limit($visitor->purpose ?? 'Regular Visit', 25) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        @php
                                                            $vType = $visitor->visitor_type ?? $visitor->pass_type ?? 'Regular';
                                                            $typeClasses = match (true) {
                                                                stripos($vType, 'VIP') !== false => 'bg-purple-50 text-purple-700 border-purple-100',
                                                                stripos($vType, 'Contractor') !== false => 'bg-amber-50 text-amber-700 border-amber-100',
                                                                default => 'bg-gray-50 text-gray-600 border-gray-100',
                                                            };
                                                        @endphp
                                 <span
                                                            class="px-2.5 py-1 text-[10px] font-bold rounded-lg border {{ $typeClasses }} uppercase tracking-tight">
                                                            {{ $vType }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4 text-right">
                                                        <div class="text-[11px] font-bold text-gray-800">
                                                            {{ $visitor->created_at->format('M d, Y') }}</div>
                                                        <div class="text-[10px] text-gray-400 uppercase">
                                                            {{ $visitor->created_at->format('h:i A') }}</div>
                                                    </td>
                                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3 text-gray-300">
                                                <i data-lucide="users" class="w-6 h-6"></i>
                                            </div>
                                            <p class="text-gray-400 text-sm font-medium">No visitors found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($visitors->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50/50">
                        {{ $visitors->withQueryString()->links() }}
                    </div>
                @endif
            </div>

            <!-- Access Logs Sidebar -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
                <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <div class="w-1 h-4 bg-amber-500 rounded-full"></div>
                        Access Events
                    </h3>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Real-time</span>
                </div>
                <div class="divide-y divide-gray-50 max-h-[600px] overflow-y-auto">
                    @forelse($accessLogs as $log)
                        @php
                            $logAction = strtolower($log->action ?? 'activity');
                            $icon = match (true) {
                                str_contains($logAction, 'login') => 'log-in',
                                str_contains($logAction, 'export') => 'download',
                                str_contains($logAction, 'view') => 'eye',
                                str_contains($logAction, 'update') => 'edit-3',
                                str_contains($logAction, 'delete') => 'trash-2',
                                str_contains($logAction, 'create') => 'plus-circle',
                                default => 'activity',
                            };
                            $iconColor = match (true) {
                                str_contains($logAction, 'login') => 'text-blue-500 bg-blue-50',
                                str_contains($logAction, 'delete') => 'text-red-500 bg-red-50',
                                str_contains($logAction, 'update') => 'text-amber-500 bg-amber-50',
                                str_contains($logAction, 'create') => 'text-green-500 bg-green-50',
                                default => 'text-slate-500 bg-slate-50',
                            };
                        @endphp
                        <div class="px-5 py-4 hover:bg-gray-50 transition-all flex items-start gap-4 group">
                            <div
                                class="w-8 h-8 rounded-lg shrink-0 flex items-center justify-center {{ $iconColor }} border border-black/5">
                                <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-[13px] font-bold text-gray-800 truncate group-hover:text-blue-600 transition-colors uppercase tracking-tight">
                                    {{ $log->action }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[11px] font-medium text-gray-500 truncate">
                                        {{ $log->user ? $log->user->name : 'System' }}
                                    </span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">
                                        {{ $log->created_at->diffForHumans(null, true) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-20 text-center flex flex-col items-center">
                            <i data-lucide="shield-alert" class="w-12 h-12 text-gray-100 mb-2"></i>
                            <p class="text-gray-400 text-sm font-medium">No recent logs found</p>
                        </div>
                    @endforelse
                </div>
            </div>
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