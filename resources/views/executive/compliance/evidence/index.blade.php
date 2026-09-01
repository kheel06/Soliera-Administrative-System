@extends('layouts.app')

@section('title', 'Executive | Evidence')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Compliance Evidence Repository</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
            <h3 class="text-gray-500 text-sm font-medium">Total Evidence Files</h3>
            <p class="text-3xl font-bold mt-2 text-gray-800">--</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
            <h3 class="text-gray-500 text-sm font-medium">Pending Review</h3>
            <p class="text-3xl font-bold mt-2 text-gray-800">--</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
            <h3 class="text-gray-500 text-sm font-medium">Verified Valid</h3>
            <p class="text-3xl font-bold mt-2 text-gray-800">--</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-700">Recent Evidence Uploads</h3>
            <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">Upload New</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">File Name</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Related Permit/Case</th>
                        <th class="px-6 py-3">Uploaded By</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4" colspan="6">
                            <div class="text-center py-8 text-gray-500">
                                <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                                <p>No evidence files found.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
