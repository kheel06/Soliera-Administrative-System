@extends('layouts.app')

@section('title', 'Compliance | Renewals')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Renewal Management</h1>
                <p class="text-sm text-gray-500 mt-1">Timeline of upcoming permit and license renewals.</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('compliance.permits') }}" class="btn btn-outline btn-sm gap-2">
                    <i data-lucide="shield" class="w-4 h-4"></i>
                    All Permits
                </a>
            </div>
        </div>

        @php
            $expiringCount = $permits->where('expiration_date', '<=', now()->addDays(30))->count();
            $overdueCount = $permits->where('expiration_date', '<', now())->count();
        @endphp

        <!-- Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Overdue</h3>
                        <p class="text-3xl font-bold mt-1 {{ $overdueCount > 0 ? 'text-red-500' : 'text-gray-900' }}">{{ $overdueCount }}</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="alert-octagon" class="w-6 h-6 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Due This Month</h3>
                        <p class="text-3xl font-bold mt-1 text-amber-500">{{ $expiringCount }}</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="calendar-days" class="w-6 h-6 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                <h3 class="font-bold text-[#0a1e3b] text-sm uppercase tracking-wider">Upcoming Deadlines</h3>
            </div>
            <div class="p-6">
                @forelse($permits->groupBy(fn($p) => $p->expiration_date ? $p->expiration_date->format('F Y') : 'No Date') as $month => $monthPermits)
                    <div class="mb-10 last:mb-0 relative">
                        <!-- Month Header -->
                        <div class="flex items-center gap-4 mb-6">
                            <div class="bg-[#0a1e3b] text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/10">
                                {{ $month }}
                            </div>
                            <div class="flex-1 h-px bg-gray-100"></div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ count($monthPermits) }} Items</div>
                        </div>

                        <!-- Permits in Month -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ml-4 border-l-2 border-gray-50 pl-8">
                            @foreach($monthPermits as $permit)
                                @php
                                    $daysLeft = $permit->expiration_date ? now()->diffInDays($permit->expiration_date, false) : null;
                                    $isUrgent = $daysLeft !== null && $daysLeft <= 14;
                                    $isOverdue = $daysLeft !== null && $daysLeft < 0;
                                @endphp
                                <div class="bg-white p-5 rounded-2xl border transition-all duration-300 hover:shadow-md group relative
                                    {{ $isOverdue ? 'border-red-100 hover:border-red-200 bg-red-50/30' : 'border-gray-100 hover:border-amber-200' }}">
                                    
                                    @if($isUrgent)
                                        <div class="absolute -top-2 -right-2 bg-red-500 text-white p-1.5 rounded-full shadow-lg h-6 w-6 flex items-center justify-center animate-pulse">
                                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-start mb-3">
                                        <div class="p-2 rounded-lg {{ $isOverdue ? 'bg-red-100 text-red-600' : 'bg-amber-50 text-amber-600' }}">
                                            <i data-lucide="file-check" class="w-4 h-4"></i>
                                        </div>
                                        <span class="text-[10px] font-bold uppercase py-1 px-2 rounded {{ $isOverdue ? 'bg-red-200 text-red-700' : 'bg-gray-100 text-gray-600 font-medium' }}">
                                            @if($isOverdue)
                                                Overdue {{ abs($daysLeft) }}d
                                            @elseif($daysLeft !== null)
                                                {{ $daysLeft }} Days Left
                                            @else
                                                TBD
                                            @endif
                                        </span>
                                    </div>

                                    <h4 class="font-bold text-gray-900 group-hover:text-[#0a1e3b] transition-colors line-clamp-1">{{ $permit->name }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $permit->issuing_authority }}</p>

                                    <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-gray-400"></i>
                                            <span class="text-xs font-bold text-gray-700">{{ $permit->expiration_date ? $permit->expiration_date->format('M d, Y') : 'N/A' }}</span>
                                        </div>
                                        <a href="{{ route('compliance.permits') }}" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest hover:text-blue-800 transition-colors">
                                            Renew →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center">
                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="calendar" class="w-10 h-10 text-gray-300"></i>
                        </div>
                        <h3 class="text-gray-400 font-bold uppercase tracking-widest text-sm">No Renewals Found</h3>
                        <p class="text-gray-400 text-xs mt-1 font-medium">Capture permits with expiration dates to see them here.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection

