@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">New Contract</h2>
                            <p class="text-sm text-gray-600">Create a new legal agreement record.</p>
                        </div>
                        <a href="{{ route('legal.contracts.workspace') }}"
                            class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center gap-1">
                            <i data-lucide="x" class="w-4 h-4"></i> Cancel
                        </a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('legal.contracts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Left Column: Core Details -->
                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Contract Title
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" required
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ $template ? $template->name : old('title') }}"
                                        placeholder="e.g. Service Agreement 2026">
                                </div>

                                <div>
                                    <label for="contract_number"
                                        class="block text-sm font-medium text-gray-700 mb-1">Contract Number</label>
                                    <input type="text" name="contract_number" id="contract_number"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Auto-generated if empty">
                                </div>

                                <div>
                                    <label for="counterparty_name"
                                        class="block text-sm font-medium text-gray-700 mb-1">Counterparty Name <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="counterparty_name" id="counterparty_name" required
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Vendor or Client Name">
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Contract
                                        Type</label>
                                    <select name="type" id="type"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="Service Agreement" {{ ($template && $template->category == 'service_contract') || old('type') == 'Service Agreement' ? 'selected' : '' }}>Service Agreement</option>
                                        <option value="NDA" {{ ($template && $template->category == 'nda') || old('type') == 'NDA' ? 'selected' : '' }}>NDA</option>
                                        <option value="Lease" {{ old('type') == 'Lease' ? 'selected' : '' }}>Lease</option>
                                        <option value="Employment" {{ ($template && $template->category == 'employment') || old('type') == 'Employment' ? 'selected' : '' }}>Employment</option>
                                        <option value="Vendor Contract" {{ ($template && $template->category == 'supplier_agreement') || old('type') == 'Vendor Contract' ? 'selected' : '' }}>Vendor Contract</option>
                                        <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column: Status & Dates -->
                            <div class="space-y-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" id="status"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="Draft">Draft</option>
                                        <option value="Pending Review">Pending Review</option>
                                        <option value="Pending Signature">Pending Signature</option>
                                        <option value="Active">Active</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="effective_date"
                                            class="block text-sm font-medium text-gray-700 mb-1">Effective Date</label>
                                        <input type="date" name="effective_date" id="effective_date"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="expiration_date"
                                            class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                                        <input type="date" name="expiration_date" id="expiration_date"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div>
                                    <label for="contract_value"
                                        class="block text-sm font-medium text-gray-700 mb-1">Contract Value (USD)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                                        <input type="number" step="0.01" name="contract_value" id="contract_value"
                                            class="w-full pl-7 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="0.00">
                                    </div>
                                </div>

                                <div>
                                    <label for="department"
                                        class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                    <select name="department" id="department"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="General">General</option>
                                        <option value="IT">IT</option>
                                        <option value="HR">HR</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Legal">Legal</option>
                                        <option value="Operations">Operations</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Full Width: Description & File -->
                        <div class="space-y-4 mb-8">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description /
                                    Scope</label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $template ? $template->description : old('description') }}</textarea>
                            </div>

                            <div>
                                <label for="document" class="block text-sm font-medium text-gray-700 mb-1">Attach Document
                                    (PDF/Docx)</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i data-lucide="cloud-upload" class="w-8 h-8 text-gray-400 mb-2"></i>
                                            <p class="text-sm text-gray-500"><span class="font-semibold">Click to
                                                    upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500">PDF, DOCX (MAX. 10MB)</p>
                                        </div>
                                        <input id="dropzone-file" type="file" name="document" class="hidden" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="button" onclick="window.history.back()"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">Cancel</button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium flex items-center gap-2">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Save Contract
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection