@extends('layouts.app')

@section('title', 'Edit Case: ' . $case->case_number)

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('legal.cases.desk.show', $case->id) }}"
                    class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Case Details
                </a>
                <h2 class="text-2xl font-bold text-gray-800 mt-2">Edit Case: {{ $case->case_number }}</h2>
                <p class="text-gray-600">Update the details of this legal case.</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <form action="{{ route('legal.cases.desk.update', $case->id) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Case Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="case_title" value="{{ old('case_title', $case->case_title) }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Case Type <span
                                    class="text-red-500">*</span></label>
                            <select name="case_type" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="civil" {{ $case->case_type == 'civil' ? 'selected' : '' }}>Civil</option>
                                <option value="criminal" {{ $case->case_type == 'criminal' ? 'selected' : '' }}>Criminal
                                </option>
                                <option value="administrative" {{ $case->case_type == 'administrative' ? 'selected' : '' }}>
                                    Administrative</option>
                                <option value="contract" {{ $case->case_type == 'contract' ? 'selected' : '' }}>Contract
                                    Dispute</option>
                                <option value="employment" {{ $case->case_type == 'employment' ? 'selected' : '' }}>Employment
                                    Issue</option>
                                <option value="property" {{ $case->case_type == 'property' ? 'selected' : '' }}>Property Issue
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Priority <span
                                    class="text-red-500">*</span></label>
                            <select name="priority" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="low" {{ $case->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $case->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $case->priority == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ $case->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status <span
                                    class="text-red-500">*</span></label>
                            <select name="status" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="pending" {{ $case->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="ongoing" {{ $case->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ $case->status == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="rejected" {{ $case->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Court Date (Optional)</label>
                            <input type="date" name="court_date"
                                value="{{ $case->court_date ? $case->court_date->format('Y-m-d') : '' }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Case Description <span
                                    class="text-red-500">*</span></label>
                            <textarea name="case_description" rows="4" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('case_description', $case->case_description) }}</textarea>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t">
                        <a href="{{ route('legal.cases.desk.show', $case->id) }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow-sm">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection