@extends('layouts.app')

@section('title', $document->title . ' - Imported Legal Document')

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
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                            <a href="{{ route('legal.documents.imported') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                Imported Documents
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $document->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Document Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-4">
                                <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-lg mr-4">
                                    <i data-lucide="file-text" class="w-6 h-6 text-red-600"></i>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $document->title }}</h1>
                                    <p class="text-gray-600 mt-1">Imported Legal Document</p>
                                </div>
                            </div>
                            
                            <!-- Document Metadata -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                                <div class="flex items-center text-sm">
                                    <i data-lucide="calendar" class="w-4 h-4 mr-2 text-gray-400"></i>
                                    <span class="text-gray-600">Created:</span>
                                    <span class="ml-2 font-medium">{{ $document->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                
                                @if($document->department)
                                    <div class="flex items-center text-sm">
                                        <i data-lucide="building" class="w-4 h-4 mr-2 text-gray-400"></i>
                                        <span class="text-gray-600">Department:</span>
                                        <span class="ml-2 font-medium">{{ $document->department }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center text-sm">
                                    <i data-lucide="user" class="w-4 h-4 mr-2 text-gray-400"></i>
                                    <span class="text-gray-600">Created by:</span>
                                    <span class="ml-2 font-medium">{{ $document->creator ? $document->creator->employee_name : 'Unknown' }}</span>
                                </div>
                                
                                @if($document->uploaded_by && $document->uploader)
                                    <div class="flex items-center text-sm">
                                        <i data-lucide="upload" class="w-4 h-4 mr-2 text-gray-400"></i>
                                        <span class="text-gray-600">Uploaded by:</span>
                                        <span class="ml-2 font-medium">{{ $document->uploader->employee_name }}</span>
                                    </div>
                                @endif
                                
                                @if($document->case)
                                    <div class="flex items-center text-sm">
                                        <i data-lucide="briefcase" class="w-4 h-4 mr-2 text-gray-400"></i>
                                        <span class="text-gray-600">Related Case:</span>
                                        <span class="ml-2 font-medium">{{ $document->case->case_title }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center text-sm">
                                    <i data-lucide="tag" class="w-4 h-4 mr-2 text-gray-400"></i>
                                    <span class="text-gray-600">Status:</span>
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $document->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                           $document->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           $document->status === 'draft' ? 'bg-gray-100 text-gray-800' : 
                                           'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($document->description)
                                <div class="mt-6">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Description</h3>
                                    <p class="text-gray-600">{{ $document->description }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col space-y-2 ml-6">
                            <a href="{{ route('legal.documents.imported.preview', $document->id) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                                <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                Preview Document
                            </a>
                            <a href="{{ route('legal.documents.imported.download', $document->id) }}" 
                               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center">
                                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Document Preview Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Document Preview</h2>
                    
                    <!-- PDF Preview with Censorship Notice -->
                    <div class="border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                        <div class="bg-yellow-50 border-b border-yellow-200 px-4 py-3">
                            <div class="flex items-center">
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 mr-2"></i>
                                <p class="text-sm text-yellow-800">
                                    <strong>Privacy Notice:</strong> Sensitive information in this document may be automatically censored for privacy protection.
                                </p>
                            </div>
                        </div>
                        
                        <!-- PDF Preview iframe -->
                        <div class="relative" style="height: 600px;">
                            <iframe src="{{ route('legal.documents.imported.preview', $document->id) }}" 
                                    class="w-full h-full border-0"
                                    title="Document Preview">
                                <div class="flex items-center justify-center h-full">
                                    <p class="text-gray-500">Your browser does not support PDF preview. 
                                       <a href="{{ route('legal.documents.imported.download', $document->id) }}" class="text-blue-600 hover:underline">Download the PDF</a> to view.
                                    </p>
                                </div>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
