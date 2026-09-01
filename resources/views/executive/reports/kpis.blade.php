@extends('layouts.app')

@section('title', 'Executive | Reports & KPIs')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Reports & KPIs</h1>
                <p class="text-sm text-gray-500 mt-1">Executive performance dashboard and analytics</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">

                <a href="{{ route('executive.audit_logs') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="file-search" class="w-4 h-4"></i>
                    Audit Logs
                </a>
            </div>
        </div>

        <!-- Legal KPIs -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="gavel" class="w-5 h-5 text-blue-600"></i>
                Legal Governance
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Contracts</h3>
                            <p class="text-2xl font-bold mt-1 text-gray-900">{{ $legalKpis['total_contracts'] }}</p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="file-text" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Active Contracts</h3>
                            <p class="text-2xl font-bold mt-1 text-emerald-600">{{ $legalKpis['active_contracts'] }}</p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="trending-up" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Portfolio Value</h3>
                            <p class="text-lg font-bold mt-1 text-blue-600">
                                ₱{{ number_format($legalKpis['contracts_value'], 0) }}</p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="dollar-sign" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Expiring (30d)</h3>
                            <p class="text-2xl font-bold mt-1 text-amber-600">{{ $legalKpis['expiring_30d'] }}</p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="clock" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Open Cases</h3>
                            <p class="text-2xl font-bold mt-1 text-purple-600">{{ $legalKpis['open_cases'] }}</p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="briefcase" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Urgent Cases</h3>
                            <p class="text-2xl font-bold mt-1 text-red-600">{{ $legalKpis['urgent_cases'] }}</p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Compliance KPIs -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-green-600"></i>
                Compliance Status
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Permits</h3>
                            <p class="text-2xl font-bold mt-1 text-gray-900">{{ $complianceKpis['total_permits'] }}</p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="shield" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Active Permits</h3>
                            <p class="text-2xl font-bold mt-1 text-emerald-600">{{ $complianceKpis['active_permits'] }}</p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="check-circle" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Expired</h3>
                            <p
                                class="text-2xl font-bold mt-1 {{ $complianceKpis['expired_permits'] > 0 ? 'text-red-600' : 'text-gray-800' }}">
                                {{ $complianceKpis['expired_permits'] }}
                            </p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="x-circle" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Pending Renewals</h3>
                            <p class="text-2xl font-bold mt-1 text-amber-600">{{ $complianceKpis['pending_renewals'] }}</p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="rotate-cw" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Compliance Rate</h3>
                            <p
                                class="text-2xl font-bold mt-1 {{ $complianceKpis['compliance_rate'] >= 90 ? 'text-emerald-600' : ($complianceKpis['compliance_rate'] >= 70 ? 'text-amber-600' : 'text-red-600') }}">
                                {{ $complianceKpis['compliance_rate'] }}%
                            </p>
                        </div>
                        <div class="p-2 bg-[#0a1e3b] rounded-xl shadow-inner">
                            <i data-lucide="activity" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                    <div class="mt-2 w-full bg-gray-100 rounded-full h-1">
                        <div class="h-1 rounded-full {{ $complianceKpis['compliance_rate'] >= 90 ? 'bg-emerald-500' : ($complianceKpis['compliance_rate'] >= 70 ? 'bg-amber-500' : 'bg-red-500') }}"
                            style="width: {{ $complianceKpis['compliance_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Monthly Trends Chart -->
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4">Activity Trends (6 Months)</h3>
                <div class="h-64">
                    <canvas id="trendsChart"></canvas>
                </div>
            </div>

            <!-- Department Performance -->
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4">Contract Value by Department</h3>
                <div class="space-y-4">
                    @forelse($departmentPerformance as $dept)
                        @php
                            $maxValue = $departmentPerformance->max('total_value') ?: 1;
                            $percentage = ($dept->total_value / $maxValue) * 100;
                        @endphp
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">{{ $dept->department }}</span>
                                <span class="text-gray-600">₱{{ number_format($dept->total_value, 0) }} ({{ $dept->contracts }}
                                    contracts)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-8">
                            <p>No department data available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Additional KPIs Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Visitor KPIs -->
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="users" class="w-5 h-5 text-purple-600"></i>
                    Visitor Activity (30 Days)
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Visitors</span>
                        <span class="font-bold text-xl">{{ $visitorKpis['total_visitors_30d'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Daily Average</span>
                        <span class="font-bold text-xl">{{ $visitorKpis['avg_daily_visitors'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Violations</span>
                        <span
                            class="font-bold text-xl {{ $visitorKpis['violations_30d'] > 0 ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $visitorKpis['violations_30d'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Document KPIs -->
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                    Document Vault
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Documents</span>
                        <span class="font-bold text-xl">{{ $documentKpis['total_documents'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">New (30 Days)</span>
                        <span class="font-bold text-xl text-blue-600">{{ $documentKpis['documents_30d'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Audit KPIs -->
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="shield" class="w-5 h-5 text-green-600"></i>
                    Audit Activity (30 Days)
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Events</span>
                        <span class="font-bold text-xl">{{ $auditStats['total_logs_30d'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Active Users</span>
                        <span class="font-bold text-xl text-green-600">{{ $auditStats['unique_users_30d'] }}</span>
                    </div>
                </div>
                <a href="{{ route('executive.audit_logs') }}"
                    class="mt-4 inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
                    View Audit Logs <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Activity Trends Chart
            const trendsCtx = document.getElementById('trendsChart').getContext('2d');
            new Chart(trendsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(collect($monthlyTrends)->pluck('month')) !!},
                    datasets: [
                        {
                            label: 'Contracts',
                            data: {!! json_encode(collect($monthlyTrends)->pluck('contracts')) !!},
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Cases',
                            data: {!! json_encode(collect($monthlyTrends)->pluck('cases')) !!},
                            borderColor: '#8B5CF6',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Visitors',
                            data: {!! json_encode(collect($monthlyTrends)->pluck('visitors')) !!},
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4
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