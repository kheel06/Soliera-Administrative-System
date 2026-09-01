@extends('layouts.app')

@section('content')
<div class="py-3 sm:py-4 lg:py-6 space-y-4 sm:space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Sync Management</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-1">Monitor sync health, queues, and manual actions for the admin system.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="refreshAllStatus()" class="px-3 py-2 bg-[#001F54] text-white text-sm font-medium rounded-lg hover:bg-[#003380] transition-colors flex items-center gap-2">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                Refresh All
            </button>
        </div>
    </div>

    <!-- Soliera Admin API Connection Status -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-[#001F54] rounded-xl flex items-center justify-center">
                    <i data-lucide="globe" class="w-7 h-7 text-[#F7B32B]"></i>
                </div>
                <div>
                    <h2 class="text-gray-900 font-bold text-lg">Soliera Admin API</h2>
                    <p class="text-gray-500 text-sm">{{ $adminApiUrl ?? 'https://admin.soliera-hotel-restaurant.com' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if(($apiStatus['connected'] ?? false))
                    <span class="px-3 py-1.5 bg-green-50 text-green-700 text-sm font-medium rounded-full flex items-center gap-2 border border-green-100">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        Connected
                    </span>
                @else
                    <span class="px-3 py-1.5 bg-red-50 text-red-700 text-sm font-medium rounded-full flex items-center gap-2 border border-red-100">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        Disconnected
                    </span>
                @endif
                @if(!($apiStatus['connected'] ?? false))
                    <button onclick="connectIntegration('soliera_admin')" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                        <i data-lucide="plug" class="w-4 h-4"></i>
                        Connect
                    </button>
                @endif
                <button onclick="triggerSync('soliera_admin')" class="px-4 py-2 bg-[#001F54] hover:bg-[#003380] text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    Manual Sync
                </button>
                <button onclick="testConnection()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                    <i data-lucide="wifi" class="w-4 h-4"></i>
                    Test Connection
                </button>
            </div>
        </div>
        <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
            <div>
                <p class="text-gray-500 mb-1">Last Check</p>
                <p class="text-gray-900 font-semibold">{{ $apiStatus['last_check'] ?? 'Never' }}</p>
            </div>
            <div>
                <p class="text-gray-500 mb-1">Status Code</p>
                <p class="text-gray-900 font-semibold">{{ $apiStatus['status_code'] ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-500 mb-1">Message</p>
                <p class="text-gray-900 font-semibold truncate">{{ $apiStatus['message'] ?? 'Not checked' }}</p>
            </div>
            <div>
                <p class="text-gray-500 mb-1">Sync Target</p>
                <p class="text-gray-900 font-semibold">Online System</p>
            </div>
        </div>
    </div>

    <!-- Sync Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Integrations -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Total Integrations</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ count($syncStatus) }}</p>
                </div>
                <div class="w-12 h-12 bg-[#001F54] rounded-xl flex items-center justify-center">
                    <i data-lucide="link" class="w-6 h-6 text-[#F7B32B]"></i>
                </div>
            </div>
        </div>

        <!-- Connected -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Connected</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ collect($syncStatus)->where('status', 'connected')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-[#001F54] rounded-xl flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-[#F7B32B]"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ collect($syncStatus)->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-[#001F54] rounded-xl flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6 text-[#F7B32B]"></i>
                </div>
            </div>
        </div>

        <!-- Disconnected -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Disconnected</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ collect($syncStatus)->where('status', 'disconnected')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-[#001F54] rounded-xl flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-6 h-6 text-[#F7B32B]"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sync Queue -->
    <div id="queue" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Queue</h2>
            <span class="text-xs text-gray-500">Pending sync items</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Item</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Source</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Queued At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                            No queued items.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Conflicts -->
    <div id="conflicts" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Conflicts</h2>
            <span class="text-xs text-gray-500">Records requiring review</span>
        </div>
        <div class="px-4 py-8 text-center text-gray-500">
            No conflicts detected.
        </div>
    </div>

    <!-- Recent Sync Activity -->
    <div id="logs" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Recent Sync Activity</h2>
            <button onclick="loadLogs()" class="text-sm text-[#001F54] hover:underline flex items-center gap-1">
                <i data-lucide="refresh-cw" class="w-3 h-3"></i>
                Refresh
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Timestamp</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Integration</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Action</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Records</th>
                    </tr>
                </thead>
                <tbody id="sync-logs-body" class="divide-y divide-gray-100">
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            <i data-lucide="loader" class="w-6 h-6 mx-auto mb-2 animate-spin"></i>
                            Loading sync logs...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadLogs();
    lucide.createIcons();
});

function loadLogs() {
    fetch('{{ route("integration-sync.logs") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderLogs(data.data);
            }
        })
        .catch(error => {
            console.error('Error loading logs:', error);
            document.getElementById('sync-logs-body').innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-red-500">
                        Failed to load sync logs
                    </td>
                </tr>
            `;
        });
}

function renderLogs(logs) {
    const tbody = document.getElementById('sync-logs-body');
    if (logs.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                    No sync activity found
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = logs.map(log => `
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 text-sm text-gray-600">${log.timestamp}</td>
            <td class="px-4 py-3 text-sm font-medium text-gray-900">${log.integration}</td>
            <td class="px-4 py-3 text-sm text-gray-600">${log.action}</td>
            <td class="px-4 py-3">
                ${log.status === 'success' 
                    ? '<span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Success</span>'
                    : '<span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Failed</span>'
                }
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">${log.records}</td>
        </tr>
    `).join('');
}

function triggerSync(integration) {
    const btn = event.target.closest('button');
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Syncing...';
    btn.disabled = true;
    lucide.createIcons();

    fetch(`/integration-sync/${integration}/trigger`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', data.message);
            loadLogs();
        } else {
            showNotification('error', data.message);
        }
    })
    .catch(error => {
        showNotification('error', 'Sync failed. Please try again.');
    })
    .finally(() => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
        lucide.createIcons();
    });
}

function connectIntegration(integration) {
    showNotification('info', `Connection wizard for ${integration} coming soon.`);
}

function viewDetails(integration) {
    showNotification('info', `Settings for ${integration} coming soon.`);
}

function refreshAllStatus() {
    showNotification('info', 'Refreshing all integration statuses...');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function testConnection() {
    const btn = event.target.closest('button');
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Testing...';
    btn.disabled = true;
    lucide.createIcons();

    fetch('{{ route("integration-sync.test-connection") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', 'Connection successful! API is reachable.');
        } else {
            showNotification('error', 'Connection failed: ' + (data.status?.message || 'Unable to reach API'));
        }
        setTimeout(() => location.reload(), 2000);
    })
    .catch(error => {
        showNotification('error', 'Connection test failed. Please try again.');
    })
    .finally(() => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
        lucide.createIcons();
    });
}

function showNotification(type, message) {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500'
    };

    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 animate-fade-in`;
    notification.innerHTML = `
        <i data-lucide="${type === 'success' ? 'check-circle' : type === 'error' ? 'x-circle' : 'info'}" class="w-5 h-5"></i>
        <span>${message}</span>
    `;
    document.body.appendChild(notification);
    lucide.createIcons();

    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection
