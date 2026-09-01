@extends('layouts.app')

@section('title', 'Vault | Documents')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ isset($currentFolder) ? $currentFolder->name : 'Central Document Vault' }}
                    </h2>
                    <p class="text-sm text-gray-600">
                        {{ isset($currentFolder) ? ($currentFolder->description ?? 'Folder contents') : 'Secure storage for corporate records, contracts, and policies.' }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <button type="button" id="openCreateFolderBtn"
                        class="bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg flex items-center gap-2 cursor-pointer transition-all">
                        <i data-lucide="folder-plus" class="w-4 h-4"></i>
                        New Folder
                    </button>
                    <button type="button" id="openUploadBtn"
                        class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 cursor-pointer transition-all shadow-sm">
                        <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                        Upload File
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-6">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error mb-6">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error mb-6">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    <div>
                        <h3 class="font-bold">Please correct the following errors:</h3>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Storage Metrics (Only show on Root) -->
            @if(!isset($currentFolder))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Storage Overview</h3>
                        <span class="text-sm text-gray-500">{{ $stats['total_size'] }} of 1 TB used</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-4">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $stats['percent_used'] }}%"></div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-[#0A1829] rounded-lg">
                                <i data-lucide="file-text" class="w-5 h-5 text-[#EDA900]"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium">Contracts</div>
                                <div class="text-xs text-gray-500">{{ $stats['contracts_size'] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-[#0A1829] rounded-lg">
                                <i data-lucide="image" class="w-5 h-5 text-[#EDA900]"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium">Media</div>
                                <div class="text-xs text-gray-500">{{ $stats['media_size'] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-[#0A1829] rounded-lg">
                                <i data-lucide="archive" class="w-5 h-5 text-[#EDA900]"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium">Archives</div>
                                <div class="text-xs text-gray-500">{{ $stats['archives_size'] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-[#0A1829] rounded-lg">
                                <i data-lucide="file" class="w-5 h-5 text-[#EDA900]"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium">Others</div>
                                <div class="text-xs text-gray-500">{{ $stats['others_size'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Breadcrumbs & Search -->
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center mb-6">
                <nav class="flex text-sm font-medium text-gray-500 items-center">
                    <a href="{{ route('vault.documents.index_new') }}" class="hover:text-blue-600 flex items-center gap-1">
                        <i data-lucide="home" class="w-4 h-4"></i> Vault
                    </a>

                    @if(isset($breadcrumbs))
                        @foreach($breadcrumbs as $crumb)
                            <span class="mx-2">/</span>
                            <a href="{{ route('vault.folders.show', $crumb->id) }}"
                                class="hover:text-blue-600">{{ $crumb->name }}</a>
                        @endforeach
                    @endif

                    @if(isset($currentFolder))
                        <span class="mx-2">/</span>
                        <span class="text-gray-900 font-semibold">{{ $currentFolder->name }}</span>
                    @else
                        <span class="mx-2">/</span>
                        <span class="text-gray-900">Corporate</span>
                    @endif
                </nav>
                <div class="flex gap-2 w-full md:w-auto">
                    <form method="GET"
                        action="{{ isset($currentFolder) ? route('vault.folders.show', $currentFolder->id) : route('vault.documents.index_new') }}"
                        class="relative flex-grow md:flex-grow-0">
                        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search files..."
                            class="pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-[#EDA900] focus:border-[#EDA900] w-full">
                    </form>

                    <!-- Filter Dropdown -->
                    <div class="relative" x-data="{ openFilters: false }" @click.away="openFilters = false">
                        <button @click="openFilters = !openFilters"
                            class="px-3 py-2 rounded-lg bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] flex items-center gap-2 transition-colors duration-200">
                            <i data-lucide="filter" class="w-4 h-4 text-[#0A1829]"></i>
                        </button>
                        <div x-show="openFilters"
                            class="absolute right-0 z-20 mt-2 w-72 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none p-4"
                            style="display: none;">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-sm font-semibold text-gray-700">Filters</h3>
                                <a href="{{ isset($currentFolder) ? route('vault.folders.show', $currentFolder->id) : route('vault.documents.index_new') }}"
                                    class="text-xs text-[#0A1829] hover:text-gray-900">Clear All</a>
                            </div>
                            <form method="GET"
                                action="{{ isset($currentFolder) ? route('vault.folders.show', $currentFolder->id) : route('vault.documents.index_new') }}"
                                class="space-y-3">
                                <input type="hidden" name="search" value="{{ request('search') }}">

                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Category</label>
                                    <select name="category"
                                        class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        <option value="">All Categories</option>
                                        <option value="contract" {{ request('category') == 'contract' ? 'selected' : '' }}>
                                            Contract</option>
                                        <option value="financial" {{ request('category') == 'financial' ? 'selected' : '' }}>
                                            Financial</option>
                                        <option value="policy" {{ request('category') == 'policy' ? 'selected' : '' }}>Policy
                                        </option>
                                        <option value="report" {{ request('category') == 'report' ? 'selected' : '' }}>Report
                                        </option>
                                        <option value="general" {{ request('category') == 'general' ? 'selected' : '' }}>
                                            General</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Department</label>
                                    <select name="department"
                                        class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        <option value="">All Departments</option>
                                        <option value="Legal" {{ request('department') == 'Legal' ? 'selected' : '' }}>Legal
                                        </option>
                                        <option value="Finance" {{ request('department') == 'Finance' ? 'selected' : '' }}>
                                            Finance</option>
                                        <option value="HR" {{ request('department') == 'HR' ? 'selected' : '' }}>HR</option>
                                        <option value="Operations" {{ request('department') == 'Operations' ? 'selected' : '' }}>Operations</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Date Range</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                                            class="w-full text-xs border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                                            class="w-full text-xs border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] text-sm font-medium py-2 rounded-lg transition-colors duration-200">Apply
                                    Filters</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions Toolbar (Hidden by default) -->
            <div id="bulkActionsToolbar"
                class="hidden bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="font-medium text-blue-800"><span id="selectedCount">0</span> items selected</span>
                    <div class="h-4 w-px bg-blue-300"></div>
                    <button onclick="bulkMove()"
                        class="text-sm text-blue-700 hover:text-blue-900 font-medium flex items-center gap-1">
                        <i data-lucide="folder-input" class="w-4 h-4"></i> Move
                    </button>
                    @if(in_array(auth()->user()->role, ['Admin Manager', 'Owner']))
                        <button onclick="bulkDelete()"
                            class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center gap-1">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                        </button>
                    @endif
                </div>
                <button onclick="clearSelection()" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Folder Filters (Only shown if we are in root or if needed) -->
            <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
                <!-- These could be quick filters for folders if we want -->
            </div>

            <!-- Content Grid -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg min-h-[500px]">
                <form id="bulkActionForm" method="POST">
                    @csrf
                    <input type="hidden" name="action" id="bulkActionInput">
                    <input type="hidden" name="target_folder_id" id="bulkTargetFolderId">

                    <div class="p-6">
                        <!-- Folders -->
                        @if($folders->count() > 0)
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Folders</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                                @foreach($folders as $folder)
                                    <div class="group cursor-pointer relative folder-item" draggable="true"
                                        ondragstart="handleDragStart(event, 'folder', {{ $folder->id }})"
                                        ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                        ondrop="handleDrop(event, {{ $folder->id }})"
                                        oncontextmenu="handleContextMenu(event, 'folder', {{ $folder->id }}, '{{ addslashes($folder->name) }}')">

                                        <!-- Checkbox for Folder -->
                                        <div class="absolute top-2 left-2 z-10">
                                            <input type="checkbox" name="selected_folders[]" value="{{ $folder->id }}"
                                                class="checkbox checkbox-xs checkbox-primary item-checkbox"
                                                onchange="updateBulkToolbar()">
                                        </div>

                                        <a href="{{ route('vault.folders.show', $folder->id) }}" class="block">
                                            <div
                                                class="bg-blue-50 group-hover:bg-blue-100 rounded-xl p-4 flex flex-col items-center justify-center transition-colors h-32 pt-8 border-2 border-transparent">
                                                <i data-lucide="folder" class="w-10 h-10 text-blue-500 mb-2 fill-current"></i>
                                                <span
                                                    class="text-sm font-medium text-gray-700 text-center truncate w-full">{{ $folder->name }}</span>
                                                <span class="text-xs text-gray-400">{{ $folder->documents_count ?? 0 }} items</span>
                                                @if(!empty($folder->tags))
                                                    <div class="flex gap-1 mt-2 flex-wrap justify-center max-w-full">
                                                        @foreach($folder->tags as $tag)
                                                            <a href="{{ request()->fullUrlWithQuery(['search' => $tag]) }}"
                                                                class="px-1.5 py-0.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-[10px] rounded-full truncate max-w-[80px] transition-colors"
                                                                onclick="event.stopPropagation();">{{ $tag }}</a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                        <!-- Optional: Delete button overlay (Single) -->
                                        @if(in_array(auth()->user()->role, ['Admin Manager', 'Owner']))
                                            <form action="{{ route('vault.folders.destroy', $folder->id) }}" method="POST"
                                                class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                                onsubmit="return confirm('Delete folder?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 bg-red-100 text-red-600 rounded hover:bg-red-200"><i
                                                        data-lucide="trash-2" class="w-3 h-3"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Files -->
                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Files</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 md:px-6 py-3 text-left">
                                            <input type="checkbox" id="selectAllFiles" class="checkbox checkbox-xs"
                                                onchange="toggleSelectAll(this)">
                                        </th>
                                        <th
                                            class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name</th>
                                        <th
                                            class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date Modified</th>
                                        <th
                                            class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Category</th>
                                        <th
                                            class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Owner</th>
                                        <th
                                            class="px-3 md:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($documents as $document)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 md:px-6 py-3 md:py-4">
                                                <input type="checkbox" name="selected_documents[]" value="{{ $document->id }}"
                                                    class="checkbox checkbox-xs checkbox-primary item-checkbox"
                                                    onchange="updateBulkToolbar()">
                                            </td>
                                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @php
                                                        $icon = match ($document->category) {
                                                            'contract' => 'file-text',
                                                            'financial' => 'file-spreadsheet',
                                                            'image' => 'image',
                                                            'archive' => 'archive',
                                                            default => 'file'
                                                        };
                                                        $color = match ($document->category) {
                                                            'contract' => 'text-red-500',
                                                            'financial' => 'text-green-500',
                                                            'image' => 'text-purple-500',
                                                            'archive' => 'text-yellow-500',
                                                            default => 'text-gray-500'
                                                        };
                                                    @endphp
                                                    <i data-lucide="{{ $icon }}" class="w-5 h-5 {{ $color }} mr-3"></i>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $document->title }}</span>
                                                    @if(!empty($document->tags))
                                                        <div class="flex gap-1 ml-2">
                                                            @foreach($document->tags as $tag)
                                                                <a href="{{ request()->fullUrlWithQuery(['search' => $tag]) }}"
                                                                    class="px-1.5 py-0.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs rounded-full transition-colors"
                                                                    onclick="event.stopPropagation();">{{ $tag }}</a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $document->updated_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ ucfirst($document->category ?? 'General') }}
                                            </td>
                                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $document->uploader->name ?? 'Unknown' }}
                                            </td>
                                            <td
                                                class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button"
                                                    onclick="openPreviewModal('{{ route('document.preview', $document->id) }}', '{{ addslashes($document->title) }}')"
                                                    class="text-blue-600 hover:text-blue-900 mr-3 inline-block" title="Preview">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                </button>
                                                <a href="{{ route('vault.documents.show_new', $document->id) }}"
                                                    class="text-gray-400 hover:text-blue-600 inline-block" title="Details"><i
                                                        data-lucide="file-text" class="w-4 h-4"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-3 md:px-6 py-4 text-center text-gray-500">
                                                @if($folders->count() == 0)
                                                    <div class="flex flex-col items-center justify-center py-8">
                                                        <i data-lucide="folder-open" class="w-12 h-12 text-gray-300 mb-2"></i>
                                                        <p>This folder is empty.</p>
                                                    </div>
                                                @else
                                                    <p class="py-4">No files in this view.</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $documents->links() }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Pure CSS/JS Modals -->

    <!-- Upload Modal -->
    <div id="uploadModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeUploadModal()"></div>
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl p-6 transform transition-all">
                <button type="button" onclick="closeUploadModal()"
                    class="absolute right-4 top-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i data-lucide="upload" class="w-5 h-5 text-blue-600"></i>
                    Upload Document
                </h3>
                <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="redirect_to" value="vault">
                    @if(isset($currentFolder))
                        <input type="hidden" name="folder_id" value="{{ $currentFolder->id }}">
                    @endif
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Document Title</label>
                            <input type="text" name="title" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('title') }}" placeholder="e.g. Annual Report 2026">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="general">General</option>
                                    <option value="contract">Contract</option>
                                    <option value="financial">Financial</option>
                                    <option value="policy">Policy</option>
                                    <option value="report">Report</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                <select name="department"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Department...</option>
                                    <option value="Legal">Legal</option>
                                    <option value="Finance">Finance</option>
                                    <option value="HR">HR</option>
                                    <option value="Operations">Operations</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                rows="3"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                            <input type="text" name="tags"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Comma separated tags">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">File</label>
                            <input type="file" name="document_file" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png">
                            @error('document_file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                        <button type="button" onclick="closeUploadModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">Cancel</button>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Folder Modal -->
    <div id="createFolderModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeCreateFolderModal()"></div>
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 transform transition-all">
                <button type="button" onclick="closeCreateFolderModal()"
                    class="absolute right-4 top-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i data-lucide="folder-plus" class="w-5 h-5 text-blue-600"></i>
                    Create New Folder
                </h3>
                <form action="{{ route('vault.folders.store') }}" method="POST">
                    @csrf
                    @if(isset($currentFolder))
                        <input type="hidden" name="parent_id" value="{{ $currentFolder->id }}">
                    @endif
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Folder Name</label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g. Q1 Reports">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                            <input type="text" name="tags"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Comma separated tags">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                            <textarea name="description"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                rows="2"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                        <button type="button" onclick="closeCreateFolderModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">Cancel</button>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Create
                            Folder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closePreviewModal()"></div>
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-5xl h-[85vh] overflow-hidden flex flex-col">
                <div class="bg-gray-100 px-4 py-3 flex justify-between items-center border-b">
                    <h3 class="font-bold text-lg truncate pr-4" id="previewTitle">Document Preview</h3>
                    <button type="button" onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="flex-grow bg-gray-50 relative">
                    <iframe id="previewFrame" src="" class="w-full h-full border-0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function openUploadModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function openCreateFolderModal() {
            document.getElementById('createFolderModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateFolderModal() {
            document.getElementById('createFolderModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function openPreviewModal(url, title) {
            document.getElementById('previewFrame').src = url;
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('previewModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePreviewModal() {
            document.getElementById('previewModal').classList.add('hidden');
            document.getElementById('previewFrame').src = '';
            document.body.style.overflow = '';
        }

        // Attach event listeners on DOM ready
        document.addEventListener('DOMContentLoaded', function () {
            // Button event listeners
            document.getElementById('openUploadBtn').addEventListener('click', openUploadModal);
            document.getElementById('openCreateFolderBtn').addEventListener('click', openCreateFolderModal);

            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeUploadModal();
                    closeCreateFolderModal();
                    closePreviewModal();
                }
            });

            // Re-initialize Lucide icons
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });

        // Bulk Actions & Selection Logic
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
            updateBulkToolbar();
        }

        function updateBulkToolbar() {
            const selectedFolders = document.querySelectorAll('input[name="selected_folders[]"]:checked');
            const selectedDocs = document.querySelectorAll('input[name="selected_documents[]"]:checked');
            const totalSelected = selectedFolders.length + selectedDocs.length;

            const toolbar = document.getElementById('bulkActionsToolbar');
            const countSpan = document.getElementById('selectedCount');

            if (totalSelected > 0) {
                toolbar.classList.remove('hidden');
                toolbar.classList.add('flex');
                countSpan.textContent = totalSelected;
            } else {
                toolbar.classList.add('hidden');
                toolbar.classList.remove('flex');
            }
        }

        function clearSelection() {
            const checkboxes = document.querySelectorAll('.item-checkbox, #selectAllFiles');
            checkboxes.forEach(cb => cb.checked = false);
            updateBulkToolbar();
        }

        function bulkDelete() {
            if (confirm('Are you sure you want to delete the selected items? This action cannot be undone.')) {
                const form = document.getElementById('bulkActionForm');
                form.action = "{{ route('vault.bulk.destroy') }}";
                form.submit();
            }
        }

        function bulkMove() {
            const targetId = prompt("Enter Target Folder ID (Leave blank for root):");
            if (targetId !== null) {
                const form = document.getElementById('bulkActionForm');
                document.getElementById('bulkTargetFolderId').value = targetId;
                form.action = "{{ route('vault.bulk.move') }}";
                form.submit();
            }
        }

        // Context Menu & Drag-Drop Logic
        function handleContextMenu(event, type, id, name) {
            event.preventDefault();
        }

        function handleDragStart(event, type, id) {
            event.dataTransfer.setData('text/plain', JSON.stringify({ type, id }));
        }

        function handleDragOver(event) {
            event.preventDefault();
            event.currentTarget.classList.add('bg-blue-100', 'border-blue-400');
        }

        function handleDragLeave(event) {
            event.currentTarget.classList.remove('bg-blue-100', 'border-blue-400');
        }

        function handleDrop(event, targetFolderId) {
            event.preventDefault();
            event.currentTarget.classList.remove('bg-blue-100', 'border-blue-400');

            const data = JSON.parse(event.dataTransfer.getData('text/plain'));
            if (data.id == targetFolderId && data.type === 'folder') return;

            if (confirm(`Move this item into the folder?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('vault.bulk.move') }}";
                form.innerHTML = `
                                @csrf
                                <input type="hidden" name="target_folder_id" value="${targetFolderId}">
                                <input type="hidden" name="selected_folders[]" value="${data.type === 'folder' ? data.id : ''}">
                                <input type="hidden" name="selected_documents[]" value="${data.type === 'file' ? data.id : ''}">
                            `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection