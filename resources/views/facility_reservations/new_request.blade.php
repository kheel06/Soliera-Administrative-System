<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>New Request - Soliera</title>
  @include('partials.favicon')
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* SweetAlert2 Modal Styles */
    .swal2-popup {
      font-family: inherit;
      border-radius: 12px !important;
      padding: 0 !important;
      max-width: 1000px !important;
    }
    .swal2-confirm {
      background-color: #22c55e !important;
      border: none !important;
      padding: 12px 24px !important;
      border-radius: 8px !important;
      font-weight: 600 !important;
      font-size: 14px !important;
      color: white !important;
      margin-right: 8px !important;
    }
    .swal2-cancel {
      background-color: #6b7280 !important;
      border: none !important;
      padding: 12px 24px !important;
      border-radius: 8px !important;
      font-weight: 600 !important;
      font-size: 14px !important;
      color: white !important;
      margin-left: 8px !important;
    }
    .swal2-actions {
      gap: 10px !important;
      margin-top: 20px !important;
    }
    .swal2-title {
      font-size: 20px !important;
      font-weight: 600 !important;
      margin-bottom: 16px !important;
    }
    .swal2-content {
      font-size: 16px !important;
      line-height: 1.5 !important;
      padding: 0 !important;
    }
    .swal2-html-container {
      margin: 0 !important;
      padding: 0 !important;
    }

    /* Request Details Modal Styles */
    .request-details-modal {
      display: flex;
      flex-direction: column;
      height: 85vh;
      max-height: 900px;
      background: white;
      border-radius: 12px;
      overflow: hidden;
    }

    /* Sticky Header */
    .modal-header {
      position: sticky;
      top: 0;
      z-index: 10;
      background: white;
      border-bottom: 1px solid #e5e7eb;
      padding: 20px 24px;
      flex-shrink: 0;
    }
    .modal-header-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
    }
    .modal-title-section {
      flex: 1;
      min-width: 0;
    }
    .modal-title {
      font-size: 20px;
      font-weight: 600;
      color: #111827;
      margin: 0 0 4px 0;
    }
    .modal-subtitle {
      font-size: 14px;
      color: #6b7280;
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }
    .modal-close-btn {
      background: none;
      border: none;
      padding: 8px;
      cursor: pointer;
      color: #6b7280;
      border-radius: 6px;
      transition: all 0.2s;
      flex-shrink: 0;
    }
    .modal-close-btn:hover {
      background: #f3f4f6;
      color: #111827;
    }

    /* Tabs */
    .modal-tabs {
      display: flex;
      gap: 4px;
      border-bottom: 1px solid #e5e7eb;
      padding: 0 24px;
      overflow-x: auto;
      flex-shrink: 0;
    }
    .modal-tab {
      padding: 12px 16px;
      background: none;
      border: none;
      border-bottom: 2px solid transparent;
      cursor: pointer;
      font-size: 14px;
      font-weight: 500;
      color: #6b7280;
      white-space: nowrap;
      transition: all 0.2s;
      position: relative;
    }
    .modal-tab:hover {
      color: #111827;
      background: #f9fafb;
    }
    .modal-tab.active {
      color: #001F54;
      border-bottom-color: #001F54;
      background: #f9fafb;
    }

    /* Tab Content */
    .modal-body {
      flex: 1;
      overflow-y: auto;
      padding: 24px;
      min-height: 0;
    }
    .tab-content {
      display: none;
    }
    .tab-content.active {
      display: block;
    }

    /* Detail Row - Fixed Layout (No Label Wrapping) */
    .detail-row {
      display: grid;
      grid-template-columns: 180px 1fr;
      gap: 16px;
      align-items: start;
    }
    @media (max-width: 640px) {
      .detail-row {
        grid-template-columns: 1fr;
        gap: 8px;
      }
    }
    .detail-label {
      flex-shrink: 0;
      min-width: 0;
    }
    .label-text {
      font-weight: 600;
      font-size: 14px;
      color: #374151;
      white-space: nowrap;
      word-break: keep-all;
      display: block;
    }
    .detail-value {
      min-width: 0;
      word-wrap: break-word;
      overflow-wrap: break-word;
      font-size: 14px;
      color: #111827;
    }
    .detail-value a {
      color: #2563eb;
      text-decoration: none;
    }
    .detail-value a:hover {
      text-decoration: underline;
    }

    /* Copy Button */
    .copy-btn {
      background: #f3f4f6;
      border: none;
      padding: 4px 8px;
      border-radius: 4px;
      cursor: pointer;
      color: #6b7280;
      transition: all 0.2s;
      flex-shrink: 0;
    }
    .copy-btn:hover {
      background: #e5e7eb;
      color: #111827;
    }

    /* Section Styling */
    .detail-section {
      margin-bottom: 32px;
    }
    .detail-section:last-child {
      margin-bottom: 0;
    }
    .section-title {
      font-size: 16px;
      font-weight: 600;
      color: #111827;
      margin-bottom: 16px;
      padding-bottom: 8px;
      border-bottom: 2px solid #e5e7eb;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Overview Summary Card */
    .overview-summary {
      background: linear-gradient(135deg, #001F54 0%, #2d5a87 100%);
      color: white;
      padding: 24px;
      border-radius: 12px;
      margin-bottom: 24px;
    }
    .overview-summary-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }
    .summary-item {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    .summary-label {
      font-size: 12px;
      opacity: 0.8;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .summary-value {
      font-size: 18px;
      font-weight: 600;
    }

    /* Special Request Callout */
    .special-request-callout {
      background: #fef3c7;
      border-left: 4px solid #f59e0b;
      padding: 16px;
      border-radius: 8px;
      margin: 16px 0;
    }
    .special-request-callout-title {
      font-weight: 600;
      color: #92400e;
      margin-bottom: 8px;
      font-size: 14px;
    }
    .special-request-callout-text {
      color: #78350f;
      font-size: 14px;
      line-height: 1.6;
    }

    /* Image Grid */
    .image-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 16px;
      margin: 16px 0;
    }
    .image-item {
      position: relative;
      aspect-ratio: 16/9;
      overflow: hidden;
      border-radius: 8px;
      border: 1px solid #e5e7eb;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .image-item:hover {
      transform: scale(1.02);
    }
    .image-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Sticky Footer */
    .modal-footer {
      position: sticky;
      bottom: 0;
      z-index: 10;
      background: white;
      border-top: 1px solid #e5e7eb;
      padding: 16px 24px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 12px;
      flex-shrink: 0;
    }
    .modal-footer-actions {
      display: flex;
      gap: 12px;
      justify-content: center;
    }
    .modal-footer-btn {
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      border: none;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .modal-footer-btn-close {
      background: #6b7280;
      color: white;
    }
    .modal-footer-btn-close:hover {
      background: #4b5563;
    }
    .modal-footer-btn-danger {
      background: #ef4444;
      color: white;
    }
    .modal-footer-btn-danger:hover {
      background: #dc2626;
    }
    .modal-footer-btn-primary {
      background: #22c55e;
      color: white;
    }
    .modal-footer-btn-primary:hover {
      background: #16a34a;
    }

    /* Status Badge */
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 12px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
      border: 1px solid;
    }
    .status-badge.pending {
      background: #fef3c7;
      color: #92400e;
      border-color: #fbbf24;
    }
    .status-badge.approved {
      background: #d1fae5;
      color: #065f46;
      border-color: #10b981;
    }
    .status-badge.rejected, .status-badge.declined {
      background: #fee2e2;
      color: #991b1b;
      border-color: #ef4444;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .request-details-modal {
        height: 90vh;
      }
      .modal-header {
        padding: 16px;
      }
      .modal-body {
        padding: 16px;
      }
      .modal-footer {
        padding: 12px 16px;
        flex-direction: column;
      }
      .modal-footer-actions {
        width: 100%;
        margin-left: 0;
      }
      .modal-footer-btn {
        flex: 1;
      }
      .detail-row {
        grid-template-columns: 1fr;
      }
      .overview-summary-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
  @vite(['resources/css/app.css', 'resources/css/soliera.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
  @include('partials.page-loader')
  <div class="flex h-screen overflow-hidden">
    <!-- Hidden CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                <i data-lucide="clipboard-list" class="w-6 h-6 text-[#F7B32B]"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-800">
                  Submitted Requests
                </h1>
                <p class="text-gray-500 text-sm">View and manage submitted requests</p>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <button onclick="loadFacilityRequests()" class="btn btn-sm bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 gap-2 shadow-sm">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                Refresh
              </button>
            </div>
          </div>
        </div>

        <!-- Stats Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <!-- Total Requests -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Requests</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="statTotalRequests">—</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#001F54] to-[#2d5a87] flex items-center justify-center">
                <i data-lucide="clipboard-list" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Pending -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Pending Review</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="statPendingReview">—</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#001F54] to-[#2d5a87] flex items-center justify-center">
                <i data-lucide="clock" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Approved -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Approved</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="statApproved">—</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#001F54] to-[#2d5a87] flex items-center justify-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Reservations -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Reservations</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="statReservations">—</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#001F54] to-[#2d5a87] flex items-center justify-center">
                <i data-lucide="calendar" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>
        </div>

        
        <!-- Requests Table Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <!-- Table Header -->
          <div class="bg-[#001F54] px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
              <h3 class="text-lg font-semibold text-white flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                  <i data-lucide="list" class="w-4 h-4 text-[#F7B32B]"></i>
                </div>
                Submitted Requests
              </h3>
              <div class="flex items-center gap-3">
                <!-- Search -->
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-white/60"></i>
                  </div>
                  <input type="text" id="searchRequests" placeholder="Search requests..." 
                         class="pl-10 pr-4 py-2 text-sm bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-[#F7B32B]/50 focus:border-transparent w-48">
                </div>
              </div>
            </div>
          </div>

          <!-- Loading Skeleton -->
          <div id="tableLoading" class="px-6 py-8">
            <div class="animate-pulse space-y-4">
              <div class="h-4 bg-gray-200 rounded w-3/4"></div>
              <div class="h-4 bg-gray-200 rounded w-1/2"></div>
              <div class="h-4 bg-gray-200 rounded w-5/6"></div>
            </div>
          </div>

          <!-- Error State -->
          <div id="tableError" class="hidden text-center py-16">
            <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
              <i data-lucide="alert-circle" class="w-8 h-8 text-red-300"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Error Loading Data</h3>
            <p class="text-gray-400 text-sm mb-4" id="errorMessage">Failed to load facility requests from the API.</p>
            <button onclick="loadFacilityRequests()" class="btn btn-sm bg-[#001F54] text-white hover:bg-[#2d5a87]">
              <i data-lucide="refresh-cw" class="w-4 h-4"></i>
              Retry
            </button>
          </div>

          <!-- Empty State -->
          <div id="tableEmpty" class="hidden text-center py-16">
            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mx-auto mb-4">
              <i data-lucide="inbox" class="w-8 h-8 text-blue-300"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No requests found</h3>
            <p class="text-gray-400 text-sm">There are no facility requests to display at this time.</p>
          </div>

          <!-- Table Container -->
          <div id="tableContainer" class="hidden overflow-x-auto">
            <table class="table w-full min-w-[800px]" id="nrRequestsTable">
              <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                  <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider py-3 px-4">Request ID</th>
                  <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider py-3 px-4">Type</th>
                  <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider py-3 px-4">Facility/Equipment</th>
                  <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider py-3 px-4">Schedule</th>
                  <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider py-3 px-4">Status</th>
                  <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wider py-3 px-4">Actions</th>
                </tr>
              </thead>
              <tbody id="tableBody" class="divide-y divide-gray-100">
                <!-- Table rows will be populated by JavaScript -->
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>

  @include('partials.soliera_js')
  
  <!-- API Client (uses server-side proxy - token handled server-side to prevent 401 + avoid exposing secrets) -->
  <script>
    /**
     * Soliera Hotel API Client
     * All API calls go through Laravel server-side proxy to avoid exposing token to browser.
     * Token handled server-side to prevent 401 + avoid exposing secrets.
     */
    class SolieraApiClient {
      constructor() {
        // No config needed - all calls go through server-side proxy
        this.proxyBaseUrl = '/internal/soliera';
      }

      getHeaders() {
        // Only need CSRF token for Laravel routes, not Bearer token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
          || document.querySelector('input[name="_token"]')?.value;
        
        return {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken || '',
          'X-Requested-With': 'XMLHttpRequest',
        };
      }

      async getCore1Events() {
        try {
          const response = await fetch(`${this.proxyBaseUrl}/core1events`, {
            method: 'GET',
            headers: this.getHeaders(),
            credentials: 'same-origin', // Include cookies for auth
          });

          if (!response.ok) {
            const errorText = await response.text();
            let errorMessage = `API Error: ${response.status}`;
            try {
              const errorJson = JSON.parse(errorText);
              errorMessage += ' - ' + (errorJson.message || errorText);
            } catch {
              errorMessage += ' - ' + errorText;
            }
            throw new Error(errorMessage);
          }

          const data = await response.json();
          // Handle both array and object with data property
          return Array.isArray(data) ? data : (data.data || data.events || []);
        } catch (error) {
          console.error('Error fetching core1events:', error);
          throw error;
        }
      }

      async updateEventStatus(eventbookingID, status) {
        try {
          const response = await fetch(`${this.proxyBaseUrl}/eventapproved/${eventbookingID}`, {
            method: 'PUT',
            headers: this.getHeaders(),
            credentials: 'same-origin', // Include cookies for auth
            body: JSON.stringify({
              status: status
            }),
          });

          if (!response.ok) {
            const errorText = await response.text();
            let errorMessage = `API Error: ${response.status}`;
            try {
              const errorJson = JSON.parse(errorText);
              errorMessage += ' - ' + (errorJson.message || errorText);
            } catch {
              errorMessage += ' - ' + errorText;
            }
            throw new Error(errorMessage);
          }

          const data = await response.json();
          return data;
        } catch (error) {
          console.error('Error updating event status:', error);
          throw error;
        }
      }
    }

    window.SolieraApiClient = SolieraApiClient;
  </script>
  
  <script>
    // Current active tab
    let currentTab = 'reservation';
    
    // Tab filtering logic
    function nrShowTab(type) {
      currentTab = type;
      
      // Reset all navigation buttons - update to pill style
      const nav1 = document.getElementById('nav-facility');
      const nav2 = document.getElementById('nav-maintenance');
      const nav3 = document.getElementById('nav-equipment');
      
      const activeClasses = ['bg-[#001F54]', 'text-white', 'shadow-md'];
      const inactiveClasses = ['bg-white', 'text-gray-600', 'hover:bg-gray-50', 'border', 'border-gray-200'];
      
      [nav1, nav2, nav3].forEach(btn => {
        if (btn) {
          // Remove all active and inactive classes
          activeClasses.forEach(cls => btn.classList.remove(cls));
          inactiveClasses.forEach(cls => btn.classList.remove(cls));
          // Add inactive classes by default
          inactiveClasses.forEach(cls => btn.classList.add(cls));
          
          // Update icon box inside button
          const iconBox = btn.querySelector('div');
          if (iconBox) {
            iconBox.classList.remove('bg-white/20', 'bg-[#001F54]');
            iconBox.classList.add('bg-[#001F54]');
          }
        }
      });

      // Update active navigation button
      const activeBtn = type === 'reservation' ? nav1 : type === 'maintenance' ? nav2 : nav3;
      if (activeBtn) {
        inactiveClasses.forEach(cls => activeBtn.classList.remove(cls));
        activeClasses.forEach(cls => activeBtn.classList.add(cls));
        
        // Update icon box for active button
        const iconBox = activeBtn.querySelector('div');
        if (iconBox) {
          iconBox.classList.remove('bg-[#001F54]');
          iconBox.classList.add('bg-white/20');
        }
      }
      
      // Update URL
      try {
        const url = new URL(window.location.href);
        if (type === 'reservation') {
          url.searchParams.delete('tab');
        } else {
          url.searchParams.set('tab', type);
        }
        window.history.replaceState({}, '', url);
      } catch(e) {}

      // Filter rows
      filterTable();
    }
    
    // Filter table based on tab and search
    function filterTable() {
      const searchTerm = document.getElementById('searchRequests')?.value.toLowerCase() || '';
      const rows = document.querySelectorAll('#nrRequestsTable tbody tr');
      let count = 0;
      
      rows.forEach(row => {
        const rt = row.getAttribute('data-rt');
        const matchesTab = rt === currentTab;
        const rowText = row.textContent.toLowerCase();
        const matchesSearch = searchTerm === '' || rowText.includes(searchTerm);
        const show = matchesTab && matchesSearch;
        row.style.display = show ? '' : 'none';
        if (show) count++;
      });
      
      const totalEl = document.getElementById('nrTotalCount');
      if (totalEl) totalEl.textContent = count;
    }

    document.addEventListener('DOMContentLoaded', function(){
      // Default to Facility Request tab (reservation)
      const urlParams = new URLSearchParams(window.location.search);
      const initial = urlParams.get('tab') || 'reservation';
      if (typeof nrShowTab === 'function') nrShowTab(initial);
      
      // Search functionality
      const searchInput = document.getElementById('searchRequests');
      if (searchInput) {
        searchInput.addEventListener('input', function() {
          filterTable();
        });
      }
      
      // Initialize Lucide icons
      if (window.lucide && window.lucide.createIcons) {
        window.lucide.createIcons();
      }
    });
    
    // Helper: Build absolute image URL from relative path
    function buildImageUrl(path) {
      if (!path || typeof path !== 'string') return null;
      // If already absolute URL, return as-is
      if (path.startsWith('http://') || path.startsWith('https://')) {
        return path;
      }
      // Build absolute URL from API base
      const apiBaseUrl = 'https://hotel.soliera-hotel-restaurant.com';
      // Remove leading slash if present to avoid double slashes
      const cleanPath = path.startsWith('/') ? path.substring(1) : path;
      return `${apiBaseUrl}/${cleanPath}`;
    }

    // Helper: Parse JSON string if needed
    function parseJsonIfString(value) {
      if (typeof value === 'string') {
        // Check if it looks like JSON (starts with [ or {)
        const trimmed = value.trim();
        if ((trimmed.startsWith('[') && trimmed.endsWith(']')) || 
            (trimmed.startsWith('{') && trimmed.endsWith('}'))) {
          try {
            return JSON.parse(value);
          } catch (e) {
            // Not valid JSON, return as string
            return value;
          }
        }
      }
      return value;
    }

    // Helper: Format value for display
    function formatFieldValue(value, fieldType = 'text') {
      // Parse JSON strings first
      value = parseJsonIfString(value);
      
      if (value === null || value === undefined || value === '') {
        return '—';
      }

      // Handle arrays
      if (Array.isArray(value)) {
        if (value.length === 0) return '—';
        // Return array for chip rendering
        return value;
      }

      // Handle objects
      if (typeof value === 'object' && value !== null) {
        // If it's a nested object with specific structure, format it
        if (fieldType === 'object') {
          return value; // Return object for structured rendering
        }
        // Otherwise stringify for display
        return JSON.stringify(value, null, 2);
      }

      // Handle booleans
      if (typeof value === 'boolean') {
        return value ? 'Yes' : 'No';
      }

      // Handle image paths
      if (fieldType === 'image' && typeof value === 'string') {
        return buildImageUrl(value);
      }

      // Handle dates
      if (fieldType === 'date' && value) {
        try {
          const date = new Date(value);
          if (isNaN(date.getTime())) {
            return String(value);
          }
          return date.toLocaleString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
          });
        } catch (e) {
          return String(value);
        }
      }

      return String(value);
    }

    // Helper: Render array as chips
    function renderArrayAsChips(arr) {
      if (!Array.isArray(arr) || arr.length === 0) return '—';
      return arr.map(item => 
        `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">${escapeHtml(String(item))}</span>`
      ).join(' ');
    }

    // Helper: Render image
    function renderImage(imageUrl, alt = 'Image') {
      if (!imageUrl) return '—';
      const fullUrl = buildImageUrl(imageUrl);
      return `
        <div class="mt-2">
          <img src="${fullUrl}" 
               alt="${escapeHtml(alt)}" 
               class="max-h-48 w-auto rounded-lg border border-gray-200 object-cover cursor-pointer hover:opacity-90 transition-opacity"
               onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'200\\' height=\\'200\\'%3E%3Crect fill=\\'%23f3f4f6\\' width=\\'200\\' height=\\'200\\'/%3E%3Ctext fill=\\'%239ca3af\\' font-family=\\'sans-serif\\' font-size=\\'14\\' x=\\'50%25\\' y=\\'50%25\\' text-anchor=\\'middle\\' dominant-baseline=\\'middle\\'%3EImage not found%3C/text%3E%3C/svg%3E';"
               onclick="window.open('${fullUrl}', '_blank')"
               title="Click to view full size">
          <a href="${fullUrl}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 block">Open image in new tab</a>
        </div>
      `;
    }

    // Helper: Escape HTML
    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    // Helper: Format currency (PHP)
    function formatCurrency(value) {
      if (!value) return '—';
      const num = parseFloat(value);
      if (isNaN(num)) return value;
      return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2
      }).format(num);
    }

    // Helper: Format date consistently
    function formatDateConsistent(dateStr) {
      if (!dateStr) return '—';
      try {
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return dateStr;
        return date.toLocaleDateString('en-US', { 
          year: 'numeric', 
          month: 'short', 
          day: 'numeric'
        });
      } catch (e) {
        return dateStr;
      }
    }

    // Helper: Copy to clipboard (global function)
    window.copyToClipboard = function(text, label) {
      navigator.clipboard.writeText(text).then(() => {
        // Show temporary success message
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.textContent = `${label} copied to clipboard`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
      }).catch(() => {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
      });
    };

    // Helper: Render field row with fixed layout (no label wrapping)
    function renderFieldRow(label, value, fieldType = 'text', isImage = false, options = {}) {
      // Don't render if value is null, undefined, or empty string
      if (value === null || value === undefined || value === '') {
        return '';
      }
      
      let displayValue = formatFieldValue(value, fieldType);
      
      // Don't render if formatted value is "—"
      if (displayValue === '—') {
        return '';
      }

      const { copyable = false, clickable = false, href = null } = options;
      
      if (isImage && displayValue && displayValue !== '—') {
        return `
          <div class="detail-row mb-4">
            <div class="detail-label">
              <span class="label-text">${escapeHtml(label)}</span>
            </div>
            <div class="detail-value">
              ${renderImage(displayValue, label)}
            </div>
          </div>
        `;
      }
      
      if (Array.isArray(displayValue)) {
        if (displayValue.length === 0) return '';
        return `
          <div class="detail-row mb-4">
            <div class="detail-label">
              <span class="label-text">${escapeHtml(label)}</span>
            </div>
            <div class="detail-value">
              <div class="flex flex-wrap gap-2">${renderArrayAsChips(displayValue)}</div>
            </div>
          </div>
        `;
      }
      
      if (typeof displayValue === 'object' && displayValue !== null && !Array.isArray(displayValue)) {
        const objHtml = Object.entries(displayValue).map(([k, v]) => {
          const val = formatFieldValue(v);
          if (val === '—') return '';
          return `<div class="text-xs mb-1"><span class="font-medium">${escapeHtml(String(k))}:</span> <span class="text-gray-700">${escapeHtml(String(val))}</span></div>`;
        }).filter(html => html !== '').join('');
        if (!objHtml) return '';
        return `
          <div class="detail-row mb-4">
            <div class="detail-label">
              <span class="label-text">${escapeHtml(label)}</span>
            </div>
            <div class="detail-value">
              <div class="bg-gray-50 p-3 rounded text-xs space-y-1 border border-gray-200">${objHtml}</div>
            </div>
          </div>
        `;
      }
      
      // Format currency if needed
      if (fieldType === 'currency' || (typeof value === 'string' && value.includes('.') && !isNaN(parseFloat(value)))) {
        const num = parseFloat(value);
        if (!isNaN(num) && label.toLowerCase().includes('price')) {
          displayValue = formatCurrency(value);
        }
      }
      
      // Format date if needed
      if (fieldType === 'date') {
        displayValue = formatDateConsistent(value);
      }
      
      // Build value with optional copy/click actions
      let valueHtml = escapeHtml(String(displayValue));
      if (copyable) {
        valueHtml = `
          <div class="flex items-center gap-2">
            <span class="flex-1">${valueHtml}</span>
            <button onclick="copyToClipboard('${escapeHtml(String(value))}', '${escapeHtml(label)}')" 
                    class="copy-btn" 
                    title="Copy ${escapeHtml(label)}"
                    aria-label="Copy ${escapeHtml(label)} to clipboard">
              <i data-lucide="copy" class="w-4 h-4"></i>
            </button>
          </div>
        `;
      } else if (clickable && href) {
        valueHtml = `<a href="${href}" class="text-blue-600 hover:text-blue-800 hover:underline">${valueHtml}</a>`;
      }
      
      return `
        <div class="detail-row mb-4">
          <div class="detail-label">
            <span class="label-text">${escapeHtml(label)}</span>
          </div>
          <div class="detail-value">
            ${valueHtml}
          </div>
        </div>
      `;
    }

    // View request details from API data
    async function viewRequestDetailsFromApi(eventbookingID, clickedElement = null) {
      if (!apiClient) {
        if (!initApiClient()) {
          Swal.fire({
            title: 'Error!',
            text: 'API client is not initialized. Please refresh the page.',
            icon: 'error',
            confirmButtonColor: '#ef4444',
          });
          return;
        }
      }

      // Find the event in local data
      const event = allEvents.find(e => 
        (e.eventbookingID || e.id || e.booking_id) == eventbookingID
      );

      if (!event) {
        Swal.fire({
          title: 'Error!',
          text: 'Request not found in local data.',
          icon: 'error',
          confirmButtonColor: '#ef4444',
        });
        return;
      }

      // Show loading state
      const button = clickedElement || (window.event?.target?.closest('button'));
      const originalHTML = button?.innerHTML || '';
      if (button) {
        button.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>';
        button.disabled = true;
        if (window.lucide && window.lucide.createIcons) {
          window.lucide.createIcons();
        }
      }

      try {
        // Get raw event data - use the full event object from API
        const rawData = event.raw || event;
        
        // Helper to safely get value (only if exists and not null)
        function getValue(key) {
          const value = rawData[key];
          if (value !== undefined && value !== null && value !== '') {
            return value;
          }
          return null;
        }
        
        // Helper to parse JSON string if needed
        function parseJsonValue(value) {
          if (typeof value === 'string' && (value.startsWith('[') || value.startsWith('{'))) {
            try {
              return JSON.parse(value);
            } catch (e) {
              return value;
            }
          }
          return value;
        }
        
        // Helpers for restaurant/alternate API formats
        function getFirstValue(...keys) {
          for (const key of keys) {
            const value = rawData[key];
            if (value !== undefined && value !== null && value !== '') return value;
            if (rawData._raw && rawData._raw[key] !== undefined && rawData._raw[key] !== null && rawData._raw[key] !== '') {
              return rawData._raw[key];
            }
          }
          return null;
        }

        const parsedNotes = parseJsonValue(getFirstValue('facility_notes_parsed'));
        const noteRequests = parsedNotes?.requests || {};
        const sourceType = rawData._source || (getFirstValue('reservation_id') ? 'restaurant' : 'hotel');

        // Extract data using exact API field names (separate mapping per source)
        const data = sourceType === 'restaurant' ? {
          // Main Information
          eventbookingID: getFirstValue('reservation_id', 'eventbookingID', 'id'),
          eventstatus: getFirstValue('reservation_status', 'eventstatus', 'status'),
          eventtype_ID: null,

          // Organizer/Contact (restaurant feed usually doesn't include these)
          eventorganizer_name: getFirstValue('eventorganizer_name', 'contact_name', 'contactName'),
          eventorganizer_email: getFirstValue('eventorganizer_email', 'contact_email', 'contactEmail'),
          eventorganizer_phone: getFirstValue('eventorganizer_phone', 'contact_phone', 'contactPhone'),

          // Event Details
          event_name: getFirstValue('event_name', 'eventName'),
          event_specialrequest: noteRequests['Requirements'] || noteRequests['Requirement'] || null,
          event_equipment: noteRequests['Equipment'] || null,
          event_numguest: getFirstValue('event_numguest', 'num_guest', 'guest_count'),
          event_setup_time: noteRequests['Setup Time'] || noteRequests['Setup time'] || null,

          // Booking/Schedule
          event_bookedate: getFirstValue('event_date'),
          event_checkin: getFirstValue('event_date'),
          event_checkout: null,
          event_time: getFirstValue('event_time', 'eventTime'),
          event_date_formatted: getFirstValue('event_date_formatted'),
          event_time_formatted: getFirstValue('event_time_formatted'),

          // Payment
          event_paymentstatus: null,
          event_paymentmethod: null,
          event_total_price: null,
          event_bookingreceiptID: null,

          // Event Type
          eventtype_name: getFirstValue('event_type', 'eventtype_name'),
          eventtype_photo: null,
          eventtype_price: null,
          eventtype_description: null,
          eventtype_capacity: null,
          eventtype_duration: null,
          eventtype_status: null,
          eventtype_amenities: null,
          eventtype_catering_options: null,
          eventtype_theme_options: null,
          eventtype_extra_services: null,

          // Facility
          facility_name: getFirstValue('venue'),
          facility_type: null,
          facility_photo: null,
          facility_capacity: null,
          facility_status: null,
          facility_description: null,
          facility_amenities: null,
          facility_notes: getFirstValue('facility_notes'),

          // Additional flags
          days_until_event: getFirstValue('days_until_event'),
          is_upcoming: getFirstValue('is_upcoming'),
          is_today: getFirstValue('is_today'),
          is_past: getFirstValue('is_past'),

          // Timestamps
          created_at: getValue('created_at'),
          updated_at: getValue('updated_at')
        } : {
          // Main Information
          eventbookingID: getFirstValue('eventbookingID', 'reservation_id', 'id', 'booking_id'),
          eventstatus: getFirstValue('eventstatus', 'reservation_status', 'status', 'bookingStatus'),
          eventtype_ID: getValue('eventtype_ID'),
          
          // Organizer/Contact
          eventorganizer_name: getFirstValue('eventorganizer_name', 'contact_name', 'contactName'),
          eventorganizer_email: getFirstValue('eventorganizer_email', 'contact_email', 'contactEmail'),
          eventorganizer_phone: getFirstValue('eventorganizer_phone', 'contact_phone', 'contactPhone'),
          
          // Event Details
          event_name: getFirstValue('event_name', 'eventName', 'event_title', 'event'),
          event_specialrequest: getFirstValue('event_specialrequest') || noteRequests['Requirements'] || noteRequests['Requirement'] || null,
          event_equipment: getFirstValue('event_equipment') || noteRequests['Equipment'] || null,
          event_numguest: getFirstValue('event_numguest', 'num_guest', 'guest_count'),
          event_setup_time: noteRequests['Setup Time'] || noteRequests['Setup time'] || null,
          
          // Booking/Schedule
          event_bookedate: getFirstValue('event_bookedate', 'event_date', 'bookedate', 'eventDate'),
          event_checkin: getFirstValue('event_checkin', 'event_date', 'checkin', 'check_in'),
          event_checkout: getFirstValue('event_checkout', 'checkout', 'check_out'),
          event_time: getFirstValue('event_time', 'eventTime', 'start_time', 'startTime'),
          
          // Payment
          event_paymentstatus: getValue('event_paymentstatus'),
          event_paymentmethod: getValue('event_paymentmethod'),
          event_total_price: getValue('event_total_price'),
          event_bookingreceiptID: getValue('event_bookingreceiptID'),
          
          // Event Type
          eventtype_name: getFirstValue('eventtype_name', 'event_type', 'eventType'),
          eventtype_photo: getValue('eventtype_photo'),
          eventtype_price: getValue('eventtype_price'),
          eventtype_description: getValue('eventtype_description'),
          eventtype_capacity: getValue('eventtype_capacity'),
          eventtype_duration: getValue('eventtype_duration'),
          eventtype_status: getValue('eventtype_status'),
          eventtype_amenities: parseJsonValue(getValue('eventtype_amenities')),
          eventtype_catering_options: parseJsonValue(getValue('eventtype_catering_options')),
          eventtype_theme_options: parseJsonValue(getValue('eventtype_theme_options')),
          eventtype_extra_services: parseJsonValue(getValue('eventtype_extra_services')),
          
          // Facility
          facility_name: getFirstValue('facility_name', 'venue', 'facility', 'facilityName'),
          facility_type: getValue('facility_type'),
          facility_photo: getValue('facility_photo'),
          facility_capacity: getValue('facility_capacity'),
          facility_status: getValue('facility_status'),
          facility_description: getValue('facility_description'),
          facility_amenities: parseJsonValue(getValue('facility_amenities')),
          facility_notes: getFirstValue('facility_notes'),
          
          // Timestamps
          created_at: getValue('created_at'),
          updated_at: getValue('updated_at')
        };
        
        // Build sections - only include sections with data
        const sections = [];
        
        // Main Information Section
        const mainFields = [];
        if (data.eventbookingID) mainFields.push(renderFieldRow('Request ID', data.eventbookingID));
        if (data.eventstatus) mainFields.push(renderFieldRow('Status', data.eventstatus));
        if (data.eventtype_ID) mainFields.push(renderFieldRow('Event Type ID', data.eventtype_ID));
        if (mainFields.filter(f => f).length > 0) {
          sections.push(`
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
              <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4"></i>
                Main Information
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                ${mainFields.filter(f => f).join('')}
              </div>
            </div>
          `);
        }
        
        // Contact / Organizer Section
        const contactFields = [];
        if (data.eventorganizer_name) contactFields.push(renderFieldRow('Name', data.eventorganizer_name));
        if (data.eventorganizer_email) contactFields.push(renderFieldRow('Email', data.eventorganizer_email));
        if (data.eventorganizer_phone) contactFields.push(renderFieldRow('Phone', data.eventorganizer_phone));
        if (contactFields.filter(f => f).length > 0) {
          sections.push(`
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
              <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4"></i>
                Contact / Organizer
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                ${contactFields.filter(f => f).join('')}
              </div>
            </div>
          `);
        }
        
        // Event Details Section
        const eventFields = [];
        if (data.event_name) eventFields.push(renderFieldRow('Event Name', data.event_name));
        if (data.event_specialrequest) eventFields.push(renderFieldRow('Special Request', data.event_specialrequest));
        if (data.event_equipment) eventFields.push(renderFieldRow('Equipment', data.event_equipment));
        if (data.event_setup_time) eventFields.push(renderFieldRow('Setup Time', data.event_setup_time));
        if (data.facility_notes) eventFields.push(renderFieldRow('Notes', data.facility_notes));
        if (data.event_numguest) eventFields.push(renderFieldRow('Number of Guests', data.event_numguest));
        if (eventFields.filter(f => f).length > 0) {
          sections.push(`
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
              <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <i data-lucide="calendar-days" class="w-4 h-4"></i>
                Event Details
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                ${eventFields.filter(f => f).join('')}
              </div>
            </div>
          `);
        }
        
        // Booking / Schedule Section
        const scheduleFields = [];
        if (data.event_bookedate) scheduleFields.push(renderFieldRow('Book Date', data.event_bookedate, 'date'));
        if (data.event_checkin) scheduleFields.push(renderFieldRow('Check-in', data.event_checkin, 'date'));
        if (data.event_checkout) scheduleFields.push(renderFieldRow('Check-out', data.event_checkout, 'date'));
        if (data.event_time_formatted || data.event_time) {
          scheduleFields.push(renderFieldRow('Event Time', data.event_time_formatted || data.event_time));
        }
        if (scheduleFields.filter(f => f).length > 0) {
          sections.push(`
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
              <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                Booking / Schedule
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                ${scheduleFields.filter(f => f).join('')}
              </div>
            </div>
          `);
        }
        
        // Payment Section
        const paymentFields = [];
        if (data.event_paymentstatus) paymentFields.push(renderFieldRow('Payment Status', data.event_paymentstatus));
        if (data.event_paymentmethod) paymentFields.push(renderFieldRow('Payment Method', data.event_paymentmethod));
        if (data.event_total_price) paymentFields.push(renderFieldRow('Total Price', data.event_total_price));
        if (data.event_bookingreceiptID) paymentFields.push(renderFieldRow('Booking Receipt ID', data.event_bookingreceiptID));
        if (paymentFields.filter(f => f).length > 0) {
          sections.push(`
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
              <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                Payment
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                ${paymentFields.filter(f => f).join('')}
              </div>
            </div>
          `);
        }
        
        // Event Type Details Section
        const eventTypeFields = [];
        if (data.eventtype_name) eventTypeFields.push(renderFieldRow('Event Type Name', data.eventtype_name));
        if (data.eventtype_photo) eventTypeFields.push(renderFieldRow('Event Type Photo', data.eventtype_photo, 'image', true));
        if (data.eventtype_price) eventTypeFields.push(renderFieldRow('Price', data.eventtype_price));
        if (data.eventtype_duration) eventTypeFields.push(renderFieldRow('Duration', data.eventtype_duration));
        if (data.eventtype_capacity) eventTypeFields.push(renderFieldRow('Capacity', data.eventtype_capacity));
        if (data.eventtype_description) eventTypeFields.push(renderFieldRow('Description', data.eventtype_description));
        if (data.eventtype_status) eventTypeFields.push(renderFieldRow('Status', data.eventtype_status));
        if (data.eventtype_amenities) eventTypeFields.push(renderFieldRow('Amenities', data.eventtype_amenities));
        if (data.eventtype_catering_options) eventTypeFields.push(renderFieldRow('Catering Options', data.eventtype_catering_options));
        if (data.eventtype_theme_options) eventTypeFields.push(renderFieldRow('Theme Options', data.eventtype_theme_options));
        if (data.eventtype_extra_services) eventTypeFields.push(renderFieldRow('Extra Services', data.eventtype_extra_services));
        if (eventTypeFields.filter(f => f).length > 0) {
          sections.push(`
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
              <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <i data-lucide="tag" class="w-4 h-4"></i>
                Event Type Details
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                ${eventTypeFields.filter(f => f).join('')}
              </div>
            </div>
          `);
        }
        
        // Facility Details Section
        const facilityFields = [];
        if (data.facility_name) facilityFields.push(renderFieldRow('Facility Name', data.facility_name));
        if (data.facility_type) facilityFields.push(renderFieldRow('Facility Type', data.facility_type));
        if (data.facility_photo) facilityFields.push(renderFieldRow('Facility Photo', data.facility_photo, 'image', true));
        if (data.facility_capacity) facilityFields.push(renderFieldRow('Capacity', data.facility_capacity));
        if (data.facility_status) facilityFields.push(renderFieldRow('Status', data.facility_status));
        if (data.facility_description) facilityFields.push(renderFieldRow('Description', data.facility_description));
        if (data.facility_amenities) facilityFields.push(renderFieldRow('Amenities', data.facility_amenities));
        if (facilityFields.filter(f => f).length > 0) {
          sections.push(`
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
              <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <i data-lucide="building-2" class="w-4 h-4"></i>
                Facility Details
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                ${facilityFields.filter(f => f).join('')}
              </div>
            </div>
          `);
        }
        
        // Get status badge HTML
        const status = data.eventstatus || '';
        const statusLower = status.toLowerCase();
        const statusBadgeClass = statusLower === 'approved' ? 'approved' : 
                                 (statusLower === 'rejected' || statusLower === 'declined') ? 'rejected' : 'pending';
        const statusBadge = status ? `
          <span class="status-badge ${statusBadgeClass}">
            <i data-lucide="${getStatusIcon(status)}" class="w-3 h-3"></i>
            ${status}
          </span>
        ` : '';

        // Build Overview Tab (Summary + Key Info)
        const overviewContent = `
          <div class="detail-section">
            <div class="overview-summary">
              <div class="overview-summary-grid">
                ${data.eventbookingID ? `
                  <div class="summary-item">
                    <div class="summary-label">Request ID</div>
                    <div class="summary-value">#${String(data.eventbookingID).padStart(6, '0')}</div>
                  </div>
                ` : ''}
                ${data.eventstatus ? `
                  <div class="summary-item">
                    <div class="summary-label">Status</div>
                    <div class="summary-value">${statusBadge}</div>
                  </div>
                ` : ''}
                ${data.eventtype_name ? `
                  <div class="summary-item">
                    <div class="summary-label">Event Type</div>
                    <div class="summary-value">${escapeHtml(data.eventtype_name)}</div>
                  </div>
                ` : ''}
                ${data.event_checkin && data.event_checkout ? `
                  <div class="summary-item">
                    <div class="summary-label">Date Range</div>
                    <div class="summary-value">${formatDateConsistent(data.event_checkin)} - ${formatDateConsistent(data.event_checkout)}</div>
                  </div>
                ` : ''}
                ${(!data.event_checkout && data.event_checkin) ? `
                  <div class="summary-item">
                    <div class="summary-label">Event Date</div>
                    <div class="summary-value">${formatDateConsistent(data.event_checkin)}</div>
                  </div>
                ` : ''}
                ${(data.event_time_formatted || data.event_time) ? `
                  <div class="summary-item">
                    <div class="summary-label">Event Time</div>
                    <div class="summary-value">${escapeHtml(data.event_time_formatted || data.event_time)}</div>
                  </div>
                ` : ''}
                ${data.facility_name ? `
                  <div class="summary-item">
                    <div class="summary-label">Venue</div>
                    <div class="summary-value">${escapeHtml(data.facility_name)}</div>
                  </div>
                ` : ''}
                ${data.event_numguest && data.eventtype_capacity ? `
                  <div class="summary-item">
                    <div class="summary-label">Guests / Capacity</div>
                    <div class="summary-value">${data.event_numguest} / ${data.eventtype_capacity}</div>
                  </div>
                ` : ''}
                ${data.event_total_price ? `
                  <div class="summary-item">
                    <div class="summary-label">Total Price</div>
                    <div class="summary-value">${formatCurrency(data.event_total_price)}</div>
                  </div>
                ` : ''}
              </div>
            </div>
          </div>
          
          <div class="detail-section">
            <h3 class="section-title">
              <i data-lucide="info" class="w-4 h-4"></i>
              Request Information
            </h3>
            ${data.eventbookingID ? renderFieldRow('Request ID', data.eventbookingID) : ''}
            ${data.eventstatus ? renderFieldRow('Status', data.eventstatus) : ''}
            ${data.eventtype_ID ? renderFieldRow('Event Type ID', data.eventtype_ID) : ''}
            ${data.eventtype_name ? renderFieldRow('Event Type', data.eventtype_name) : ''}
            ${data.facility_name ? renderFieldRow('Venue', data.facility_name) : ''}
            ${(data.days_until_event !== null && data.days_until_event !== undefined) ? renderFieldRow('Days Until Event', data.days_until_event) : ''}
            ${(data.is_upcoming !== null && data.is_upcoming !== undefined) ? renderFieldRow('Upcoming', data.is_upcoming ? 'Yes' : 'No') : ''}
            ${(data.is_past !== null && data.is_past !== undefined) ? renderFieldRow('Past', data.is_past ? 'Yes' : 'No') : ''}
          </div>

          <div class="detail-section">
            <h3 class="section-title">
              <i data-lucide="user" class="w-4 h-4"></i>
              Organizer / Contact
            </h3>
            ${data.eventorganizer_name ? renderFieldRow('Name', data.eventorganizer_name) : ''}
            ${data.eventorganizer_email ? renderFieldRow('Email', data.eventorganizer_email, 'text', false, { copyable: true, clickable: true, href: `mailto:${escapeHtml(data.eventorganizer_email)}` }) : ''}
            ${data.eventorganizer_phone ? renderFieldRow('Phone', data.eventorganizer_phone, 'text', false, { copyable: true, clickable: true, href: `tel:${escapeHtml(data.eventorganizer_phone)}` }) : ''}
          </div>

          <div class="detail-section">
            <h3 class="section-title">
              <i data-lucide="calendar" class="w-4 h-4"></i>
              Schedule
            </h3>
            ${data.event_bookedate ? renderFieldRow('Book Date', data.event_bookedate, 'date') : ''}
            ${data.event_checkin ? renderFieldRow('Check-in', data.event_checkin, 'date') : ''}
            ${data.event_checkout ? renderFieldRow('Check-out', data.event_checkout, 'date') : ''}
            ${(data.event_time_formatted || data.event_time) ? renderFieldRow('Event Time', data.event_time_formatted || data.event_time) : ''}
          </div>
        `;

        // Build Event Tab
        const eventContent = `
          <div class="detail-section">
            <h3 class="section-title">
              <i data-lucide="calendar-days" class="w-4 h-4"></i>
              Event Details
            </h3>
            ${data.event_name ? renderFieldRow('Event Name', data.event_name) : ''}
            ${data.event_numguest ? renderFieldRow('Number of Guests', data.event_numguest) : ''}
            ${data.event_equipment ? renderFieldRow('Equipment', data.event_equipment) : ''}
            ${data.event_specialrequest ? `
              <div class="special-request-callout">
                <div class="special-request-callout-title">Special Request</div>
                <div class="special-request-callout-text">${escapeHtml(data.event_specialrequest)}</div>
              </div>
            ` : ''}
          </div>
        `;

        // Build Payment Tab
        const paymentContent = `
          <div class="detail-section">
            <h3 class="section-title">
              <i data-lucide="credit-card" class="w-4 h-4"></i>
              Payment Information
            </h3>
            ${data.event_paymentstatus ? renderFieldRow('Payment Status', data.event_paymentstatus) : ''}
            ${data.event_paymentmethod ? renderFieldRow('Payment Method', data.event_paymentmethod) : ''}
            ${data.event_total_price ? renderFieldRow('Total Price', data.event_total_price, 'currency') : ''}
            ${data.event_bookingreceiptID ? renderFieldRow('Booking Receipt ID', data.event_bookingreceiptID) : ''}
            ${(!data.event_paymentstatus && !data.event_paymentmethod && !data.event_total_price && !data.event_bookingreceiptID) ? '<p class="text-sm text-gray-500">No payment data available.</p>' : ''}
          </div>
        `;

        // Build Event Type Tab
        const eventTypeContent = `
          ${data.eventtype_photo ? `
            <div class="detail-section">
              <div class="image-grid">
                <div class="image-item" onclick="window.open('${buildImageUrl(data.eventtype_photo)}', '_blank')">
                  <img src="${buildImageUrl(data.eventtype_photo)}" alt="Event Type Photo" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'200\\' height=\\'200\\'%3E%3Crect fill=\\'%23f3f4f6\\' width=\\'200\\' height=\\'200\\'/%3E%3Ctext fill=\\'%239ca3af\\' font-family=\\'sans-serif\\' font-size=\\'14\\' x=\\'50%25\\' y=\\'50%25\\' text-anchor=\\'middle\\' dominant-baseline=\\'middle\\'%3EImage not found%3C/text%3E%3C/svg%3E';">
                </div>
              </div>
            </div>
          ` : ''}
          <div class="detail-section">
            <h3 class="section-title">
              <i data-lucide="tag" class="w-4 h-4"></i>
              Event Type Details
            </h3>
            ${data.eventtype_name ? renderFieldRow('Name', data.eventtype_name) : ''}
            ${data.eventtype_price ? renderFieldRow('Price', data.eventtype_price, 'currency') : ''}
            ${data.eventtype_duration ? renderFieldRow('Duration', data.eventtype_duration) : ''}
            ${data.eventtype_capacity ? renderFieldRow('Capacity', data.eventtype_capacity) : ''}
            ${data.eventtype_status ? renderFieldRow('Status', data.eventtype_status) : ''}
            ${data.eventtype_description ? renderFieldRow('Description', data.eventtype_description) : ''}
            ${data.eventtype_amenities ? renderFieldRow('Amenities', data.eventtype_amenities) : ''}
            ${data.eventtype_catering_options ? renderFieldRow('Catering Options', data.eventtype_catering_options) : ''}
            ${data.eventtype_theme_options ? renderFieldRow('Theme Options', data.eventtype_theme_options) : ''}
            ${data.eventtype_extra_services ? renderFieldRow('Extra Services', data.eventtype_extra_services) : ''}
            ${(!data.eventtype_name && !data.eventtype_price && !data.eventtype_duration && !data.eventtype_capacity && !data.eventtype_status && !data.eventtype_description && !data.eventtype_amenities && !data.eventtype_catering_options && !data.eventtype_theme_options && !data.eventtype_extra_services) ? '<p class="text-sm text-gray-500">No event type data available.</p>' : ''}
          </div>
        `;

        // Build Facility Tab
        const facilityContent = `
          ${data.facility_photo ? `
            <div class="detail-section">
              <div class="image-grid">
                <div class="image-item" onclick="window.open('${buildImageUrl(data.facility_photo)}', '_blank')">
                  <img src="${buildImageUrl(data.facility_photo)}" alt="Facility Photo" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'200\\' height=\\'200\\'%3E%3Crect fill=\\'%23f3f4f6\\' width=\\'200\\' height=\\'200\\'/%3E%3Ctext fill=\\'%239ca3af\\' font-family=\\'sans-serif\\' font-size=\\'14\\' x=\\'50%25\\' y=\\'50%25\\' text-anchor=\\'middle\\' dominant-baseline=\\'middle\\'%3EImage not found%3C/text%3E%3C/svg%3E';">
                </div>
              </div>
            </div>
          ` : ''}
          <div class="detail-section">
            <h3 class="section-title">
              <i data-lucide="building-2" class="w-4 h-4"></i>
              Facility Details
            </h3>
            ${data.facility_name ? renderFieldRow('Facility Name', data.facility_name) : ''}
            ${data.facility_type ? renderFieldRow('Facility Type', data.facility_type) : ''}
            ${data.facility_capacity ? renderFieldRow('Capacity', data.facility_capacity) : ''}
            ${data.facility_status ? renderFieldRow('Status', data.facility_status) : ''}
            ${data.facility_description ? renderFieldRow('Description', data.facility_description) : ''}
            ${data.facility_amenities ? renderFieldRow('Amenities', data.facility_amenities) : ''}
            ${(!data.facility_name && !data.facility_type && !data.facility_capacity && !data.facility_status && !data.facility_description && !data.facility_amenities) ? '<p class="text-sm text-gray-500">No facility data available.</p>' : ''}
          </div>
        `;

        // Build complete modal HTML with tabs
        const modalHTML = `
          <div class="request-details-modal" role="dialog" aria-labelledby="modal-title" aria-modal="true">
            <!-- Sticky Header -->
            <div class="modal-header">
              <div class="modal-header-content">
                <div class="modal-title-section">
                  <h2 id="modal-title" class="modal-title">Request Details</h2>
                  <div class="modal-subtitle">
                    ${data.eventbookingID ? `<span>Request #${String(data.eventbookingID).padStart(6, '0')}</span>` : ''}
                    ${statusBadge}
                  </div>
                </div>
                <button class="modal-close-btn" onclick="Swal.close()" aria-label="Close modal" title="Close (ESC)">
                  <i data-lucide="x" class="w-5 h-5"></i>
                </button>
              </div>
            </div>

            <!-- Tabs -->
            <div class="modal-tabs" role="tablist">
              <button class="modal-tab active" role="tab" aria-selected="true" aria-controls="tab-overview" data-tab="overview">
                Overview
              </button>
              <button class="modal-tab" role="tab" aria-selected="false" aria-controls="tab-event" data-tab="event">
                Event
              </button>
              <button class="modal-tab" role="tab" aria-selected="false" aria-controls="tab-payment" data-tab="payment">
                Payment
              </button>
              <button class="modal-tab" role="tab" aria-selected="false" aria-controls="tab-eventtype" data-tab="eventtype">
                Event Type
              </button>
              <button class="modal-tab" role="tab" aria-selected="false" aria-controls="tab-facility" data-tab="facility">
                Facility
              </button>
            </div>

            <!-- Tab Content -->
            <div class="modal-body">
              <div id="tab-overview" class="tab-content active" role="tabpanel">
                ${overviewContent}
              </div>
              <div id="tab-event" class="tab-content" role="tabpanel">
                ${eventContent}
              </div>
              <div id="tab-payment" class="tab-content" role="tabpanel">
                ${paymentContent}
              </div>
              <div id="tab-eventtype" class="tab-content" role="tabpanel">
                ${eventTypeContent}
              </div>
              <div id="tab-facility" class="tab-content" role="tabpanel">
                ${facilityContent}
              </div>
            </div>

            <!-- Sticky Footer -->
            <div class="modal-footer">
              <div class="modal-footer-actions">
                <button class="modal-footer-btn modal-footer-btn-close" onclick="Swal.close()" aria-label="Close modal">
                  Close
                </button>
              </div>
            </div>
          </div>
        `;

        // Show modal
        Swal.fire({
          html: modalHTML,
          width: '1000px',
          showConfirmButton: false,
          showCancelButton: false,
          allowOutsideClick: true,
          allowEscapeKey: true,
          customClass: {
            popup: 'p-0',
            htmlContainer: 'p-0'
          },
          didOpen: () => {
            // Re-initialize Lucide icons (with delay to ensure DOM is ready)
            setTimeout(() => {
              if (window.lucide && window.lucide.createIcons) {
                window.lucide.createIcons();
              }
            }, 100);

            // Tab switching functionality
            const tabs = document.querySelectorAll('.modal-tab');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabs.forEach(tab => {
              tab.addEventListener('click', () => {
                const targetTab = tab.getAttribute('data-tab');
                
                // Update tab states
                tabs.forEach(t => {
                  t.classList.remove('active');
                  t.setAttribute('aria-selected', 'false');
                });
                tab.classList.add('active');
                tab.setAttribute('aria-selected', 'true');
                
                // Update content visibility
                tabContents.forEach(content => {
                  content.classList.remove('active');
                });
                const targetContent = document.getElementById(`tab-${targetTab}`);
                if (targetContent) {
                  targetContent.classList.add('active');
                }
                
                // Re-initialize icons for new content
                if (window.lucide && window.lucide.createIcons) {
                  window.lucide.createIcons();
                }
              });
            });

            // ESC key handler
            document.addEventListener('keydown', function escHandler(e) {
              if (e.key === 'Escape') {
                Swal.close();
                document.removeEventListener('keydown', escHandler);
              }
            });

            // Focus trap (basic implementation)
            const modal = document.querySelector('.request-details-modal');
            if (modal) {
              const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
              if (focusableElements.length > 0) {
                focusableElements[0].focus();
              }
            }
          }
        });

      } catch (error) {
        console.error('Error loading request details:', error);
        Swal.fire({
          title: 'Error!',
          text: 'Failed to load request details. Please try again.',
          icon: 'error',
          confirmButtonColor: '#ef4444',
        });
      } finally {
        // Reset button
        if (button && originalHTML) {
          button.innerHTML = originalHTML;
          button.disabled = false;
          if (window.lucide && window.lucide.createIcons) {
            window.lucide.createIcons();
          }
        }
      }
    }
    
    // Edit request
    function editRequest(requestId) {
      Swal.fire({
        title: 'Edit Request',
        text: 'Are you sure you want to edit this request?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Edit',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusConfirm: false
      }).then((result) => {
        if (result.isConfirmed) {
          // Show loading state
          const button = event.target.closest('button');
          const originalContent = button.innerHTML;
          button.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>';
          button.disabled = true;
          
          // For now, just show a notification that edit is coming soon
          setTimeout(() => {
            Swal.fire({
              title: 'Coming Soon!',
              text: 'Edit functionality is currently under development.',
              icon: 'info',
              confirmButtonColor: '#3b82f6',
              customClass: {
                popup: 'rounded-lg'
              }
            });
            // Reset button
            button.innerHTML = originalContent;
            button.disabled = false;
          }, 1000);
        }
      });
    }
    
    // Approve request
    function approveRequest(requestId) {
      Swal.fire({
        title: 'Approve Request',
        text: 'Are you sure you want to approve this request? This action will change the status from "Pending" to "Approved" and cannot be undone.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Approve',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusConfirm: false
      }).then((result) => {
        if (result.isConfirmed) {
          // Show loading state
          const button = event.target.closest('button');
          const originalContent = button.innerHTML;
          button.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>';
          button.disabled = true;
          
          // Send approval request
          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value ||
                           '{{ csrf_token() }}';
          
          fetch(`/facility_reservations/${requestId}/approve-request`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              _token: csrfToken
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              Swal.fire({
                title: 'Success!',
                text: 'Request has been approved successfully! An email notification has been sent to the requester.',
                icon: 'success',
                confirmButtonColor: '#22c55e',
                customClass: {
                  popup: 'rounded-lg'
                }
              }).then(() => {
                // Reload page to update status
                window.location.reload();
              });
            } else {
              Swal.fire({
                title: 'Error!',
                text: data.message || 'Error approving request',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                customClass: {
                  popup: 'rounded-lg'
                }
              });
              // Reset button
              button.innerHTML = originalContent;
              button.disabled = false;
            }
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire({
              title: 'Error!',
              text: 'Error approving request',
              icon: 'error',
              confirmButtonColor: '#ef4444',
              customClass: {
                popup: 'rounded-lg'
              }
            });
            // Reset button
            button.innerHTML = originalContent;
            button.disabled = false;
          });
        }
      });
    }
    
    // Global showNotification is provided by soliera_js.blade.php
    // No need to define fallback - the global function with Soliera theme is already available

    // ============================================
    // API-BASED FACILITY REQUESTS MANAGEMENT
    // ============================================
    
    let apiClient = null;
    let allEvents = [];
    let filteredEvents = [];

    // Initialize API client (no config needed - uses server-side proxy)
    function initApiClient() {
      // Token handled server-side to prevent 401 + avoid exposing secrets
      // All API calls go through Laravel proxy at /internal/soliera/*
      apiClient = new SolieraApiClient();
      console.log('API Client initialized - using server-side proxy (token handled server-side)');
      return true;
    }

    // Show table error state
    function showTableError(message) {
      document.getElementById('tableLoading').classList.add('hidden');
      document.getElementById('tableContainer').classList.add('hidden');
      document.getElementById('tableEmpty').classList.add('hidden');
      document.getElementById('tableError').classList.remove('hidden');
      document.getElementById('errorMessage').textContent = message || 'Failed to load facility requests from the API.';
    }

    // Show table empty state
    function showTableEmpty() {
      document.getElementById('tableLoading').classList.add('hidden');
      document.getElementById('tableContainer').classList.add('hidden');
      document.getElementById('tableError').classList.add('hidden');
      document.getElementById('tableEmpty').classList.remove('hidden');
    }

    // Show table with data
    function showTable() {
      document.getElementById('tableLoading').classList.add('hidden');
      document.getElementById('tableError').classList.add('hidden');
      document.getElementById('tableEmpty').classList.add('hidden');
      document.getElementById('tableContainer').classList.remove('hidden');
    }

    // Show loading state
    function showTableLoading() {
      document.getElementById('tableLoading').classList.remove('hidden');
      document.getElementById('tableContainer').classList.add('hidden');
      document.getElementById('tableError').classList.add('hidden');
      document.getElementById('tableEmpty').classList.add('hidden');
    }

    // Map API event to display format
    function mapEventToDisplay(event) {
      // Extract fields with fallbacks - API field names may vary
      const eventId = event.eventbookingID || event.id || event.booking_id || 'N/A';
      const eventName = event.eventName || event.title || event.name || '—';
      const contactName = event.contactName || event.contact_name || event.requesterName || event.requester_name || '—';
      const contactEmail = event.contactEmail || event.contact_email || event.email || '—';
      const department = event.department || event.departmentName || '—';
      const priority = (event.priority || 'medium').toLowerCase();
      const facility = event.facilityName || event.facility_name || event.roomName || event.room_name || event.equipment || '—';
      // Use eventstatus from API as primary source
      const status = (event.eventstatus || event.status || event.bookingStatus || 'pending').toLowerCase();
      
      // Comprehensive date/time handling - check all possible schedule fields
      const startDate = event.startDate || event.start_date || event.eventDate || event.event_date || 
                       event.requestedDate || event.requested_date || event.bookedate || event.book_date ||
                       event.checkin || event.check_in || event.bookingDate || event.booking_date || null;
      const endDate = event.endDate || event.end_date || event.endTime || event.end_time || 
                     event.requestedEndDate || event.requested_end_date || event.checkout || event.check_out || null;
      const startTime = event.startTime || event.start_time || null;
      const endTime = event.endTime || event.end_time || null;
      
      // Also check nested objects for schedule data
      const scheduleDate = startDate || (event.booking && event.booking.date) || 
                          (event.schedule && event.schedule.date) || null;
      const scheduleStart = startTime || (event.booking && event.booking.startTime) || 
                           (event.schedule && event.schedule.startTime) || null;
      const scheduleEnd = endTime || (event.booking && event.booking.endTime) || 
                         (event.schedule && event.schedule.endTime) || null;

      return {
        eventbookingID: eventId,
        eventName,
        contactName,
        contactEmail,
        department,
        priority,
        facility,
        status,
        startDate: scheduleDate || startDate,
        endDate,
        startTime: scheduleStart || startTime,
        endTime: scheduleEnd || endTime,
        raw: event // Keep raw data for reference
      };
    }

    // Format date for display
    function formatDate(dateStr) {
      if (!dateStr) return 'N/A';
      try {
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
      } catch (e) {
        return dateStr;
      }
    }

    // Calculate duration between two dates
    function calculateDuration(checkin, checkout) {
      if (!checkin || !checkout) return '';
      try {
        const start = new Date(checkin);
        const end = new Date(checkout);
        if (isNaN(start.getTime()) || isNaN(end.getTime())) return '';
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        if (diffDays === 1) return '1 day';
        return `${diffDays} days`;
      } catch (e) {
        return '';
      }
    }

    // Format time for display
    function formatTime(timeStr) {
      if (!timeStr) return '';
      try {
        // Handle both "HH:MM" and full datetime strings
        if (timeStr.includes('T')) {
          const date = new Date(timeStr);
          return date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
        }
        // If it's just time, try to parse it
        const [hours, minutes] = timeStr.split(':');
        const hour = parseInt(hours);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const displayHour = hour % 12 || 12;
        return `${displayHour}:${minutes || '00'} ${ampm}`;
      } catch (e) {
        return timeStr;
      }
    }

    // Get status styles
    function getStatusStyles(status) {
      const statusLower = (status || 'pending').toLowerCase();
      const styles = {
        'pending': 'bg-amber-100 text-amber-700 border-amber-200',
        'approved': 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'declined': 'bg-red-100 text-red-700 border-red-200',
        'rejected': 'bg-red-100 text-red-700 border-red-200',
        'in_progress': 'bg-blue-100 text-blue-700 border-blue-200',
        'completed': 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'done': 'bg-emerald-100 text-emerald-700 border-emerald-200',
      };
      return styles[statusLower] || 'bg-gray-100 text-gray-700 border-gray-200';
    }

    // Get status icon
    function getStatusIcon(status) {
      const statusLower = (status || 'pending').toLowerCase();
      const icons = {
        'pending': 'clock',
        'approved': 'check-circle',
        'declined': 'x-circle',
        'rejected': 'x-circle',
        'in_progress': 'loader',
        'completed': 'check-circle-2',
        'done': 'check-circle-2',
      };
      return icons[statusLower] || 'circle';
    }

    // Get priority styles
    function getPriorityStyles(priority) {
      const priorityLower = (priority || 'medium').toLowerCase();
      const styles = {
        'low': 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'medium': 'bg-amber-100 text-amber-700 border-amber-200',
        'high': 'bg-orange-100 text-orange-700 border-orange-200',
        'urgent': 'bg-red-100 text-red-700 border-red-200',
      };
      return styles[priorityLower] || 'bg-gray-100 text-gray-700 border-gray-200';
    }

    // Get priority icon
    function getPriorityIcon(priority) {
      const priorityLower = (priority || 'medium').toLowerCase();
      const icons = {
        'low': 'arrow-down',
        'medium': 'minus',
        'high': 'arrow-up',
        'urgent': 'alert-triangle',
      };
      return icons[priorityLower] || 'minus';
    }

    // Get status icon background color
    function getStatusIconBg(status) {
      const statusLower = (status || 'pending').toLowerCase();
      const styles = {
        'pending': 'bg-amber-100',
        'approved': 'bg-emerald-100',
        'declined': 'bg-red-100',
        'rejected': 'bg-red-100',
        'in_progress': 'bg-blue-100',
        'completed': 'bg-emerald-100',
        'done': 'bg-emerald-100',
      };
      return styles[statusLower] || 'bg-gray-100';
    }

    // Get status icon color
    function getStatusIconColor(status) {
      const statusLower = (status || 'pending').toLowerCase();
      const styles = {
        'pending': 'text-amber-600',
        'approved': 'text-emerald-600',
        'declined': 'text-red-600',
        'rejected': 'text-red-600',
        'in_progress': 'text-blue-600',
        'completed': 'text-emerald-600',
        'done': 'text-emerald-600',
      };
      return styles[statusLower] || 'text-gray-600';
    }

    // Get status text color
    function getStatusTextColor(status) {
      const statusLower = (status || 'pending').toLowerCase();
      const styles = {
        'pending': 'text-amber-700',
        'approved': 'text-emerald-700',
        'declined': 'text-red-700',
        'rejected': 'text-red-700',
        'in_progress': 'text-blue-700',
        'completed': 'text-emerald-700',
        'done': 'text-emerald-700',
      };
      return styles[statusLower] || 'text-gray-700';
    }

    // Render table rows
    function renderTable(events) {
      const tbody = document.getElementById('tableBody');
      if (!tbody) return;

      if (events.length === 0) {
        showTableEmpty();
        return;
      }

      tbody.innerHTML = events.map(event => {
        const display = mapEventToDisplay(event);
        
        // Get raw event data once for use throughout this row
        const rawEvent = display.raw || event;
        
        // Get status from raw event data (eventstatus) for real-time updates
        const eventStatus = rawEvent.eventstatus || display.status || 'pending';
        const normalizedStatus = String(eventStatus).toLowerCase();
        const statusStyles = getStatusStyles(normalizedStatus);
        const statusIcon = getStatusIcon(normalizedStatus);
        const priorityStyles = getPriorityStyles(display.priority);
        const priorityIcon = getPriorityIcon(display.priority);

        // Extract schedule data using exact API field names
        const bookedate = rawEvent.event_bookedate || null;
        const checkin = rawEvent.event_checkin || null;
        const checkout = rawEvent.event_checkout || null;
        
        // Format dates for display (using formatDate for table consistency)
        const formattedBookDate = bookedate ? formatDate(bookedate) : null;
        const formattedCheckin = checkin ? formatDate(checkin) : null;
        const formattedCheckout = checkout ? formatDate(checkout) : null;

        // Get source indicator
        const source = rawEvent._source || 'hotel';
        const sourceLabel = rawEvent._source_label || 'Hotel';
        const sourceStyles = source === 'restaurant' 
          ? 'bg-orange-50 text-orange-700 border-orange-200' 
          : 'bg-purple-50 text-purple-700 border-purple-200';
        const sourceIcon = source === 'restaurant' ? 'utensils' : 'building';

        return `
          <tr data-event-id="${display.eventbookingID}" data-source="${source}" class="hover:bg-gray-50/50 transition-colors">
            <td class="py-3 px-4">
              <div class="flex flex-col gap-1">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 font-mono text-xs font-medium">
                  #${String(display.eventbookingID).padStart(6, '0')}
                </span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium border ${sourceStyles}">
                  <i data-lucide="${sourceIcon}" class="w-2.5 h-2.5"></i>
                  ${sourceLabel}
                </span>
              </div>
            </td>
            <td class="py-3 px-4">
              <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                  <i data-lucide="calendar" class="w-3.5 h-3.5 text-blue-600"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Reservation</span>
              </div>
            </td>
            <td class="py-3 px-4">
              <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center">
                  <i data-lucide="building-2" class="w-3.5 h-3.5 text-purple-600"></i>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-800">${display.facility}</p>
                </div>
              </div>
            </td>
            <td class="py-3 px-4">
              ${(formattedCheckin || formattedCheckout || formattedBookDate) ? `
              <div class="text-sm space-y-1">
                ${formattedBookDate ? `
                <div class="flex items-center gap-2">
                  <div class="w-6 h-6 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="calendar" class="w-3 h-3 text-gray-500"></i>
                  </div>
                  <span class="text-gray-700">Booked: ${formattedBookDate}</span>
                </div>
                ` : ''}
                ${formattedCheckin ? `
                <div class="flex items-center gap-2">
                  <div class="w-6 h-6 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="log-in" class="w-3 h-3 text-blue-500"></i>
                  </div>
                  <span class="text-gray-600">Check-in: ${formattedCheckin}</span>
                </div>
                ` : ''}
                ${formattedCheckout ? `
                <div class="flex items-center gap-2">
                  <div class="w-6 h-6 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="log-out" class="w-3 h-3 text-orange-500"></i>
                  </div>
                  <span class="text-gray-600">Check-out: ${formattedCheckout}</span>
                </div>
                ` : ''}
                ${checkin && checkout ? `
                <div class="text-xs text-gray-500 mt-2 pt-2 border-t border-gray-200 ml-8">
                  Duration: ${calculateDuration(checkin, checkout)}
                </div>
                ` : ''}
              </div>
              ` : `
              <div class="flex items-center gap-2 text-gray-400">
                <div class="w-6 h-6 rounded-lg bg-gray-100 flex items-center justify-center">
                  <i data-lucide="calendar-x" class="w-3 h-3 text-gray-400"></i>
                </div>
                <span class="text-sm italic">Schedule not available</span>
              </div>
              `}
            </td>
            <td class="py-3 px-4">
              <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg ${getStatusIconBg(normalizedStatus)} flex items-center justify-center">
                  <i data-lucide="${statusIcon}" class="w-3.5 h-3.5 ${getStatusIconColor(normalizedStatus)}"></i>
                </div>
                <span class="text-sm font-medium ${getStatusTextColor(normalizedStatus)}">${normalizedStatus.charAt(0).toUpperCase() + normalizedStatus.slice(1)}</span>
              </div>
            </td>
            <td class="py-3 px-4">
              <div class="flex items-center justify-center gap-2" data-action-buttons>
                <button onclick="viewRequestDetailsFromApi('${display.eventbookingID}', this)" 
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed group"
                        title="View Details">
                  <i data-lucide="eye" class="w-4 h-4"></i>
                </button>
                ${(normalizedStatus !== 'approved' && normalizedStatus !== 'declined' && normalizedStatus !== 'rejected' && normalizedStatus !== 'completed' && normalizedStatus !== 'done') ? `
                <button onclick="updateEventStatus('${display.eventbookingID}', 'APPROVED', this)" 
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed group"
                        title="Approve">
                  <i data-lucide="check" class="w-4 h-4"></i>
                </button>
                <button onclick="updateEventStatus('${display.eventbookingID}', 'DECLINED', this)" 
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed group"
                        title="Decline">
                  <i data-lucide="x" class="w-4 h-4"></i>
                </button>
                ` : ''}
              </div>
            </td>
          </tr>
        `;
      }).join('');

      // Re-initialize Lucide icons for new content
      if (window.lucide && window.lucide.createIcons) {
        window.lucide.createIcons();
      }

      showTable();
    }

      // Update summary cards
      function updateSummaryCards(events) {
        const total = events.length;
        const pending = events.filter(e => {
          const status = (e.eventstatus || e.status || e.bookingStatus || 'pending').toLowerCase();
          return status === 'pending' || !status || status === '';
        }).length;
        const approved = events.filter(e => {
          const status = (e.eventstatus || e.status || e.bookingStatus || '').toLowerCase();
          return status === 'approved';
        }).length;
      const reservations = total; // All events are reservations

      document.getElementById('statTotalRequests').textContent = total;
      document.getElementById('statPendingReview').textContent = pending;
      document.getElementById('statApproved').textContent = approved;
      document.getElementById('statReservations').textContent = reservations;
    }

    // Load facility requests from API (combined Hotel + Restaurant)
    async function loadFacilityRequests() {
      if (!apiClient) {
        if (!initApiClient()) {
          return;
        }
      }

      showTableLoading();

      try {
        // Use combined endpoint to fetch from both Hotel and Restaurant APIs
        const response = await fetch('/internal/soliera/combined/facility-requests');
        const result = await response.json();
        
        if (!response.ok) {
          throw new Error(result.message || 'Failed to fetch facility requests');
        }
        
        const events = result.data || [];
        allEvents = events;
        filteredEvents = events;
        
        // Log source information
        if (result.sources) {
          console.log('Facility requests loaded:', {
            hotel: result.sources.hotel?.count || 0,
            restaurant: result.sources.restaurant?.count || 0,
            total: events.length
          });
        }
        
        updateSummaryCards(events);
        renderTable(events);
        updateRequestCount(events.length);
      } catch (error) {
        console.error('Error loading facility requests:', error);
        showTableError(error.message || 'Failed to load facility requests. Please check your API configuration.');
      }
    }

    // Update request count
    function updateRequestCount(count) {
      const countEl = document.getElementById('nrTotalCount');
      if (countEl) {
        countEl.textContent = count;
      }
    }

    // Helper: Update modal status in real-time if modal is open for this event
    function updateModalIfOpen(eventbookingID, newStatus) {
      // Check if SweetAlert modal is open
      const swalModal = document.querySelector('.swal2-popup');
      if (!swalModal) return;
      
      // Check if this modal is for the same event
      const modalTitle = swalModal.querySelector('#modal-title');
      if (!modalTitle) return;
      
      // Find the status badge in the modal header
      const statusBadge = swalModal.querySelector('.status-badge');
      if (statusBadge) {
        const statusLower = String(newStatus).toLowerCase();
        const statusBadgeClass = statusLower === 'approved' ? 'approved' : 
                                 (statusLower === 'rejected' || statusLower === 'declined') ? 'rejected' : 'pending';
        
        // Update badge class
        statusBadge.className = `status-badge ${statusBadgeClass}`;
        
        // Update badge icon
        const icon = statusBadge.querySelector('i[data-lucide]');
        if (icon) {
          icon.setAttribute('data-lucide', getStatusIcon(statusLower));
        }
        
        // Update badge text
        const textNode = Array.from(statusBadge.childNodes).find(node => 
          node.nodeType === 3 && node.textContent.trim()
        );
        if (textNode) {
          textNode.textContent = String(newStatus).charAt(0).toUpperCase() + String(newStatus).slice(1);
        } else {
          // If no text node, update the badge content
          statusBadge.innerHTML = `
            <i data-lucide="${getStatusIcon(statusLower)}" class="w-3 h-3"></i>
            ${String(newStatus).charAt(0).toUpperCase() + String(newStatus).slice(1)}
          `;
        }
        
        // Re-initialize Lucide icons
        if (window.lucide && window.lucide.createIcons) {
          window.lucide.createIcons();
        }
      }
      
      // Update status in the Overview summary card
      const overviewSummary = swalModal.querySelector('.overview-summary');
      if (overviewSummary) {
        const summaryItems = overviewSummary.querySelectorAll('.summary-item');
        summaryItems.forEach(item => {
          const label = item.querySelector('.summary-label');
          if (label && label.textContent.trim() === 'Status') {
            const value = item.querySelector('.summary-value');
            if (value) {
              const statusLower = String(newStatus).toLowerCase();
              const statusBadgeClass = statusLower === 'approved' ? 'approved' : 
                                       (statusLower === 'rejected' || statusLower === 'declined') ? 'rejected' : 'pending';
              value.innerHTML = `
                <span class="status-badge ${statusBadgeClass}">
                  <i data-lucide="${getStatusIcon(statusLower)}" class="w-3 h-3"></i>
                  ${String(newStatus).charAt(0).toUpperCase() + String(newStatus).slice(1)}
                </span>
              `;
              // Re-initialize Lucide icons
              if (window.lucide && window.lucide.createIcons) {
                window.lucide.createIcons();
              }
            }
          }
        });
      }
      
      // Also update status in the Request Information section
      const overviewSection = swalModal.querySelector('#tab-overview');
      if (overviewSection) {
        const statusRows = overviewSection.querySelectorAll('.detail-row');
        statusRows.forEach(row => {
          const label = row.querySelector('.label-text');
          if (label && label.textContent.trim() === 'Status') {
            const value = row.querySelector('.detail-value');
            if (value) {
              value.textContent = String(newStatus).charAt(0).toUpperCase() + String(newStatus).slice(1);
            }
          }
        });
      }
    }

    // Update event status
    async function updateEventStatus(eventbookingID, status, clickedElement = null) {
      if (!apiClient) {
        if (!initApiClient()) {
          Swal.fire({
            title: 'Error!',
            text: 'API client is not initialized. Please refresh the page.',
            icon: 'error',
            confirmButtonColor: '#ef4444',
          });
          return;
        }
      }

      // Find the row and disable buttons
      const row = document.querySelector(`tr[data-event-id="${eventbookingID}"]`);
      const actionButtons = row?.querySelector('[data-action-buttons]');
      
      if (actionButtons) {
        const buttons = actionButtons.querySelectorAll('button');
        buttons.forEach(btn => {
          btn.disabled = true;
          btn.classList.add('opacity-50', 'cursor-not-allowed');
        });
      }

      // Show confirmation
      const statusLabels = {
        'APPROVED': 'Approve',
        'DECLINED': 'Decline'
      };

      const result = await Swal.fire({
        title: `${statusLabels[status]} Request`,
        text: `Are you sure you want to ${statusLabels[status].toLowerCase()} this request?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Yes, ${statusLabels[status]}`,
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusConfirm: false
      });

      if (!result.isConfirmed) {
        // Re-enable buttons if cancelled
        if (actionButtons) {
          const buttons = actionButtons.querySelectorAll('button');
          buttons.forEach(btn => {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
          });
        }
        return;
      }

      // Show loading spinner in the button
      const clickedButton = clickedElement || (window.event?.target?.closest('button'));
      const originalHTML = clickedButton?.innerHTML || '';
      if (clickedButton) {
        clickedButton.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>';
        clickedButton.disabled = true;
        if (window.lucide && window.lucide.createIcons) {
          window.lucide.createIcons();
        }
      }

      // Find event index and store original status for rollback
      const eventIndex = allEvents.findIndex(e => 
        String(e.eventbookingID || e.id || e.booking_id) === String(eventbookingID)
      );
      
      if (eventIndex === -1) {
        // Re-enable buttons
        if (actionButtons) {
          const buttons = actionButtons.querySelectorAll('button');
          buttons.forEach(btn => {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            if (btn === clickedButton && originalHTML) {
              btn.innerHTML = originalHTML;
              if (window.lucide && window.lucide.createIcons) {
                window.lucide.createIcons();
              }
            }
          });
        }
        Swal.fire({
          title: 'Error!',
          text: 'Request not found in local data.',
          icon: 'error',
          confirmButtonColor: '#ef4444',
        });
        return;
      }
      
      // Store original status for rollback if needed
      const originalStatus = allEvents[eventIndex].status;
      const originalBookingStatus = allEvents[eventIndex].bookingStatus;
      const originalEventStatus = allEvents[eventIndex].eventstatus || (allEvents[eventIndex].raw && allEvents[eventIndex].raw.eventstatus);

      try {
        // Optimistic update: Update UI immediately before API call
        
        // Optimistically update status immediately
        const optimisticStatus = status === 'APPROVED' ? 'Approved' : (status === 'DECLINED' ? 'Declined' : status);
        const optimisticStatusLower = optimisticStatus.toLowerCase();
        
        // Update all status fields for compatibility
        allEvents[eventIndex].status = optimisticStatusLower;
        allEvents[eventIndex].bookingStatus = optimisticStatusLower;
        allEvents[eventIndex].eventstatus = optimisticStatus;
        
        // Also update raw data if it exists (this is what the table and modal read from)
        if (allEvents[eventIndex].raw) {
          allEvents[eventIndex].raw.status = optimisticStatusLower;
          allEvents[eventIndex].raw.bookingStatus = optimisticStatusLower;
          allEvents[eventIndex].raw.eventstatus = optimisticStatus;
        }
        
        // Update filtered events and re-render immediately (real-time update)
        filteredEvents = [...allEvents];
        renderTable(filteredEvents);
        updateSummaryCards(allEvents);
        
        // Update modal if it's open for this event
        updateModalIfOpen(eventbookingID, optimisticStatus);
        
        // Determine which API to call based on source
        const eventSource = allEvents[eventIndex]._source || allEvents[eventIndex].raw?._source || 'hotel';
        let response;
        
        if (eventSource === 'restaurant') {
          // Call Restaurant API
          const res = await fetch(`/internal/soliera/restaurant/facility-requests/${eventbookingID}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ status: status })
          });
          response = await res.json();
        } else {
          // Call Hotel API (default)
          response = await apiClient.updateEventStatus(eventbookingID, status);
        }
        
        // Determine the final status from API response
        let finalStatus = optimisticStatus;
        let finalStatusLower = optimisticStatusLower;
        
        if (response) {
          // Check various possible response formats, prioritizing eventstatus
          const responseStatus = response.data?.eventstatus || 
                                response.eventstatus ||
                                response.data?.status || 
                                response.status || 
                                response.bookingStatus ||
                                response.data?.bookingStatus;
          
          if (responseStatus) {
            finalStatus = String(responseStatus);
            finalStatusLower = finalStatus.toLowerCase();
          }
        }
        
        // Update with confirmed status from API
        allEvents[eventIndex].status = finalStatusLower;
        allEvents[eventIndex].bookingStatus = finalStatusLower;
        allEvents[eventIndex].eventstatus = finalStatus;
        
        if (allEvents[eventIndex].raw) {
          allEvents[eventIndex].raw.status = finalStatusLower;
          allEvents[eventIndex].raw.bookingStatus = finalStatusLower;
          allEvents[eventIndex].raw.eventstatus = finalStatus;
        }
        
        // Re-render with confirmed status
        filteredEvents = [...allEvents];
        renderTable(filteredEvents);
        updateSummaryCards(allEvents);
        
        // Update modal again with confirmed status
        updateModalIfOpen(eventbookingID, finalStatus);
        
        // Reload data from API to ensure we have the latest status (for persistence verification)
        // This ensures the UI matches the backend state after refresh
        setTimeout(async () => {
          try {
            await loadFacilityRequests();
          } catch (error) {
            console.warn('Failed to reload data after status update:', error);
            // Non-critical - we already updated the UI optimistically
          }
        }, 500);
        
        // Show success toast
        Swal.fire({
          title: 'Success!',
          text: `Request has been ${statusLabels[status].toLowerCase()}d successfully!`,
          icon: 'success',
          confirmButtonColor: '#22c55e',
          timer: 2000,
          showConfirmButton: false,
          customClass: {
            popup: 'rounded-lg'
          }
        });
      } catch (error) {
        // Rollback on error
        const eventIndex = allEvents.findIndex(e => 
          String(e.eventbookingID || e.id || e.booking_id) === String(eventbookingID)
        );
        
        if (eventIndex !== -1) {
          allEvents[eventIndex].status = originalStatus;
          allEvents[eventIndex].bookingStatus = originalBookingStatus;
          allEvents[eventIndex].eventstatus = originalEventStatus;
          
          if (allEvents[eventIndex].raw) {
            allEvents[eventIndex].raw.status = originalStatus;
            allEvents[eventIndex].raw.bookingStatus = originalBookingStatus;
            allEvents[eventIndex].raw.eventstatus = originalEventStatus;
          }
          
          filteredEvents = [...allEvents];
          renderTable(filteredEvents);
          updateSummaryCards(allEvents);
          
          // Update modal if it's open
          updateModalIfOpen(eventbookingID, originalEventStatus || originalStatus);
        }
        console.error('Error updating event status:', error);
        
        // Re-enable buttons on error
        if (actionButtons) {
          const buttons = actionButtons.querySelectorAll('button');
          buttons.forEach(btn => {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            if (btn === clickedButton && originalHTML) {
              btn.innerHTML = originalHTML;
              if (window.lucide && window.lucide.createIcons) {
                window.lucide.createIcons();
              }
            }
          });
        }

        Swal.fire({
          title: 'Error!',
          text: error.message || `Failed to ${statusLabels[status].toLowerCase()} request. Please try again.`,
          icon: 'error',
          confirmButtonColor: '#ef4444',
          customClass: {
            popup: 'rounded-lg'
          }
        });
      }
    }

    // Enhanced search functionality
    function filterTableBySearch() {
      const searchTerm = (document.getElementById('searchRequests')?.value || '').toLowerCase();
      
      if (!searchTerm) {
        filteredEvents = [...allEvents];
      } else {
        filteredEvents = allEvents.filter(event => {
          const display = mapEventToDisplay(event);
          const searchableText = [
            display.eventbookingID,
            display.eventName,
            display.contactName,
            display.contactEmail,
            display.department,
            display.facility,
            display.status
          ].join(' ').toLowerCase();
          
          return searchableText.includes(searchTerm);
        });
      }
      
      renderTable(filteredEvents);
      updateRequestCount(filteredEvents.length);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize API client
      if (initApiClient()) {
        // Load facility requests
        loadFacilityRequests();
      }

      // Search functionality
      const searchInput = document.getElementById('searchRequests');
      if (searchInput) {
        searchInput.addEventListener('input', filterTableBySearch);
      }

      // Initialize Lucide icons
      if (window.lucide && window.lucide.createIcons) {
        window.lucide.createIcons();
      }
    });
  </script>
</body>
</html>
