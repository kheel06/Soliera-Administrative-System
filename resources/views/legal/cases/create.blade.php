@extends('layouts.app')

@section('title', 'New Legal Case')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('legal.cases.desk') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Cases
                </a>
                <h2 class="text-2xl font-bold text-gray-800 mt-2">Create New Legal Case</h2>
                <p class="text-gray-600">Register a new litigation, dispute, or legal notice.</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <form action="{{ route('legal.cases.desk.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Case Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="case_title" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="e.g., Property Damage - Delivery Truck">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Case Type <span
                                    class="text-red-500">*</span></label>
                            <select name="case_type" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Type</option>
                                <option value="civil">Civil</option>
                                <option value="criminal">Criminal</option>
                                <option value="administrative">Administrative</option>
                                <option value="contract">Contract Dispute</option>
                                <option value="employment">Employment Issue</option>
                                <option value="property">Property Issue</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Priority <span
                                    class="text-red-500">*</span></label>
                            <select name="priority" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Filing Date <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="filing_date" required value="{{ date('Y-m-d') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Incident Date (Optional)</label>
                            <input type="datetime-local" name="incident_date"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Employee Involved (Optional)</label>
                            <input type="text" name="employee_involved"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Full Name or ID">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Case Description <span
                                    class="text-red-500">*</span></label>
                            <textarea name="case_description" rows="4" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Provide detailed background of the case..."></textarea>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t">
                        <a href="{{ route('legal.cases.desk') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow-sm">Create
                            Case</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection