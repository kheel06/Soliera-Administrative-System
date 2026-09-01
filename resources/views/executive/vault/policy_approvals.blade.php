@extends('layouts.app')

@section('title', 'Executive | Document Vault')

@section('content')
    <style>
        .vault-blur {
            filter: blur(5px);
            transition: filter 0.3s ease;
            user-select: none;
            pointer-events: none;
        }

        .vault-unlocked .vault-blur {
            filter: blur(0);
            user-select: auto;
            pointer-events: auto;
        }
    </style>

    <div class="p-6 max-w-7xl mx-auto" id="vaultContainer">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                    Document Vault - Policy Approvals
                    <span id="lockBadge"
                        class="px-2 py-0.5 text-[10px] bg-amber-100 text-amber-700 rounded-full uppercase tracking-wider font-bold">Locked</span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">Review and manage document policies and approvals</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <!-- Export Dropdown -->
                <div class="relative" x-data="{ openExport: false }" @click.away="openExport = false">
                    <button @click="openExport = !openExport"
                        class="bg-[#F7B32B] hover:bg-[#e5a220] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200 text-sm shadow-sm">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Export Reports
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    <div x-show="openExport"
                        class="absolute right-0 z-20 mt-2 w-48 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none py-1"
                        style="display: none;">
                        <a href="{{ route('executive.vault.export') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                            <i data-lucide="file-spreadsheet" class="w-4 h-4 inline mr-2 text-green-600"></i>
                            Export as Excel
                        </a>
                        <a href="{{ route('executive.vault.export_pdf') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 items-center">
                            <i data-lucide="file" class="w-4 h-4 inline mr-2 text-red-600"></i>
                            Export as PDF
                        </a>
                    </div>
                </div>

                <a href="{{ route('executive.retention') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    Retention Overview
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Documents</h3>
                        <p class="text-2xl font-bold mt-1 text-blue-600">{{ $stats['total_documents'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="file-text" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Pending Review</h3>
                        <p class="text-2xl font-bold mt-1 text-amber-600">{{ $stats['pending_review'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="clock" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Recent Uploads (30d)</h3>
                        <p class="text-2xl font-bold mt-1 text-emerald-600">{{ $stats['recent_uploads'] }}</p>
                    </div>
                    <div class="p-2.5 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="upload-cloud" class="w-5 h-5 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
                <h3 class="font-bold text-gray-800">Documents</h3>
                <button onclick="handleVaultLock()" id="mainVaultBtn"
                    class="flex items-center gap-2 text-xs font-bold text-amber-600 hover:text-amber-700 transition-colors">
                    <i data-lucide="lock" class="w-4 h-4" id="mainLockIcon"></i>
                    <span id="mainLockText">Unlock Vault</span>
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4">Document</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Uploaded</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                                        </div>
                                        <div class="vault-blur">
                                            <p class="font-bold text-gray-900">
                                                {{ Str::limit($doc->title ?? $doc->document_name ?? 'Untitled', 40) }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1 uppercase tracking-tighter">
                                                {{ $doc->file_size ?? ($doc->metadata['file_size'] ?? 'Unknown size') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="vault-blur px-2.5 py-1 text-[11px] font-bold rounded-md bg-gray-100 text-gray-600 uppercase">
                                        {{ ucfirst($doc->category ?? $doc->document_type ?? $doc->type ?? 'General') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="vault-blur px-2.5 py-1 text-[11px] font-bold rounded-full uppercase
                                                                                                                            {{ ($doc->status ?? 'active') === 'active' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                                                                                                            {{ ($doc->status ?? 'active') === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                                                                                                            {{ ($doc->status ?? 'active') === 'archived' ? 'bg-gray-100 text-gray-600' : '' }}
                                                                                                                            {{ (string) ($doc->status ?? '') === 'Approved' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                                                                                                            {{ (string) ($doc->status ?? '') === 'Archived' ? 'bg-gray-100 text-gray-600' : '' }}">
                                        {{ ucfirst($doc->status ?? 'Active') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="vault-blur">
                                        <p class="text-gray-900 font-medium">{{ $doc->created_at->format('M d, Y') }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $doc->created_at->diffForHumans() }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- View Button (Opens Modal) -->
                                        <button
                                            onclick="openDocModal({{ $doc->id }}, '{{ addslashes($doc->title) }}', '{{ addslashes($doc->description ?? '') }}', '{{ $doc->category ?? 'General' }}', '{{ $doc->created_at->format('M d, Y H:i') }}', '{{ $doc->updated_at->format('M d, Y H:i') }}', '{{ $doc->file_path }}', '{{ $doc->file_size ?? ($doc->metadata['file_size'] ?? 'Unknown') }}')"
                                            class="p-2 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer"
                                            title="View Document">
                                            <i data-lucide="eye" class="w-4 h-4 text-gray-600"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i data-lucide="folder-open" class="w-16 h-16 mb-4 opacity-20"></i>
                                        <p class="text-lg font-medium">No documents available</p>
                                        <p class="text-sm">Document vault is currently empty</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($documents->hasPages())
                <div class="px-6 py-4 border-t bg-gray-50 flex items-center justify-between">
                    {{ $documents->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Password Prompt Modal -->
    <div id="passwordModal"
        class="fixed inset-0 bg-[#0a1e3b]/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-8 transform transition-all">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="shield-alert" class="w-8 h-8 text-amber-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Access Required</h3>
                <p class="text-gray-500 text-sm mt-1">Please enter your password to view sensitive documents.</p>
            </div>
            <div class="space-y-4">
                <input type="password" id="vaultPassword" class="input input-bordered w-full rounded-xl"
                    placeholder="••••••••" autofocus>
                <div class="flex gap-2">
                    <button onclick="closeModal()"
                        class="btn btn-ghost flex-1 rounded-xl font-bold uppercase text-xs tracking-wider">Cancel</button>
                    <button onclick="verifyPassword()"
                        class="btn bg-[#0a1e3b] hover:bg-[#152a4d] text-white flex-1 rounded-xl font-bold uppercase text-xs tracking-wider">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isUnlocked = false;

        function handleVaultLock() {
            if (isUnlocked) {
                lockVault();
            } else {
                openModal();
            }
        }

        function openModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
            document.getElementById('vaultPassword').focus();
        }

        function closeModal() {
            document.getElementById('passwordModal').classList.add('hidden');
            document.getElementById('vaultPassword').value = '';
        }

        function verifyPassword() {
            const password = document.getElementById('vaultPassword').value;
            // For demo: password is 'admin' or '1234'
            if (password === 'admin' || password === '1234') {
                unlockVault();
                closeModal();
            } else {
                alert('Invalid password. Access denied.');
            }
        }

        function unlockVault() {
            isUnlocked = true;
            document.getElementById('vaultContainer').classList.add('vault-unlocked');
            document.getElementById('lockBadge').textContent = 'Unlocked';
            document.getElementById('lockBadge').classList.replace('bg-amber-100', 'bg-emerald-100');
            document.getElementById('lockBadge').classList.replace('text-amber-700', 'text-emerald-700');

            document.getElementById('mainLockText').textContent = 'Lock Vault';
            document.querySelectorAll('.mainLockText').forEach(el => el.textContent = 'Lock');

            // Update icons
            document.querySelectorAll('.lock-icon').forEach(icon => {
                icon.setAttribute('data-lucide', 'unlock');
            });
            document.getElementById('mainLockIcon').setAttribute('data-lucide', 'unlock');

            if (window.lucide) window.lucide.createIcons();
        }

        function lockVault() {
            isUnlocked = false;
            document.getElementById('vaultContainer').classList.remove('vault-unlocked');
            document.getElementById('lockBadge').textContent = 'Locked';
            document.getElementById('lockBadge').classList.replace('bg-emerald-100', 'bg-amber-100');
            document.getElementById('lockBadge').classList.replace('text-emerald-700', 'text-amber-700');

            document.getElementById('mainLockText').textContent = 'Unlock Vault';
            document.querySelectorAll('.mainLockText').forEach(el => el.textContent = 'Unlock');

            // Update icons
            document.querySelectorAll('.lock-icon').forEach(icon => {
                icon.setAttribute('data-lucide', 'lock');
            });
            document.getElementById('mainLockIcon').setAttribute('data-lucide', 'lock');

            if (window.lucide) window.lucide.createIcons();
        }

        // Document Modal Functions
        function openDocModal(id, title, description, category, created, updated, filePath, fileSize) {
            document.getElementById('docModalTitle').textContent = title;
            document.getElementById('docModalCategory').textContent = category;
            document.getElementById('docModalFileSize').textContent = fileSize;

            // Set preview URL for iframe
            const previewUrl = `/vault/documents/${id}/preview`;
            document.getElementById('docModalPdfViewer').src = previewUrl;

            // Set download link
            const downloadUrl = `/vault/documents/${id}/download`;
            document.getElementById('docModalDownloadBtn').href = downloadUrl;

            // Show modal
            document.getElementById('documentModal').classList.remove('hidden');
            if (window.lucide) window.lucide.createIcons();
        }

        function closeDocModal() {
            document.getElementById('documentModal').classList.add('hidden');
            // Clear iframe to stop loading
            document.getElementById('docModalPdfViewer').src = '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }

            // Keyboard support for password modal
            document.getElementById('vaultPassword').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') verifyPassword();
            });

            // Escape key to close document modal
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeDocModal();
                }
            });
        });
    </script>

    <!-- Document Details Modal -->
    <div id="documentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <div class="flex items-center gap-3">
                    <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                    <div>
                        <h3 id="docModalTitle" class="text-lg font-bold text-gray-900">Document Preview</h3>
                        <p class="text-xs text-gray-500">
                            <span id="docModalFileSize">Unknown size</span> •
                            <span id="docModalCategory">General</span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Download Button -->
                    <a id="docModalDownloadBtn" href="#" download
                        class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                        title="Download">
                        <i data-lucide="download" class="w-5 h-5"></i>
                    </a>
                    <!-- Close Button -->
                    <button onclick="closeDocModal()" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- PDF Preview Area -->
            <div class="flex-1 bg-gray-100 rounded-b-2xl overflow-hidden p-2">
                <iframe id="docModalPdfViewer" src="" class="w-full h-full border-0 rounded-lg bg-white"
                    title="Document Preview">
                </iframe>
            </div>
        </div>
    </div>
@endsection