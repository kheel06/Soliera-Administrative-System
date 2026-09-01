<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Audit Logs - Soliera</title>
  @include('partials.favicon')
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  @vite(['resources/css/soliera.css'])
  <style>
    /* Line clamp for activity description */
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  </style>
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

        <!-- Page Header -->
        <div class="mb-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-xl bg-[#001F54] flex items-center justify-center">
                <i data-lucide="activity" class="w-6 h-6 text-[#F7B32B]"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-800">Audit Trail & Transaction</h1>
                <p class="text-gray-500 text-sm">Monitor and track all system activities and user actions</p>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <a href="{{ route('access.audit_logs.export') }}"
                class="btn btn-sm bg-gradient-to-r from-[#F7B32B] to-[#f59e0b] text-gray-800 border-none hover:shadow-md transition-all gap-2">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export
              </a>
            </div>
          </div>
        </div>

        <!-- Stats Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          @php
            // Get totals from database (not from paginated collection)
            $totalLogs = \App\Models\AccessLog::count();
            $todayLogs = \App\Models\AccessLog::where('created_at', '>=', now()->startOfDay())->count();
            $loginLogs = \App\Models\AccessLog::where('action', 'Login')->count();
            $uniqueUsers = \App\Models\AccessLog::distinct('user_id')->count('user_id');
          @endphp

          <!-- Total Logs -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Logs</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalLogs) }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="scroll-text" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Today's Activity -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Today's Activity</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($todayLogs) }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="calendar-check" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Total Logins -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Logins</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($loginLogs) }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="log-in" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Active Users -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Active Users</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($uniqueUsers) }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Audit Logs Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <!-- Table Header -->
          <div class="bg-[#001F54] px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
              <h3 class="text-lg font-semibold text-white flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                  <i data-lucide="scroll-text" class="w-4 h-4 text-[#F7B32B]"></i>
                </div>
                Audit Logs
              </h3>
            </div>
          </div>

          <!-- Filters Row -->
          <div class="p-4 bg-gray-50 border-b border-gray-100">
            <div class="flex items-center gap-3 flex-wrap">
              <!-- Search Bar -->
              <div class="relative flex-1 min-w-[200px]">
                <i data-lucide="search"
                  class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                  placeholder="Search logs..."
                  class="input input-bordered input-sm w-full pl-10 pr-4 bg-white border-gray-200 focus:border-[#001F54] focus:ring-1 focus:ring-[#001F54]/20">
              </div>

              <!-- Department Filter -->
              <select id="departmentFilter" name="department"
                class="select select-bordered select-sm bg-white border-gray-200">
                <option value="">All Departments</option>
                <option value="Administrative" {{ request('department') == 'Administrative' ? 'selected' : '' }}>
                  Administrative</option>
                <option value="Soliera Restaurant" {{ request('department') == 'Soliera Restaurant' ? 'selected' : '' }}>
                  Soliera Restaurant</option>
                <option value="Management" {{ request('department') == 'Management' ? 'selected' : '' }}>Management
                </option>
                <option value="Reception" {{ request('department') == 'Reception' ? 'selected' : '' }}>Reception</option>
                <option value="Housekeeping" {{ request('department') == 'Housekeeping' ? 'selected' : '' }}>Housekeeping
                </option>
                <option value="Restaurant" {{ request('department') == 'Restaurant' ? 'selected' : '' }}>Restaurant
                </option>
                <option value="Legal" {{ request('department') == 'Legal' ? 'selected' : '' }}>Legal</option>
                <option value="IT" {{ request('department') == 'IT' ? 'selected' : '' }}>IT</option>
                <option value="Finance" {{ request('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
              </select>

              <!-- Action Filter -->
              <select id="actionFilter" name="action" class="select select-bordered select-sm bg-white border-gray-200">
                <option value="">All Actions</option>
                <option value="Login" {{ request('action') == 'Login' ? 'selected' : '' }}>Login</option>
                <option value="Logout" {{ request('action') == 'Logout' ? 'selected' : '' }}>Logout</option>
                <option value="save_legal_draft" {{ request('action') == 'save_legal_draft' ? 'selected' : '' }}>Save
                  Legal Draft</option>
                <option value="document_view" {{ request('action') == 'document_view' ? 'selected' : '' }}>Document View
                </option>
                <option value="Document_uploaded" {{ request('action') == 'Document_uploaded' ? 'selected' : '' }}>
                  Document Uploaded</option>
                <option value="Access_control_check" {{ request('action') == 'Access_control_check' ? 'selected' : '' }}>
                  Access Control Check</option>
                <option value="Profile_updated" {{ request('action') == 'Profile_updated' ? 'selected' : '' }}>Profile
                  Updated</option>
                <option value="Table_added" {{ request('action') == 'Table_added' ? 'selected' : '' }}>Table Added
                </option>
                <option value="Facility_reserved" {{ request('action') == 'Facility_reserved' ? 'selected' : '' }}>
                  Facility Reserved</option>
                <option value="Visitor_registered" {{ request('action') == 'Visitor_registered' ? 'selected' : '' }}>
                  Visitor Registered</option>
                <option value="Report_generated" {{ request('action') == 'Report_generated' ? 'selected' : '' }}>Report
                  Generated</option>
                <option value="Settings_updated" {{ request('action') == 'Settings_updated' ? 'selected' : '' }}>Settings
                  Updated</option>
                <option value="Data_exported" {{ request('action') == 'Data_exported' ? 'selected' : '' }}>Data Exported
                </option>
              </select>

              <!-- Date Filter -->
              <input type="date" id="dateFilter" name="date" value="{{ request('date') }}"
                class="input input-bordered input-sm bg-white border-gray-200">

              <!-- Clear Filters -->
              <button onclick="clearFilters()" class="btn btn-sm btn-ghost text-gray-500 hover:text-gray-700 gap-1">
                <i data-lucide="x" class="w-4 h-4"></i>
                Clear
              </button>
            </div>
          </div>

          <div id="logsTableWrapper" class="relative">
            <div id="loadingOverlay" class="absolute inset-0 bg-white/50 z-10 flex items-center justify-center hidden">
              <span class="loading loading-spinner loading-md text-[#001F54]"></span>
            </div>
            @include('access.partials.audit_logs_table')
          </div>
        </div>
      </main>
    </div>
  </div>

  @include('partials.soliera_js')

  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    let debounceTimer;

    function fetchLogs(page = 1) {
      const search = document.getElementById('searchInput').value;
      const department = document.getElementById('departmentFilter').value;
      const action = document.getElementById('actionFilter').value;
      const date = document.getElementById('dateFilter').value;

      const overlay = document.getElementById('loadingOverlay');
      overlay.classList.remove('hidden');

      const params = new URLSearchParams({
        search: search,
        department: department,
        action: action,
        date: date,
        page: page
      });

      fetch(`{{ route('access.audit_logs') }}?${params.toString()}`, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
        .then(response => response.text())
        .then(html => {
          document.getElementById('logsTableWrapper').innerHTML = `
          <div id="loadingOverlay" class="absolute inset-0 bg-white/50 z-10 flex items-center justify-center hidden">
            <span class="loading loading-spinner loading-md text-[#001F54]"></span>
          </div>
          ${html}
        `;

          // Removed header records badge; no need to update count here

          // Re-initialize Lucide icons
          lucide.createIcons();

          // Update URL without refreshing the page
          const newUrl = `${window.location.pathname}?${params.toString()}`;
          window.history.pushState({ path: newUrl }, '', newUrl);

          overlay.classList.add('hidden');
        })
        .catch(error => {
          console.error('Error fetching logs:', error);
          overlay.classList.add('hidden');
        });
    }

    function changePage(page) {
      fetchLogs(page);
    }

    function clearFilters() {
      document.getElementById('searchInput').value = '';
      document.getElementById('departmentFilter').value = '';
      document.getElementById('actionFilter').value = '';
      document.getElementById('dateFilter').value = '';

      fetchLogs(1);
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function () {
      const searchInput = document.getElementById('searchInput');
      const departmentFilter = document.getElementById('departmentFilter');
      const actionFilter = document.getElementById('actionFilter');
      const dateFilter = document.getElementById('dateFilter');

      if (searchInput) {
        searchInput.addEventListener('input', () => {
          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(() => fetchLogs(1), 300);
        });
      }

      if (departmentFilter) {
        departmentFilter.addEventListener('change', () => fetchLogs(1));
      }

      if (actionFilter) {
        actionFilter.addEventListener('change', () => fetchLogs(1));
      }

      if (dateFilter) {
        dateFilter.addEventListener('change', () => fetchLogs(1));
      }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function () {
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('search')) document.getElementById('searchInput').value = urlParams.get('search');
      if (urlParams.has('department')) document.getElementById('departmentFilter').value = urlParams.get('department');
      if (urlParams.has('action')) document.getElementById('actionFilter').value = urlParams.get('action');
      if (urlParams.has('date')) document.getElementById('dateFilter').value = urlParams.get('date');

      fetchLogs(urlParams.get('page') || 1);
    });
  </script>
</body>

</html>
