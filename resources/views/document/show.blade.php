<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $document->title }} - Policy Document</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  @vite(['resources/css/soliera.css'])
</head>

<body class="bg-base-100">
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('partials.sidebarr')
    <!-- Main content -->
    <div class="flex flex-col flex-1 overflow-hidden">
      <!-- Header -->
      @include('partials.navbar')

      <!-- Main content area -->
      <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
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

        <!-- Back button -->
        <div class="flex items-center mb-6">
          <a href="{{ route('executive.policy_approvals') }}"
            class="text-[#F7B32B] hover:text-[#e5a220] flex items-center gap-2 font-medium transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>BACK</span>
          </a>
        </div>

        <!-- Document Header -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
          <div class="flex items-start justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $document->title }}</h1>
            <span class="px-3 py-1.5 text-xs font-bold rounded-full uppercase 
              {{ $document->status === 'Draft' ? 'bg-amber-100 text-amber-700' : '' }}
              {{ $document->status === 'Approved' ? 'bg-emerald-100 text-emerald-700' : '' }}
              {{ $document->status === 'archived' ? 'bg-gray-100 text-gray-600' : '' }}">
              {{ ucfirst($document->status) }}
            </span>
          </div>

          @if($document->description)
            <div class="mb-6">
              <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Description</h3>
              <p class="text-gray-700 leading-relaxed">{{ $document->description }}</p>
            </div>
          @endif

          <div class="grid grid-cols-2 gap-6">
            <div>
              <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Uploaded By</h3>
              <p class="text-gray-900 font-medium">
                {{ $document->uploader_name ?? $document->uploader->name ?? 'Ernesto Piquero Jr' }}
              </p>
            </div>
            <div>
              <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">File Path</h3>
              <p class="text-gray-600 text-sm break-all">{{ $document->file_path }}</p>
            </div>
            <div>
              <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Category</h3>
              <p class="text-gray-900 font-medium">{{ ucfirst($document->category ?? 'General') }}</p>
            </div>
            <div>
              <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Upload Date</h3>
              <p class="text-gray-900 font-medium">{{ $document->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
              <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Last Updated</h3>
              <p class="text-gray-900 font-medium">{{ $document->updated_at->format('M d, Y H:i') }}</p>
            </div>
          </div>
        </div>

        <!-- Document File Section -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
          <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
            DOCUMENT FILE
          </h3>

          @if($document->file_path)
            <div class="border-2 border-blue-100 rounded-xl p-6 bg-blue-50/30 hover:bg-blue-50/50 transition-colors">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                  <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="file-text" class="w-8 h-8 text-blue-600"></i>
                  </div>
                  <div>
                    <p class="font-bold text-gray-900 text-lg mb-1">
                      {{ basename($document->file_path) }}
                    </p>
                    <div class="flex items-center gap-3 text-sm">
                      <span class="text-gray-600">
                        <i data-lucide="file" class="w-4 h-4 inline mr-1"></i>
                        PDF Document
                      </span>
                      @if($document->file_size || ($document->metadata && isset($document->metadata['file_size'])))
                        <span class="text-gray-600">
                          <i data-lucide="hard-drive" class="w-4 h-4 inline mr-1"></i>
                          {{ $document->file_size ?? $document->metadata['file_size'] ?? 'Unknown size' }}
                        </span>
                      @endif
                    </div>
                  </div>
                </div>
                <a href="{{ route('vault.documents.download', $document->id) }}"
                  class="btn bg-blue-600 hover:bg-blue-700 text-white border-0 gap-2 px-6" target="_blank">
                  <i data-lucide="download" class="w-4 h-4"></i>
                  Download
                </a>
              </div>
            </div>
          @else
            <div class="text-center py-12 text-gray-400">
              <i data-lucide="file-x" class="w-16 h-16 mx-auto mb-3 opacity-30"></i>
              <p class="text-sm italic">No document file attached.</p>
            </div>
          @endif
        </div>
      </main>
    </div>
  </div>

  @include('partials.soliera_js')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (window.lucide) {
        window.lucide.createIcons();
      }
    });
  </script>
</body>

</html>