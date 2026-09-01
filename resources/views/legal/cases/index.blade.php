@extends('layouts.app')

@section('title', 'Cases & Disputes')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Cases & Disputes Desk</h2>
                    <p class="text-sm text-gray-600">Track litigation, disputes, and legal notices.</p>
                </div>
                <div class="flex gap-2">
                    <!-- Export Dropdown -->
                    <div class="relative" x-data="{ openExport: false }" @click.away="openExport = false">
                        <button @click="openExport = !openExport"
                            class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                            <i data-lucide="download" class="w-4 h-4"></i>
                            Export Reports
                            <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                        </button>
                        <div x-show="openExport"
                            class="absolute right-0 z-20 mt-2 w-48 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none py-1"
                            style="display: none;">
                            <a href="{{ route('legal.cases.desk.export') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                                <i data-lucide="file-spreadsheet" class="w-4 h-4 inline mr-2 text-green-600"></i>
                                Export as Excel
                            </a>
                            <a href="{{ route('legal.cases.desk.export_pdf') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                                <i data-lucide="file" class="w-4 h-4 inline mr-2 text-red-600"></i>
                                Export as PDF
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('legal.cases.desk.create') }}"
                        class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        New Case
                    </a>
                </div>
            </div>

            <!-- Metrics/KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Active Cases -->
                <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between border border-gray-100">
                    <div>
                        <div class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-1">Active Cases</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['active'] }}</div>
                    </div>
                    <div class="p-3 rounded-lg bg-[#0A1829]">
                        <i data-lucide="briefcase" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>

                <!-- High Risk -->
                <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between border border-gray-100">
                    <div>
                        <div class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-1">High Risk</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['high_risk'] }}</div>
                    </div>
                    <div class="p-3 rounded-lg bg-[#0A1829]">
                        <i data-lucide="flame" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>

                <!-- Hearings -->
                <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between border border-gray-100">
                    <div>
                        <div class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-1">Hearings (7 Days)
                        </div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['hearings'] }}</div>
                    </div>
                    <div class="p-3 rounded-lg bg-[#0A1829]">
                        <i data-lucide="gavel" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>

                <!-- Settled -->
                <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between border border-gray-100">
                    <div>
                        <div class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-1">Settled (YTD)</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['settled'] }}</div>
                    </div>
                    <div class="p-3 rounded-lg bg-[#0A1829]">
                        <i data-lucide="check-circle" class="w-6 h-6 text-[#EDA900]"></i>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <div class="flex flex-col md:flex-row gap-4 justify-between">
                    <div class="flex gap-2">
                        <a href="{{ route('legal.cases.desk', ['tab' => 'all', 'search' => request('search')]) }}"
                            class="px-4 py-2 text-sm font-medium {{ request('tab', 'all') == 'all' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">All
                            Cases</a>
                        <a href="{{ route('legal.cases.desk', ['tab' => 'my_cases', 'search' => request('search')]) }}"
                            class="px-4 py-2 text-sm font-medium {{ request('tab') == 'my_cases' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">My
                            Cases</a>
                        <a href="{{ route('legal.cases.desk', ['tab' => 'high_priority', 'search' => request('search')]) }}"
                            class="px-4 py-2 text-sm font-medium {{ request('tab') == 'high_priority' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">High
                            Priority</a>
                    </div>
                    <div class="flex gap-2">
                        <form method="GET" action="{{ route('legal.cases.desk') }}" class="relative">
                            <input type="hidden" name="tab" value="{{ request('tab', 'all') }}">
                            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search cases..."
                                class="pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        </form>

                        <!-- Filter Dropdown -->
                        <div class="relative" x-data="{ openFilters: false }" @click.away="openFilters = false">
                            <button @click="openFilters = !openFilters"
                                class="px-3 py-2 rounded-lg bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] flex items-center gap-2 transition-colors duration-200">
                                <i data-lucide="filter" class="w-4 h-4 text-[#0A1829]"></i>
                            </button>
                            <div x-show="openFilters"
                                class="absolute right-0 z-20 mt-2 w-72 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none p-4"
                                style="display: none;">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-sm font-semibold text-gray-700">Filters</h3>
                                    <a href="{{ route('legal.cases.desk') }}"
                                        class="text-xs text-[#0A1829] hover:text-gray-900">Clear All</a>
                                </div>
                                <form method="GET" action="{{ route('legal.cases.desk') }}" class="space-y-3">
                                    <input type="hidden" name="tab" value="{{ request('tab', 'all') }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">

                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Case Type</label>
                                        <select name="type"
                                            class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <option value="">All Types</option>
                                            <option value="civil" {{ request('type') == 'civil' ? 'selected' : '' }}>Civil
                                            </option>
                                            <option value="criminal" {{ request('type') == 'criminal' ? 'selected' : '' }}>
                                                Criminal</option>
                                            <option value="administrative" {{ request('type') == 'administrative' ? 'selected' : '' }}>Administrative</option>
                                            <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>
                                                Contract</option>
                                            <option value="employment" {{ request('type') == 'employment' ? 'selected' : '' }}>Employment</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Priority</label>
                                        <select name="priority"
                                            class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <option value="">All Priorities</option>
                                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low
                                            </option>
                                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>
                                                Medium</option>
                                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High
                                            </option>
                                            <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>
                                                Urgent</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                                        <select name="status"
                                            class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <option value="">All Statuses</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>
                                                Ongoing</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                                Rejected</option>
                                        </select>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] text-sm font-medium py-2 rounded-lg transition-colors duration-200">Apply
                                        Filters</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cases Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Case Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Case Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Priority</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($cases as $case)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $case->case_title }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($case->case_description, 30) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $case->case_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucfirst($case->case_type) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $case->status_color }}">
                                            {{ $case->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $case->priority_color }}">
                                            {{ ucfirst($case->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                            <button @click="open = !open" @click.away="open = false"
                                                class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                                            </button>
                                            <div x-show="open"
                                                class="absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                style="display: none;">
                                                <div class="py-1">
                                                    <a href="{{ route('legal.cases.desk.show', $case->id) }}"
                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View
                                                        Details</a>
                                                    <a href="{{ route('legal.cases.desk.edit', $case->id) }}"
                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                                    <form action="{{ route('legal.cases.desk.destroy', $case->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this case?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No cases found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $cases->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection