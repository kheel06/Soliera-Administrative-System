@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Contract Details</h2>
                    <p class="text-sm text-gray-600">View and manage contract information.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('legal.contracts.workspace') }}"
                        class="bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Back to List
                    </a>
                    <a href="{{ route('legal.contracts.edit', $contract->id) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Contract
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Details Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Contract Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Title</label>
                                    <div class="mt-1 text-sm text-gray-900 font-medium">{{ $contract->title }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Contract Number</label>
                                    <div class="mt-1 text-sm text-gray-900 font-family-mono">
                                        {{ $contract->contract_number }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Counterparty</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $contract->counterparty_name }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Type</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $contract->type }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Effective Date</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $contract->effective_date ? $contract->effective_date->format('M d, Y') : '-' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Expiration Date</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $contract->expiration_date ? $contract->expiration_date->format('M d, Y') : '-' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Contract Value</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $contract->contract_value ? '$' . number_format($contract->contract_value, 2) : '-' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Department</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $contract->department }}</div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-500">Description</label>
                                <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                    {{ $contract->description ?? 'No description provided.' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Clauses / Key Terms (Placeholder) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Key Terms & Clauses</h3>
                            <p class="text-sm text-gray-500 italic">No clauses extracted yet.</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Status</h3>
                            @php
                                $statusColor = match ($contract->status) {
                                    'Active' => 'bg-green-100 text-green-800',
                                    'Draft' => 'bg-gray-100 text-gray-800',
                                    'Pending Signature' => 'bg-blue-100 text-blue-800',
                                    'Expired' => 'bg-red-100 text-red-800',
                                    default => 'bg-yellow-100 text-yellow-800',
                                };
                            @endphp
                            <span
                                class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColor }}">
                                {{ $contract->status }}
                            </span>

                            <div class="mt-6 space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Owner</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $contract->owner->name ?? 'Unknown' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Created At</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $contract->created_at->format('M d, Y h:i A') }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Last Updated</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $contract->updated_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Document File -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Document File</h3>
                            @if($contract->file_path)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <i data-lucide="file-text" class="w-8 h-8 text-blue-500 mr-3"></i>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ basename($contract->file_path) }}</p>
                                        <p class="text-xs text-gray-500">PDF Document</p>
                                    </div>
                                    <a href="{{ route('legal.contracts.download', $contract->id) }}"
                                        class="text-blue-600 hover:text-blue-800 p-2">
                                        <i data-lucide="download" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            @elseif(strtolower($contract->type) === 'employment')
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <i data-lucide="file-text" class="w-8 h-8 text-blue-500 mr-3"></i>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            EMPLOYEE CONTRACT & HR POLICY AGREEMENT</p>
                                        <p class="text-xs text-gray-500">PDF Document Template</p>
                                    </div>
                                    <a href="{{ route('legal.contracts.download', $contract->id) }}"
                                        class="text-blue-600 hover:text-blue-800 p-2" target="_blank">
                                        <i data-lucide="download" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic">No document file attached.</p>
                            @endif

                            @if($contract->status === 'Draft')
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <form action="{{ route('legal.contracts.status', $contract->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Pending Review">
                                        <button type="submit"
                                            class="w-full btn btn-primary btn-sm gap-2">
                                            <i data-lucide="send" class="w-4 h-4"></i>
                                            Send for Approval
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection