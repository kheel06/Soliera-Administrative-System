@extends('layouts.app')

@section('title', 'Reports | Audit Logs')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">System Audit Logs</h1>
                    <p class="text-sm text-gray-500 mt-1">Track and review all system activities and security events.</p>
                </div>
                <div class="flex gap-2 mt-4 md:mt-0">
                    <a href="{{ route('access.audit_logs.export') }}"
                        class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Export Logs
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-8">
                <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
                    <div class="w-full md:w-auto">
                        <!-- Left side content if any, or empty space -->
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        <form method="GET" action="{{ route('reports.audit_logs') }}"
                            class="relative flex-grow md:flex-grow-0">
                            @if(request('user_id'))
                                <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                            @endif
                            @if(request('action'))
                                <input type="hidden" name="action" value="{{ request('action') }}">
                            @endif
                            @if(request('date_from'))
                                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                            @endif
                            @if(request('date_to'))
                                <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                            @endif

                            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search logs..."
                                class="pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-[#EDA900] focus:border-[#EDA900] w-full md:w-64">
                        </form>

                        <!-- Filter Dropdown -->
                        <div class="relative" x-data="{ openFilters: false }" @click.away="openFilters = false">
                            <button @click="openFilters = !openFilters"
                                class="px-3 py-2 rounded-lg bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] flex items-center gap-2 transition-colors duration-200">
                                <i data-lucide="filter" class="w-4 h-4 text-[#0A1829]"></i>
                            </button>
                            <div x-show="openFilters"
                                class="absolute right-0 z-20 mt-2 w-80 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none p-4"
                                style="display: none;">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-sm font-semibold text-gray-700">Filters</h3>
                                    <a href="{{ route('reports.audit_logs') }}"
                                        class="text-xs text-[#0A1829] hover:text-gray-900">Clear All</a>
                                </div>
                                <form method="GET" action="{{ route('reports.audit_logs') }}" class="space-y-3">
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif

                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Performed By</label>
                                        <select name="user_id"
                                            class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <option value="">All Users</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->Dept_no }}" {{ request('user_id') == $user->Dept_no ? 'selected' : '' }}>
                                                    {{ $user->employee_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Action Type</label>
                                        <select name="action"
                                            class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <option value="">All Activities</option>
                                            <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Logins
                                            </option>
                                            <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>
                                                Logouts</option>
                                            <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>
                                                Creation</option>
                                            <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>
                                                Updates</option>
                                            <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>
                                                Deletions</option>
                                            <option value="document_view" {{ request('action') == 'document_view' ? 'selected' : '' }}>Document Views</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Date Range</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                                class="w-full text-xs border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                                class="w-full text-xs border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] text-sm font-medium py-2 rounded-lg transition-colors duration-200">Apply
                                        Filters</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logs Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    Timestamp</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    Performed By</th>
                                <th
                                    class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">
                                    Action</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">
                                    IP Address</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Details
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($logs as $log)
                                @php
                                    $actionStyle = match (true) {
                                        str_contains($log->action, 'delete') => 'bg-red-50 text-red-600 border-red-100',
                                        str_contains($log->action, 'create') || str_contains($log->action, 'add') => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        str_contains($log->action, 'update') || str_contains($log->action, 'edit') => 'bg-amber-50 text-amber-600 border-amber-100',
                                        str_contains($log->action, 'login') => 'bg-blue-50 text-blue-600 border-blue-100',
                                        default => 'bg-gray-50 text-gray-600 border-gray-100',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition-all group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-[11px] font-bold text-gray-800 leading-none mb-1">
                                            {{ $log->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 font-medium uppercase tracking-tighter">
                                            {{ $log->created_at->format('H:i:s') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            @if(isset($log->user->profile_picture) && $log->user->profile_picture)
                                                <img src="{{ asset('storage/' . $log->user->profile_picture) }}"
                                                    alt="{{ $log->user->name }}"
                                                    class="w-8 h-8 rounded-full border border-gray-100 shadow-sm object-cover">
                                            @else
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-[10px] font-black text-blue-600 shadow-sm">
                                                    {{ strtoupper(substr($log->user->name ?? 'S', 0, 2)) }}
                                                </div>
                                            @endif
                                            <span
                                                class="text-xs font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition-colors">{{ $log->user->name ?? 'System' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span
                                            class="px-2.5 py-1 text-[10px] font-black rounded-lg border {{ $actionStyle }} uppercase tracking-widest shadow-sm">
                                            {{ str_replace('_', ' ', $log->action) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <code
                                            class="text-[10px] font-mono bg-gray-100 px-1.5 py-0.5 rounded text-gray-500 border border-gray-200">{{ $log->ip_address ?? '0.0.0.0' }}</code>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[11px] text-gray-600 font-medium leading-relaxed max-w-sm truncate"
                                            title="{{ is_string($log->details) ? $log->details : json_encode($log->details) }}">
                                            {{ Str::limit(is_string($log->details) ? $log->details : json_encode($log->details), 60) }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                <i data-lucide="shield-alert" class="w-8 h-8 text-gray-200"></i>
                                            </div>
                                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No audit logs
                                                found</p>
                                            <p class="text-xs text-gray-400 mt-1 uppercase tracking-tighter">Try adjusting your
                                                filter criteria</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                        {{ $logs->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection