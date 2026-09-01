@extends('layouts.app')

@section('title', 'Executive | Retention Overview')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Document Retention Overview</h1>
                <p class="text-sm text-gray-500 mt-1">Monitor retention policies and disposal history</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('executive.policy_approvals') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="file-check" class="w-4 h-4"></i>
                    Policy Approvals
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Retention Policies</h3>
                        <p class="text-2xl font-bold mt-1 text-blue-600">{{ $stats['total_policies'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="shield-check" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Documents</h3>
                        <p class="text-2xl font-bold mt-1 text-emerald-600">{{ $stats['total_documents'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="folder-open" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Disposed (30d)</h3>
                        <p class="text-2xl font-bold mt-1 text-amber-600">{{ $stats['disposed_30d'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="trash-2" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Disposed</h3>
                        <p class="text-2xl font-bold mt-1 text-gray-900">{{ $stats['disposed_total'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="archive" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Retention Policies -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-gray-800">Active Retention Policies</h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                    @forelse($policies as $policy)
                        <div class="px-4 py-3 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $policy->name }}</p>
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $policy->description ?? 'No description' }}</p>
                                </div>
                                <span class="px-2 py-0.5 text-xs font-medium rounded bg-blue-100 text-blue-700">
                                    {{ $policy->retention_period ?? 'Indefinite' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center text-gray-400">
                            <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-2"></i>
                            <p>No retention policies defined</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Documents by Type -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-gray-800">Documents by Type</h3>
                </div>
                <div class="p-4">
                    @forelse($documentsByType as $type)
                        @php
                            $maxCount = $documentsByType->max('count') ?: 1;
                            $percentage = ($type->count / $maxCount) * 100;
                        @endphp
                        <div class="mb-4 last:mb-0">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">{{ $type->document_type ?? 'General' }}</span>
                                <span class="text-gray-600">{{ $type->count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-8">
                            <p>No document data available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Disposal History -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800">Recent Disposal History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Document</th>
                            <th class="px-4 py-3">Disposed By</th>
                            <th class="px-4 py-3">Reason</th>
                            <th class="px-4 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($disposalHistory as $disposal)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $disposal->document_title ?? 'Unknown Document' }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $disposal->disposed_by_name ?? 'System' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-gray-100 text-gray-600">
                                        {{ $disposal->disposal_reason_display ?? 'Expired' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500 text-xs">
                                    {{ $disposal->disposed_at->format('M d, Y') }}
                                    <div class="text-[10px] text-gray-400">{{ $disposal->disposed_at->diffForHumans() }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                    <i data-lucide="trash-2" class="w-12 h-12 mx-auto mb-2"></i>
                                    <p>No disposal history found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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