@extends('layouts.app')

@section('title', 'Visitors | Incidents')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Security Incidents</h1>
                <p class="text-sm text-gray-500 mt-1">Log and track visitor-related security incidents and violations.</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <button onclick="document.getElementById('reportIncidentModal').showModal()"
                    class="btn btn-primary bg-[#0a1e3b] hover:bg-[#112f5a] text-white border-none gap-2">
                    <i data-lucide="siren" class="w-4 h-4"></i>
                    Report Incident
                </button>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Open Incidents -->
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Active Incidents</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['open'] }}</div>
                    <div class="text-xs text-orange-600 mt-1 flex items-center gap-1">
                        <i data-lucide="activity" class="w-3 h-3"></i> Require Investigation
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="alert-octagon" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>

            <!-- Critical -->
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Critical Severity</div>
                    <div class="text-3xl font-bold text-red-600">{{ $stats['critical'] }}</div>
                    <div class="text-xs text-red-500 mt-1 flex items-center gap-1">
                        <i data-lucide="flame" class="w-3 h-3"></i> Emergency Level
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="siren" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>

            <!-- Resolved -->
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Resolved (Month)</div>
                    <div class="text-3xl font-bold text-green-600">{{ $stats['resolved_month'] }}</div>
                    <div class="text-xs text-green-600 mt-1 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-3 h-3"></i> Case Closed
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="shield-check" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>
        </div>

        <!-- Incident List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">Incident</th>
                            <th class="px-6 py-4 font-bold">Location</th>
                            <th class="px-6 py-4 font-bold">Severity</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold">Date</th>
                            <th class="px-6 py-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($incidents as $incident)
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="font-bold text-gray-800">{{ $incident->title }}</div>
                                                    <div class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ $incident->description }}</div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    <div class="flex items-center gap-1">
                                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-400"></i>
                                                        {{ $incident->location }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    @php
                                                        $severityColors = [
                                                            'Low' => 'bg-gray-100 text-gray-600',
                                                            'Medium' => 'bg-amber-100 text-amber-600',
                                                            'High' => 'bg-orange-100 text-orange-600',
                                                            'Critical' => 'bg-red-100 text-red-600'
                                                        ];
                                                    @endphp
                             <span
                                                        class="px-2 py-1 rounded text-xs font-bold uppercase {{ $severityColors[$incident->severity] ?? 'bg-gray-100 text-gray-600' }}">
                                                        {{ $incident->severity }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                                        <span class="w-2 h-2 rounded-full 
                                                                    {{ $incident->status === 'Open' ? 'bg-red-500' :
                                ($incident->status === 'Resolved' ? 'bg-green-500' : 'bg-blue-500') }}">
                                                        </span>
                                                        {{ $incident->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $incident->incident_date->format('M d, Y') }}<br>
                                                    <span class="text-xs text-gray-400">{{ $incident->incident_date->format('h:i A') }}</span>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <button class="btn btn-ghost btn-xs">View</button>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <i data-lucide="shield-check" class="w-12 h-12 mx-auto mb-3 opacity-20"></i>
                                    <p>No incidents reported.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($incidents->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $incidents->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Report Modal -->
    <dialog id="reportIncidentModal" class="modal">
        <div class="modal-box bg-white rounded-2xl p-0 overflow-hidden max-w-lg">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-lg text-gray-800">Report Security Incident</h3>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-gray-500">✕</button>
                </form>
            </div>

            <form action="{{ route('visitors.incidents.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Incident Title</label>
                    <input type="text" name="title" required
                        class="w-full rounded-lg border-gray-300 focus:border-[#0a1e3b] focus:ring-[#0a1e3b]"
                        placeholder="e.g. Unauthorized Access Attempt">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Severity</label>
                        <select name="severity"
                            class="w-full rounded-lg border-gray-300 focus:border-[#0a1e3b] focus:ring-[#0a1e3b]">
                            <option>Low</option>
                            <option selected>Medium</option>
                            <option>High</option>
                            <option>Critical</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date & Time</label>
                        <input type="datetime-local" name="incident_date" required
                            class="w-full rounded-lg border-gray-300 focus:border-[#0a1e3b] focus:ring-[#0a1e3b]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" required
                        class="w-full rounded-lg border-gray-300 focus:border-[#0a1e3b] focus:ring-[#0a1e3b]"
                        placeholder="e.g. Main Lobby, Parking Lot B">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" required
                        class="w-full rounded-lg border-gray-300 focus:border-[#0a1e3b] focus:ring-[#0a1e3b]"
                        placeholder="Describe what happened..."></textarea>
                </div>

                <div class="pt-4 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('reportIncidentModal').close()"
                        class="btn btn-ghost hover:bg-gray-100">Cancel</button>
                    <button type="submit"
                        class="btn btn-primary bg-[#0a1e3b] hover:bg-[#112f5a] text-white border-none">Submit
                        Report</button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection