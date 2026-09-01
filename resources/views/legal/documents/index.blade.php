@extends('layouts.app')

@section('title', 'Legal | Documents')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main content -->
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Header -->
        @include('partials.navbar')

        <!-- Main content area -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Imported Legal Documents</h1>
                        <p class="text-gray-600 mt-1">View and manage imported PDF legal documents</p>
                    </div>
                    <div class="flex space-x-3">
                        <form method="GET" action="{{ route('legal.documents.search') }}" class="flex">
                            <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Search documents..." 
                                   class="px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition-colors">
                                <i data-lucide="search" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Documents Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($documents as $document)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200">
                        <div class="p-6">
                            <!-- Document Icon -->
                            <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-lg mb-4">
                                <i data-lucide="file-text" class="w-6 h-6 text-red-600"></i>
                            </div>
                            
                            <!-- Document Title -->
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $document->title }}</h3>
                            
                            <!-- Document Info -->
                            <div class="space-y-2 text-sm text-gray-600">
                                @if($document->department)
                                    <div class="flex items-center">
                                        <i data-lucide="building" class="w-4 h-4 mr-2"></i>
                                        {{ $document->department }}
                                    </div>
                                @endif
                                
                                <div class="flex items-center">
                                    <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                                    {{ $document->created_at->format('M d, Y') }}
                                </div>
                                
                                <div class="flex items-center">
                                    <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                    {{ $document->creator ? $document->creator->employee_name : 'Unknown' }}
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $document->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                           $document->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           $document->status === 'draft' ? 'bg-gray-100 text-gray-800' : 
                                           'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-4 flex space-x-2">
                                <a href="{{ route('legal.documents.imported.show', $document->id) }}" 
                                   class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                    View Details
                                </a>
                                <a href="{{ route('legal.documents.imported.preview', $document->id) }}" 
                                   target="_blank"
                                   class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded-lg hover:bg-gray-700 transition-colors">
                                    Preview
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="flex flex-col items-center">
                            <i data-lucide="file-x" class="w-12 h-12 text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No documents found</h3>
                            <p class="text-gray-600">No imported legal documents match your search criteria.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($documents->hasPages())
                <div class="mt-8">
                    {{ $documents->links() }}
                </div>
            @endif
        </main>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
