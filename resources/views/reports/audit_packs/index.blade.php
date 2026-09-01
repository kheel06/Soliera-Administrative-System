@extends('layouts.app')

@section('title', 'Reports | Audit Packs')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Monthly Audit Packs</h2>
                <p class="text-sm text-gray-600">Generate comprehensive compliance reports for auditing.</p>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Generator Form -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="file-plus" class="w-5 h-5 text-blue-500"></i>
                    Generate New Pack
                </h3>
                <form action="{{ route('reports.audit_packs.generate') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Report Month</label>
                            <input type="month" name="month" required class="w-full border-gray-300 rounded-lg" value="{{ date('Y-m') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Module Scope</label>
                            <select name="module" class="w-full border-gray-300 rounded-lg">
                                <option value="all">Full System Audit (All Modules)</option>
                                <option value="facilities">Facilities & Reservations</option>
                                <option value="visitors">Visitor Management</option>
                                <option value="legal">Legal & Contracts</option>
                                <option value="access">Access Control Logs</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Select specific module or generate a full system report.</p>
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                                <i data-lucide="settings-2" class="w-4 h-4"></i>
                                Generate Audit Pack
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Recent Packs -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="history" class="w-5 h-5 text-gray-400"></i>
                    Recent Archives
                </h3>
                <div class="space-y-3">
                    <!-- Simulated History Items -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white rounded-lg border border-gray-200">
                                <i data-lucide="file-check" class="w-5 h-5 text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">December 2025 Full Audit</div>
                                <div class="text-xs text-gray-500">Generated Jan 02, 2026</div>
                            </div>
                        </div>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Download</button>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white rounded-lg border border-gray-200">
                                <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Nov 2025 Visitor Logs</div>
                                <div class="text-xs text-gray-500">Generated Dec 01, 2025</div>
                            </div>
                        </div>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Download</button>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white rounded-lg border border-gray-200">
                                <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Nov 2025 Facilities Report</div>
                                <div class="text-xs text-gray-500">Generated Dec 01, 2025</div>
                            </div>
                        </div>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Download</button>
                    </div>
                </div>
                
                <div class="mt-6 text-center">
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-700">View All Archives</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
