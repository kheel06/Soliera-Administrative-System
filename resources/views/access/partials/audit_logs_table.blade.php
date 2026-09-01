<div class="overflow-x-auto" id="auditLogsTableContainer">
    <table class="table w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left py-3 px-3 md:px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Log ID</th>
                <th class="text-left py-3 px-3 md:px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Department
                </th>
                <th class="text-left py-3 px-3 md:px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee
                </th>
                <th class="text-left py-3 px-3 md:px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Module</th>
                <th class="text-left py-3 px-3 md:px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                <th class="text-left py-3 px-3 md:px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Activity
                </th>
                <th class="text-left py-3 px-3 md:px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <!-- Log ID -->
                    <td class="py-3 px-3 md:px-4">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 font-mono text-xs font-medium">
                            #{{ $log->id }}
                        </span>
                    </td>

                    <!-- Department -->
                    <td class="py-3 px-3 md:px-4">
                        <div>
                            <span
                                class="text-sm font-medium text-gray-700">{{ $log->user->dept_name ?? 'Administrative' }}</span>
                            <span class="block text-xs text-gray-400">ID: {{ $log->user->Dept_no ?? '1' }}</span>
                        </div>
                    </td>

                    <!-- Employee -->
                    <td class="py-3 px-3 md:px-4">
                        <div class="flex items-center gap-3">
                            @if($log->user && $log->user->profile_picture)
                                <div class="w-9 h-9 rounded-lg overflow-hidden ring-2 ring-[#001F54]/20">
                                    <img src="{{ asset('storage/' . $log->user->profile_picture) }}"
                                        alt="{{ $log->user->employee_name }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-9 h-9 rounded-lg bg-[#001F54] flex items-center justify-center flex-shrink-0">
                                    <span
                                        class="text-[#F7B32B] font-semibold text-xs">{{ strtoupper(substr($log->user->employee_name ?? 'U', 0, 1)) }}</span>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">
                                    {{ $log->user->employee_name ?? 'Unknown User' }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $log->user->role ?? 'No role' }}</p>
                            </div>
                        </div>
                    </td>

                    <!-- Module -->
                    <td class="py-3 px-3 md:px-4">
                        @php
                            $moduleMap = [
                                'Login' => ['name' => 'Authentication', 'color' => 'bg-emerald-100 text-emerald-700 border-emerald-200'],
                                'Logout' => ['name' => 'Authentication', 'color' => 'bg-emerald-100 text-emerald-700 border-emerald-200'],
                                'save_legal_draft' => ['name' => 'Legal Management', 'color' => 'bg-blue-100 text-blue-700 border-blue-200'],
                                'document_view' => ['name' => 'Document Management', 'color' => 'bg-purple-100 text-purple-700 border-purple-200'],
                                'Document_uploaded' => ['name' => 'Document Management', 'color' => 'bg-purple-100 text-purple-700 border-purple-200'],
                                'Access_control_check' => ['name' => 'Security', 'color' => 'bg-red-100 text-red-700 border-red-200'],
                                'Profile_updated' => ['name' => 'User Management', 'color' => 'bg-amber-100 text-amber-700 border-amber-200'],
                                'Table_added' => ['name' => 'Table Management', 'color' => 'bg-cyan-100 text-cyan-700 border-cyan-200'],
                                'Facility_reserved' => ['name' => 'Facility Management', 'color' => 'bg-indigo-100 text-indigo-700 border-indigo-200'],
                                'Visitor_registered' => ['name' => 'Visitor Management', 'color' => 'bg-pink-100 text-pink-700 border-pink-200'],
                                'Report_generated' => ['name' => 'Reporting', 'color' => 'bg-orange-100 text-orange-700 border-orange-200'],
                                'Settings_updated' => ['name' => 'System Admin', 'color' => 'bg-gray-100 text-gray-700 border-gray-200'],
                                'Data_exported' => ['name' => 'Data Management', 'color' => 'bg-teal-100 text-teal-700 border-teal-200'],
                            ];
                            $moduleInfo = $moduleMap[$log->action] ?? ['name' => 'System', 'color' => 'bg-gray-100 text-gray-700 border-gray-200'];
                        @endphp
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $moduleInfo['color'] }}">
                            {{ $moduleInfo['name'] }}
                        </span>
                    </td>

                    <!-- Action -->
                    <td class="py-3 px-3 md:px-4">
                        <div class="flex items-center gap-2">
                            <i data-lucide="activity" class="w-3.5 h-3.5 text-gray-400"></i>
                            <span class="text-sm text-gray-600">{{ str_replace('_', ' ', $log->action) }}</span>
                        </div>
                    </td>

                    <!-- Activity -->
                    <td class="py-3 px-3 md:px-4">
                        <span class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($log->description, 50) }}</span>
                    </td>

                    <!-- Date -->
                    <td class="py-3 px-3 md:px-4">
                        <div class="text-sm">
                            <p class="text-gray-700 font-medium">
                                {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y') }}
                            </p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}
                            </p>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-16">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                                <i data-lucide="activity" class="w-8 h-8 text-blue-300"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-600 mb-2">No Activity Logs Found</h3>
                            <p class="text-gray-400 text-sm">No system activity logs available at the moment.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination (AJAX friendly) -->
<div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50" id="paginationContainer">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Pagination Info -->
        <div class="text-sm text-gray-600">
            Showing <span class="font-semibold">{{ $logs->firstItem() ?? 0 }}</span> to
            <span class="font-semibold">{{ $logs->lastItem() ?? 0 }}</span> of
            <span class="font-semibold" id="totalLogsCount">{{ number_format($logs->total()) }}</span> records
        </div>

        <!-- Pagination Controls -->
        @if($logs->hasPages())
            <div class="join">
                <!-- Previous Button -->
                <button class="join-item btn btn-sm {{ $logs->onFirstPage() ? 'btn-disabled' : '' }}"
                    onclick="{{ !$logs->onFirstPage() ? "changePage('" . ($logs->currentPage() - 1) . "')" : '' }}">
                    «
                </button>

                @php
                    $currentPage = $logs->currentPage();
                    $lastPage = $logs->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);
                @endphp

                <!-- First Page -->
                @if($startPage > 1)
                    <button class="join-item btn btn-sm" onclick="changePage(1)">1</button>
                    @if($startPage > 2)
                        <button class="join-item btn btn-sm btn-disabled">...</button>
                    @endif
                @endif

                <!-- Page Numbers -->
                @for($page = $startPage; $page <= $endPage; $page++)
                    <button class="join-item btn btn-sm {{ $page == $currentPage ? 'btn-active' : '' }}"
                        onclick="changePage('{{ $page }}')">
                        {{ $page }}
                    </button>
                @endfor

                <!-- Last Page -->
                @if($endPage < $lastPage)
                    @if($endPage < $lastPage - 1)
                        <button class="join-item btn btn-sm btn-disabled">...</button>
                    @endif
                    <button class="join-item btn btn-sm" onclick="changePage('{{ $lastPage }}')">{{ $lastPage }}</button>
                @endif

                <!-- Next Button -->
                <button class="join-item btn btn-sm {{ !$logs->hasMorePages() ? 'btn-disabled' : '' }}"
                    onclick="{{ $logs->hasMorePages() ? "changePage('" . ($logs->currentPage() + 1) . "')" : '' }}">
                    »
                </button>
            </div>
        @endif
    </div>
</div>