@extends('layouts.app')

@section('title', 'Legal | Clause Library')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Clause Library</h2>
                    <p class="text-sm text-gray-600">Browse and manage standard legal clauses for your contracts.</p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('legal.clauses') }}" class="relative">
                        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search clauses..."
                            class="pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-[#EDA900] focus:border-[#EDA900]">
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
                                <a href="{{ route('legal.clauses') }}"
                                    class="text-xs text-[#0A1829] hover:text-gray-900">Clear All</a>
                            </div>
                            <form method="GET" action="{{ route('legal.clauses') }}" class="space-y-3">
                                <input type="hidden" name="search" value="{{ request('search') }}">

                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Category</label>
                                    <select name="category"
                                        class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        <option value="">All Categories</option>
                                        <option value="General" {{ request('category') == 'General' ? 'selected' : '' }}>
                                            General</option>
                                        <option value="Risk" {{ request('category') == 'Risk' ? 'selected' : '' }}>Risk
                                        </option>
                                        <option value="Liability" {{ request('category') == 'Liability' ? 'selected' : '' }}>
                                            Liability</option>
                                        <option value="Termination" {{ request('category') == 'Termination' ? 'selected' : '' }}>Termination</option>
                                        <option value="Compliance" {{ request('category') == 'Compliance' ? 'selected' : '' }}>Compliance</option>
                                        <option value="Litigation" {{ request('category') == 'Litigation' ? 'selected' : '' }}>Litigation</option>
                                        <option value="Intellectual Property" {{ request('category') == 'Intellectual Property' ? 'selected' : '' }}>Intellectual Property</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Mandatory Status</label>
                                    <select name="mandatory"
                                        class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        <option value="">Any</option>
                                        <option value="yes" {{ request('mandatory') == 'yes' ? 'selected' : '' }}>Mandatory
                                            Only</option>
                                        <option value="no" {{ request('mandatory') == 'no' ? 'selected' : '' }}>Optional Only
                                        </option>
                                    </select>
                                </div>

                                <button type="submit"
                                    class="w-full bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] text-sm font-medium py-2 rounded-lg transition-colors duration-200">Apply
                                    Filters</button>
                            </form>
                        </div>
                    </div>

                    <button type="button" onclick="openAddClauseModal()"
                        class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Add Clause
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-6 text-sm py-2 rounded-lg">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Clause Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mandatory</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last
                                Updated</th>
                            <th
                                class="px-6 py-3 justify-end text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($clauses as $clause)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $clause->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1 line-clamp-1 italic">
                                        "{{ Str::limit($clause->content, 80) }}"</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $clause->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($clause->is_mandatory)
                                        <span class="text-red-600"><i data-lucide="check-circle" class="w-5 h-5"></i></span>
                                    @else
                                        <span class="text-gray-300"><i data-lucide="circle" class="w-5 h-5"></i></span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $clause->updated_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <button class="text-gray-400 hover:text-blue-600" title="Copy Clause"
                                            onclick="copyToClipboard(`{{ addslashes($clause->content) }}`)">
                                            <i data-lucide="copy" class="w-4 h-4"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-yellow-600" title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i data-lucide="file-text" class="w-12 h-12 text-gray-300 mb-3"></i>
                                        <p class="font-medium">No clauses found.</p>
                                        <p class="text-sm">Click "Add Clause" to create your first standard clause.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Clause Modal (Pure CSS/JS Approach) -->
    <div id="addClauseModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeAddClauseModal()"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl p-6 transform transition-all">
                <button type="button" onclick="closeAddClauseModal()"
                    class="absolute right-4 top-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i data-lucide="file-plus" class="w-5 h-5 text-blue-600"></i>
                    Add New Clause
                </h3>

                <form action="{{ route('legal.clauses.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Clause Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g. Confidentiality (Generic)">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="General">General</option>
                                <option value="Risk">Risk</option>
                                <option value="Liability">Liability</option>
                                <option value="Termination">Termination</option>
                                <option value="Intellectual Property">Intellectual Property</option>
                                <option value="Compliance">Compliance</option>
                                <option value="Litigation">Litigation</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Clause Content</label>
                            <textarea name="content" required rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter the full legal text of the clause...">{{ old('content') }}</textarea>
                            @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tags (Optional)</label>
                            <input type="text" name="tags" value="{{ old('tags') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Comma separated, e.g. standard, short-form">
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_mandatory" id="is_mandatory"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_mandatory" class="text-sm text-gray-700">Mark as Mandatory in all
                                contracts</label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                        <button type="button" onclick="closeAddClauseModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                            Save Clause
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Modal Functions
        function openAddClauseModal() {
            document.getElementById('addClauseModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddClauseModal() {
            document.getElementById('addClauseModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Attach event listeners
        document.addEventListener('DOMContentLoaded', function () {
            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeAddClauseModal();
                }
            });

            // Re-initialize icons
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                toast.textContent = 'Clause copied to clipboard!';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 2000);
            }).catch(err => {
                console.error('Error in copying text: ', err);
            });
        }
    </script>
@endpush