@extends('layouts.app')

@section('title', 'Executive | Renewal Calendar')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Renewal Calendar</h1>
                <p class="text-sm text-gray-500 mt-1">Track upcoming permit and license renewals</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('executive.permits') }}" class="btn btn-outline btn-sm gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Compliance Center
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Overdue -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Overdue</h3>
                        <p class="text-3xl font-bold mt-1 {{ $stats['overdue'] > 0 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $stats['overdue'] }}</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="alert-circle" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>
                <div
                    class="mt-4 flex items-center text-xs font-semibold {{ $stats['overdue'] > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                    <i data-lucide="{{ $stats['overdue'] > 0 ? 'alert-triangle' : 'check-circle' }}"
                        class="w-3.5 h-3.5 mr-1.5"></i>
                    <span>{{ $stats['overdue'] > 0 ? 'Action Required' : 'All Clear' }}</span>
                </div>
            </div>

            <!-- Next 30 Days -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Next 30 Days</h3>
                        <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['next_30_days'] }}</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="calendar-clock" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>
                <div
                    class="mt-4 flex items-center text-xs font-semibold {{ $stats['next_30_days'] > 0 ? 'text-amber-600' : 'text-gray-500' }}">
                    <i data-lucide="clock" class="w-3.5 h-3.5 mr-1.5"></i>
                    <span>{{ $stats['next_30_days'] > 0 ? 'Urgent Priority' : 'No Immediate Renewals' }}</span>
                </div>
            </div>

            <!-- Next 60 Days -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Next 60 Days</h3>
                        <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['next_60_days'] }}</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="calendar-days" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-semibold text-blue-600">
                    <i data-lucide="eye" class="w-3.5 h-3.5 mr-1.5"></i>
                    <span>Upcoming Review</span>
                </div>
            </div>

            <!-- Next 90 Days -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Next 90 Days</h3>
                        <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['next_90_days'] }}</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="calendar" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-semibold text-gray-500">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5 mr-1.5"></i>
                    <span>Quarterly Outlook</span>
                </div>
            </div>
        </div>

        <!-- Calendar Timeline -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800">Renewal Timeline</h3>
            </div>
            <div class="p-5">
                @forelse($calendar as $month => $monthPermits)
                    @php
                        $monthDate = \Carbon\Carbon::parse($month . '-01');
                        $isCurrentMonth = $monthDate->isCurrentMonth();
                        $isPast = $monthDate->lt(now()->startOfMonth());
                    @endphp
                    <div class="mb-6 last:mb-0">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-24 flex-shrink-0">
                                <span
                                    class="text-lg font-bold {{ $isCurrentMonth ? 'text-blue-600' : ($isPast ? 'text-gray-400' : 'text-gray-700') }}">
                                    {{ $monthDate->format('M Y') }}
                                </span>
                            </div>
                            <div class="flex-1 h-px bg-gray-200"></div>
                            <span class="text-sm text-gray-500">{{ count($monthPermits) }}
                                {{ Str::plural('item', count($monthPermits)) }}</span>
                        </div>

                        <div class="ml-8 space-y-2">
                            @foreach($monthPermits as $permit)
                                <div
                                    class="flex items-center gap-4 p-3 rounded-lg border hover:bg-gray-50 transition-colors
                                                                        {{ $permit['days_left'] < 0 ? 'border-red-200 bg-red-50' : '' }}
                                                                        {{ $permit['days_left'] >= 0 && $permit['days_left'] <= 14 ? 'border-amber-200 bg-amber-50' : '' }}
                                                                        {{ $permit['days_left'] > 14 && $permit['days_left'] <= 30 ? 'border-yellow-200 bg-yellow-50' : '' }}
                                                                        {{ $permit['days_left'] > 30 ? 'border-gray-200 bg-white' : '' }}">

                                    <!-- Date Badge -->
                                    <div class="w-16 text-center flex-shrink-0">
                                        <div
                                            class="text-2xl font-bold {{ $permit['days_left'] < 0 ? 'text-red-600' : 'text-gray-800' }}">
                                            {{ \Carbon\Carbon::parse($permit['expiration_date'])->format('d') }}
                                        </div>
                                        <div class="text-xs text-gray-500 uppercase">
                                            {{ \Carbon\Carbon::parse($permit['expiration_date'])->format('D') }}
                                        </div>
                                    </div>

                                    <!-- Permit Info -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate">{{ $permit['name'] }}</h4>
                                        <p class="text-sm text-gray-500">{{ $permit['authority'] ?? 'N/A' }}</p>
                                    </div>

                                    <!-- Status -->
                                    <div class="text-right flex-shrink-0">
                                        @if($permit['days_left'] < 0)
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                                Overdue
                                            </span>
                                            <p class="text-xs text-red-600 mt-1">{{ abs($permit['days_left']) }} days ago</p>
                                        @elseif($permit['days_left'] <= 7)
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                                Critical
                                            </span>
                                            <p class="text-xs text-red-600 mt-1">{{ $permit['days_left'] }} days left</p>
                                        @elseif($permit['days_left'] <= 30)
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-amber-100 text-amber-700">
                                                Urgent
                                            </span>
                                            <p class="text-xs text-amber-600 mt-1">{{ $permit['days_left'] }} days left</p>
                                        @else
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                                Upcoming
                                            </span>
                                            <p class="text-xs text-gray-500 mt-1">{{ $permit['days_left'] }} days left</p>
                                        @endif
                                    </div>

                                    <!-- Action -->
                                    <a href="{{ route('compliance.permits') }}" class="btn btn-ghost btn-sm flex-shrink-0"
                                        title="View Permit">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-400">
                        <i data-lucide="calendar" class="w-16 h-16 mx-auto mb-4"></i>
                        <p class="text-lg font-medium">No upcoming renewals</p>
                        <p class="text-sm">All permits are up to date</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Legend -->
        <div class="mt-6 flex flex-wrap gap-4 justify-center text-sm">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-red-100 border border-red-200"></div>
                <span class="text-gray-600">Overdue / Critical (≤7 days)</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-amber-100 border border-amber-200"></div>
                <span class="text-gray-600">Urgent (8-30 days)</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-gray-100 border border-gray-200"></div>
                <span class="text-gray-600">Upcoming (>30 days)</span>
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