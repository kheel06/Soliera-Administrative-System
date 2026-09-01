@extends('layouts.app')

@section('title', 'Executive | Risk & Compliance')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Risk & Compliance Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Monitor compliance status, risks, and corrective actions</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('executive.permits') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="file-check" class="w-4 h-4"></i>
                    View Permits
                </a>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Compliance Score</h3>
                        <p class="text-2xl font-bold mt-1 text-emerald-600">{{ $stats['compliance_score'] }}%</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="shield-check" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
                <div class="mt-3 w-full bg-gray-100 rounded-full h-1">
                    <div class="bg-emerald-500 h-1 rounded-full" style="width: {{ $stats['compliance_score'] }}%"></div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Corrective Actions</h3>
                        <p
                            class="text-2xl font-bold mt-1 {{ $stats['open_corrective_actions'] > 0 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $stats['open_corrective_actions'] }}
                        </p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Visitor Incidents</h3>
                        <p class="text-2xl font-bold mt-1 text-amber-600">{{ $stats['visitor_incidents_30d'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="alert-octagon" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Docs Disposed</h3>
                        <p class="text-2xl font-bold mt-1 text-blue-600">{{ $stats['documents_disposed_30d'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="trash-2" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Overdue Permits</h3>
                        <p
                            class="text-2xl font-bold mt-1 {{ $stats['overdue_permits'] > 0 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $stats['overdue_permits'] }}
                        </p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="clock" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Pending Renewals</h3>
                        <p class="text-2xl font-bold mt-1 text-orange-600">{{ $stats['pending_renewals'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="refresh-ccw" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Compliance Matrix -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800">Compliance Matrix by Category</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Category</th>
                            <th class="px-4 py-3 text-center">Active</th>
                            <th class="px-4 py-3 text-center">In Renewal</th>
                            <th class="px-4 py-3 text-center">Expired</th>
                            <th class="px-4 py-3 text-center">Total</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($matrix as $category => $data)
                            @php
                                $total = $data['total'] ?: 1;
                                $healthScore = ($data['active'] / $total) * 100;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $category }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-medium">
                                        {{ $data['active'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-700 font-medium">
                                        {{ $data['renewal'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $data['expired'] > 0 ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600' }} font-medium">
                                        {{ $data['expired'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center font-medium">{{ $data['total'] }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="h-2 rounded-full transition-all duration-500
                                                        {{ $healthScore >= 80 ? 'bg-emerald-500' : ($healthScore >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                                style="width: {{ $healthScore }}%"></div>
                                        </div>
                                        <span
                                            class="text-xs font-medium {{ $healthScore >= 80 ? 'text-emerald-600' : ($healthScore >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                                            {{ round($healthScore) }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Risk Trend Chart -->
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800">Risk Trend (6 Months)</h3>
                </div>
                <div class="h-64">
                    <canvas id="riskTrendChart"></canvas>
                </div>
            </div>

            <!-- Recent Violations -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-gray-800">Recent Visitor Violations</h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
                    @forelse($recentViolations as $violation)
                        <div class="px-4 py-3 hover:bg-gray-50">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $violation->violation_type ?? 'Unknown' }}</p>
                                    <p class="text-sm text-gray-500 mt-0.5">
                                        {{ Str::limit($violation->description ?? 'No description', 60) }}
                                    </p>
                                </div>
                                <span
                                    class="px-2 py-0.5 text-xs font-medium rounded-full 
                                            {{ ($violation->severity ?? 'low') === 'high' ? 'bg-red-100 text-red-700' : '' }}
                                            {{ ($violation->severity ?? 'low') === 'medium' ? 'bg-amber-100 text-amber-700' : '' }}
                                            {{ ($violation->severity ?? 'low') === 'low' ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ ucfirst($violation->severity ?? 'low') }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">{{ $violation->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center text-gray-400">
                            <i data-lucide="shield-check" class="w-12 h-12 mx-auto mb-2"></i>
                            <p>No recent violations</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Expiring Permits Alert -->
        @if($expiringPermits->count() > 0)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-amber-800">Permits Expiring Soon</h3>
                        <p class="text-sm text-amber-600">The following permits expire within 30 days</p>
                    </div>
                </div>
                <div class="space-y-2">
                    @foreach($expiringPermits as $permit)
                        @php
                            $daysLeft = now()->diffInDays($permit->expiration_date, false);
                        @endphp
                        <div class="flex items-center justify-between bg-white rounded-lg px-4 py-2 border border-amber-100">
                            <div>
                                <p class="font-medium text-gray-900">{{ $permit->name }}</p>
                                <p class="text-xs text-gray-500">{{ $permit->issuing_authority ?? 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium {{ $daysLeft <= 7 ? 'text-red-600' : 'text-amber-600' }}">
                                    {{ $daysLeft }} days left
                                </p>
                                <p class="text-xs text-gray-500">{{ $permit->expiration_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('executive.permits') }}" class="btn btn-warning btn-sm gap-2">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        Manage Permits
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Risk Trend Chart
            const riskTrendCtx = document.getElementById('riskTrendChart').getContext('2d');
            new Chart(riskTrendCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(collect($riskTrend)->pluck('month')) !!},
                    datasets: [
                        {
                            label: 'Visitor Violations',
                            data: {!! json_encode(collect($riskTrend)->pluck('violations')) !!},
                            backgroundColor: '#F59E0B',
                            borderRadius: 4,
                        },
                        {
                            label: 'Expired Permits',
                            data: {!! json_encode(collect($riskTrend)->pluck('expired_permits')) !!},
                            backgroundColor: '#EF4444',
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 20, usePointStyle: true }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });

            // Initialize Lucide icons
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection