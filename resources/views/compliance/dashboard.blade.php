@extends('layouts.app')

@section('title', 'Compliance | Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Compliance Overview</h2>
            <p class="text-gray-600 mt-1">Monitor regulatory status, upcoming renewals, and critical alerts.</p>
        </div>

        <!-- Stats Grid -->
        <!-- Stats Grid (Standardized Design) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Permits -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Permits</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['total_permits'] }}</div>
                     <div class="text-xs text-green-600 mt-1 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-3 h-3"></i> Active
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="file-check" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>

            <!-- Critical Issues -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Critical Issues</div>
                    <div class="text-3xl font-bold text-red-600">{{ $stats['critical_permits'] }}</div>
                    <div class="text-xs text-red-500 mt-1 flex items-center gap-1">
                        <i data-lucide="alert-octagon" class="w-3 h-3"></i> Action Required
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>

            <!-- Upcoming Renewals -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Upcoming Renewals</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['upcoming_renewals'] }}</div>
                    <div class="text-xs text-yellow-600 mt-1 flex items-center gap-1">
                        <i data-lucide="clock" class="w-3 h-3"></i> Next 30 Days
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="calendar" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>

            <!-- Compliance Score -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Compliance Score</div>
                    <div class="text-3xl font-bold text-green-600">{{ $stats['compliance_score'] }}%</div>
                    <div class="text-xs text-gray-500 mt-1">Overall Rating</div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="shield-check" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Expiring Soon -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-yellow-500"></i>
                        Expiring Soon (30 Days)
                    </h3>
                    <a href="{{ route('compliance.permits') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                </div>
                <div class="p-6">
                    @forelse($expiring_soon as $permit)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0 last:pb-0 first:pt-0">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $permit->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $permit->issuing_authority }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-red-600">{{ \Carbon\Carbon::parse($permit->expiration_date)->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($permit->expiration_date)->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <i data-lucide="check-circle" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                            <p>No permits expiring soon.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activity / Quick Actions -->
            <div class="space-y-8">
                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="font-bold text-gray-800">Quick Actions</h3>
                    </div>
                    <div class="p-6 grid grid-cols-2 gap-4">
                        <a href="{{ route('compliance.permits.create') }}" class="flex flex-col items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group cursor-pointer border border-blue-100">
                            <div class="p-3 bg-blue-100 rounded-full text-blue-600 mb-2 group-hover:bg-blue-200 transition-colors">
                                <i data-lucide="plus" class="w-6 h-6"></i>
                            </div>
                            <span class="font-medium text-gray-900">Add Permit</span>
                        </a>
                        <a href="{{ route('compliance.renewals') }}" class="flex flex-col items-center justify-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group cursor-pointer border border-purple-100">
                            <div class="p-3 bg-purple-100 rounded-full text-purple-600 mb-2 group-hover:bg-purple-200 transition-colors">
                                <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                            </div>
                            <span class="font-medium text-gray-900">Process Renewal</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Permits -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="font-bold text-gray-800">Recently Added</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($recent_permits as $permit)
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0 text-gray-500">
                                        <i data-lucide="file-text" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $permit->name }}</h4>
                                        <p class="text-xs text-gray-500">Added {{ $permit->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
