@extends('layouts.app')

@section('title', 'Compliance | Evidence')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Compliance Evidence</h1>
                <p class="text-sm text-gray-500 mt-1">Repository of clearance certificates, permits, and receipts.</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('compliance.permits.create') }}"
                    class="btn btn-primary bg-[#0a1e3b] hover:bg-[#112f5a] text-white border-none gap-2">
                    <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                    Upload New
                </a>
            </div>
        </div>

        <!-- Document Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($documents as $doc)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="p-3 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-[#0a1e3b] group-hover:text-[#EDA900] transition-colors">
                            <i data-lucide="file-text" class="w-6 h-6"></i>
                        </div>
                        <div class="dropdown dropdown-end">
                            <button class="btn btn-ghost btn-xs btn-circle text-gray-400">
                                <i data-lucide="more-vertical" class="w-4 h-4"></i>
                            </button>
                            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-10">
                                <li><a>Download</a></li>
                                <li><a>View Details</a></li>
                            </ul>
                        </div>
                    </div>

                    <h3 class="font-bold text-gray-900 mb-1 truncate" title="{{ $doc->title }}">{{ $doc->title }}</h3>
                    <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $doc->description }}</p>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-50 text-xs">
                        <div class="text-gray-500">
                            {{ $doc->created_at->format('M d, Y') }}
                        </div>
                        <div class="flex items-center gap-1 text-gray-400">
                            <i data-lucide="hard-drive" class="w-3 h-3"></i>
                            <span>{{ number_format($doc->file_size / 1024, 1) }} KB</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="folder-open" class="w-10 h-10 text-gray-300"></i>
                    </div>
                    <h3 class="text-gray-900 font-bold mb-1">No Evidence Found</h3>
                    <p class="text-gray-500 text-sm mb-4">Upload permits or compliance documents to see them here.</p>
                    <a href="{{ route('compliance.permits.create') }}"
                        class="btn btn-outline text-blue-600 hover:bg-blue-50 border-blue-200">
                        Upload Document
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $documents->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection