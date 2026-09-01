@extends('layouts.app')

@section('title', 'Legal | Templates')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Legal Templates & Clauses</h2>
                    <p class="text-sm text-gray-600">Standardized documents and clause library.</p>
                </div>
                <a href="{{ route('legal.templates.create') }}"
                    class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    New Template
                </a>
            </div>

            <!-- Templates Grid -->
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Document Templates</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($templates as $template)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 rounded-lg bg-[#0A1829]">
                                @if($template->category == 'employment')
                                    <i data-lucide="users" class="w-6 h-6 text-[#EDA900]"></i>
                                @elseif($template->category == 'service_contract')
                                    <i data-lucide="briefcase" class="w-6 h-6 text-[#EDA900]"></i>
                                @else
                                    <i data-lucide="file-text" class="w-6 h-6 text-[#EDA900]"></i>
                                @endif
                            </div>
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold {{ $template->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($template->status) }}
                            </span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $template->name }}</h4>
                        <p class="text-sm text-gray-500 mb-4">{{ $template->description }}</p>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-xs text-gray-400">Ver. {{ $template->version }}</span>
                            <a href="{{ route('legal.documents.draft', ['template' => $template->id]) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">Use Template</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Clause Library -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Clause Library</h3>
                    <a href="{{ route('legal.clauses') }}" class="text-sm text-blue-600 hover:text-blue-800">View All
                        Clauses</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($clauses as $clause)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h5 class="text-sm font-bold text-gray-900">{{ $clause->title }}</h5>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">"{{ $clause->content }}"</p>
                                    <div class="mt-2 flex gap-2">
                                        <span
                                            class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded">{{ $clause->category }}</span>
                                        @if($clause->is_mandatory)
                                            <span class="bg-red-50 text-red-600 text-xs px-2 py-0.5 rounded">Mandatory</span>
                                        @endif
                                    </div>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600"
                                    onclick="copyToClipboard('{{ addslashes($clause->content) }}')">
                                    <i data-lucide="copy" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Clause copied to clipboard');
                }).catch(err => {
                    console.error('Error in copying text: ', err);
                });
            }
        </script>
    @endpush
@endsection