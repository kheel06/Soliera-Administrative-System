@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Edit Contract</h2>
                            <p class="text-sm text-gray-600">Update contract details.</p>
                        </div>
                        <a href="{{ route('legal.contracts.details', $contract->id) }}"
                            class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center gap-1">
                            <i data-lucide="x" class="w-4 h-4"></i> Cancel
                        </a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('legal.contracts.update', $contract->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Left Column: Core Details -->
                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Contract Title
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $contract->title) }}"
                                        required
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. Service Agreement 2026">
                                </div>

                                <div>
                                    <label for="contract_number"
                                        class="block text-sm font-medium text-gray-700 mb-1">Contract Number</label>
                                    <input type="text" name="contract_number" id="contract_number"
                                        value="{{ old('contract_number', $contract->contract_number) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Auto-generated if empty" readonly>
                                    <p class="text-xs text-gray-500 mt-1">Contract number cannot be changed.</p>
                                </div>

                                <div>
                                    <label for="counterparty_name"
                                        class="block text-sm font-medium text-gray-700 mb-1">Counterparty Name <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="counterparty_name" id="counterparty_name"
                                        value="{{ old('counterparty_name', $contract->counterparty_name) }}" required
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Vendor or Client Name">
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Contract
                                        Type</label>
                                    <select name="type" id="type"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="Service Agreement" {{ old('type', $contract->type) == 'Service Agreement' ? 'selected' : '' }}>Service Agreement</option>
                                        <option value="NDA" {{ old('type', $contract->type) == 'NDA' ? 'selected' : '' }}>NDA
                                        </option>
                                        <option value="Lease" {{ old('type', $contract->type) == 'Lease' ? 'selected' : '' }}>
                                            Lease</option>
                                        <option value="Employment" {{ old('type', $contract->type) == 'Employment' ? 'selected' : '' }}>Employment</option>
                                        <option value="Vendor Contract" {{ old('type', $contract->type) == 'Vendor Contract' ? 'selected' : '' }}>Vendor Contract</option>
                                        <option value="Other" {{ old('type', $contract->type) == 'Other' ? 'selected' : '' }}>
                                            Other</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column: Status & Dates -->
                            <div class="space-y-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" id="status"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="Draft" {{ old('status', $contract->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Pending Review" {{ old('status', $contract->status) == 'Pending Review' ? 'selected' : '' }}>Pending Review</option>
                                        <option value="Pending Signature" {{ old('status', $contract->status) == 'Pending Signature' ? 'selected' : '' }}>Pending Signature</option>
                                        <option value="Active" {{ old('status', $contract->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Expired" {{ old('status', $contract->status) == 'Expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="Terminated" {{ old('status', $contract->status) == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="effective_date"
                                            class="block text-sm font-medium text-gray-700 mb-1">Effective Date</label>
                                        <input type="date" name="effective_date" id="effective_date"
                                            value="{{ old('effective_date', optional($contract->effective_date)->format('Y-m-d')) }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="expiration_date"
                                            class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                                        <input type="date" name="expiration_date" id="expiration_date"
                                            value="{{ old('expiration_date', optional($contract->expiration_date)->format('Y-m-d')) }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div>
                                    <label for="contract_value"
                                        class="block text-sm font-medium text-gray-700 mb-1">Contract Value (USD)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                                        <input type="number" step="0.01" name="contract_value" id="contract_value"
                                            value="{{ old('contract_value', $contract->contract_value) }}"
                                            class="w-full pl-7 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="0.00">
                                    </div>
                                </div>

                                <div>
                                    <label for="department"
                                        class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                    <select name="department" id="department"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="General" {{ old('department', $contract->department) == 'General' ? 'selected' : '' }}>General</option>
                                        <option value="IT" {{ old('department', $contract->department) == 'IT' ? 'selected' : '' }}>IT</option>
                                        <option value="HR" {{ old('department', $contract->department) == 'HR' ? 'selected' : '' }}>HR</option>
                                        <option value="Finance" {{ old('department', $contract->department) == 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Legal" {{ old('department', $contract->department) == 'Legal' ? 'selected' : '' }}>Legal</option>
                                        <option value="Operations" {{ old('department', $contract->department) == 'Operations' ? 'selected' : '' }}>Operations</option>
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
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $contract->description) }}</textarea>
                            </div>

                            <div>
                                <label for="document" class="block text-sm font-medium text-gray-700 mb-1">Replace Document
                                    (PDF/Docx)</label>
                                @if($contract->file_path)
                                    <div class="text-sm text-gray-500 mb-2">Current file: {{ basename($contract->file_path) }}
                                    </div>
                                @endif
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
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            @if(in_array(session('user_role'), ['Administrator', 'Super Admin']))
                                <button type="button"
                                    onclick="if(confirm('Are you sure you want to delete this contract?')) document.getElementById('delete-contract-form').submit();"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center gap-1">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i> Delete Contract
                                </button>
                            @else
                                <div></div> <!-- Spacer -->
                            @endif
                            <div class="flex items-center gap-3">
                                <a href="{{ route('legal.contracts.details', $contract->id) }}"
                                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">Cancel</a>
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium flex items-center gap-2">
                                    <i data-lucide="save" class="w-4 h-4"></i>
                                    Update Contract
                                </button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-contract-form" action="{{ route('legal.contracts.destroy', $contract->id) }}"
                        method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection