@extends('layouts.app')

@section('title', 'Violation Reports')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Violation Reports</h1>
                <a href="{{ route('legal.violation_reports.create') }}" class="bg-[#F7B32B] text-[#001F54] px-4 py-2 rounded-lg hover:bg-[#f5a623] transition-colors flex items-center">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Report Violation
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                               placeholder="Report ID, Name, Description...">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                            <option value="">All Status</option>
                            <option value="reported" {{ request('status') == 'reported' ? 'selected' : '' }}>Reported</option>
                            <option value="under_investigation" {{ request('status') == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="dismissed" {{ request('status') == 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                        </select>
                    </div>
                    <div>
                        <label for="severity" class="block text-sm font-medium text-gray-700">Severity</label>
                        <select name="severity" id="severity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                            <option value="">All Severity</option>
                            <option value="low" {{ request('severity') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('severity') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('severity') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-[#F7B32B] text-[#001F54] px-4 py-2 rounded-lg hover:bg-[#f5a623] transition-colors flex items-center">
                            <i data-lucide="search" class="w-4 h-4 mr-2"></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Violation Reports Table -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                @if($reports->count() > 0)
                    <x-table-card :title="'Violation Reports'" :pagination="$reports->links()">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reporter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Violator</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reports as $report)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $report->report_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div>
                                            <div class="font-medium">{{ $report->reporter_name }}</div>
                                            <div class="text-gray-500">{{ $report->reporter_department }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($report->violator_name)
                                            <div>
                                                <div class="font-medium">{{ $report->violator_name }}</div>
                                                <div class="text-gray-500">{{ $report->violator_department }}</div>
                                            </div>
                                        @else
                                            <span class="text-gray-400">Not specified</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $report->violation_type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $report->severity_color }}">
                                            {{ ucfirst($report->severity) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $report->status_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $report->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('legal.violation_reports.show', $report->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </x-table-card>
                @else
                    <div class="text-center py-8">
                        <i data-lucide="flag" class="w-16 h-16 text-gray-400 mb-4 mx-auto"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No violation reports found</h3>
                        <p class="text-gray-500 mb-4">No reports match your current filters.</p>
                        <a href="{{ route('legal.violation_reports.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors inline-flex items-center">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Report Violation
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush
@endsection
