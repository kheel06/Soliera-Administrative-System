@extends('layouts.app')

@section('title', 'Executive | Governance Overview')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Executive Dashboard - Governance Overview</h1>
                <p class="text-sm text-gray-500 mt-1">Real-time insights across Legal, Compliance, and Operations</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('executive.kpis') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                    View Reports
                </a>
                <a href="{{ route('executive.audit_logs') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="file-search" class="w-4 h-4"></i>
                    Audit Logs
                </a>
            </div>
        </div>

        <!-- KPI Cards Section -->
        <!-- KPI Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <!-- Card 1: Active Contracts -->
            <a href="{{ route('executive.contracts') }}" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Active Contracts</h3>
                            <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['active_contracts'] }}</p>
                        </div>
                        <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="file-text" class="w-6 h-6 text-amber-500"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-semibold text-emerald-600">
                        <i data-lucide="trending-up" class="w-3.5 h-3.5 mr-1.5"></i>
                        <span>Stable Portfolio</span>
                    </div>
                </div>
            </a>

            <!-- Card 2: Expiring Contracts -->
            <a href="{{ route('executive.contracts') }}?filter=expiring" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Expiring (30 Days)</h3>
                            <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['expiring_contracts'] }}</p>
                        </div>
                        <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="clock" class="w-6 h-6 text-amber-500"></i>
                        </div>
                    </div>
                    @php $hasExpiring = $stats['expiring_contracts'] > 0; @endphp
                    <div
                        class="mt-4 flex items-center text-xs font-semibold {{ $hasExpiring ? 'text-amber-600' : 'text-gray-500' }}">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 mr-1.5"></i>
                        <span>{{ $hasExpiring ? 'Requires Attention' : 'No Urgent Items' }}</span>
                    </div>
                </div>
            </a>

            <!-- Card 3: Permits for Renewal -->
            <a href="{{ route('executive.permits') }}" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Permits for Renewal
                            </h3>
                            <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['permits_renewal'] }}</p>
                        </div>
                        <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="file-check" class="w-6 h-6 text-amber-500"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-semibold text-blue-600">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1.5"></i>
                        <span>Within 60 days</span>
                    </div>
                </div>
            </a>

            <!-- Card 4: High-Risk Cases -->
            <a href="{{ route('executive.cases') }}" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">High-Risk Cases</h3>
                            <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['high_risk_cases'] }}</p>
                        </div>
                        <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-amber-500"></i>
                        </div>
                    </div>
                    @php $hasRisk = $stats['high_risk_cases'] > 0; @endphp
                    <div
                        class="mt-4 flex items-center text-xs font-semibold {{ $hasRisk ? 'text-red-600' : 'text-gray-500' }}">
                        <i data-lucide="shield" class="w-3.5 h-3.5 mr-1.5"></i>
                        <span>{{ $hasRisk ? 'Active Monitoring' : 'All Clear' }}</span>
                    </div>
                </div>
            </a>

            <!-- Card 5: Open Obligations -->
            <a href="{{ route('executive.contracts') }}" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Open Obligations</h3>
                            <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['open_obligations'] }}</p>
                        </div>
                        <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="list-checks" class="w-6 h-6 text-amber-500"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-semibold text-purple-600">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5 mr-1.5"></i>
                        <span>Track Deadlines</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Contract Status Chart -->
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800">Contract Status Distribution</h3>
                    <a href="{{ route('executive.contracts') }}"
                        class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                        View All <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="h-64">
                    <canvas id="contractStatusChart"></canvas>
                </div>
            </div>

            <!-- Contracts by Risk Level -->
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800">Contracts by Value Risk</h3>
                    <a href="{{ route('executive.risk') }}"
                        class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                        Risk Overview <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="h-64">
                    <canvas id="riskLevelChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Compliance Trend Chart -->
        <div class="bg-white p-5 rounded-xl shadow-sm mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800">Compliance Status Trend (6 Months)</h3>
                <a href="{{ route('executive.permits') }}"
                    class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                    View Permits <i data-lucide="external-link" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="h-72">
                <canvas id="complianceTrendChart"></canvas>
            </div>
        </div>

        <!-- Case Overview Section -->
        <div class="bg-white p-5 rounded-xl shadow-sm mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800">Cases & Disputes Overview</h3>
                <a href="{{ route('executive.cases') }}"
                    class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                    Manage Cases <i data-lucide="external-link" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Open Cases -->
                <div class="p-4 rounded-xl bg-blue-50 border border-blue-100">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-600 uppercase">Open Cases</span>
                        <i data-lucide="folder-open" class="w-4 h-4 text-blue-500"></i>
                    </div>
                    <div class="text-2xl font-bold text-blue-900 mt-2">{{ $casesOverview['open'] }}</div>
                    <div class="text-[10px] text-blue-600 mt-1 italic">Awaiting resolution</div>
                </div>
                <!-- In Progress -->
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-100">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-600 uppercase">Ongoing</span>
                        <i data-lucide="activity" class="w-4 h-4 text-amber-500"></i>
                    </div>
                    <div class="text-2xl font-bold text-amber-900 mt-2">{{ $casesOverview['in_progress'] }}</div>
                    <div class="text-[10px] text-amber-600 mt-1 italic">Active litigation</div>
                </div>
                <!-- Urgent -->
                <div class="p-4 rounded-xl bg-red-50 border border-red-100">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-red-600 uppercase">Urgent Items</span>
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-500"></i>
                    </div>
                    <div class="text-2xl font-bold text-red-900 mt-2">{{ $casesOverview['urgent'] }}</div>
                    <div class="text-[10px] text-red-600 mt-1 italic">Requires immediate action</div>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
            <!-- High Risk Approvals Pending -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-gray-800">High-Risk Approvals Pending</h3>
                    <a href="{{ route('executive.approvals') }}"
                        class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                        View All <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Entity</th>
                                <th class="px-4 py-3">Counterparty</th>
                                <th class="px-4 py-3">Priority</th>
                                <th class="px-4 py-3">Age</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($highRiskApprovals as $approval)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $approval->department }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $approval->counterparty_name }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full 
                                                                                    {{ $approval->priority === 'urgent' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ ucfirst($approval->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $approval->created_at->diffForHumans() }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('executive.approvals') }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center">
                                        <div class="flex flex-col items-center text-gray-400">
                                            <i data-lucide="check-circle-2" class="w-12 h-12 mb-2"></i>
                                            <p>No pending high-risk approvals</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contracts Awaiting Signature -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-gray-800">Contracts Awaiting Signature</h3>
                    <a href="{{ route('executive.contracts') }}?status=pending"
                        class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                        View All <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Contract</th>
                                <th class="px-4 py-3">Counterparty</th>
                                <th class="px-4 py-3">Value</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($contractsAwaitingApproval as $contract)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900 truncate max-w-[200px]"
                                            title="{{ $contract->title }}">
                                            {{ Str::limit($contract->title, 30) }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $contract->type }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $contract->counterparty_name }}</td>
                                    <td class="px-4 py-3 text-gray-800 font-medium">
                                        ₱{{ number_format($contract->contract_value, 2) }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('legal.contracts.details', $contract->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                            <i data-lucide="file-signature" class="w-4 h-4"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center">
                                        <div class="flex flex-col items-center text-gray-400">
                                            <i data-lucide="file-check" class="w-12 h-12 mb-2"></i>
                                            <p>No contracts awaiting signature</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Upcoming Renewals -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-5 py-4 border-b flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800">Upcoming Renewals (Next 90 Days)</h3>
                <a href="{{ route('executive.renewals') }}"
                    class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                    Calendar View <i data-lucide="calendar" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Item</th>
                            <th class="px-4 py-3">Counterparty/Authority</th>
                            <th class="px-4 py-3">Expiration</th>
                            <th class="px-4 py-3">Days Left</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($upcomingRenewals as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full 
                                                                                {{ $item['type'] === 'Contract' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $item['type'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ Str::limit($item['title'], 35) }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $item['counterparty'] }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ \Carbon\Carbon::parse($item['expiration_date'])->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    @php $days = $item['days_remaining']; @endphp
                                    <span
                                        class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full 
                                                                                {{ $days <= 14 ? 'bg-red-100 text-red-700' : ($days <= 30 ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-700') }}">
                                        {{ $days }} days
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ $item['url'] }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center">
                                    <div class="flex flex-col items-center text-gray-400">
                                        <i data-lucide="calendar-check" class="w-12 h-12 mb-2"></i>
                                        <p>No upcoming renewals in the next 90 days</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bottom Row: Audit Logs & Department Summary -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <!-- Recent Audit Events -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-gray-800">Recent Audit Events</h3>
                    <a href="{{ route('executive.audit_logs') }}"
                        class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                        View All <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="overflow-x-auto max-h-72 overflow-y-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-3">User</th>
                                <th class="px-4 py-3">Action</th>
                                <th class="px-4 py-3">Module</th>
                                <th class="px-4 py-3">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($auditLogs as $log)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ $log->user ? ($log->user->employee_name ?? $log->user->name) : 'System' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $log->action }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="inline-flex px-2 py-0.5 text-xs font-medium rounded bg-gray-100 text-gray-700">
                                            {{ $log->metadata['module'] ?? 'System' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $log->created_at->format('M d, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                        No recent audit events
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Department Contract Summary -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-gray-800">Contract Value by Department</h3>
                    <a href="{{ route('executive.contracts') }}"
                        class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                        Details <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="p-5">
                    @forelse($departmentContracts as $dept)
                        <div class="mb-4 last:mb-0">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">{{ $dept->department }}</span>
                                <span class="text-gray-600">₱{{ number_format($dept->total_value, 0) }} ({{ $dept->count }}
                                    contracts)</span>
                            </div>
                            @php
                                $maxValue = $departmentContracts->max('total_value') ?: 1;
                                $percentage = ($dept->total_value / $maxValue) * 100;
                            @endphp
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-8">
                            <i data-lucide="building-2" class="w-12 h-12 mx-auto mb-2"></i>
                            <p>No department data available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Contract Status Doughnut Chart
            const contractStatusCtx = document.getElementById('contractStatusChart').getContext('2d');
            new Chart(contractStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Pending', 'Expired', 'Terminated'],
                    datasets: [{
                        data: [
                                            {{ $contractStatusData['active'] }},
                                            {{ $contractStatusData['pending'] }},
                                            {{ $contractStatusData['expired'] }},
                            {{ $contractStatusData['terminated'] }}
                        ],
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#6B7280'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
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
                    cutout: '60%'
                }
            });

            // Risk Level Doughnut Chart
            const riskLevelCtx = document.getElementById('riskLevelChart').getContext('2d');
            new Chart(riskLevelCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Low Risk (<₱10K)', 'Medium Risk (₱10K-50K)', 'High Risk (>₱50K)'],
                    datasets: [{
                        data: [
                                            {{ $contractRiskData['low'] }},
                                            {{ $contractRiskData['medium'] }},
                            {{ $contractRiskData['high'] }}
                        ],
                        backgroundColor: ['#22C55E', '#F59E0B', '#EF4444'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
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
                    cutout: '60%'
                }
            });

            // Compliance Trend Line Chart
            const complianceTrendCtx = document.getElementById('complianceTrendChart').getContext('2d');
            new Chart(complianceTrendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(collect($complianceTrend)->pluck('month')) !!},
                    datasets: [
                        {
                            label: 'Active Permits',
                            data: {!! json_encode(collect($complianceTrend)->pluck('active')) !!},
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'In Renewal',
                            data: {!! json_encode(collect($complianceTrend)->pluck('renewal')) !!},
                            borderColor: '#F59E0B',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Expired',
                            data: {!! json_encode(collect($complianceTrend)->pluck('expired')) !!},
                            borderColor: '#EF4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
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
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
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