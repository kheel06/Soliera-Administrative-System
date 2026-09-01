@extends('layouts.app')

@section('title', 'Executive | Cases & Disputes')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Cases & Disputes</h1>
                <p class="text-sm text-gray-500 mt-1">Legal case oversight and monitoring</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('executive.contracts') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    View Contracts
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Cases</h3>
                        <p class="text-2xl font-bold mt-1 text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="briefcase" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <a href="?status=pending" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Open</h3>
                            <p class="text-2xl font-bold mt-1 text-amber-600">{{ $stats['open'] }}</p>
                        </div>
                        <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="folder-open" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </a>

            <a href="?status=ongoing" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Ongoing</h3>
                            <p class="text-2xl font-bold mt-1 text-blue-600">{{ $stats['ongoing'] }}</p>
                        </div>
                        <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="activity" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </a>

            <a href="?priority=urgent" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Urgent</h3>
                            <p class="text-2xl font-bold mt-1 text-red-600">{{ $stats['urgent'] }}</p>
                        </div>
                        <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </a>

            <a href="?priority=high" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">High Priority</h3>
                            <p class="text-2xl font-bold mt-1 text-orange-600">{{ $stats['high_priority'] }}</p>
                        </div>
                        <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </a>

            <a href="?status=resolved" class="block group">
                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Resolved</h3>
                            <p class="text-2xl font-bold mt-1 text-emerald-600">{{ $stats['resolved'] }}</p>
                        </div>
                        <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="check-square" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <form method="GET" class="flex flex-col md:flex-row md:items-center gap-4">
                <!-- Search Input -->
                <div class="relative w-full md:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ $search }}"
                        class="input input-bordered input-sm w-full pl-9 rounded-xl bg-white border-gray-200 focus:bg-white transition-all text-xs shadow-sm"
                        placeholder="Case title or description...">
                </div>

                <!-- Status Select (Visible) -->
                <select name="status"
                    class="select select-bordered select-sm rounded-xl text-xs bg-white border-gray-200 focus:border-blue-500 focus:ring-0 shadow-sm font-bold text-gray-600 w-full md:w-40"
                    onchange="this.form.submit()">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ongoing" {{ $status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Settled</option>
                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                <!-- Filter Icon (Priority Only) -->
                <div class="dropdown dropdown-end md:ml-auto">
                    <button type="button" tabindex="0"
                        class="btn btn-sm btn-circle bg-[#F7B32B] border-[#F7B32B] hover:bg-[#e5a220] transition-all shadow-md"
                        title="Filter Priority">
                        <i data-lucide="filter" class="w-4 h-4 text-[#001F54]"></i>
                    </button>
                    <ul tabindex="0"
                        class="dropdown-content z-[50] menu p-2 shadow-2xl bg-white border border-gray-100 rounded-2xl w-48 mt-2">
                        <!-- Priority Filters -->
                        <li
                            class="menu-title px-4 py-2 text-[10px] uppercase font-bold text-gray-400 tracking-widest border-b border-gray-50 mb-1">
                            Priority</li>
                        <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'all']) }}"
                                class="py-2 rounded-xl text-xs {{ $priority === 'all' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">All
                                Priority</a></li>
                        <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'urgent']) }}"
                                class="py-2 rounded-xl text-xs {{ $priority === 'urgent' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Urgent</a>
                        </li>
                        <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'high']) }}"
                                class="py-2 rounded-xl text-xs {{ $priority === 'high' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">High</a>
                        </li>
                        <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'medium']) }}"
                                class="py-2 rounded-xl text-xs {{ $priority === 'medium' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Medium</a>
                        </li>
                        <li><a href="{{ request()->fullUrlWithQuery(['priority' => 'low']) }}"
                                class="py-2 rounded-xl text-xs {{ $priority === 'low' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-600' }}">Low</a>
                        </li>
                    </ul>
                </div>

                <!-- Hidden Input for Priority -->
                <input type="hidden" name="priority" value="{{ $priority }}">
            </form>
        </div>

        <!-- Cases Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Case</th>
                            <th class="px-4 py-3">Priority</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Assigned To</th>
                            <th class="px-4 py-3">Created</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($cases as $case)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ Str::limit($case->case_title, 45) }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($case->case_description, 60) }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-0.5 text-xs font-medium rounded-full 
                                                                                {{ $case->priority === 'urgent' ? 'bg-red-100 text-red-700' : '' }}
                                                                                {{ $case->priority === 'high' ? 'bg-orange-100 text-orange-700' : '' }}
                                                                                {{ $case->priority === 'medium' ? 'bg-blue-100 text-blue-700' : '' }}
                                                                                {{ $case->priority === 'low' ? 'bg-gray-100 text-gray-700' : '' }}">
                                        {{ ucfirst($case->priority ?? 'normal') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-0.5 text-xs font-medium rounded-full 
                                                                                {{ $case->status === 'pending' ? 'bg-blue-100 text-blue-700' : '' }}
                                                                                {{ $case->status === 'ongoing' ? 'bg-orange-100 text-orange-700' : '' }}
                                                                                {{ $case->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                                                                {{ $case->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    @if($case->assignedTo)
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-blue-600">
                                                    {{ substr($case->assignedTo->employee_name ?? $case->assignedTo->name ?? 'U', 0, 1) }}
                                                </span>
                                            </div>
                                            <span>{{ $case->assignedTo->employee_name ?? $case->assignedTo->name ?? 'Unknown' }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Unassigned</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-500 text-xs">
                                    {{ $case->created_at->format('M d, Y') }}
                                    <div class="text-gray-400">{{ $case->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('legal.cases.desk.show', $case->id) }}"
                                        class="btn btn-ghost btn-xs gap-1">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                    <i data-lucide="briefcase" class="w-12 h-12 mx-auto mb-3"></i>
                                    <p class="text-lg font-medium">No cases found</p>
                                    <p class="text-sm">Try adjusting your filters</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($cases->hasPages())
                <div class="px-4 py-3 border-t bg-gray-50">
                    {{ $cases->withQueryString()->links() }}
                </div>
            @endif
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