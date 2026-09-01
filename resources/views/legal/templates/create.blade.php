@extends('layouts.app')

@section('title', 'Legal | Create Template')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">Create New Legal Template</h2>
                    <p class="text-sm text-gray-600">Standardize your department's document drafting process.</p>
                </div>

                <form action="{{ route('legal.templates.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Template Name</label>
                            <input type="text" name="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="e.g. Non-Disclosure Agreement">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Template Code</label>
                            <input type="text" name="code" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="e.g. NDA-2026-V1">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="nda">NDA</option>
                                <option value="employment">Employment</option>
                                <option value="service_contract">Service Contract</option>
                                <option value="moa">MOA</option>
                                <option value="incident_report">Incident Report</option>
                                <option value="supplier_agreement">Supplier Agreement</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Initial Version</label>
                            <input type="text" name="version" value="1.0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Describe the purpose of this template..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Template Content (HTML/Markdown)</label>
                        <textarea name="content" rows="12" required
                            class="mt-1 block w-full font-mono text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Enter standard body of the document..."></textarea>
                        <p class="mt-2 text-xs text-gray-400 italic">Tip: Use placeholders like [Counterparty_Name] for
                            later replacement.</p>
                    </div>

                    <input type="hidden" name="status" value="draft">

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('legal.templates') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white shadow-sm hover:bg-blue-700">Save
                            Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection