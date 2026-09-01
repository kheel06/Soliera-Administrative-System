@extends('layouts.app')

@section('content')
    @include('partials.page-loader')

    <div class="py-4 sm:py-6 space-y-6">



        <!-- Main Table Card -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- Table Body -->
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left font-semibold text-gray-600 uppercase tracking-widest text-[10px] py-4">
                                Submission Details</th>
                            <th class="text-center font-semibold text-gray-600 uppercase tracking-widest text-[10px] py-4">
                                Status</th>
                            <th class="text-center font-semibold text-gray-600 uppercase tracking-widest text-[10px] py-4">
                                Uploaded By</th>
                            <th class="text-center font-semibold text-gray-600 uppercase tracking-widest text-[10px] py-4">
                                Date Received</th>
                            <th class="text-center font-semibold text-gray-600 uppercase tracking-widest text-[10px] py-4">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                            <i data-lucide="file-text" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $doc->title }}</h4>
                                            <p class="text-xs text-gray-500 uppercase font-medium">{{ $doc->category }} •
                                                {{ $doc->department }}
                                            </p>
                                            <p class="text-[10px] text-blue-600 font-mono mt-0.5">{{ $doc->reference_id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusStyles = [
                                            'active' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                            'pending_review' => 'bg-amber-50 text-amber-700 border-amber-100',
                                            'archived' => 'bg-gray-50 text-gray-600 border-gray-100',
                                            'rejected' => 'bg-red-50 text-red-700 border-red-100',
                                        ];
                                        $style = $statusStyles[$doc->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                      @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold border {{ $style }}">
                                        {{ strtoupper(str_replace('_', ' ', $doc->status)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="flex flex-col items-center">
                                        <span
                                            class="text-sm font-medium text-gray-800">{{ $doc->uploader->employee_name ?? 'Unknown' }}</span>
                                        <span
                                            class="text-[10px] text-gray-400 capitalize">{{ $doc->uploader->dept_name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="text-xs font-medium text-gray-600">{{ $doc->created_at->format('M d, Y') }}</span>
                                    <p class="text-[10px] text-gray-400">{{ $doc->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('legal.documents.show', $doc->id) }}"
                                            class="btn btn-ghost btn-sm btn-square text-blue-600 hover:bg-blue-50"
                                            title="Review">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        @if($doc->status === 'pending_review')
                                            <button onclick="approveSub({{ $doc->id }})"
                                                class="btn btn-ghost btn-sm btn-square text-emerald-600 hover:bg-emerald-50"
                                                title="Approve">
                                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                            </button>
                                        @endif
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                            class="btn btn-ghost btn-sm btn-square text-gray-500 hover:bg-gray-50"
                                            title="Download">
                                            <i data-lucide="download" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                                            <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Submissions Found</h3>
                                        <p class="text-gray-500 max-w-sm mx-auto">Department document requests and external
                                            submissions will appear here for review.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($documents->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $documents->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function approveSub(id) {
            Swal.fire({
                title: 'Approve Submission?',
                text: "This document will be marked as active in the repository.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Approve'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform AJAX approval
                    fetch(`/legal/documents/${id}/approve-doc`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Approved!', 'Document is now active.', 'success').then(() => window.location.reload());
                            } else {
                                Swal.fire('Error', data.message || 'Something went wrong', 'error');
                            }
                        });
                }
            });
        }
    </script>
@endsection