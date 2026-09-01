@extends('layouts.app')

@section('title', 'Company Policies')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Company Policies</h1>
                <a href="{{ route('legal.policies.create') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg transition-all duration-200 cursor-pointer hover:scale-105 text-sm font-medium" style="background: linear-gradient(135deg, #F7A923 0%, #E6940F 100%); color: #1f2937; box-shadow: 0 2px 8px rgba(247, 169, 35, 0.25); border: none;" onmouseover="this.style.background='linear-gradient(135deg, #E6940F 0%, #D2840E 100%)'; this.style.boxShadow='0 4px 12px rgba(247, 169, 35, 0.35)'" onmouseout="this.style.background='linear-gradient(135deg, #F7A923 0%, #E6940F 100%)'; this.style.boxShadow='0 2px 8px rgba(247, 169, 35, 0.25)'">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Create Policy
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">All Categories</option>
                            <option value="HR" {{ request('category') == 'HR' ? 'selected' : '' }}>HR</option>
                            <option value="Legal" {{ request('category') == 'Legal' ? 'selected' : '' }}>Legal</option>
                            <option value="Finance" {{ request('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Operations" {{ request('category') == 'Operations' ? 'selected' : '' }}>Operations</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-lg transition-all duration-200 cursor-pointer hover:scale-105 text-sm font-medium" style="background: linear-gradient(135deg, #F7A923 0%, #E6940F 100%); color: #1f2937; box-shadow: 0 2px 8px rgba(247, 169, 35, 0.25); border: none;" onmouseover="this.style.background='linear-gradient(135deg, #E6940F 0%, #D2840E 100%)'; this.style.boxShadow='0 4px 12px rgba(247, 169, 35, 0.35)'" onmouseout="this.style.background='linear-gradient(135deg, #F7A923 0%, #E6940F 100%)'; this.style.boxShadow='0 2px 8px rgba(247, 169, 35, 0.25)'">
                            <i data-lucide="search" class="w-4 h-4 mr-2"></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Policies Table -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                @if($policies->count() > 0)
                    <x-table-card :title="'Company Policies'" :pagination="$policies->links()">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Effective Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($policies as $policy)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $policy->policy_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $policy->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $policy->category }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $policy->status_color }}">
                                            {{ ucfirst($policy->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $policy->effective_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <span class="text-gray-400">No actions available</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </x-table-card>
                @else
                    <div class="text-center py-8">
                        <i data-lucide="file-text" class="w-16 h-16 text-gray-400 mb-4 mx-auto"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No policies found</h3>
                        <p class="text-gray-500 mb-4">Get started by creating your first company policy.</p>
                        <a href="{{ route('legal.policies.create') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg transition-all duration-200 cursor-pointer hover:scale-105 text-sm font-medium" style="background: linear-gradient(135deg, #F7A923 0%, #E6940F 100%); color: #1f2937; box-shadow: 0 2px 8px rgba(247, 169, 35, 0.25); border: none;" onmouseover="this.style.background='linear-gradient(135deg, #E6940F 0%, #D2840E 100%)'; this.style.boxShadow='0 4px 12px rgba(247, 169, 35, 0.35)'" onmouseout="this.style.background='linear-gradient(135deg, #F7A923 0%, #E6940F 100%)'; this.style.boxShadow='0 2px 8px rgba(247, 169, 35, 0.25)'">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Create Policy
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush
@endsection
