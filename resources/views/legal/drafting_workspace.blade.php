<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Legal Document Drafting Workspace - Soliera</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/css/soliera.css', 'resources/js/app.js'])
  <style>
    .ql-editor {
      min-height: 500px;
      font-family: 'Times New Roman', serif;
      font-size: 12pt;
      line-height: 1.5;
    }

    .read-only-mode {
      background-color: #f9fafb !important;
      /* Light gray */
      color: #6b7280 !important;
    }

    /* Disable toolbar interaction when read-only */
    .ql-disabled .ql-toolbar {
      opacity: 0.5;
      pointer-events: none;
    }

    .ql-toolbar {
      border-top: 1px solid #ccc;
      border-left: 1px solid #ccc;
      border-right: 1px solid #ccc;
    }

    .ql-container {
      border-bottom: 1px solid #ccc;
      border-left: 1px solid #ccc;
      border-right: 1px solid #ccc;
    }

    .drafting-workspace {
      height: calc(100vh - 120px);
    }

    .editor-container {
      height: calc(100vh - 200px);
    }

    .toolbar-section {
      background: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
    }

    .document-info {
      background: #e9ecef;
      border-bottom: 1px solid #dee2e6;
    }

    /* Ensure proper spacing for the new layout */
    .card-body {
      padding: 1rem;
    }
  </style>
</head>

<body class="bg-base-100">
  @include('partials.page-loader')
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

        <!-- Page Header -->
        <div class="mb-8">
          <div class="bg-gradient-to-r from-blue-50 to-indigo-100 rounded-lg p-6 border border-blue-200">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2" style="color: var(--color-charcoal-ink);">
                  <i data-lucide="file-text" class="w-8 h-8 inline-block mr-3 text-blue-600"></i>
                  Legal Document Drafting Workspace
                </h1>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Editor Container -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
          <!-- Editor Header -->
          <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
              <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                  <div class="p-2 bg-blue-100 rounded-lg">
                    <i data-lucide="edit-3" class="w-6 h-6 text-blue-600"></i>
                  </div>
                  <div>
                    <h3 class="text-xl font-semibold text-gray-800">Document Editor</h3>
                    <p class="text-sm text-gray-500">Professional legal document creation</p>
                  </div>
                </div>
                @if($document)
                  <span class="badge badge-info badge-lg">
                    <i data-lucide="file-edit" class="w-4 h-4 mr-1"></i>
                    Editing: {{ $document->title }}
                  </span>
                @else
                  <span class="badge badge-primary badge-lg">
                    <i data-lucide="file-plus" class="w-4 h-4 mr-1"></i>
                    New Document
                  </span>
                @endif
              </div>
            </div>

            <!-- Document Properties -->
            <div class="bg-white rounded-lg p-4 border border-gray-200">
              <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i data-lucide="settings" class="w-4 h-4"></i>
                Document Properties
              </h4>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium text-gray-700">Document Title</span>
                  </label>
                  <input type="text" id="documentTitle"
                    class="input input-bordered w-full focus:ring-2 focus:ring-blue-500"
                    value="{{ $document->title ?? '' }}" placeholder="Enter document title...">
                </div>
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium text-gray-700">Document Type</span>
                  </label>
                  <select id="documentType" class="select select-bordered w-full focus:ring-2 focus:ring-blue-500">
                    <option value="contract" {{ ($document->category ?? '') == 'contract' ? 'selected' : '' }}>Contract
                    </option>
                    <option value="employment" {{ ($document->category ?? '') == 'employment' ? 'selected' : '' }}>
                      Employment</option>
                    <option value="NDA" {{ ($document->category ?? '') == 'NDA' ? 'selected' : '' }}>NDA</option>
                    <option value="policy" {{ ($document->category ?? '') == 'policy' ? 'selected' : '' }}>Policy</option>
                    <option value="agreement" {{ ($document->category ?? '') == 'agreement' ? 'selected' : '' }}>Agreement
                    </option>
                    <option value="SLA" {{ ($document->category ?? '') == 'SLA' ? 'selected' : '' }}>SLA</option>
                    <option value="notice" {{ ($document->category ?? '') == 'notice' ? 'selected' : '' }}>Notice</option>
                    <option value="memorandum" {{ ($document->category ?? '') == 'memorandum' ? 'selected' : '' }}>
                      Memorandum</option>
                    <option value="license" {{ ($document->category ?? '') == 'license' ? 'selected' : '' }}>License
                    </option>
                    <option value="subpoena" {{ ($document->category ?? '') == 'subpoena' ? 'selected' : '' }}>Subpoena
                    </option>
                    <option value="affidavit" {{ ($document->category ?? '') == 'affidavit' ? 'selected' : '' }}>Affidavit
                    </option>
                    <option value="cease and desist" {{ ($document->category ?? '') == 'cease and desist' ? 'selected' : '' }}>Cease & Desist</option>
                    <option value="legal brief" {{ ($document->category ?? '') == 'legal brief' ? 'selected' : '' }}>Legal
                      Brief</option>
                    <option value="financial" {{ ($document->category ?? '') == 'financial' ? 'selected' : '' }}>Financial
                    </option>
                    <option value="compliance" {{ ($document->category ?? '') == 'compliance' ? 'selected' : '' }}>
                      Compliance</option>
                    <option value="report" {{ ($document->category ?? '') == 'report' ? 'selected' : '' }}>Report</option>
                    <option value="general" {{ ($document->category ?? '') == 'general' ? 'selected' : '' }}>General
                    </option>
                  </select>
                </div>
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium text-gray-700">Contract Value</span>
                  </label>
                  <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">₱</span>
                    <input type="number" id="contractValue"
                      class="input input-bordered w-full pl-8 focus:ring-2 focus:ring-blue-500"
                      value="{{ $contract->contract_value ?? '' }}" placeholder="0.00" step="0.01">
                  </div>
                </div>
                <!-- Row 2 -->
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium text-gray-700">Counterparty</span>
                  </label>
                  <input type="text" id="counterpartyName"
                    class="input input-bordered w-full focus:ring-2 focus:ring-blue-500"
                    value="{{ $contract->counterparty_name ?? '' }}" placeholder="Enter counterparty name...">
                </div>
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium text-gray-700">Effective Date</span>
                  </label>
                  <input type="date" id="effectiveDate"
                    class="input input-bordered w-full focus:ring-2 focus:ring-blue-500"
                    value="{{ isset($contract->effective_date) ? $contract->effective_date->format('Y-m-d') : '' }}">
                </div>
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium text-gray-700">Expiration Date</span>
                  </label>
                  <input type="date" id="expirationDate"
                    class="input input-bordered w-full focus:ring-2 focus:ring-blue-500"
                    value="{{ isset($contract->expiration_date) ? $contract->expiration_date->format('Y-m-d') : '' }}">
                </div>
              </div>
            </div>
          </div>

          <!-- Editor Content -->
          <div class="p-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
              <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                <div class="flex items-center justify-between">
                  <h4 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <i data-lucide="type" class="w-4 h-4"></i>
                    Rich Text Editor
                  </h4>
                  <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span id="headerWordCount">Words: 0</span>
                    <span id="headerCharCount">Characters: 0</span>
                    <span id="templateStatusBadge" class="text-green-600 font-medium hidden">Template loaded
                      (Read-Only)</span>
                    <span class="text-green-600" id="headerLastSaved">Ready</span>
                  </div>
                </div>
              </div>
              <!-- Quill Editor -->
              <div id="editor" style="height: 500px;"></div>
            </div>
          </div>

          <!-- Editor Footer -->
          <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-200 p-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                  <i data-lucide="file-text" class="w-4 h-4 text-blue-500"></i>
                  <span id="footerWordCount">Words: 0</span>
                </div>
                <div class="flex items-center gap-2">
                  <i data-lucide="type" class="w-4 h-4 text-green-500"></i>
                  <span id="footerCharCount">Characters: 0</span>
                </div>
                <div class="flex items-center gap-2">
                  <i data-lucide="clock" class="w-4 h-4 text-orange-500"></i>
                  <span id="footerLastSaved">Ready</span>
                </div>
                <div class="flex items-center gap-2">
                  <i data-lucide="shield-check" class="w-4 h-4 text-green-500"></i>
                  <span class="text-green-600">Auto-save: ON</span>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <button onclick="saveDocument()"
                  class="btn btn-warning btn-sm bg-[#EA9A00] border-none text-white hover:bg-[#d48c00] flex items-center gap-2 px-6">
                  <i data-lucide="save" class="w-4 h-4"></i>
                  SAVE DOCUMENT
                </button>
                <div class="dropdown dropdown-end">
                  <button tabindex="0"
                    class="btn btn-warning btn-sm bg-[#EA9A00] border-none text-white hover:bg-[#d48c00] flex items-center gap-2 px-6">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    EXPORT
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                  </button>
                  <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-40">
                    <li><a onclick="exportDocument('pdf')" class="flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        Export as PDF
                      </a></li>
                    <li><a onclick="exportDocument('word')" class="flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        Export as Word
                      </a></li>
                  </ul>
                </div>
                <button onclick="window.history.back()"
                  class="btn btn-ghost btn-sm text-gray-500 hover:bg-gray-100 flex items-center gap-2">
                  <i data-lucide="x" class="w-4 h-4"></i>
                  CLOSE
                </button>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Template Selection Modal -->
  <div id="templateModal" class="modal">
    <div class="modal-box w-11/12 max-w-4xl">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold">Choose a Template</h3>
        <button class="btn btn-sm btn-circle btn-ghost" onclick="closeTemplateModal()">✕</button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($templates as $key => $template)
          <div class="card bg-base-100 shadow-sm border border-gray-200 cursor-pointer hover:shadow-md transition-shadow"
            data-template-key="{{ $key }}"
            onclick="loadTemplateContent('{{ $key }}', '{{ addslashes($template['title']) }}', `{{ addslashes($template['content']) }}`, true)">
            <div class="card-body p-4">
              <h4 class="card-title text-sm">{{ $template['title'] }}</h4>
              <p class="text-xs text-gray-600 mt-2">Click to load this template</p>
            </div>
          </div>
        @endforeach
      </div>

      <div class="modal-action">
        <button class="btn btn-outline" onclick="closeTemplateModal()">Cancel</button>
      </div>
    </div>
  </div>

  <!-- E‑Signature Modal -->
  <div id="esignModal" class="modal">
    <div class="modal-box w-11/12 max-w-lg">
      <h3 class="font-bold text-lg mb-4">Send for E‑Signature</h3>
      <div class="grid grid-cols-1 gap-3">
        <div>
          <label class="label"><span class="label-text">Hotel Signer Name</span></label>
          <input id="hotelSignerName" type="text" class="input input-bordered w-full"
            placeholder="e.g. Juan Dela Cruz" />
        </div>
        <div>
          <label class="label"><span class="label-text">Hotel Signer Email</span></label>
          <input id="hotelSignerEmail" type="email" class="input input-bordered w-full"
            placeholder="e.g. juan@example.com" />
        </div>
        <div>
          <label class="label"><span class="label-text">Vendor Signer Name</span></label>
          <input id="vendorSignerName" type="text" class="input input-bordered w-full"
            placeholder="e.g. Maria Santos" />
        </div>
        <div>
          <label class="label"><span class="label-text">Vendor Signer Email</span></label>
          <input id="vendorSignerEmail" type="email" class="input input-bordered w-full"
            placeholder="e.g. maria@example.com" />
        </div>
      </div>
      <div class="modal-action">
        <button class="btn btn-outline" onclick="closeESignModal()">Cancel</button>
        <button class="btn btn-primary" onclick="sendForESign()">Send</button>
      </div>
    </div>
  </div>

  <!-- Pen Signature Modal -->
  <div id="penSignModal" class="modal">
    <div class="modal-box w-11/12 max-w-2xl">
      <h3 class="font-bold text-lg mb-4">Draw Your Signature</h3>
      <div class="border rounded-lg p-3 bg-gray-50">
        <div class="flex items-center justify-between mb-2">
          <div class="flex items-center gap-2">
            <label class="text-sm">Pen Color</label>
            <input id="penColor" type="color" value="#000000" class="w-8 h-8 border rounded">
            <label class="text-sm ml-4">Thickness</label>
            <input id="penSize" type="range" min="1" max="8" value="3" class="range range-xs w-40">
          </div>
          <div class="flex items-center gap-2">
            <button class="btn btn-outline btn-sm" onclick="clearPenCanvas()"><i data-lucide="trash-2"
                class="w-4 h-4 mr-1"></i>Clear</button>
          </div>
        </div>
        <div class="bg-white border rounded-lg overflow-hidden">
          <canvas id="penCanvas" width="900" height="220"
            style="touch-action:none; display:block; width:100%; height:220px; cursor: crosshair;"></canvas>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn btn-outline" onclick="closePenSignModal()">Cancel</button>
        <button class="btn btn-primary" onclick="insertPenSignature()">Insert to Document</button>
      </div>
    </div>
  </div>

  <script>
    let quill;
    let documentId = {{ $document->id ?? 'null' }};
    let autoSaveInterval;
    let isDirty = false;
    let loadedTemplateKey = null; // Track which template has been loaded
    // Expose templates to client for robust loading via URL param
    const TEMPLATES = @json($templates ?? []);

    // Initialize Quill editor
    document.addEventListener('DOMContentLoaded', function () {
      // Quill configuration
      const toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'font': [] }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'script': 'sub' }, { 'script': 'super' }],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],
        [{ 'direction': 'rtl' }],
        [{ 'align': [] }],
        ['blockquote', 'code-block'],
        ['link', 'image'],
        ['pen'], // custom pen button
        ['clean']
      ];

      quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
          toolbar: toolbarOptions
        },
        placeholder: 'Start typing your legal document...'
      });

      // Hook custom pen button to open signature modal
      const penBtn = document.querySelector('.ql-pen');
      if (penBtn) {
        penBtn.title = 'Sign with Pen';
        penBtn.innerHTML = '🖊';
        penBtn.style.fontSize = '14px';
        penBtn.addEventListener('click', openPenSignModal);
      }

      // Load existing content if editing (preserve original HTML)
      @if($document && $document->metadata && isset($document->metadata['content']))
        const __initialHtml = @json($document->metadata['content']);
        quill.setContents(quill.clipboard.convert(__initialHtml));
      @elseif($selectedTemplate)
        // Load template content in Read-Only mode
        loadTemplateContent('{{ $selectedTemplate["id"] ?? $templateParam }}', '{{ addslashes($selectedTemplate["title"]) }}', `{!! addslashes($selectedTemplate["content"]) !!}`, true);

        @if(isset($selectedTemplate['category']))
          const category = '{{ $selectedTemplate["category"] }}';
          // Try to set value directly
          const docTypeSelect = document.getElementById('documentType');
          docTypeSelect.value = category;

          // If value didn't stick (case sensitivity mismatch), try to find matching option
          if (docTypeSelect.value !== category) {
            for (let i = 0; i < docTypeSelect.options.length; i++) {
              if (docTypeSelect.options[i].value.toLowerCase() === category.toLowerCase()) {
                docTypeSelect.selectedIndex = i;
                break;
              }
            }
          }
        @endif
      @endif

      // Set up event listeners
      quill.on('text-change', function () {
        isDirty = true;
        updateWordCount();
        updateLastSaved('Unsaved changes');
      });

      // Handle Document Type change to load corresponding template
      document.getElementById('documentType').addEventListener('change', function () {
        const selectedType = this.value;
        const currentTitle = document.getElementById('documentTitle').value.trim();
        const newTitle = currentTitle || (selectedType.charAt(0).toUpperCase() + selectedType.slice(1) + ' Template');

        // Update title if it was empty
        if (!currentTitle) {
          document.getElementById('documentTitle').value = newTitle;
        }

        // Generate template content
        const templateContent = generateLegalTemplate(selectedType, newTitle);

        // Clear editor and load new content
        quill.setContents([]);
        // Convert to HTML (preserving newlines) and set in Quill
        const htmlContent = templateContent.replace(/\n/g, '<br>');
        quill.clipboard.dangerouslyPasteHTML(htmlContent);

        isDirty = true;
        updateWordCount();
        updateLastSaved('Template changed to ' + selectedType);
        showNotification('Document template updated to ' + selectedType, 'info');
      });

      // Auto-save every 30 seconds
      autoSaveInterval = setInterval(function () {
        if (isDirty) {
          saveDraft(true); // Silent save
        }
      }, 30000);

      // Update word count on load
      updateWordCount();

      // Robust URL-param based template loader (fallback if server-side condition missed)
      try {
        const params = new URLSearchParams(window.location.search);
        const key = params.get('template');
        if (key && typeof key === 'string' && TEMPLATES[key]) {
          const tpl = TEMPLATES[key];
          loadTemplateContent(key, tpl.title, tpl.content);
        }
      } catch (e) { }
    });

    // Word count and character count
    function updateWordCount() {
      const text = quill.getText();
      // Remove trailing newline that Quill adds
      const cleanText = text.replace(/\n$/, '');
      const words = cleanText.trim().split(/\s+/).filter(word => word.length > 0).length;
      const chars = cleanText.length;

      const wordText = `Words: ${words}`;
      const charText = `Characters: ${chars}`;

      // Update Header
      const headerWordCount = document.getElementById('headerWordCount');
      const headerCharCount = document.getElementById('headerCharCount');
      if (headerWordCount) headerWordCount.textContent = wordText;
      if (headerCharCount) headerCharCount.textContent = charText;

      // Update Footer
      const footerWordCount = document.getElementById('footerWordCount');
      const footerCharCount = document.getElementById('footerCharCount');
      if (footerWordCount) footerWordCount.textContent = wordText;
      if (footerCharCount) footerCharCount.textContent = charText;
    }

    function updateLastSaved(message) {
      const headerLastSaved = document.getElementById('headerLastSaved');
      const footerLastSaved = document.getElementById('footerLastSaved');

      if (headerLastSaved) headerLastSaved.textContent = message;
      if (footerLastSaved) footerLastSaved.textContent = message;
    }

    // Template functions
    function loadTemplate() {
      // Update template visibility based on loaded template
      updateTemplateVisibility();
      document.getElementById('templateModal').classList.add('modal-open');
    }

    function updateTemplateVisibility() {
      // Hide the loaded template from the modal
      const templateCards = document.querySelectorAll('[data-template-key]');
      templateCards.forEach(card => {
        const templateKey = card.getAttribute('data-template-key');
        if (loadedTemplateKey && templateKey === loadedTemplateKey) {
          card.style.display = 'none';
        } else {
          card.style.display = 'block';
        }
      });
    }

    function closeTemplateModal() {
      document.getElementById('templateModal').classList.remove('modal-open');
    }

    function loadTemplateContent(templateKey, title, content, isReadOnly = false) {
      if ((typeof templateKey === 'string' || typeof templateKey === 'number') && title && content) {
        // Correctly handle HTML content (don't escape twice)
        quill.clipboard.dangerouslyPasteHTML(content);
        document.getElementById('documentTitle').value = title;

        if (isReadOnly) {
          setTimeout(() => {
            quill.enable(false);
            quill.root.setAttribute('contenteditable', false);
            quill.root.classList.add('read-only-mode'); // Optional styling hook
          }, 100);
          document.getElementById('templateStatusBadge').classList.remove('hidden');
          updateLastSaved('Template loaded (Read-Only)');

          // Disable inputs (Title should be read only for templates, but allow metadata edits)
          document.getElementById('documentTitle').readOnly = true;

          // Enable metadata fields for user input even when template is loaded
          document.getElementById('documentType').disabled = false;
          document.getElementById('contractValue').readOnly = false;
          document.getElementById('counterpartyName').readOnly = false;
          document.getElementById('effectiveDate').readOnly = false;
          document.getElementById('expirationDate').readOnly = false;

          isDirty = false;
        } else {
          quill.enable(true);
          quill.root.setAttribute('contenteditable', true);
          quill.root.classList.remove('read-only-mode');
          document.getElementById('templateStatusBadge').classList.add('hidden');

          // Enable inputs
          document.getElementById('documentTitle').readOnly = false;
          document.getElementById('documentType').disabled = false;
          document.getElementById('contractValue').readOnly = false;
          document.getElementById('counterpartyName').readOnly = false;
          document.getElementById('effectiveDate').readOnly = false;
          document.getElementById('expirationDate').readOnly = false;

          isDirty = true;
          updateLastSaved('Template loaded');
        }

        updateWordCount();

        // Track the loaded template
        loadedTemplateKey = templateKey;

        if (document.getElementById('templateModal').classList.contains('modal-open')) {
          closeTemplateModal();
        }

        if (!isReadOnly) {
          showNotification('Template loaded successfully', 'success');
        }
      } else {
        showNotification('Error loading template', 'error');
        closeTemplateModal();
      }
    }


    // Save functions
    function saveDraft(silent = false) {
      const title = document.getElementById('documentTitle').value.trim();
      const content = quill.root.innerHTML;
      const documentType = document.getElementById('documentType').value;
      const contractValue = document.getElementById('contractValue').value;
      const counterpartyName = document.getElementById('counterpartyName').value;
      const effectiveDate = document.getElementById('effectiveDate').value;
      const expirationDate = document.getElementById('expirationDate').value;

      if (!title) {
        if (!silent) {
          showNotification('Please enter a document title', 'error');
        }
        return;
      }

      if (!content || content === '<p><br></p>') {
        if (!silent) {
          showNotification('Please enter some content', 'error');
        }
        return;
      }

      const formData = new FormData();
      formData.append('title', title);
      formData.append('content', content);
      formData.append('document_type', documentType);
      formData.append('contract_value', contractValue);
      formData.append('counterparty_name', counterpartyName);
      formData.append('effective_date', effectiveDate);
      formData.append('expiration_date', expirationDate);
      formData.append('document_id', documentId || '');
      formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

      fetch('{{ route("legal.documents.save_draft") }}', {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            documentId = data.document_id;
            isDirty = false;
            if (!silent) {
              showNotification(data.message, 'success');
            }
            updateLastSaved('Saved at ' + new Date().toLocaleTimeString());
          } else {
            if (!silent) {
              showNotification('Error saving draft: ' + (data.message || 'Unknown error'), 'error');
            }
          }
        })
        .catch(error => {
          console.error('Error:', error);
          if (!silent) {
            showNotification('Error saving draft', 'error');
          }
        });
    }

    function saveDocument() {
      const title = document.getElementById('documentTitle').value.trim();
      const content = quill.root.innerHTML;
      const documentType = document.getElementById('documentType').value;
      const contractValue = document.getElementById('contractValue').value;
      const counterpartyName = document.getElementById('counterpartyName').value;
      const effectiveDate = document.getElementById('effectiveDate').value;
      const expirationDate = document.getElementById('expirationDate').value;

      if (!title) {
        showNotification('Please enter a document title', 'error');
        return;
      }

      if (!content || content === '<p><br></p>') {
        showNotification('Please enter some content', 'error');
        return;
      }

      const formData = new FormData();
      formData.append('title', title);
      formData.append('content', content);
      formData.append('document_type', documentType);
      formData.append('contract_value', contractValue);
      formData.append('counterparty_name', counterpartyName);
      formData.append('effective_date', effectiveDate);
      formData.append('expiration_date', expirationDate);
      formData.append('document_id', documentId || '');
      formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

      fetch('{{ route("legal.documents.save_draft") }}', {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            documentId = data.document_id;
            isDirty = false;
            showNotification('Document saved successfully!', 'success');
            updateLastSaved('Saved at ' + new Date().toLocaleTimeString());
            setTimeout(() => {
              window.location.href = '{{ route("legal.legal_documents", ["tab" => "create"]) }}';
            }, 1500);
          } else {
            showNotification('Error saving document: ' + (data.message || 'Unknown error'), 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showNotification('Error saving document', 'error');
        });
    }

    function exportDocument(format) {
      if (!documentId) {
        showNotification('Please save the document first before exporting', 'error');
        return;
      }

      window.open(`{{ route("legal.documents.export", ":id") }}?format=${format}`.replace(':id', documentId), '_blank');
    }

    // Insert a reusable signature block at the end of the document
    function insertSignatureBlock() {
      const today = new Date().toISOString().slice(0, 10);
      const block = `
        <div style="page-break-inside: avoid; margin-top: 32px;">
          <p><strong>IN WITNESS WHEREOF</strong>, the parties have executed this document on <u>${today}</u>.</p>
          <table style="width:100%; margin-top:24px; font-size:12pt;">
            <tr>
              <td style="width:50%; vertical-align:top; padding-right:16px;">
                <div style="margin-bottom:48px;">
                  <div style="border-top:1px solid #000; width:260px; margin-top:40px;"></div>
                  <div><strong>Authorized Signatory</strong></div>
                  <div>For: <strong>{{ '{' }}{HotelLegalName}{{ '}' }}</strong></div>
                  <div>Name: __________________________</div>
                  <div>Title: __________________________</div>
                  <div>Date: __________________________</div>
                </div>
              </td>
              <td style="width:50%; vertical-align:top; padding-left:16px;">
                <div style="margin-bottom:48px;">
                  <div style="border-top:1px solid #000; width:260px; margin-top:40px;"></div>
                  <div><strong>Authorized Signatory</strong></div>
                  <div>For: <strong>{{ '{' }}{ServiceProviderLegalName}{{ '}' }}</strong></div>
                  <div>Name: __________________________</div>
                  <div>Title: __________________________</div>
                  <div>Date: __________________________</div>
                </div>
              </td>
            </tr>
          </table>
        </div>`;

      const range = quill.getSelection(true);
      // Move cursor to end then paste
      quill.setSelection(quill.getLength() - 1, 0);
      quill.clipboard.dangerouslyPasteHTML(quill.getLength() - 1, block);
      isDirty = true;
      updateLastSaved('Signature block inserted');
    }

    function openESignModal() {
      if (!documentId) {
        showNotification('Save or approve the document first', 'error');
        return;
      }
      document.getElementById('esignModal').classList.add('modal-open');
    }
    function closeESignModal() {
      document.getElementById('esignModal').classList.remove('modal-open');
    }
    function sendForESign() {
      const hotelName = document.getElementById('hotelSignerName').value.trim();
      const hotelEmail = document.getElementById('hotelSignerEmail').value.trim();
      const vendorName = document.getElementById('vendorSignerName').value.trim();
      const vendorEmail = document.getElementById('vendorSignerEmail').value.trim();
      if (!hotelName || !hotelEmail || !vendorName || !vendorEmail) {
        showNotification('Please provide all signer details', 'error');
        return;
      }
      const formData = new FormData();
      formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
      formData.append('hotel_signer_name', hotelName);
      formData.append('hotel_signer_email', hotelEmail);
      formData.append('vendor_signer_name', vendorName);
      formData.append('vendor_signer_email', vendorEmail);

      fetch(`{{ url('/legal/documents') }}/${documentId}/send-esign`, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(r => r.json())
        .then(d => {
          if (d.success) {
            showNotification('E‑signature request sent', 'success');
            closeESignModal();
          } else {
            showNotification(d.message || 'Failed to send for e‑signature', 'error');
          }
        })
        .catch(() => showNotification('Failed to send for e‑signature', 'error'));
    }

    // Pen signature functions
    let penCanvas, penCtx, drawing = false, lastX = 0, lastY = 0;
    function openPenSignModal() {
      const modal = document.getElementById('penSignModal');
      modal.classList.add('modal-open');
      setTimeout(() => initPenCanvas(), 0);
    }
    function closePenSignModal() {
      document.getElementById('penSignModal').classList.remove('modal-open');
    }
    function initPenCanvas() {
      penCanvas = document.getElementById('penCanvas');
      if (!penCanvas) return;
      penCtx = penCanvas.getContext('2d');
      penCtx.lineCap = 'round';
      penCtx.lineJoin = 'round';
      // Mouse events
      penCanvas.onmousedown = (e) => { drawing = true;[lastX, lastY] = getPos(e); };
      penCanvas.onmousemove = (e) => { if (!drawing) return; drawLine(e); };
      penCanvas.onmouseup = () => drawing = false;
      penCanvas.onmouseleave = () => drawing = false;
      // Touch events
      penCanvas.addEventListener('touchstart', (e) => { e.preventDefault(); drawing = true;[lastX, lastY] = getPos(e.touches[0]); });
      penCanvas.addEventListener('touchmove', (e) => { e.preventDefault(); if (!drawing) return; drawLine(e.touches[0]); });
      penCanvas.addEventListener('touchend', () => drawing = false);
    }
    function getPos(e) {
      const rect = penCanvas.getBoundingClientRect();
      return [(e.clientX - rect.left) * (penCanvas.width / rect.width), (e.clientY - rect.top) * (penCanvas.height / rect.height)];
    }
    function drawLine(e) {
      const [x, y] = getPos(e);
      penCtx.strokeStyle = document.getElementById('penColor').value;
      penCtx.lineWidth = document.getElementById('penSize').value;
      penCtx.beginPath();
      penCtx.moveTo(lastX, lastY);
      penCtx.lineTo(x, y);
      penCtx.stroke();
      [lastX, lastY] = [x, y];
    }
    function clearPenCanvas() {
      if (!penCtx) return; penCtx.clearRect(0, 0, penCanvas.width, penCanvas.height);
    }
    function insertPenSignature() {
      if (!penCanvas) return;
      const dataUrl = penCanvas.toDataURL('image/png');
      const html = `<p><img src="${dataUrl}" style="max-width:300px; height:auto;" /></p>`;
      quill.clipboard.dangerouslyPasteHTML(quill.getLength() - 1, html);
      isDirty = true;
      updateLastSaved('Signature inserted');
      closePenSignModal();
    }

    // Notification function
    // Global showNotification is provided by soliera_js.blade.php
    // No need to define fallback - the global function with Soliera theme is already available

    // Warn before leaving if there are unsaved changes
    window.addEventListener('beforeunload', function (e) {
      if (isDirty) {
        e.preventDefault();
        e.returnValue = '';
      }
    });

    // Clean up on page unload
    window.addEventListener('unload', function () {
      if (autoSaveInterval) {
        clearInterval(autoSaveInterval);
      }
    });


    // Generate proper legal templates
    function generateLegalTemplate(documentType, title) {
      const currentDate = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
      const companyName = '<span contenteditable="false">SOLIERA HOTEL</span>';

      const header = `
        <div style="text-align: center; margin-bottom: 2.5rem; font-family: 'Times New Roman', serif;">
          <h1 style="font-size: 26pt; font-weight: bold; margin-bottom: 0.2em; text-transform: uppercase; letter-spacing: 2px; color: #000;">${companyName}</h1>
          <p style="font-size: 11pt; color: #333; margin: 0;">[HOTEL ADDRESS]</p>
          <p style="font-size: 11pt; color: #333; margin: 0;">[CITY, STATE ZIP]</p>
          <div style="margin: 1.5rem auto; border-bottom: 2px solid #000; width: 60%;"></div>
          <h2 style="font-size: 20pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 0.5em; color: #000;">${title}</h2>
          <p style="font-size: 12pt; margin-top: 0.5em; color: #000;">Date: <strong>${currentDate}</strong></p>
        </div>
      `;

      let content = '';
      switch (documentType) {
        case 'contract':
        case 'employment contract':
          content = generateEmploymentContractTemplate(title, currentDate, companyName);
          break;
        case 'policy':
        case 'hr policy':
          content = generatePolicyTemplate(title, currentDate, companyName);
          break;
        case 'agreement':
        case 'service agreement':
          content = generateAgreementTemplate(title, currentDate, companyName);
          break;
        case 'notice':
        case 'legal notice':
          content = generateNoticeTemplate(title, currentDate, companyName);
          break;
        case 'memorandum':
        case 'memo':
          content = generateMemorandumTemplate(title, currentDate, companyName);
          break;
        case 'license':
        case 'permit':
          content = generateLicenseTemplate(title, currentDate, companyName);
          break;
        case 'subpoena':
          content = generateSubpoenaTemplate(title, currentDate, companyName);
          break;
        case 'affidavit':
          content = generateAffidavitTemplate(title, currentDate, companyName);
          break;
        case 'cease and desist':
        case 'cease desist':
          content = generateCeaseDesistTemplate(title, currentDate, companyName);
          break;
        case 'legal brief':
        case 'brief':
          content = generateLegalBriefTemplate(title, currentDate, companyName);
          break;
        case 'financial':
        case 'financial document':
          content = generateFinancialTemplate(title, currentDate, companyName);
          break;
        case 'compliance':
        case 'compliance document':
          content = generateComplianceTemplate(title, currentDate, companyName);
          break;
        case 'report':
        case 'legal report':
          content = generateReportTemplate(title, currentDate, companyName);
          break;
        default:
          content = generateGeneralTemplate(title, currentDate, companyName);
          break;
      }

      return `<div style="padding: 1in; font-family: 'Times New Roman', serif; line-height: 1.6; max-width: 8.5in; margin: 0 auto;">
        ${header}
        <div style="font-size: 12pt; text-align: justify; color: #000;">
          ${content}
        </div>
      </div>`;
    }

    // Employment Contract Template
    function generateEmploymentContractTemplate(title, date, company) {
      return `
        <p>This Employment Contract ("Agreement") is entered into on <strong>${date}</strong> between <strong>${company}</strong> ("Company") and <strong>[EMPLOYEE_NAME]</strong> ("Employee").</p>
        
        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">1. POSITION AND DUTIES</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">Employee shall serve as [POSITION_TITLE] and shall perform all duties and responsibilities associated with this position as assigned by the Company. Employee agrees to devote their full professional time and effort to the performance of these duties.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">2. COMPENSATION</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">Employee shall receive a base salary of <strong>$[SALARY_AMOUNT]</strong> per [PAY_PERIOD], payable in accordance with the Company's standard payroll practices and subject to applicable withholdings.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">3. WORK SCHEDULE</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">Employee's regular work schedule shall be [WORK_HOURS] per week, Monday through Friday, from [START_TIME] to [END_TIME]. The Company reserves the right to modify this schedule as operational needs require.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">4. BENEFITS</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">Employee shall be entitled to participate in the Company's benefit programs, including but not limited to health insurance, dental insurance, retirement plans, and paid time off, subject to eligibility requirements.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">5. TERMINATION</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">This Agreement may be terminated by either party with [NOTICE_PERIOD] written notice, or immediately by the Company for cause as defined by applicable labor laws.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">6. CONFIDENTIALITY</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">Employee agrees to maintain the absolute confidentiality of all Company proprietary information, trade secrets, and guest data during and after the term of employment.</p>

        <div style="margin-top: 4em;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="width: 50%; vertical-align: bottom;">
                <p style="margin-bottom: 4em;"><strong>FOR THE COMPANY:</strong></p>
                <div style="border-bottom: 1px solid #000; width: 85%;"></div>
                <p style="margin-top: 0.5em;">[REPRESENTATIVE NAME]<br><span style="font-size: 10pt; color: #666;">Title: [TITLE]</span></p>
              </td>
              <td style="width: 50%; vertical-align: bottom;">
                <p style="margin-bottom: 4em;"><strong>FOR THE EMPLOYEE:</strong></p>
                <div style="border-bottom: 1px solid #000; width: 85%;"></div>
                <p style="margin-top: 0.5em;">[EMPLOYEE NAME]<br><span style="font-size: 10pt; color: #666;">ID: [ID_NUMBER]</span></p>
              </td>
            </tr>
          </table>
        </div>
      `;
    }

    // Policy Template
    function generatePolicyTemplate(title, date, company) {
      return `
        <p><strong>Effective Date:</strong> ${date}</p>
        <p><strong>Policy Number:</strong> POL-${new Date().getFullYear()}-[000]</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">1. PURPOSE</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">This policy establishes guidelines for [POLICY_SUBJECT] to ensure professional standards and compliance with applicable laws, regulations, and hotel standards.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">2. SCOPE</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">This policy applies to all employees, contractors, and third-party stakeholders associated with <strong>${company}</strong>.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">3. POLICY STATEMENT</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;"><strong>${company}</strong> is committed to [CORE_POLICY_PRINCIPLE]. All personnel are expected to adhere to the following standards: [DETAILED_POLICY_CONTENT]</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">4. PROCEDURES</h3>
        <ul style="margin-left: 0.5in; margin-top: 0.5em;">
          <li>Process Step 1: [DESCRIPTION]</li>
          <li>Process Step 2: [DESCRIPTION]</li>
          <li>Process Step 3: [DESCRIPTION]</li>
        </ul>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">5. COMPLIANCE</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">Failure to comply with this policy may result in disciplinary action, up to and including termination of employment or contract, in accordance with Company regulations.</p>

        <div style="margin-top: 4em; border-top: 1px solid #000; padding-top: 1em; width: 45%;">
          <p><strong>APPROVED BY:</strong><br>
          <span style="font-size: 12pt; font-weight: bold;">[APPROVER_NAME]</span><br>
          <span style="font-size: 10pt; color: #666;">[APPROVER_TITLE]</span></p>
        </div>
      `;
    }

    // Agreement Template
    function generateAgreementTemplate(title, date, company) {
      return `
        <p>This Agreement is made and entered into on <strong>${date}</strong> between <strong>${company}</strong> ("First Party") and <strong>[PARTY_B_NAME]</strong> ("Second Party").</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">1. RECITALS</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">WHEREAS, the First Party desires to [PURPOSE_A]; and WHEREAS, the Second Party represents it has the expertise and resources to [PURPOSE_B]; NOW, THEREFORE, the parties agree as follows:</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">2. TERMS AND CONDITIONS</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">The parties hereby agree to the following terms: [TERM_1], [TERM_2], and [TERM_3]. These conditions shall remain binding for the duration of the agreement.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">3. PAYMENT TERMS</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">Payment shall be made in the amount of <strong>$[AMOUNT]</strong> payable upon [PAYMENT_MILESTONE] via [PAYMENT_METHOD], subject to original invoice presentation.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">4. TERM AND TERMINATION</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">This Agreement shall commence on [START_DATE] and remain in effect until [END_DATE]. Either party may terminate this Agreement with [NOTICE_PERIOD] written notice.</p>

        <div style="margin-top: 5em;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="width: 50%; vertical-align: bottom;">
                <p style="margin-bottom: 4em;"><strong>FOR THE FIRST PARTY:</strong></p>
                <div style="border-bottom: 1px solid #000; width: 85%;"></div>
                <p style="margin-top: 0.5em;">Name: [NAME]<br><span style="font-size: 10pt; color: #666;">Title: [TITLE]</span></p>
              </td>
              <td style="width: 50%; vertical-align: bottom;">
                <p style="margin-bottom: 4em;"><strong>FOR THE SECOND PARTY:</strong></p>
                <div style="border-bottom: 1px solid #000; width: 85%;"></div>
                <p style="margin-top: 0.5em;">Name: [NAME]<br><span style="font-size: 10pt; color: #666;">Title: [TITLE]</span></p>
              </td>
            </tr>
          </table>
        </div>
      `;
    }

    // Notice Template
    function generateNoticeTemplate(title, date, company) {
      return `
        <div style="margin-bottom: 2em;">
          <p><strong>TO:</strong> [RECIPIENT_NAME]</p>
          <p><strong>FROM:</strong> <strong>${company}</strong></p>
          <p><strong>SUBJECT:</strong> <strong>[NOTICE_SUBJECT]</strong></p>
        </div>

        <p>This formal notice serves to inform you that [NOTICE_CONTENT].</p>
        
        <p style="margin-top: 1.5em; text-indent: 0.5in;">Please be advised that [IMPORTANT_INFORMATION]. It is critical that you acknowledge receipt of this notice and comply with any stated requirements.</p>
        
        <p style="margin-top: 1.5em;">If you have any questions regarding this matter, please contact the undersigned or [CONTACT_PERSON] at [CONTACT_INFO].</p>
        
        <div style="margin-top: 4em;">
          <p>Sincerely,</p>
          <div style="margin-top: 3em;">
            <p><strong>[SENDER_NAME]</strong><br>
            [SENDER_TITLE]<br>
            <strong>${company}</strong></p>
          </div>
        </div>
      `;
    }

    // Memorandum Template
    function generateMemorandumTemplate(title, date, company) {
      return `
        <div style="background-color: #f9fafb; padding: 1.5em; border: 1px solid #eee; margin-bottom: 2em;">
          <table style="width: 100%;">
            <tr><td style="width: 100pt; font-weight: bold;">TO:</td><td>[RECIPIENT_NAME]</td></tr>
            <tr><td style="font-weight: bold;">FROM:</td><td>[SENDER_NAME]</td></tr>
            <tr><td style="font-weight: bold;">DATE:</td><td>${date}</td></tr>
            <tr><td style="font-weight: bold;">SUBJECT:</td><td><strong>[MEMORANDUM_SUBJECT]</strong></td></tr>
          </table>
        </div>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; color: #1a365d;">1. BACKGROUND</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">[BACKGROUND_INFORMATION_CONTENT]</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; color: #1a365d;">2. DISCUSSION</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">[DETAILED_DISCUSSION_POINTS]</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; color: #1a365d;">3. RECOMMENDATION</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">[PROPOSED_ACTIONS_OR_SOLUTIONS]</p>

        <p style="margin-top: 3em;">Please acknowledge receipt of this memorandum and proceed as advised.</p>

        <div style="margin-top: 4em;">
          <p><strong>[SENDER_NAME]</strong><br>
          <span style="font-size: 10pt; color: #666;">[SENDER_TITLE]</span></p>
        </div>
      `;
    }

    // License Template
    function generateLicenseTemplate(title, date, company) {
      return `<p>This License Agreement ("Agreement") is entered into on <strong>${date}</strong> between <strong>${company}</strong> ("Licensor") and <strong>[LICENSEE_NAME]</strong> ("Licensee").</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">1. GRANT OF LICENSE</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">Licensor hereby grants to Licensee a non-exclusive, non-transferable license to use [LICENSED_ACTIVITY] solely for the purposes described in this Agreement.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">2. TERM AND DURATION</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">This license shall commence on [START_DATE] and continue until [END_DATE], unless terminated earlier in accordance with the provisions herein.</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">3. RESTRICTIONS</h3>
        <ul style="margin-left: 0.5in; margin-top: 0.5em;">
          <li>Licensee shall not sub-license or transfer rights to third parties.</li>
          <li>Licensee shall adhere to all [SPECIFIC_RESTRICTIONS].</li>
        </ul>

        <div style="margin-top: 4em;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="width: 50%; vertical-align: bottom;">
                <p style="margin-bottom: 4em;"><strong>FOR THE LICENSOR:</strong></p>
                <div style="border-bottom: 1px solid #000; width: 85%;"></div>
                <p style="margin-top: 0.5em;">[REPRESENTATIVE NAME]<br><span style="font-size: 10pt; color: #666;">Title: [TITLE]</span></p>
              </td>
              <td style="width: 50%; vertical-align: bottom;">
                <p style="margin-bottom: 4em;"><strong>FOR THE LICENSEE:</strong></p>
                <div style="border-bottom: 1px solid #000; width: 85%;"></div>
                <p style="margin-top: 0.5em;">[LICENSEE NAME]<br><span style="font-size: 10pt; color: #666;">Title: [TITLE]</span></p>
              </td>
            </tr>
          </table>
        </div>
      `;
    }

    // Subpoena Template
    function generateSubpoenaTemplate(title, date, company) {
      return `
        <div style="margin-bottom: 2em; border-left: 5px solid #000; padding-left: 1.5em;">
          <p style="font-size: 14pt; font-weight: bold;">TO: [RECIPIENT_NAME]</p>
          <p>ADDRESS: [RECIPIENT_ADDRESS]</p>
        </div>

        <p style="font-size: 13pt; font-weight: bold; text-align: center; margin-bottom: 2em; text-decoration: underline;">SUBPOENA AD TESTIFICANDUM</p>

        <p style="text-indent: 0.5in; margin-top: 1.5em;"><strong>YOU ARE HEREBY COMMANDED</strong> to appear before <strong>[COURT_NAME]</strong> located at [COURT_ADDRESS] on <strong>[APPEARANCE_DATE]</strong> at <strong>[APPEARANCE_TIME]</strong> to testify in the matter of <strong>[CASE_TITLE]</strong>.</p>

        <p style="text-indent: 0.5in; margin-top: 1.5em;"><strong>YOU ARE FURTHER COMMANDED</strong> to bring with you and produce the following documents or items: [LIST_OF_DOCUMENTS_REQUIRED].</p>

        <p style="margin-top: 2em; color: #d32f2f; font-weight: bold;">WARNING: FAILURE TO COMPLY WITH THIS SUBPOENA MAY RESULT IN CONTEMPT OF COURT PROCEEDINGS AND LEGAL PENALTIES AS PROVIDED BY LAW.</p>

        <div style="margin-top: 5em; text-align: right;">
          <div style="display: inline-block; text-align: left; width: 250pt;">
            <p>DATED: ${date}</p>
            <div style="border-bottom: 1px solid #000; width: 100%; margin-top: 3em;"></div>
            <p><strong>[COURT_CLERK_NAME]</strong><br>
            Court Clerk, [COURT_NAME]</p>
          </div>
        </div>
      `;
    }

    // Affidavit Template
    function generateAffidavitTemplate(title, date, company) {
      return `
        <div style="width: 200pt; border: 1px solid #000; padding: 0.5em; margin-bottom: 2em;">
          <p>REPUBLIC OF THE PHILIPPINES )<br>
          CITY OF [CITY_NAME] &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) S.S.</p>
        </div>

        <p style="text-indent: 0.5in;">I, <strong>[AFFIANT_NAME]</strong>, of legal age, [CIVIL_STATUS], [NATIONALITY], and residing at [AFFIANT_ADDRESS], after having been duly sworn to in accordance with law, do hereby depose and state that:</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em;">STATEMENT OF FACTS</h3>
        <ol style="margin-left: 0.5in; margin-top: 0.5em;">
          <li style="margin-bottom: 1em;">I am [AFFIANT_DESCRIPTION] and have personal knowledge of the facts set forth in this affidavit.</li>
          <li style="margin-bottom: 1em;">[FACT_DESCRIPTION_1]</li>
          <li style="margin-bottom: 1em;">[FACT_DESCRIPTION_2]</li>
        </ol>

        <p style="margin-top: 2em; text-indent: 0.5in;">I am executing this affidavit to attest to the truth of the foregoing facts and for [PURPOSE_OF_AFFIDAVIT].</p>

        <div style="margin-top: 4em; text-align: right;">
          <div style="display: inline-block; text-align: center;">
            <div style="border-bottom: 1px solid #000; width: 200pt;"></div>
            <p><strong>[AFFIANT_NAME]</strong><br>Affiant</p>
          </div>
        </div>

        <p style="margin-top: 3em;"><strong>SUBSCRIBED AND SWORN</strong> to before me this [DAY] day of [MONTH], [YEAR] at [PLACE].</p>

        <div style="margin-top: 2em;">
          <p>Doc. No. ____;<br>
          Page No. ____;<br>
          Book No. ____;<br>
          Series of [YEAR].</p>
        </div>
      `;
    }

    // Cease and Desist Template
    function generateCeaseDesistTemplate(title, date, company) {
      return `
        <p style="text-align: right;"><strong>VIA CERTIFIED MAIL</strong></p>
        
        <div style="margin-bottom: 2em;">
          <p><strong>TO:</strong> [RECIPIENT_NAME]<br>
          [RECIPIENT_ADDRESS]</p>
        </div>

        <p>RE: <strong>CEASE AND DESIST DEMAND</strong> - [NATURE_OF_VIOLATION]</p>

        <p style="margin-top: 1.5em;">Dear [RECIPIENT_NAME],</p>

        <p style="text-indent: 0.5in;">This firm represents <strong>${company}</strong>. It has come to our attention that you are engaged in [VIOLATION_DESCRIPTION]. Such activities are in direct violation of [SPECIFIC_LAW_OR_CONTRACT].</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; color: #b71c1c;">DEMAND FOR IMMEDIATE ACTION</h3>
        <p style="text-indent: 0.5in;">WE HEREBY DEMAND that you immediately cease and desist all [VIOLATION_ACTIVITY]. You are further required to [REMEDIATION_STEP] no later than [DEADLINE_DATE].</p>

        <p style="margin-top: 1.5em;">Should you fail to comply with this demand, our client has authorized us to pursue all available legal remedies, including injunctive relief and monetary damages.</p>

        <div style="margin-top: 4em;">
          <p>Sincerely,</p>
          <p style="margin-top: 3em;"><strong>[ATTORNEY_NAME]</strong><br>
          Legal Counsel for ${company}</p>
        </div>
      `;
    }

    // Legal Brief Template
    function generateLegalBriefTemplate(title, date, company) {
      return `
        <p style="text-align: center; border: 1px solid #000; padding: 1em;">
          <strong>IN THE SUPREME COURT / COURT OF APPEALS</strong><br>
          [JURISDICTION_NAME]
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-top: 2em;">
          <tr>
            <td style="width: 50%; padding: 1em; border-right: 1px solid #000;">
              <strong>[PLAYER_A_NAME]</strong>,<br>
              &nbsp;&nbsp;&nbsp;&nbsp;Petitioner/Plaintiff,
              <p style="margin-top: 2em;">- versus -</p>
              <strong>[PLAYER_B_NAME]</strong>,<br>
              &nbsp;&nbsp;&nbsp;&nbsp;Respondent/Defendant.
            </td>
            <td style="width: 50%; padding: 1em; vertical-align: top;">
              CASE NO. [CASE_NUMBER]<br>
              For: [NATURE_OF_CASE]
            </td>
          </tr>
        </table>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 2em; text-align: center; text-decoration: underline;">LEGAL BRIEF</h3>

        <h4 style="font-weight: bold; margin-top: 1.5em;">I. PRELIMINARY STATEMENT</h4>
        <p style="text-indent: 0.5in;">This brief is submitted on behalf of <strong>${company}</strong> to address the critical issues of [CORE_ISSUE].</p>

        <h4 style="font-weight: bold; margin-top: 1.5em;">II. STATEMENT OF FACTS</h4>
        <p style="text-indent: 0.5in;">[FACTUAL_SUMMARY_CONTENT]</p>

        <h4 style="font-weight: bold; margin-top: 1.5em;">III. ARGUMENT</h4>
        <p style="text-indent: 0.5in;">[LEGAL_ARGUMENT_BODY]</p>

        <h4 style="font-weight: bold; margin-top: 1.5em;">IV. PRAYER</h4>
        <p style="text-indent: 0.5in;">WHEREFORE, it is respectfully prayed that [RELIEF_REQUESTED].</p>

        <div style="margin-top: 5em;">
          <p>Respectfully submitted,</p>
          <div style="margin-top: 3em;">
            <p><strong>[ATTORNEY_NAME]</strong><br>
            Counsel for Petitioner</p>
          </div>
        </div>
      `;
    }

    function generateFinancialTemplate(title, date, company) {
      return `
        <h3 style="font-size: 16pt; font-weight: bold; text-align: center; margin-bottom: 2em; color: #2c3e50;">STATEMENT OF FINANCIAL POSITION</h3>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 1em;">
          <tr style="background-color: #f1f5f9;"><td colspan="2" style="padding: 0.5em; font-weight: bold;">ASSETS</td></tr>
          <tr><td style="padding: 0.5em; border-bottom: 1px solid #eee;">Current Assets</td><td style="padding: 0.5em; border-bottom: 1px solid #eee; text-align: right;">$[AMOUNT]</td></tr>
          <tr><td style="padding: 0.5em; border-bottom: 1px solid #eee;">Fixed Assets</td><td style="padding: 0.5em; border-bottom: 1px solid #eee; text-align: right;">$[AMOUNT]</td></tr>
          <tr style="font-weight: bold;"><td style="padding: 0.5em;">TOTAL ASSETS</td><td style="padding: 0.5em; text-align: right; border-top: 2px solid #000;">$[TOTAL_ASSETS]</td></tr>
          
          <tr style="background-color: #f1f5f9;"><td colspan="2" style="padding: 0.5em; font-weight: bold; margin-top: 1em;">LIABILITIES & EQUITY</td></tr>
          <tr><td style="padding: 0.5em; border-bottom: 1px solid #eee;">Current Liabilities</td><td style="padding: 0.5em; border-bottom: 1px solid #eee; text-align: right;">$[AMOUNT]</td></tr>
          <tr><td style="padding: 0.5em; border-bottom: 1px solid #eee;">Shareholders' Equity</td><td style="padding: 0.5em; border-bottom: 1px solid #eee; text-align: right;">$[AMOUNT]</td></tr>
          <tr style="font-weight: bold;"><td style="padding: 0.5em;">TOTAL LIABILITIES & EQUITY</td><td style="padding: 0.5em; text-align: right; border-top: 2px solid #000;">$[TOTAL_EQUITY]</td></tr>
        </table>

        <div style="margin-top: 4em;">
          <p style="font-size: 10pt; color: #666;">Prepared by: [PREPARER_NAME]</p>
          <p style="font-size: 10pt; color: #666;">Verified by: [VERIFIER_NAME]</p>
          <p style="font-size: 10pt; color: #666;">Date: ${date}</p>
        </div>
      `;
    }

    // Compliance Document Template
    function generateComplianceTemplate(title, date, company) {
      return `
        <p style="text-indent: 0.5in;">I, <strong>[OFFICER_NAME]</strong>, in my capacity as [OFFICER_TITLE] of <strong>${company}</strong>, do hereby certify that as of <strong>${date}</strong>, the Company is in full compliance with the following requirements:</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #000;">CERTIFIED COMPLIANCE AREAS</h3>
        <ul style="margin-left: 0.5in; margin-top: 1em;">
          <li style="margin-bottom: 0.5em;">[COMPLIANCE_AREA_1]: Fully Compliant</li>
          <li style="margin-bottom: 0.5em;">[COMPLIANCE_AREA_2]: Fully Compliant</li>
          <li style="margin-bottom: 0.5em;">[COMPLIANCE_AREA_3]: Fully Compliant</li>
        </ul>

        <p style="margin-top: 2em; text-indent: 0.5in;">This certification is based on our internal audits and periodic reviews conducted by the Compliance Department.</p>

        <div style="margin-top: 5em;">
          <div style="width: 200pt; border-top: 1px solid #000; padding-top: 0.5em;">
            <p><strong>[OFFICER_NAME]</strong><br>
            Compliance Officer</p>
          </div>
        </div>
      `;
    }

    // Report Template
    function generateReportTemplate(title, date, company) {
      return `
        <h3 style="font-size: 15pt; font-weight: bold; background-color: #f8fafc; padding: 0.5em; border-left: 4px solid #334155; margin-bottom: 1em;">EXECUTIVE SUMMARY</h3>
        <p style="text-indent: 0.5in;">[EXECUTIVE_SUMMARY_CONTENT]</p>

        <h3 style="font-size: 15pt; font-weight: bold; margin-top: 2em;">1. INTRODUCTION</h3>
        <p style="text-indent: 0.5in;">[REPORT_INTRODUCTION_BODY]</p>

        <h3 style="font-size: 15pt; font-weight: bold; margin-top: 2em;">2. KEY FINDINGS</h3>
        <ul style="margin-left: 0.5in; margin-top: 1em;">
          <li>[KEY_FINDING_1]</li>
          <li>[KEY_FINDING_2]</li>
        </ul>

        <h3 style="font-size: 15pt; font-weight: bold; margin-top: 2em;">3. RECOMMENDATIONS</h3>
        <p style="text-indent: 0.5in;">[DETAILED_RECOMMENDATIONS_AND_NEXT_STEPS]</p>

        <div style="margin-top: 4em; border-top: 1px solid #eee; padding-top: 2em;">
          <p><strong>Reported by:</strong> [AUTHOR_NAME]</p>
          <p><strong>Department:</strong> [DEPARTMENT_NAME]</p>
          <p><strong>Status:</strong> FINAL</p>
        </div>
      `;
    }

    // General Template
    function generateGeneralTemplate(title, date, company) {
      return `
        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">1. INTRODUCTION</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">[INTRODUCTION_CONTENT_BODY]</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">2. MAIN CONTENT</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">[DETAILED_DOCUMENT_BODY_AND_CLAUSES]</p>

        <h3 style="font-size: 14pt; font-weight: bold; margin-top: 1.5em; border-bottom: 1px solid #eee; padding-bottom: 0.3em;">3. CONCLUSION</h3>
        <p style="text-indent: 0.5in; margin-top: 0.5em;">[CONCLUSION_AND_FINAL_REMARKS]</p>

        <div style="margin-top: 4em; border-top: 1px solid #000; padding-top: 1em; width: 45%;">
          <p><strong>AUTHORIZED BY:</strong><br>
          <span style="font-size: 12pt; font-weight: bold;">[APPROVER_NAME]</span><br>
          <span style="font-size: 10pt; color: #666;">[APPROVER_TITLE]</span></p>
        </div>
      `;
    }
  </script>

  @include('partials.soliera_js')
</body>

</html>