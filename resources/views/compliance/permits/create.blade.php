@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Add New Compliance Permit</h2>
                        <a href="{{ route('compliance.permits') }}"
                            class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Back to List
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        Please check the form for errors.
                                    </p>
                                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('compliance.permits.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Permit Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Permit / License Name
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="e.g. Environmental Clearance Certificate">
                            </div>

                            <!-- Issuing Authority -->
                            <div>
                                <label for="issuing_authority" class="block text-sm font-medium text-gray-700 mb-1">Issuing
                                    Authority <span class="text-red-500">*</span></label>
                                <input type="text" name="issuing_authority" id="issuing_authority"
                                    value="{{ old('issuing_authority') }}" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="e.g. Dept of Environment">
                            </div>

                            <!-- Reference Number -->
                            <div>
                                <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-1">Reference
                                    / License #</label>
                                <input type="text" name="reference_number" id="reference_number"
                                    value="{{ old('reference_number') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="e.g. ECC-2024-001">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span
                                        class="text-red-500">*</span></label>
                                <select name="status" id="status" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Renewal in Progress" {{ old('status') == 'Renewal in Progress' ? 'selected' : '' }}>Renewal in Progress</option>
                                    <option value="Expiring Soon" {{ old('status') == 'Expiring Soon' ? 'selected' : '' }}>
                                        Expiring Soon</option>
                                    <option value="Expired" {{ old('status') == 'Expired' ? 'selected' : '' }}>Expired
                                    </option>
                                </select>
                            </div>

                            <!-- Expiration Date -->
                            <div>
                                <label for="expiration_date" class="block text-sm font-medium text-gray-700 mb-1">Expiration
                                    Date <span class="text-red-500">*</span></label>
                                <input type="date" name="expiration_date" id="expiration_date"
                                    value="{{ old('expiration_date') }}" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Compliance Score -->
                            <div>
                                <label for="compliance_score"
                                    class="block text-sm font-medium text-gray-700 mb-1">Compliance Score (%)</label>
                                <input type="number" name="compliance_score" id="compliance_score"
                                    value="{{ old('compliance_score', 90) }}" min="0" max="100"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes / Remarks</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Additional details about this permit...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- File Upload (Placeholder for now) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Permit Document (PDF/Image)</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <i data-lucide="upload-cloud" class="mx-auto h-12 w-12 text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="document" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, PDF up to 10MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('compliance.permits') }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit"
                                class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white border-none">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                                Save Permit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection