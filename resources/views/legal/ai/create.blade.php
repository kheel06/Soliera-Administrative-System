@extends('layouts.app')

@section('title', 'AI Legal Assistant | Analyze Document')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Analyze New Document</h2>
                            <p class="text-sm text-gray-600">Upload a contract or legal document for AI-powered risk
                                assessment.</p>
                        </div>
                        <a href="{{ route('legal.ai.insights') }}"
                            class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center gap-1">
                            <i data-lucide="x" class="w-4 h-4"></i> Cancel
                        </a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('legal.ai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-8">
                            <label for="document" class="block text-sm font-medium text-gray-700 mb-2">Upload Document (PDF,
                                DOCX, TXT)</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <div class="p-4 bg-purple-100 rounded-full mb-4">
                                            <i data-lucide="upload-cloud" class="w-8 h-8 text-purple-600"></i>
                                        </div>
                                        <p class="text-lg text-gray-700 font-medium mb-1">Click to upload or drag and drop
                                        </p>
                                        <p class="text-sm text-gray-500">PDF, DOCX, or TXT (MAX. 10MB)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" name="document" class="hidden" required />
                                </label>
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex gap-3">
                                <i data-lucide="info" class="w-5 h-5 text-blue-600 shrink-0"></i>
                                <div>
                                    <h4 class="font-semibold text-blue-800 text-sm">How it works</h4>
                                    <p class="text-sm text-blue-700 mt-1">Our AI analyzes your document for compliance
                                        risks, missing clauses, and non-standard terms against Philippine legal standards.
                                        Processing typically takes 30-60 seconds.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit"
                                class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2.5 px-6 rounded-lg flex items-center gap-2 shadow-sm transition-all">
                                <i data-lucide="sparkles" class="w-4 h-4"></i>
                                Start Analysis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const fileInput = document.getElementById('dropzone-file');
            const dropzone = fileInput.closest('label');

            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    const fileInfo = dropzone.querySelector('.flex-col');

                    fileInfo.innerHTML = `
                        <div class="p-4 bg-green-100 rounded-full mb-4">
                            <i data-lucide="file-check" class="w-8 h-8 text-green-600"></i>
                        </div>
                        <p class="text-lg text-gray-700 font-medium mb-1">${fileName}</p>
                        <p class="text-sm text-green-600 font-medium">Ready to analyze</p>
                    `;

                    // Re-initialize icons just in case
                    if (window.lucide) {
                        window.lucide.createIcons();
                    }
                }
            });
        </script>
    @endpush
@endsection