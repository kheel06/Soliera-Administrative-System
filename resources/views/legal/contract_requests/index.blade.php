@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Contract Requests (CRF)</h2>
                <p class="text-sm text-gray-600">Submit and track requests for new contracts.</p>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Create Request
            </button>
        </div>

        <!-- Request Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending Approval</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['pending'] ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Drafting In Progress</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['drafting'] ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <i data-lucide="pen-tool" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Completed (This Month)</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['completed'] ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        <!-- Requests List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">My Requests</h3>
                <div class="flex gap-2">
                    <button class="text-gray-400 hover:text-gray-600"><i data-lucide="filter" class="w-4 h-4"></i></button>
                    <button class="text-gray-400 hover:text-gray-600"><i data-lucide="refresh-cw" class="w-4 h-4"></i></button>
                </div>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($requests as $request)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-full mt-1">
                                <span class="font-bold text-sm">#{{ $request->id }}</span>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">{{ $request->title }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-sm text-gray-500">Requested by: <strong>{{ $request->requester->name ?? 'Unknown' }}</strong></span>
                                    <span class="text-gray-300">&bull;</span>
                                    <span class="text-sm text-gray-500">Dept: <strong>{{ $request->department }}</strong></span>
                                    <span class="text-gray-300">&bull;</span>
                                    <span class="text-sm text-gray-500">Date: {{ $request->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">{{ Str::limit($request->description, 100) }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            @php
                                $statusColor = match($request->status) {
                                    'Approved' => 'bg-green-100 text-green-800',
                                    'In Drafting' => 'bg-blue-100 text-blue-800',
                                    'Completed' => 'bg-gray-100 text-gray-800',
                                    'Rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-yellow-100 text-yellow-800',
                                };
                            @endphp
                            <span class="px-3 py-1 {{ $statusColor }} text-xs font-semibold rounded-full">{{ $request->status }}</span>
                            <div class="flex gap-2 mt-2">
                                <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">View Details</button>
                                <span class="text-gray-300">|</span>
                                <button class="text-sm text-gray-500 hover:text-gray-700">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-gray-500">
                    No contract requests found.
                </div>
                @endforelse
            </div>
            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
