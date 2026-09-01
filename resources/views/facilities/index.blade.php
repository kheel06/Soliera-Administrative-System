<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Hotel Facilities</title>
  @include('partials.favicon')
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  @vite(['resources/css/app.css', 'resources/css/soliera.css', 'resources/js/app.js'])
  <style>
    /* Enhanced Button Styling */
    .btn {
      border-radius: 0.5rem;
      font-weight: 500;
      letter-spacing: 0.025em;
    }

    .btn-sm {
      padding: 0.5rem 0.75rem;
      font-size: 0.875rem;
      min-height: 2rem;
    }

    .btn-md {
      padding: 0.625rem 1rem;
      font-size: 0.875rem;
      min-height: 2.5rem;
    }

    /* Consistent hover effects */
    .btn:hover {
      transform: translateY(-1px);
    }

    .btn:active {
      transform: translateY(0);
    }

    /* Enhanced shadow effects */
    .btn-primary {
      background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%);
      border: none;
      box-shadow: 0 2px 4px rgba(247, 169, 35, 0.3);
      color: #2C3E50;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #E6940F 0%, #D2840E 100%);
      box-shadow: 0 4px 8px rgba(247, 169, 35, 0.4);
      transform: translateY(-2px);
    }

    .btn-warning {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      border: none;
      box-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);
    }

    .btn-warning:hover {
      background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
      box-shadow: 0 4px 8px rgba(245, 158, 11, 0.4);
    }

    .btn-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      border: none;
      box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
    }

    .btn-error {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      border: none;
      box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
    }

    .btn-error:hover {
      background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
      box-shadow: 0 4px 8px rgba(239, 68, 68, 0.4);
    }

    .btn-outline {
      border: 2px solid #F7B32B;
      background: transparent;
      color: #F7B32B;
    }

    .btn-outline:hover {
      background: #F7B32B;
      border-color: #F7B32B;
      color: #2C3E50;
    }

    /* Focus states for accessibility */
    .btn:focus {
      outline: 2px solid #3b82f6;
      outline-offset: 2px;
    }

    /* Smooth transitions for all interactive elements */
    .btn,
    .btn * {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== ROOM CARD STYLES ===== */
    .room-card {
      display: flex;
      flex-direction: column;
      height: 100%;
      background: #ffffff;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .room-card:hover {
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      transform: translateY(-4px);
    }

    .room-card-image {
      position: relative;
      width: 100%;
      height: 200px;
      overflow: hidden;
      background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    }

    .room-card-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .room-card-body {
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* Legacy facility card styles (kept for compatibility) */
    .facility-card {
      display: flex;
      flex-direction: column;
      height: 100%;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 0.75rem;
      overflow: hidden;
    }

    .facility-card-image {
      position: relative;
      width: 100%;
      height: 10rem;
      overflow: hidden;
    }

    .facility-card-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .facility-status-badge {
      position: absolute;
      top: 0.75rem;
      right: 0.75rem;
    }

    .facility-card-body {
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .facility-card-title {
      font-weight: 700;
      color: #1f2937;
      font-size: 1.25rem;
      line-height: 1.5rem;
    }

    .meta-row {
      display: flex;
      flex-wrap: wrap;
      gap: 1.25rem;
      align-items: center;
    }

    .meta-item {
      display: flex;
      align-items: center;
      color: #6b7280;
      font-size: 0.875rem;
    }

    .meta-item i {
      margin-right: 0.5rem;
    }

    .muted {
      color: #6b7280;
      font-size: 0.875rem;
    }

    /* Facility Action Buttons */
    .facility-action-btn {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0.0625rem;
      padding: 0.25rem 0.1875rem;
      border-radius: 0.25rem;
      font-size: 0.5rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.025em;
      border: none;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      min-height: 1.75rem;
      position: relative;
      overflow: hidden;
    }

    .facility-action-btn i {
      transition: transform 0.3s ease;
    }

    .facility-action-btn span {
      font-size: 0.4375rem;
      line-height: 1;
    }

    /* View Button - Orange-Yellow (matches Landing Page) */
    .facility-btn-view {
      background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%);
      color: #1f2937;
      box-shadow: 0 2px 8px rgba(247, 169, 35, 0.25);
    }

    .facility-btn-view:hover {
      background: linear-gradient(135deg, #E6940F 0%, #D2840E 100%);
      box-shadow: 0 4px 12px rgba(247, 169, 35, 0.35);
      transform: translateY(-2px);
    }

    .facility-btn-view:hover i {
      transform: scale(1.1);
    }

    /* Edit Button - Orange-Yellow (matches Landing Page) */
    .facility-btn-edit {
      background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%);
      color: #1f2937;
      box-shadow: 0 2px 8px rgba(247, 169, 35, 0.25);
    }

    .facility-btn-edit:hover {
      background: linear-gradient(135deg, #E6940F 0%, #D2840E 100%);
      box-shadow: 0 4px 12px rgba(247, 169, 35, 0.35);
      transform: translateY(-2px);
    }

    .facility-btn-edit:hover i {
      transform: scale(1.1);
    }


    .facility-btn-free {
      background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%);
      color: #1f2937;
      border: 1px solid #E6940F;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(247, 169, 35, 0.25);
    }

    .facility-btn-free:hover {
      background: linear-gradient(135deg, #E6940F 0%, #D2840E 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(247, 169, 35, 0.35);
    }

    .facility-btn-free:hover i {
      transform: scale(1.1);
    }

    /* Custom scrollbar for Recent Requests */
    #mon-recent::-webkit-scrollbar {
      width: 6px;
    }

    #mon-recent::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 3px;
    }

    #mon-recent::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 3px;
      transition: background 0.2s ease;
    }

    #mon-recent::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    /* Firefox scrollbar */
    #mon-recent {
      scrollbar-width: thin;
      scrollbar-color: #cbd5e1 #f1f5f9;
    }

    /* Delete Button - Orange-Yellow (matches Landing Page) */
    .facility-btn-delete {
      background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%);
      color: #1f2937;
      box-shadow: 0 2px 8px rgba(247, 169, 35, 0.25);
    }

    .facility-btn-delete:hover {
      background: linear-gradient(135deg, #E6940F 0%, #D2840E 100%);
      box-shadow: 0 4px 12px rgba(247, 169, 35, 0.35);
      transform: translateY(-2px);
    }

    .facility-btn-delete:hover i {
      transform: scale(1.1);
    }

    /* Active state for all buttons */
    .facility-action-btn:active {
      transform: translateY(0);
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }

    /* Focus state for accessibility */
    .facility-action-btn:focus {
      outline: 2px solid #3b82f6;
      outline-offset: 2px;
    }

    /* List view styles */
    .facility-card.list-view {
      flex-direction: row;
      height: auto;
      min-height: 200px;
    }

    .facility-card.list-view .facility-card-image {
      width: 300px;
      height: 200px;
      flex-shrink: 0;
    }

    .facility-card.list-view .facility-card-body {
      flex: 1;
      padding: 1.5rem;
    }

    .facility-card.list-view .facility-card-title {
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
    }

    .facility-card.list-view .meta-row {
      margin-bottom: 1rem;
    }

    .facility-card.list-view .facility-action-btn {
      min-height: 2.5rem;
      padding: 0.5rem 1rem;
      font-size: 0.75rem;
    }

    .facility-card.list-view .facility-action-btn span {
      font-size: 0.75rem;
    }

    /* ===== MONITORING FACILITY CARDS STYLES ===== */
    .monitoring-facility-card {
      transition: all 0.3s ease;
      border: 2px solid #e5e7eb;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    }

    .monitoring-facility-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      border-color: #3b82f6;
    }

    .monitoring-facility-card .badge {
      font-size: 0.75rem;
      font-weight: 600;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
    }

    .monitoring-facility-card .btn {
      transition: all 0.2s ease-in-out;
    }

    .monitoring-facility-card .btn:hover:not(:disabled) {
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
    }

    .monitoring-facility-card .btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .facility-action-btn {
        min-height: 1.5rem;
        padding: 0.1875rem 0.125rem;
        font-size: 0.4375rem;
      }

      .facility-action-btn span {
        font-size: 0.375rem;
      }

      .facility-card.list-view {
        flex-direction: column;
        min-height: auto;
      }

      .facility-card.list-view .facility-card-image {
        width: 100%;
        height: 150px;
      }
    }

    /* Image overlay edit controls */
    .img-edit-wrap {
      position: relative;
    }

    .img-edit-overlay {
      position: absolute;
      inset: 0;
      display: none;
      align-items: center;
      justify-content: center;
      gap: .75rem;
      background: rgba(0, 0, 0, .35);
    }

    .img-edit-wrap:hover .img-edit-overlay {
      display: flex;
    }

    .img-edit-btn {
      background: #fff;
      color: #111827;
      border-radius: .5rem;
      padding: .35rem .6rem;
      font-size: .875rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
      display: inline-flex;
      align-items: center;
      gap: .35rem;
    }

    .img-edit-btn:hover {
      background: #f3f4f6;
    }

    /* View toggle button styles */
    #viewToggleBtn {
      transition: all 0.2s ease;
      flex-shrink: 0;
      /* Prevent button from shrinking */
      min-width: 2.5rem;
      /* Ensure minimum touch target */
      min-height: 2.5rem;
      display: inline-flex !important;
      /* Force visibility */
      visibility: visible !important;
      /* Override any hidden states */
      opacity: 1 !important;
      /* Ensure full opacity */
    }

    #viewToggleBtn:hover {
      transform: scale(1.05);
    }

    #viewToggleBtn:focus {
      outline: 2px solid #3b82f6;
      outline-offset: 2px;
    }

    /* Ensure button is always visible at all breakpoints */
    @media (max-width: 640px) {
      #viewToggleBtn {
        min-width: 2rem;
        min-height: 2rem;
        padding: 0.25rem;
      }
    }

    /* Ensure the toolbar container doesn't hide the button */
    .flex.items-center.space-x-2 {
      flex-wrap: nowrap;
      overflow: visible;
    }

    /* Smooth transitions for layout changes */
    .facility-card {
      transition: none;
    }

    /* Respect reduced motion preferences */
    @media (prefers-reduced-motion: reduce) {

      .facility-card,
      #viewToggleBtn {
        transition: none;
      }

      #viewToggleBtn:hover {
        transform: none;
      }
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
            <i data-lucide="check-circle"
              class="text-xl md:text-2xl lg:text-3xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif

        <!-- Page Header -->
        <div class="mb-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-xl bg-[#001F54] flex items-center justify-center">
                <i data-lucide="building-2" class="w-6 h-6 text-[#F7B32B]"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-800">Hotel Facilities</h1>
                <p class="text-gray-500 text-sm">Manage and monitor hotel facilities</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <!-- Total Facilities -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Facilities</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $facilities->count() }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="building-2" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Available Facilities -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Available</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">
                  {{ $facilities->where('status', 'available')->count() }}
                </p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Occupied Facilities -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Occupied</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $facilities->where('status', 'occupied')->count() }}
                </p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="x-circle" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Reserved Facilities -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Reserved</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $facilities->where('status', 'reserved')->count() }}
                </p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="calendar" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>
        </div>


        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2 mb-6 justify-between">
          <div class="flex flex-wrap gap-2 justify-end w-full">
            <button type="button" onclick="location.reload()"
              class="btn btn-sm bg-gradient-to-r from-[#F7B32B] to-[#f59e0b] text-gray-800 border-none hover:shadow-md transition-all gap-2">
              <i data-lucide="refresh-cw" class="w-4 h-4"></i>
              Refresh Data
            </button>
          </div>
        </div>

        <!-- Calendar View (Hidden by default) -->
        <div id="calendarView" class="bg-white rounded-xl shadow-lg p-6 mb-8 hidden">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
              <i data-lucide="calendar-days" class="w-6 h-6 text-blue-500 mr-3"></i>
              Facility Availability Calendar
            </h2>
            <div class="flex items-center gap-3">
              <select id="calendarFacilityFilter" class="select select-bordered select-sm">
                <option value="">All Facilities</option>
                @foreach($facilities as $facility)
                  <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                @endforeach
              </select>
              <button onclick="toggleCalendarView()" class="btn btn-ghost btn-sm">
                <i data-lucide="grid-3x3"
                  class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i>
              </button>
            </div>
          </div>

          <!-- Calendar Container -->
          <div id="facilityCalendar" class="w-full">
            <!-- Calendar will be rendered here -->
            <div class="text-center py-12">
              <div class="loading loading-spinner loading-lg"></div>
              <p class="mt-4 text-gray-600">Loading calendar...</p>
            </div>
          </div>
        </div>


        <!-- Facilities Grid -->
        <div id="facilitiesGridView" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <!-- Table Header -->
          <div class="bg-[#001F54] px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
              <h3 class="text-lg font-semibold text-white flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                  <i data-lucide="building-2" class="w-4 h-4 text-[#F7B32B]"></i>
                </div>
                Facility Directory
              </h3>
              <div class="flex items-center gap-3">
                <button id="viewToggleBtn"
                  class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 text-white transition-all"
                  title="Switch to list view" aria-label="Switch to list view" aria-pressed="false" tabindex="0">
                  <i data-lucide="list" class="w-4 h-4"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Content Section -->
          <div class="p-6">

            @if($facilities->count() > 0)

              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($facilities as $facility)
                  <div id="facility-card-{{ $facility->id }}" class="room-card group">
                    <!-- Image Container -->
                    <div class="room-card-image">
                      <img
                        src="{{ $facility->cover_url ?: 'https://placehold.co/400x300?text=' . urlencode($facility->name) }}"
                        alt="{{ $facility->name }}" onerror="this.src='https://placehold.co/400x300?text=No+Image'"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                      <!-- Status Badge -->
                      <div class="absolute top-3 right-3">
                        <span
                          class="px-3 py-1.5 rounded-full text-xs font-semibold shadow-lg
                                                                            {{ $facility->status === 'available' ? 'bg-emerald-500 text-white' : '' }}
                                                                            {{ $facility->status === 'occupied' ? 'bg-red-500 text-white' : '' }}
                                                                            {{ $facility->status === 'reserved' ? 'bg-amber-500 text-white' : '' }}
                                                                            {{ !in_array($facility->status, ['available', 'occupied', 'reserved']) ? 'bg-gray-500 text-white' : '' }}">
                          {{ ucfirst($facility->status) }}
                        </span>
                      </div>

                      <!-- Capacity Tag -->
                      <div class="absolute bottom-3 left-3">
                        <div class="bg-white/95 backdrop-blur-sm rounded-lg px-3 py-2 shadow-lg">
                          <span class="text-xs text-gray-500 block">Capacity</span>
                          <span class="text-lg font-bold text-blue-900">{{ $facility->capacity ?? 0 }} pax</span>
                        </div>
                      </div>
                    </div>

                    <!-- Card Body -->
                    <div class="room-card-body">
                      <!-- Title & Type -->
                      <div class="mb-3">
                        <span class="inline-block px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded mb-2">
                          {{ $facility->facility_type ?? 'Facility' }}
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $facility->name }}</h3>
                      </div>

                      <!-- Description -->
                      @if($facility->description)
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">{{ $facility->description }}</p>
                      @endif

                      <!-- Quick Stats -->
                      <div class="flex items-center gap-4 mb-4 pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-1.5 text-gray-600">
                          <i data-lucide="users" class="w-4 h-4 text-blue-500"></i>
                          <span class="text-sm font-medium">{{ $facility->capacity ?? '-' }} Capacity</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-gray-600">
                          <i data-lucide="tag" class="w-4 h-4 text-blue-500"></i>
                          <span class="text-sm font-medium">{{ $facility->facility_type ?? 'Facility' }}</span>
                        </div>
                      </div>

                      <!-- Amenities -->
                      @php
                        $amenitiesList = is_array($facility->amenities) ? $facility->amenities : (is_string($facility->amenities) ? explode(',', $facility->amenities) : []);
                      @endphp
                      @if(!empty($amenitiesList))
                        <div class="flex flex-wrap gap-1.5 mb-4">
                          @foreach(array_slice($amenitiesList, 0, 4) as $amenity)
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-md">
                              <i data-lucide="check" class="w-3 h-3 text-emerald-500"></i>
                              {{ trim($amenity) }}
                            </span>
                          @endforeach
                          @if(count($amenitiesList) > 4)
                            <span
                              class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-600 text-xs rounded-md font-medium">
                              +{{ count($amenitiesList) - 4 }} more
                            </span>
                          @endif
                        </div>
                      @endif

                      <!-- Action Button -->
                      <button type="button"
                        class="openViewRoomBtn mt-auto w-full py-2.5 px-4 font-medium rounded-lg transition-all duration-300 flex items-center justify-center gap-2 shadow-md hover:shadow-lg"
                        style="background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%); color: #1f2937; border: none;"
                        onmouseover="this.style.background='linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'"
                        onmouseout="this.style.background='linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%)'"
                        data-id="{{ $facility->id }}" data-name="{{ $facility->name }}"
                        data-type="{{ $facility->facility_type }}" data-description="{{ $facility->description }}"
                        data-status="{{ $facility->status }}" data-capacity="{{ $facility->capacity }}"
                        data-amenities="{{ is_array($facility->amenities) ? implode(', ', $facility->amenities) : $facility->amenities }}"
                        data-image="{{ $facility->cover_url }}">
                        <i data-lucide="eye" class="w-4 h-4 text-[#1f2937]"></i>
                        <span>View Details</span>
                      </button>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="text-center py-12">
                <i data-lucide="building-2" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No Facilities Found</h3>
                <p class="text-gray-500 mb-6">Unable to fetch facilities from the hotel API. Please try again later.</p>
                <button onclick="location.reload()"
                  class="btn btn-primary btn-md hover:btn-primary-focus transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                  <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                  Refresh
                </button>
              </div>
            @endif
          </div>
          <!-- End Content Section -->
        </div>

      </main>
    </div>
  </div>

  @include('partials.soliera_js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Full Image Preview Modal -->
  <div id="fullImageModal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl bg-white text-gray-800 rounded-xl" data-theme="light"
      onclick="event.stopPropagation()">
      <div class="flex items-center justify-between mb-3">
        <h3 class="text-xl font-bold">Image Preview</h3>
        <button id="closeFullImageModal" class="btn btn-sm btn-circle btn-ghost"><i data-lucide="x"
            class="text-xl md:text-2xl lg:text-3xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i></button>
      </div>
      <div class="rounded-lg border border-gray-200"
        style="max-height:80vh; overflow:auto; background:#00000010; display:flex; align-items:center; justify-content:center;">
        <img id="fullImageEl" src="" alt="Preview"
          style="max-width:100%; max-height:80vh; width:auto; height:auto; object-fit:contain; display:block;">
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteConfirmModal" class="modal">
    <div class="modal-box w-11/12 max-w-md bg-white text-gray-800 rounded-xl" data-theme="light"
      onclick="event.stopPropagation()">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
            <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-800">Delete Facility</h3>
            <p class="text-sm text-gray-500">This action cannot be undone</p>
          </div>
        </div>
        <button id="closeDeleteModal" class="btn btn-sm btn-circle btn-ghost">
          <i data-lucide="x"
            class="text-xl md:text-2xl lg:text-3xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i>
        </button>
      </div>

      <div class="mb-6">
        <div class="bg-gray-50 rounded-lg p-4 mb-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
              <i data-lucide="building" class="w-5 h-5 text-blue-600"></i>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800" id="deleteFacilityName">—</h4>
              <p class="text-sm text-gray-500" id="deleteFacilityLocation">—</p>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
          <div>
            <span class="text-gray-500">Status:</span>
            <span class="font-medium" id="deleteFacilityStatus">—</span>
          </div>
          <div>
            <span class="text-gray-500">Reservations:</span>
            <span class="font-medium" id="deleteFacilityReservations">—</span>
          </div>
        </div>

        <div id="deleteWarningMessage" class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg hidden">
          <div class="flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-4 h-4 text-red-600"></i>
            <p class="text-sm text-red-700 font-medium">This facility has active reservations or is currently occupied!
            </p>
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-3">
        <button type="button"
          class="btn btn-outline btn-sm hover:btn-primary transition-all duration-300 shadow-sm hover:shadow-md"
          id="cancelDeleteBtn">
          <i data-lucide="x" class="w-4 h-4 mr-2"></i>
          Cancel
        </button>
        <button type="button"
          class="btn btn-error btn-sm hover:btn-error-focus transition-all duration-300 shadow-sm hover:shadow-md transform hover:scale-105"
          id="confirmDeleteBtn">
          <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
          <span id="deleteBtnText">Delete Facility</span>
        </button>
      </div>
    </div>
  </div>

  <!-- View Facility Modal -->
  <div id="viewFacilityModal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl bg-white text-gray-800 rounded-xl" data-theme="light"
      onclick="event.stopPropagation()">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <i data-lucide="building" class="w-6 h-6 text-blue-500"></i>
          <h3 class="text-2xl font-bold text-gray-800" id="vf_name">Facility Details</h3>
        </div>
        <div class="flex items-center gap-3">
          <div class="badge badge-lg" id="vf_status_badge">Available</div>
          <button id="closeViewFacilityModal" class="btn btn-sm btn-circle btn-ghost">
            <i data-lucide="x"
              class="text-xl md:text-2xl lg:text-3xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i>
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
          <div class="card bg-white border border-gray-200">
            <div class="card-body">
              <div id="vf_location_wrap" class="mb-4 hidden">
                <label class="text-sm font-medium text-gray-500">Location</label>
                <div class="flex items-center gap-2 mt-1">
                  <i data-lucide="map-pin" class="w-4 h-4 text-emerald-600"></i>
                  <span id="vf_location" class="text-gray-700"></span>
                </div>
              </div>

              <div id="vf_description_wrap" class="mb-4 hidden">
                <label class="text-sm font-medium text-gray-500">Description</label>
                <p id="vf_description" class="mt-1 text-gray-700"></p>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t">
                <div>
                  <label class="text-sm font-medium text-gray-500">Total Reservations</label>
                  <p id="vf_reservations_count" class="font-semibold text-lg">0</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Last Updated</label>
                  <p id="vf_updated_at" class="text-sm">—</p>
                </div>
              </div>


            </div>
          </div>
        </div>

        <div class="lg:col-span-1">
          <div class="card bg-white border border-gray-200 h-full">
            <div class="card-body">
              <h3 class="card-title text-lg mb-4 flex items-center">
                <i data-lucide="calendar-clock" class="w-5 h-5 mr-2 text-emerald-600"></i>
                Recent Reservations
              </h3>
              <div id="vf_recent_reservations" class="space-y-3"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- View Facility Modal (API Data) -->
  <div id="viewRoomModal" class="modal">
    <div class="modal-box w-11/12 max-w-4xl bg-white text-gray-800 rounded-xl" data-theme="light">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <i data-lucide="building-2" class="w-6 h-6 text-blue-500"></i>
          <h3 class="text-2xl font-bold text-gray-800" id="vr_name">Facility Details</h3>
        </div>
        <div class="flex items-center gap-3">
          <div class="badge badge-lg" id="vr_status_badge">Available</div>
          <button id="closeViewRoomModal" class="btn btn-sm btn-circle btn-ghost">
            <i data-lucide="x"
              class="text-xl md:text-2xl lg:text-3xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i>
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Facility Image -->
        <div class="space-y-4">
          <div class="rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
            <img id="vr_image" src="" alt="Facility Image" class="w-full h-64 object-cover"
              onerror="this.src='https://placehold.co/400x300?text=No+Image'">
          </div>
        </div>

        <!-- Facility Details -->
        <div class="space-y-4">
          <!-- Facility Type Badge -->
          <div class="flex items-center gap-2 mb-2">
            <span class="badge badge-primary badge-lg" id="vr_type">Facility</span>
          </div>

          <!-- Description -->
          <div>
            <h4 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">
              <i data-lucide="file-text" class="w-4 h-4"></i>
              Description
            </h4>
            <p class="text-gray-600 text-sm" id="vr_description">No description available.</p>
          </div>

          <!-- Facility Info Grid -->
          <div class="grid grid-cols-2 gap-4">
            <div class="bg-gray-50 p-3 rounded-lg col-span-2">
              <div class="flex items-center gap-2 text-gray-500 text-xs mb-1">
                <i data-lucide="users" class="w-3 h-3"></i>
                Capacity
              </div>
              <p class="font-bold text-2xl text-blue-600" id="vr_capacity">-</p>
            </div>
          </div>

          <!-- Amenities -->
          <div>
            <h4 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">
              <i data-lucide="check-circle" class="w-4 h-4"></i>
              Amenities
            </h4>
            <div class="flex flex-wrap gap-2" id="vr_amenities">
              <span class="badge badge-outline">No amenities listed</span>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-action mt-6">
        <button type="button" class="btn btn-ghost" onclick="closeViewRoomModal()">Close</button>
      </div>
    </div>
  </div>

  <!-- Create Facility Modal -->
  <!-- Create New Facility Modal -->
  @php
    $hasCreateFacilityErrors = $errors->hasAny(['name', 'location', 'description', 'status', 'capacity', 'amenities', 'facility_type', 'image_url']);
  @endphp
  <div id="createFacilityModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="createFacilityTitle"
    aria-hidden="true" data-open-on-load="{{ $hasCreateFacilityErrors ? 'true' : 'false' }}"
    style="background: rgba(0,0,0,0.60); backdrop-filter: blur(8px);">
    <div class="modal-box w-11/12 max-w-[680px] bg-white text-gray-800 rounded-[20px] shadow-2xl p-0 overflow-hidden"
      data-theme="light" tabindex="-1">
      <!-- Header -->
      <div class="px-8 pt-8 pb-4 flex items-center justify-between">
        <h3 id="createFacilityTitle" class="text-[32px] font-semibold font-serif text-[#111827] leading-tight">Create
          New Facility</h3>
        <button id="closeCreateFacilityModal" type="button"
          class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors"
          aria-label="Close modal">
          <i data-lucide="x" class="w-5 h-5 text-gray-400"></i>
        </button>
      </div>

      <div class="px-8 py-4">
        @if($hasCreateFacilityErrors)
          <div class="alert alert-error mb-6 py-3 rounded-xl shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="text-sm">Please correct the errors in the form below.</span>
          </div>
        @endif

        <form id="createFacilityForm" action="{{ route('facilities.store') }}" method="POST" novalidate>
          @csrf
          <div class="space-y-5">
            <!-- Facility Name -->
            <div class="form-control">
              <label class="label py-1" for="create_facility_name">
                <span class="label-text text-[#374151] font-medium">Facility Name</span>
              </label>
              <input id="create_facility_name" type="text" name="name"
                class="input input-bordered h-12 bg-[#F9FAFB] rounded-xl border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#F5B301]/20 focus:border-[#F5B301] w-full"
                value="{{ old('name') }}" placeholder="Enter facility name" required>
            </div>

            <!-- Description -->
            <div class="form-control">
              <label class="label py-1" for="create_facility_description">
                <span class="label-text text-[#374151] font-medium">Description</span>
              </label>
              <textarea id="create_facility_description" name="description" rows="4"
                class="textarea textarea-bordered min-h-[140px] bg-[#F9FAFB] rounded-xl border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#F5B301]/20 focus:border-[#F5B301] w-full"
                placeholder="Enter facility description">{{ old('description') }}</textarea>
            </div>

            <!-- Category & Capacity Row -->
            <div class="grid grid-cols-2 gap-6">
              <div class="form-control">
                <label class="label py-1" for="create_facility_type">
                  <span class="label-text text-[#374151] font-medium">Category</span>
                </label>
                <input id="create_facility_type" type="hidden" name="facility_type"
                  value="{{ old('facility_type', 'Facility') }}">
                <details id="createFacilityTypeDropdown" class="dropdown w-full">
                  <summary
                    class="btn h-12 min-h-[48px] w-full justify-between bg-[#F9FAFB] border border-gray-200 rounded-xl font-normal hover:bg-white focus:outline-none focus:ring-2 focus:ring-[#F5B301]/20 focus:border-[#F5B301]">
                    <span id="createFacilityTypeLabel">Facility</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                  </summary>
                  <ul
                    class="dropdown-content menu mt-2 p-2 shadow-xl bg-white rounded-xl w-full border border-gray-100 z-[70]">
                    @foreach(['Facility', 'Conference', 'Recreation', 'Dining', 'Wellness'] as $type)
                      <li>
                        <button type="button"
                          class="create-facility-type-option flex items-center justify-between w-full px-4 py-2.5 rounded-lg"
                          data-value="{{ $type }}">
                          <span>{{ $type }}</span><i data-lucide="check" class="w-4 h-4 opacity-0"></i>
                        </button>
                      </li>
                    @endforeach
                  </ul>
                </details>
              </div>

              <div class="form-control">
                <label class="label py-1" for="create_facility_capacity">
                  <span class="label-text text-[#374151] font-medium">Capacity (pax)</span>
                </label>
                <input id="create_facility_capacity" type="number" name="capacity" min="1"
                  class="input input-bordered h-12 bg-[#F9FAFB] rounded-xl border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#F5B301]/20 focus:border-[#F5B301] w-full"
                  value="{{ old('capacity', 50) }}" placeholder="50">
              </div>
            </div>

            <!-- Status -->
            <div class="form-control">
              <label class="label py-1" for="create_facility_status_value">
                <span class="label-text text-[#374151] font-medium">Status</span>
              </label>
              <input id="create_facility_status_value" type="hidden" name="status"
                value="{{ old('status', 'available') }}">
              <details id="createFacilityStatusDropdown" class="dropdown w-full">
                <summary
                  class="btn h-12 min-h-[48px] w-full justify-between bg-[#F9FAFB] border border-gray-200 rounded-xl font-normal hover:bg-white focus:outline-none focus:ring-2 focus:ring-[#001F54]/10">
                  <span id="createFacilityStatusLabel">available</span>
                  <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                </summary>
                <ul
                  class="dropdown-content menu mt-2 p-2 shadow-xl bg-white rounded-xl w-full border border-gray-100 z-[70]">
                  @foreach(['available', 'unavailable', 'occupied', 'reserved'] as $status)
                    <li>
                      <button type="button"
                        class="create-facility-status-option flex items-center justify-between w-full px-4 py-2.5 rounded-lg"
                        data-value="{{ $status }}">
                        <span>{{ ucfirst($status) }}</span><i data-lucide="check" class="w-4 h-4 opacity-0"></i>
                      </button>
                    </li>
                  @endforeach
                </ul>
              </details>
            </div>

            <!-- Image URL -->
            <div class="form-control">
              <label class="label py-1" for="create_facility_image_url">
                <span class="label-text text-[#374151] font-medium">Image URL</span>
              </label>
              <input id="create_facility_image_url" type="text" name="image_url"
                class="input input-bordered h-12 bg-[#F9FAFB] rounded-xl border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#F5B301]/20 focus:border-[#F5B301] w-full"
                value="{{ old('image_url', '/placeholder.svg') }}" placeholder="/placeholder.svg">
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="mt-10 px-0 pb-10 flex items-center justify-end gap-3">
            <button type="button"
              class="px-8 py-2.5 rounded-xl border border-gray-300 text-gray-600 font-medium hover:bg-gray-50 transition-colors"
              id="cancelCreateFacility">Cancel</button>
            <button id="createFacilitySubmitBtn" type="submit"
              class="px-8 py-2.5 bg-[#001F54] text-[#F5B301] font-semibold rounded-xl hover:bg-[#00163d] transition-all shadow-lg active:scale-95">
              <span id="createFacilitySubmitText">Create Facility</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Facility Modal -->
  <div id="editFacilityModal" class="modal">
    <div class="modal-box w-11/12 max-w-2xl bg-white text-gray-800" data-theme="light">
      <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
          <i data-lucide="edit-3" class="w-6 h-6 text-blue-500"></i>
          Edit Facility
        </h3>
        <button id="closeEditFacilityModal" class="btn btn-sm btn-circle btn-ghost">
          <i data-lucide="x"
            class="text-xl md:text-2xl lg:text-3xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i>
        </button>
      </div>

      <form id="editFacilityForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="label"><span class="label-text font-semibold">Facility Image</span></label>
            <div id="editImageWrap" class="img-edit-wrap rounded-xl overflow-hidden border border-gray-200"
              style="height: 180px; background:#f3f4f6; cursor:pointer;">
              <img id="edit_image_preview" src="" alt="Facility Image"
                style="width:100%; height:100%; object-fit:cover; display:none;">
              <div class="img-edit-overlay">
                <button type="button" id="btnEditImage" class="img-edit-btn"><i data-lucide="edit-3"
                    class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i><span>Edit</span></button>
                <button type="button" id="btnViewImage" class="img-edit-btn"><i data-lucide="maximize-2"
                    class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i><span>View</span></button>
                <button type="button" id="btnRemoveImage" class="img-edit-btn"><i data-lucide="eraser"
                    class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i><span>Remove
                    BG</span></button>
                <button type="button" id="btnCloseOverlay" class="img-edit-btn"><i data-lucide="x"
                    class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i></button>
              </div>
            </div>
            <input type="file" id="edit_cover_image" name="cover_image" accept=".jpg,.jpeg,.png,.webp" class="hidden">
            <input type="hidden" id="edit_remove_image" name="remove_image" value="0">
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text font-semibold">Facility Name *</span></label>
            <input type="text" name="name" id="edit_name" class="input input-bordered" required>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text font-semibold">Location</span></label>
            <input type="text" name="location" id="edit_location" class="input input-bordered">
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text font-semibold">Description</span></label>
            <textarea name="description" id="edit_description" class="textarea textarea-bordered"></textarea>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text font-semibold">Status</span></label>
            <select name="status" id="edit_status" class="select select-bordered">
              <option value="available">Available</option>
              <option value="unavailable">Unavailable</option>
              <option value="occupied">Occupied</option>
            </select>
          </div>
        </div>

        <div class="modal-action">
          <button type="button"
            class="btn btn-outline btn-sm hover:btn-primary transition-all duration-300 shadow-sm hover:shadow-md"
            id="cancelEditFacility">Cancel</button>
          <button type="submit"
            class="btn btn-primary btn-sm hover:btn-primary-focus transition-all duration-300 shadow-sm hover:shadow-md transform hover:scale-105">
            <i data-lucide="save" class="w-4 h-4 mr-2"></i>
            Update Facility
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Facility Checkout/Inspection Modal -->
  <div id="checkoutInspectionModal" class="modal" role="dialog" aria-labelledby="checkout-modal-title"
    aria-modal="true">
    <div class="modal-box w-11/12 max-w-2xl bg-white text-gray-800 rounded-xl" data-theme="light">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <i data-lucide="clipboard-check" class="w-6 h-6 text-blue-500"></i>
          <h3 id="checkout-modal-title" class="text-2xl font-bold text-gray-800">Facility Inspection: <span
              id="checkout-facility-name">—</span></h3>
        </div>
        <button id="closeCheckoutModal" class="btn btn-sm btn-circle btn-ghost" aria-label="Close inspection modal">
          <i data-lucide="x"
            class="text-xl md:text-2xl lg:text-3xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i>
        </button>
      </div>

      <form id="checkoutInspectionForm">
        @csrf
        <input type="hidden" id="checkout-request-id" name="request_id" value="">

        <!-- Damage Found Section -->
        <div class="form-control mb-6">
          <label class="label">
            <span class="label-text font-semibold text-lg">Damage Found?</span>
          </label>
          <div class="flex gap-4 mt-2">
            <label class="label cursor-pointer justify-start gap-3 flex-1">
              <input type="radio" name="damage_status" value="no_damage" class="radio radio-primary" checked
                onchange="toggleDamageFields(false)">
              <span class="label-text">No Damage</span>
            </label>
            <label class="label cursor-pointer justify-start gap-3 flex-1">
              <input type="radio" name="damage_status" value="damage_found" class="radio radio-primary"
                onchange="toggleDamageFields(true)">
              <span class="label-text">Damage Found</span>
            </label>
          </div>
        </div>

        <!-- Damage Alert (shown when damage found) -->
        <div id="damage-alert" class="alert alert-warning mb-6 hidden">
          <i data-lucide="alert-triangle" class="w-5 h-5"></i>
          <div>
            <h3 class="font-bold">Damage Detected</h3>
            <div class="text-sm">This will create a legal case automatically</div>
          </div>
        </div>

        <!-- Damage Fields (shown only when damage found) -->
        <div id="damage-fields" class="hidden space-y-4 mb-6">
          <!-- Damage Severity -->
          <div class="form-control">
            <label for="damage_severity" class="label">
              <span class="label-text font-semibold">Damage Severity</span>
            </label>
            <select id="damage_severity" name="damage_severity" class="select select-bordered w-full">
              <option value="">Select severity</option>
              <option value="minor">Minor (25% of base fine)</option>
              <option value="moderate">Moderate (50% of base fine)</option>
              <option value="major">Major (100% of base fine)</option>
              <option value="severe">Severe (200% of base fine)</option>
            </select>
          </div>

          <!-- Damage Description -->
          <div class="form-control">
            <label for="damage_description" class="label">
              <span class="label-text font-semibold">Damage Description</span>
            </label>
            <textarea id="damage_description" name="damage_description" class="textarea textarea-bordered h-32"
              placeholder="Describe the damage in detail..."></textarea>
          </div>

          <!-- Estimated Damage Cost -->
          <div class="form-control">
            <label for="damage_cost" class="label">
              <span class="label-text font-semibold">Estimated Damage Cost (₱)</span>
            </label>
            <input type="number" id="damage_cost" name="damage_cost" class="input input-bordered w-full" min="0"
              step="0.01" placeholder="Enter estimated cost (e.g., 15000.00)">
            <p class="text-sm text-gray-500 mt-2">
              <i data-lucide="info" class="w-4 h-4 inline"></i>
              If cost is ₱10,000 or more, this will automatically escalate to Legal Management
            </p>
          </div>
        </div>

        <!-- Inspector Notes (Optional) -->
        <div class="form-control mb-6">
          <label for="inspection_notes" class="label">
            <span class="label-text font-semibold">Inspector Notes (Optional)</span>
          </label>
          <textarea id="inspection_notes" name="inspection_notes" class="textarea textarea-bordered h-32"
            placeholder="Additional observations..."></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6">
          <button type="button" id="cancelCheckoutBtn" class="btn btn-ghost btn-sm">
            Cancel
          </button>
          <button type="submit" class="btn btn-primary btn-sm">
            <i data-lucide="check" class="w-4 h-4 mr-2"></i>
            Submit Inspection
          </button>
        </div>
      </form>
    </div>
    <div class="modal-backdrop" onclick="closeCheckoutModal()" aria-label="Close inspection modal"></div>
  </div>

  <script>
    // Real-time date and time
    function updateDateTime() {
      const now = new Date();
      const dateElement = document.getElementById('currentDate');
      const timeElement = document.getElementById('currentTime');

      const dateOptions = { weekday: 'short', month: 'short', day: 'numeric' };
      const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };

      if (dateElement) dateElement.textContent = now.toLocaleDateString('en-US', dateOptions);
      if (timeElement) timeElement.textContent = now.toLocaleTimeString('en-US', timeOptions);
    }

    // Global variables
    let currentViewMode = 'grid';
    let isCalendarView = false;
    let filteredFacilities = [];

    // Monitoring: fetch and render facility cards (GLOBAL FUNCTION) - EXACTLY LIKE VISITOR MANAGEMENT
    function loadFacilitiesMonitoring() {
      console.log('Loading facilities monitoring data...');
      const container = document.getElementById('monitoring-facilities-cards');
      if (container) {
        container.innerHTML = `
          <div class="col-span-full text-center py-12 text-gray-500">
            <i data-lucide="loader" class="w-12 h-12 text-gray-400 mx-auto mb-4 animate-spin"></i>
            <p>Loading facilities...</p>
          </div>
        `;
        if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
      }

      fetch('{{ route('facilities.monitoring.summary') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(response => {
          console.log('Response status:', response.status);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Monitoring facilities response:', data);
          if (data.success) {
            console.log('Facilities loaded:', data.data);
            console.log('Number of facilities:', data.data ? data.data.length : 0);
            updateMonitoringFacilitiesCards(data.data || []);
            // Update stats
            const totalActiveEl = document.getElementById('mon-total-active');
            const availableEl = document.getElementById('mon-available');
            if (totalActiveEl) totalActiveEl.textContent = data.summary?.total_active ?? 0;
            if (availableEl) availableEl.textContent = data.summary?.available_facilities ?? 0;
          } else {
            console.error('Error loading monitoring facilities:', data.message);
            const container = document.getElementById('monitoring-facilities-cards');
            if (container) {
              container.innerHTML = `
                <div class="col-span-full text-center py-12 text-red-500">
                  <i data-lucide="alert-circle" class="w-12 h-12 text-red-400 mx-auto mb-4"></i>
                  <p>Error: ${data.message || 'Failed to load facilities'}</p>
                </div>
              `;
              if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
            }
          }
        })
        .catch(error => {
          console.error('Error loading monitoring facilities:', error);
          const container = document.getElementById('monitoring-facilities-cards');
          if (container) {
            container.innerHTML = `
              <div class="col-span-full text-center py-12 text-red-500">
                <i data-lucide="alert-circle" class="w-12 h-12 text-red-400 mx-auto mb-4"></i>
                <p>Error loading facilities. Please try again.</p>
                <p class="text-sm mt-2">${error.message}</p>
              </div>
            `;
            if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
          }
        });
    }

    // Update monitoring facilities cards - EXACTLY LIKE VISITOR MANAGEMENT
    function updateMonitoringFacilitiesCards(facilities) {
      console.log('Updating monitoring facilities cards with:', facilities);
      console.log('Facilities array length:', facilities ? facilities.length : 0);
      const container = document.getElementById('monitoring-facilities-cards');
      const emptyState = document.getElementById('monitoring-empty-state');

      if (!container) {
        console.error('monitoring-facilities-cards container not found');
        return;
      }

      if (!facilities || facilities.length === 0) {
        console.log('No facilities found, showing empty state');
        container.innerHTML = '';
        if (emptyState) {
          emptyState.classList.remove('hidden');
          console.log('Empty state shown');
        }
        if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
        return;
      }

      console.log('Rendering', facilities.length, 'facility cards');
      if (emptyState) emptyState.classList.add('hidden');

      container.innerHTML = facilities.map(facility => {
        const statusLabel = facility.status_label || (facility.status === 'active' ? 'Active' : facility.status === 'pending' ? 'Pending' : 'Completed');
        let statusConfig;
        switch (facility.status) {
          case 'active':
            statusConfig = { label: statusLabel, color: '#10b981', badgeClass: 'badge-success' };
            break;
          case 'pending':
            if (statusLabel.toLowerCase().includes('legal')) {
              statusConfig = { label: statusLabel, color: '#f97316', badgeClass: 'badge-warning' };
            } else {
              statusConfig = { label: statusLabel, color: '#f59e0b', badgeClass: 'badge-warning' };
            }
            break;
          default:
            statusConfig = { label: statusLabel, color: '#6b7280', badgeClass: 'badge-neutral' };
        }

        return `
          <div class="monitoring-facility-card bg-white rounded-lg border-2 border-gray-100 p-4 hover:shadow-2xl hover:border-blue-200 transition-all duration-300 shadow-lg" 
               style="background-color: var(--color-white); border-color: #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
            
            <!-- Card Header with Status Badge -->
            <div class="flex justify-between items-start mb-3">
              <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 mb-1" style="color: var(--color-charcoal-ink);">${facility.facility_name}</h3>
                <p class="text-sm text-gray-600 font-medium" style="color: var(--color-charcoal-ink); opacity: 0.8;">${facility.facility_location}</p>
              </div>
              <span class="badge ${statusConfig.badgeClass} text-xs font-semibold px-2 py-1" style="background-color: ${statusConfig.color}; color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" data-field="status">
                ${statusConfig.label}
              </span>
            </div>

            <!-- Reservation ID -->
            <div class="mb-3 p-2 bg-gray-50 rounded-md" style="background-color: #f8fafc;">
              <div class="flex items-center gap-2 text-xs text-gray-600" style="color: var(--color-charcoal-ink); opacity: 0.8;">
                <i data-lucide="hash" class="w-3 h-3 text-blue-500"></i>
                <span class="font-semibold">Reservation ID:</span>
                <span class="font-mono text-blue-600 font-bold">#${String(facility.id).padStart(6, '0')}</span>
              </div>
            </div>

            <!-- Reserver Information -->
            <div class="mb-3 space-y-2">
              <div class="flex items-center gap-2 text-xs text-gray-600" style="color: var(--color-charcoal-ink); opacity: 0.8;">
                <i data-lucide="user" class="w-3 h-3 text-green-500"></i>
                <span class="font-medium">Reserved By: ${facility.reserver_name}</span>
              </div>
              <div class="flex items-center gap-2 text-xs text-gray-600" style="color: var(--color-charcoal-ink); opacity: 0.8;">
                <i data-lucide="mail" class="w-3 h-3 text-purple-500"></i>
                <span class="font-medium">${facility.reserver_email}</span>
              </div>
              <div class="flex items-center gap-2 text-xs text-gray-600" style="color: var(--color-charcoal-ink); opacity: 0.8;">
                <i data-lucide="building" class="w-3 h-3 text-orange-500"></i>
                <span class="font-medium">${facility.reserver_department}</span>
              </div>
            </div>

            <!-- Reservation Details -->
            <div class="mb-3 p-2 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-md border border-blue-100" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-color: #bfdbfe;">
              <div class="text-xs space-y-1">
                <div class="flex items-center gap-2">
                  <i data-lucide="target" class="w-3 h-3 text-blue-600"></i>
                  <span class="font-semibold text-gray-700" style="color: var(--color-charcoal-ink);">Purpose:</span>
                  <span class="text-gray-600 font-medium" style="color: var(--color-charcoal-ink); opacity: 0.8;">${facility.purpose}</span>
                </div>
              </div>
            </div>

            <!-- Time Information -->
            <div class="mb-3 p-2 bg-gray-50 rounded-md border border-gray-200" style="background-color: #f9fafb; border-color: #e5e7eb;">
              <div class="space-y-1">
                <div class="flex justify-between items-center text-xs">
                  <span class="text-gray-600 font-medium" style="color: var(--color-charcoal-ink); opacity: 0.8;">Start Time:</span>
                  <span class="font-semibold text-blue-600" style="color: #2563eb;">${facility.start_time}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                  <span class="text-gray-600 font-medium" style="color: var(--color-charcoal-ink); opacity: 0.8;">End Time:</span>
                  <span class="font-semibold text-orange-600" style="color: #ea580c;">${facility.end_time}</span>
                </div>
              </div>
            </div>

            ${facility.legal_case_status && facility.legal_case_status !== 'completed' ? `
              <div class="mb-3 p-2 bg-red-50 border border-red-200 rounded-md text-xs text-red-700">
                <div class="flex items-center gap-2 font-semibold">
                  <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                  Pending Legal Action
                </div>
                <p class="mt-1">Legal case ${facility.legal_case_status === 'pending' ? 'awaiting resolution' : facility.legal_case_status}</p>
              </div>
            ` : ''}

            <!-- Action Buttons -->
            <div class="flex gap-2 pt-3 border-t border-gray-200" style="border-color: #e5e7eb;">
              ${facility.status === 'active' ? `
              <!-- ACTIVE reservations: Check Out and Details -->
              <button 
                onclick="checkOutFacility(${facility.id}, '${facility.facility_name.replace(/'/g, "\\'")}')" 
                class="btn btn-sm flex-1"
                style="background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%); color: #1f2937; box-shadow: 0 2px 8px rgba(247, 179, 43, 0.25); border: none;"
                onmouseover="this.style.background='linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'; this.style.boxShadow='0 4px 12px rgba(247, 179, 43, 0.35)'"
                onmouseout="this.style.background='linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%)'; this.style.boxShadow='0 2px 8px rgba(247, 179, 43, 0.25)'">
                <i data-lucide="log-out" class="w-4 h-4 mr-1"></i>Check Out
              </button>
              <button 
                onclick="viewFacilityReservation(${facility.id})" 
                class="btn btn-sm"
                style="background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%); color: #1f2937; box-shadow: 0 2px 8px rgba(247, 179, 43, 0.25); border: none;"
                onmouseover="this.style.background='linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'; this.style.boxShadow='0 4px 12px rgba(247, 179, 43, 0.35)'"
                onmouseout="this.style.background='linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%)'; this.style.boxShadow='0 2px 8px rgba(247, 179, 43, 0.25)'">
                <i data-lucide="info" class="w-4 h-4 mr-1"></i>Details
              </button>
              ` : facility.status === 'pending' ? `
              <!-- PENDING reservations: Details only -->
              <button 
                onclick="viewFacilityReservation(${facility.id})" 
                class="btn btn-sm w-full"
                style="background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%); color: #1f2937; box-shadow: 0 2px 8px rgba(247, 179, 43, 0.25); border: none;"
                onmouseover="this.style.background='linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'; this.style.boxShadow='0 4px 12px rgba(247, 179, 43, 0.35)'"
                onmouseout="this.style.background='linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%)'; this.style.boxShadow='0 2px 8px rgba(247, 179, 43, 0.25)'">
                <i data-lucide="info" class="w-4 h-4 mr-1"></i>Details
              </button>
              ` : `
              <!-- COMPLETED reservations: View Details -->
              <button 
                onclick="viewFacilityReservation(${facility.id})" 
                class="btn btn-sm w-full"
                style="background: linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%); color: #1f2937; box-shadow: 0 2px 8px rgba(247, 179, 43, 0.25); border: none;"
                onmouseover="this.style.background='linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'; this.style.boxShadow='0 4px 12px rgba(247, 179, 43, 0.35)'"
                onmouseout="this.style.background='linear-gradient(135deg, #F7B32B 0%, #f59e0b 100%)'; this.style.boxShadow='0 2px 8px rgba(247, 179, 43, 0.25)'">
                <i data-lucide="info" class="w-4 h-4 mr-1"></i>Details
              </button>
              `}
            </div>
          </div>
        `;
      }).join('');

      if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
    }

    // View facility reservation details
    function viewFacilityReservation(reservationId) {
      window.location.href = `{{ route('facility_reservations.index') }}?reservation=${reservationId}`;
    }

    // Check out facility - opens inspection modal
    let currentCheckoutRequestId = null;
    let currentCheckoutFacilityName = null;

    function checkOutFacility(requestId, facilityName) {
      currentCheckoutRequestId = requestId;
      currentCheckoutFacilityName = facilityName || 'Facility';

      // Set modal values
      document.getElementById('checkout-request-id').value = requestId;
      document.getElementById('checkout-facility-name').textContent = facilityName || 'Facility';

      // Reset form
      document.getElementById('checkoutInspectionForm').reset();
      document.querySelector('input[name="damage_status"][value="no_damage"]').checked = true;
      toggleDamageFields(false);

      // Show modal
      document.getElementById('checkoutInspectionModal').classList.add('modal-open');
      if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
    }

    // Close checkout modal
    function closeCheckoutModal() {
      document.getElementById('checkoutInspectionModal').classList.remove('modal-open');
      currentCheckoutRequestId = null;
      currentCheckoutFacilityName = null;
    }

    // Toggle damage fields based on radio selection
    function toggleDamageFields(showDamage) {
      const damageFields = document.getElementById('damage-fields');
      const damageAlert = document.getElementById('damage-alert');

      if (showDamage) {
        damageFields.classList.remove('hidden');
        damageAlert.classList.remove('hidden');
        // Make damage fields required
        document.getElementById('damage_severity').required = true;
        document.getElementById('damage_description').required = true;
        document.getElementById('damage_cost').required = true;
      } else {
        damageFields.classList.add('hidden');
        damageAlert.classList.add('hidden');
        // Remove required and clear values
        document.getElementById('damage_severity').required = false;
        document.getElementById('damage_description').required = false;
        document.getElementById('damage_cost').required = false;
        document.getElementById('damage_severity').value = '';
        document.getElementById('damage_description').value = '';
        document.getElementById('damage_cost').value = '';
      }
      if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
    }

    // Handle checkout form submission
    document.addEventListener('DOMContentLoaded', function () {
      const checkoutForm = document.getElementById('checkoutInspectionForm');
      const closeCheckoutBtn = document.getElementById('closeCheckoutModal');
      const cancelCheckoutBtn = document.getElementById('cancelCheckoutBtn');

      if (closeCheckoutBtn) {
        closeCheckoutBtn.addEventListener('click', closeCheckoutModal);
      }

      if (cancelCheckoutBtn) {
        cancelCheckoutBtn.addEventListener('click', closeCheckoutModal);
      }

      if (checkoutForm) {
        checkoutForm.addEventListener('submit', function (e) {
          e.preventDefault();

          const formData = new FormData(checkoutForm);
          const requestId = formData.get('request_id');
          const damageStatus = formData.get('damage_status');
          const hasDamage = damageStatus === 'damage_found';

          // Prepare data
          const submitData = {
            request_id: requestId,
            damage_flag: hasDamage ? 1 : 0,
            inspection_notes: formData.get('inspection_notes') || null,
          };

          if (hasDamage) {
            submitData.damage_severity = formData.get('damage_severity');
            submitData.damage_description = formData.get('damage_description');
            submitData.damage_cost = formData.get('damage_cost');
          }

          // Submit inspection and complete request
          fetch(`{{ route('facility_reservations.complete', ':id') }}`.replace(':id', requestId), {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(submitData)
          })
            .then(response => {
              if (!response.ok) {
                return response.json().then(err => {
                  throw new Error(err.message || `HTTP error! status: ${response.status}`);
                });
              }
              return response.json();
            })
            .then(data => {
              if (data.success) {
                if (data.has_damage) {
                  // If damage found, redirect to legal cases page (main Legal Cases submodule)
                  showNotification('Inspection submitted. Damage case has been created and escalated to Legal Management.', 'success');
                  setTimeout(() => {
                    window.location.href = '{{ route("legal.case_deck") }}';
                  }, 1500);
                } else {
                  // If no damage, just show success and reload monitoring
                  showNotification('Facility checked out successfully! The facility is now available.', 'success');
                  closeCheckoutModal();
                  // Reload monitoring data to update the display
                  loadFacilitiesMonitoring();
                }
              } else {
                showNotification(data.message || 'Failed to submit inspection', 'error');
              }
            })
            .catch(error => {
              console.error('Error submitting inspection:', error);
              showNotification(error.message || 'Error submitting inspection. Please try again.', 'error');
            });
        });
      }

      // Close modal on Escape key
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
          const modal = document.getElementById('checkoutInspectionModal');
          if (modal && modal.classList.contains('modal-open')) {
            closeCheckoutModal();
          }
        }
      });
    });

    // Facilities tabs: directory | monitoring (scoped, minimal; non-breaking)
    function facilityShowTab(tabName) {
      console.log('Switching to tab:', tabName);
      const dirView = document.getElementById('facilitiesGridView');
      const monView = document.getElementById('facilitiesMonitoringView');
      const eqView = document.getElementById('facilitiesEquipmentView');

      if (!dirView || !monView) {
        console.error('Missing required elements for tab switching');
        return;
      }

      // Reset all navigation buttons
      const nav1 = document.getElementById('nav-directory');
      const nav2 = document.getElementById('nav-monitoring');
      const nav3 = document.getElementById('nav-equipment');

      // Helper function to set tab inactive state
      function setTabInactive(btn) {
        if (!btn) return;
        btn.classList.remove('bg-[#001F54]', 'text-white', 'shadow-md');
        btn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
        const iconBox = btn.querySelector('div');
        if (iconBox) {
          iconBox.classList.remove('bg-white/20');
          iconBox.classList.add('bg-[#001F54]');
        }
      }

      // Helper function to set tab active state
      function setTabActive(btn) {
        if (!btn) return;
        btn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
        btn.classList.add('bg-[#001F54]', 'text-white', 'shadow-md');
        const iconBox = btn.querySelector('div');
        if (iconBox) {
          iconBox.classList.remove('bg-[#001F54]');
          iconBox.classList.add('bg-white/20');
        }
      }

      // Reset all tabs to inactive
      [nav1, nav2, nav3].forEach(btn => setTabInactive(btn));

      if (tabName === 'monitoring') {
        dirView.classList.add('hidden');
        monView.classList.remove('hidden');
        if (eqView) eqView.classList.add('hidden');

        setTabActive(nav2);
        try {
          const url = new URL(window.location.href);
          url.searchParams.set('tab', 'monitoring');
          window.history.replaceState({}, '', url);
        } catch (e) { }

        loadFacilitiesMonitoring();
      } else if (tabName === 'equipment') {
        if (dirView) dirView.classList.add('hidden');
        if (monView) monView.classList.add('hidden');
        if (eqView) eqView.classList.remove('hidden');

        setTabActive(nav3);
        try {
          const url = new URL(window.location.href);
          url.searchParams.set('tab', 'equipment');
          window.history.replaceState({}, '', url);
        } catch (e) { }

        loadEquipmentDetails();
      } else {
        // default to directory
        monView.classList.add('hidden');
        dirView.classList.remove('hidden');
        if (eqView) eqView.classList.add('hidden');

        setTabActive(nav1);
        try {
          const url = new URL(window.location.href);
          url.searchParams.delete('tab');
          window.history.replaceState({}, '', url);
        } catch (e) { }
      }

      if (window.lucide && window.lucide.createIcons) {
        window.lucide.createIcons();
      }
    }





    // Toggle calendar view
    function toggleCalendarView() {
      const calendarView = document.getElementById('calendarView');
      const gridView = document.getElementById('facilitiesGridView');
      const toggleText = document.getElementById('calendarToggleText');

      isCalendarView = !isCalendarView;

      if (isCalendarView) {
        calendarView.classList.remove('hidden');
        gridView.classList.add('hidden');
        toggleText.textContent = 'Calendar View';
        loadFacilityCalendar();
      } else {
        calendarView.classList.add('hidden');
        gridView.classList.remove('hidden');
        toggleText.textContent = 'Calendar View';
      }
    }

    // Toggle view mode (grid/list)
    function toggleViewMode() {
      const toggleBtn = document.getElementById('viewToggleBtn');
      const grid = document.querySelector('#facilitiesGridView .grid');
      const facilityCards = document.querySelectorAll('.facility-card');

      // Toggle between grid and list
      currentViewMode = currentViewMode === 'grid' ? 'list' : 'grid';

      if (currentViewMode === 'grid') {
        // Switch to grid view
        grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6';

        // Update button state
        toggleBtn.innerHTML = '<i data-lucide="list" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer" style="display: inline-block;"></i><span class="fallback-icon" style="display: none;">☰</span>';
        toggleBtn.setAttribute('title', 'Switch to list view');
        toggleBtn.setAttribute('aria-label', 'Switch to list view');
        toggleBtn.setAttribute('aria-pressed', 'false');

        // Remove list-view class from all cards
        facilityCards.forEach(card => {
          card.classList.remove('list-view');
        });
      } else {
        // Switch to list view
        grid.className = 'grid grid-cols-1 gap-3';

        // Update button state
        toggleBtn.innerHTML = '<i data-lucide="grid-3x3" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer" style="display: inline-block;"></i><span class="fallback-icon" style="display: none;">⊞</span>';
        toggleBtn.setAttribute('title', 'Switch to grid view');
        toggleBtn.setAttribute('aria-label', 'Switch to grid view');
        toggleBtn.setAttribute('aria-pressed', 'true');

        // Add list-view class to all cards
        facilityCards.forEach(card => {
          card.classList.add('list-view');
        });
      }

      // Recreate icons for the new button content
      lucide.createIcons();

      // Add fallback icon handling
      setTimeout(() => {
        const icon = toggleBtn.querySelector('i[data-lucide]');
        const fallback = toggleBtn.querySelector('.fallback-icon');
        if (icon && !icon.querySelector('svg')) {
          // Lucide icon failed to load, show fallback
          if (fallback) {
            icon.style.display = 'none';
            fallback.style.display = 'inline-block';
          }
        }
      }, 100);

      // Save preference to localStorage
      localStorage.setItem('facilityView', currentViewMode);
    }

    // Load facility calendar
    function loadFacilityCalendar() {
      const calendarContainer = document.getElementById('facilityCalendar');
      const selectedFacility = document.getElementById('calendarFacilityFilter')?.value || '';

      // Show loading state
      calendarContainer.innerHTML = `
        <div class="text-center py-12">
          <div class="loading loading-spinner loading-lg"></div>
          <p class="mt-4 text-gray-600">Loading calendar...</p>
        </div>
      `;

      // Simulate calendar loading (replace with actual calendar implementation)
      setTimeout(() => {
        calendarContainer.innerHTML = `
          <div class="bg-gray-50 rounded-lg p-8 text-center">
            <i data-lucide="calendar-days" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Calendar View</h3>
            <p class="text-gray-500 text-sm mb-4">Calendar functionality will be implemented here</p>
            <p class="text-xs text-gray-400">Selected Facility: ${selectedFacility || 'All Facilities'}</p>
          </div>
        `;
        lucide.createIcons();
      }, 1000);
    }

    // Export facilities data
    function exportFacilities() {
      // Create CSV data
      const facilities = Array.from(document.querySelectorAll('[id^="facility-card-"]:not([style*="display: none"])'))
        .map(card => {
          const data = getFacilityData(card);
          return {
            name: data.name,
            location: data.location,
            status: data.status,
            capacity: data.capacity
          };
        });

      const csvContent = [
        ['Name', 'Location', 'Status', 'Capacity'],
        ...facilities.map(f => [f.name, f.location, f.status, f.capacity])
      ].map(row => row.map(cell => `"${cell}"`).join(',')).join('\n');

      // Download CSV
      const blob = new Blob([csvContent], { type: 'text/csv' });
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `facilities-export-${new Date().toISOString().split('T')[0]}.csv`;
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      window.URL.revokeObjectURL(url);

      showToast('Facilities data exported successfully!', 'success');
    }

    // Export monitoring data as PDF
    function exportMonitoringPdf() {
      // Create a form to submit the request
      const form = document.createElement('form');
      form.method = 'GET';
      form.action = '{{ route("facilities.monitoring.export_pdf") }}';
      form.target = '_blank';

      // Add any necessary parameters
      const params = new URLSearchParams();
      params.append('_token', '{{ csrf_token() }}');

      // Add form data to the form
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = '_token';
      input.value = '{{ csrf_token() }}';
      form.appendChild(input);

      // Append form to body and submit
      document.body.appendChild(form);
      form.submit();
      document.body.removeChild(form);

      showToast('Monitoring report is being generated...', 'info');
    }

    // Initialize everything when page loads
    document.addEventListener('DOMContentLoaded', function () {
      updateDateTime();

      // Close dropdowns when clicking outside
      document.addEventListener('click', function (e) {
        const openedDetails = document.querySelectorAll('details[open]');
        if (openedDetails.length > 0) {
          openedDetails.forEach(details => {
            if (!details.contains(e.target)) {
              details.removeAttribute('open');
            }
          });
        }
      });

      // Initialize view mode from localStorage or default to grid
      const savedView = localStorage.getItem('facilityView') || 'grid';
      currentViewMode = savedView;

      // Preload equipment details so cards are ready when tab opens
      try { if (typeof loadEquipmentDetails === 'function') loadEquipmentDetails(); } catch (e) { }

      // Initialize facilities tabs default to directory
      if (typeof facilityShowTab === 'function') {
        facilityShowTab('directory');
      }

      // Pre-load monitoring data so it's ready when tab is clicked
      loadFacilitiesMonitoring();

      // Notification function (GLOBAL SCOPE)
      // Use global showNotification from soliera_js if available, otherwise define local one with progress bar
      if (typeof window.showNotification === 'undefined' || window.showNotification.toString().indexOf('progressBar') === -1) {
        window.showNotification = function (message, type = 'info', duration = 3000) {
          // Remove any existing notification progress style if it exists
          if (!document.getElementById('notification-progress-style')) {
            const style = document.createElement('style');
            style.id = 'notification-progress-style';
            style.textContent = `
              @keyframes progressBar {
                from {
                  width: 100%;
                }
                to {
                  width: 0%;
                }
              }
              @keyframes slideInRight {
                from {
                  transform: translateX(100%);
                  opacity: 0;
                }
                to {
                  transform: translateX(0);
                  opacity: 1;
                }
              }
            `;
            document.head.appendChild(style);
          }

          // Create notification element
          const notification = document.createElement('div');
          const alertType = type === 'error' ? 'error' : type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'info';
          notification.className = `alert alert-${alertType} fixed bottom-4 right-4 z-[9999] max-w-sm shadow-lg relative overflow-hidden`;
          notification.style.cssText = 'position: fixed; bottom: 1rem; right: 1rem; z-index: 9999; max-width: 24rem; animation: slideInRight 0.3s ease-out;';

          // Set icon based on type
          const iconMap = {
            'success': 'check-circle',
            'error': 'alert-circle',
            'warning': 'alert-triangle',
            'info': 'info'
          };
          const icon = iconMap[type] || 'info';

          notification.innerHTML = `
            <div class="flex items-center gap-2 px-4 py-3">
              <i data-lucide="${icon}" class="w-5 h-5"></i>
              <span>${message}</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-black/20">
              <div class="notification-progress h-full bg-white/50" style="width: 100%; animation: progressBar ${duration}ms linear forwards;"></div>
            </div>
          `;

          document.body.appendChild(notification);

          // Force reflow to ensure animation starts
          notification.offsetHeight;

          // Initialize Lucide icons
          if (window.lucide && window.lucide.createIcons) {
            window.lucide.createIcons();
          }

          // Auto remove after duration
          setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s ease-out';
            setTimeout(() => {
              if (notification.parentNode) {
                notification.remove();
              }
            }, 300);
          }, duration);
        };
      }

      // Complete request function (mark as completed and free facility)
      window.completeRequest = async function (requestId) {
        if (!confirm('Are you sure you want to mark this request as completed? This will free up the facility.')) {
          return;
        }

        try {
          const response = await fetch(`/facility_reservations/${requestId}/complete`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          const data = await response.json();

          if (data.success) {
            showNotification('Request completed successfully! Email notification sent.', 'success');
            // Reload monitoring data to update the display
            loadFacilitiesMonitoring();
            // Refresh facility dropdown if on landing page
            if (typeof refreshFacilityDropdown === 'function') {
              refreshFacilityDropdown();
            }
          } else {
            showNotification(data.message || 'Failed to complete request', 'error');
          }
        } catch (error) {
          console.error('Error completing request:', error);
          showNotification('Error completing request', 'error');
        }
      }

      // Equipment details fetch -> render as cards
      async function loadEquipmentDetails() {
        try {
          const res = await fetch('{{ route('facilities.equipment.details') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
          const data = await res.json();
          if (!data.success) return;
          const wrap = document.getElementById('equip-cards');
          if (!wrap) return;
          wrap.innerHTML = '';
          const items = data.items || [];
          const empty = document.getElementById('equip-empty');
          let renderItems = items;
          if (renderItems.length === 0) {
            wrap.classList.remove('hidden');
            if (empty) empty.classList.add('hidden');
            renderItems = [
              { equipment_item: 'Vacuum cleaners (upright, canister, robotic)', equipment_quantity: null, id: 0, department: 'Housekeeping', priority: 'low', status: 'catalog', requested_datetime: null, location: '', contact_name: '', contact_email: '' },
              { equipment_item: 'Floor polishing/buffing machines', equipment_quantity: null, id: 0, department: 'Housekeeping', priority: 'low', status: 'catalog', requested_datetime: null, location: '', contact_name: '', contact_email: '' },
              { equipment_item: 'Laundry equipment (washing machines, dryers, steam irons)', equipment_quantity: null, id: 0, department: 'Housekeeping', priority: 'low', status: 'catalog', requested_datetime: null, location: '', contact_name: '', contact_email: '' },
              { equipment_item: 'Cleaning carts / trolleys', equipment_quantity: null, id: 0, department: 'Housekeeping', priority: 'low', status: 'catalog', requested_datetime: null, location: '', contact_name: '', contact_email: '' },
              { equipment_item: 'Linen storage racks', equipment_quantity: null, id: 0, department: 'Housekeeping', priority: 'low', status: 'catalog', requested_datetime: null, location: '', contact_name: '', contact_email: '' },
              { equipment_item: 'Disinfecting sprayers', equipment_quantity: null, id: 0, department: 'Housekeeping', priority: 'low', status: 'catalog', requested_datetime: null, location: '', contact_name: '', contact_email: '' },
              { equipment_item: 'Housekeeping radios / communication devices', equipment_quantity: null, id: 0, department: 'Housekeeping', priority: 'low', status: 'catalog', requested_datetime: null, location: '', contact_name: '', contact_email: '' },
            ];
          } else {
            wrap.classList.remove('hidden');
            if (empty) empty.classList.add('hidden');
          }
          renderItems.forEach(it => {
            const statusBadge = it.status === 'approved' ? 'badge-success' : (it.status === 'pending' ? 'badge-warning' : 'badge-neutral');
            const priBadge = it.priority === 'urgent' || it.priority === 'high' ? 'badge-error' : (it.priority === 'medium' ? 'badge-warning' : 'badge-success');
            const card = document.createElement('div');
            card.className = 'facility-card';
            card.innerHTML = `
              <div class="facility-card-body">
                <div class="flex justify-between items-start mb-2">
                  <h3 class="facility-card-title">${it.equipment_item || 'Equipment'}</h3>
                  <div class="flex items-center gap-2">
                    <span class="badge ${statusBadge}">${it.status === 'catalog' ? 'Catalog' : ((it.status || '').charAt(0).toUpperCase() + (it.status || '').slice(1))}</span>
                    <span class="badge ${priBadge}">${(it.priority || '').charAt(0).toUpperCase() + (it.priority || '').slice(1)}</span>
                  </div>
                </div>
                <div class="mb-3 space-y-2">
                  <div class="meta-row">
                    ${it.id ? `<div class=\"meta-item\"><i data-lucide=\"hash\" class=\"w-4 h-4\"></i><span>#${String(it.id).padStart(6, '0')}</span></div>` : ''}
                    <div class="meta-item"><i data-lucide="users" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i><span>${it.department || ''}</span></div>
                    <div class="meta-item"><i data-lucide="box" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i><span>Qty: ${it.equipment_quantity ?? '—'}</span></div>
                  </div>
                  <div class="meta-row">
                    <div class="meta-item"><i data-lucide="calendar" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i><span>${it.requested_datetime ? new Date(it.requested_datetime).toLocaleString() : '—'}</span></div>
                    <div class="meta-item"><i data-lucide="map-pin" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i><span>${it.location || ''}</span></div>
                  </div>
                  <div class="meta-row">
                    <div class="meta-item"><i data-lucide="user" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i><span>${it.contact_name || ''}</span></div>
                    <div class="meta-item"><i data-lucide="mail" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer"></i><span>${it.contact_email || ''}</span></div>
                  </div>
                </div>
              </div>`;
            wrap.appendChild(card);
          });
          const totalEl = document.getElementById('equip-total');
          if (totalEl) totalEl.textContent = `${items.length || renderItems.length} items`;
          if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
        } catch (e) { console.error(e); }
      }

      // Set up toggle button event listeners
      const toggleBtn = document.getElementById('viewToggleBtn');
      if (toggleBtn) {
        // Click handler
        toggleBtn.addEventListener('click', toggleViewMode);

        // Keyboard handler (Enter/Space)
        toggleBtn.addEventListener('keydown', function (e) {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleViewMode();
          }
        });

        // Initialize button state based on saved preference
        if (currentViewMode === 'list') {
          toggleBtn.innerHTML = '<i data-lucide="grid-3x3" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer" style="display: inline-block;"></i><span class="fallback-icon" style="display: none;">⊞</span>';
          toggleBtn.setAttribute('title', 'Switch to grid view');
          toggleBtn.setAttribute('aria-label', 'Switch to grid view');
          toggleBtn.setAttribute('aria-pressed', 'true');
        } else {
          toggleBtn.innerHTML = '<i data-lucide="list" class="text-lg md:text-xl lg:text-2xl transition-all duration-300 ease-in-out hover:text-accent cursor-pointer" style="display: inline-block;"></i><span class="fallback-icon" style="display: none;">☰</span>';
          toggleBtn.setAttribute('title', 'Switch to list view');
          toggleBtn.setAttribute('aria-label', 'Switch to list view');
          toggleBtn.setAttribute('aria-pressed', 'false');
        }

        // Recreate icons after updating innerHTML
        lucide.createIcons();

        // Ensure button is visible and has fallback
        toggleBtn.style.display = 'inline-flex';
        toggleBtn.style.visibility = 'visible';
        toggleBtn.style.opacity = '1';

        // Add fallback icon handling
        setTimeout(() => {
          const icon = toggleBtn.querySelector('i[data-lucide]');
          const fallback = toggleBtn.querySelector('.fallback-icon');
          if (icon && !icon.querySelector('svg')) {
            // Lucide icon failed to load, show fallback
            if (fallback) {
              icon.style.display = 'none';
              fallback.style.display = 'inline-block';
            }
          }
        }, 100);

        // Apply the saved view mode
        const grid = document.querySelector('#facilitiesGridView .grid');
        const facilityCards = document.querySelectorAll('.facility-card');

        if (currentViewMode === 'list') {
          grid.className = 'grid grid-cols-1 gap-3';
          facilityCards.forEach(card => {
            card.classList.add('list-view');
          });
        } else {
          grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6';
          facilityCards.forEach(card => {
            card.classList.remove('list-view');
          });
        }
      }


      // Update time every second
      setInterval(updateDateTime, 1000);

      // Modal handlers
      const modal = document.getElementById('createFacilityModal');
      const openBtns = document.querySelectorAll('#openCreateFacilityModal, .openCreateFacilityModalBtn');
      const closeBtn = document.getElementById('closeCreateFacilityModal');
      const cancelBtn = document.getElementById('cancelCreateFacility');
      const createForm = document.getElementById('createFacilityForm');
      const createSubmitBtn = document.getElementById('createFacilitySubmitBtn');
      const createSubmitText = document.getElementById('createFacilitySubmitText');
      const createNameInput = document.getElementById('create_facility_name');
      const createFacilityTypeInput = document.getElementById('create_facility_type');
      const createFacilityTypeLabel = document.getElementById('createFacilityTypeLabel');
      const createFacilityTypeDropdown = document.getElementById('createFacilityTypeDropdown');
      const createFacilityStatusInput = document.getElementById('create_facility_status_value');
      const createFacilityStatusLabel = document.getElementById('createFacilityStatusLabel');
      const createFacilityStatusDropdown = document.getElementById('createFacilityStatusDropdown');

      const focusableSelector = 'a[href], area[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
      let lastActiveElement = null;

      function getFocusableElements() {
        if (!modal) return [];
        const dialog = modal.querySelector('.modal-box');
        if (!dialog) return [];
        return Array.from(dialog.querySelectorAll(focusableSelector)).filter(el => el.offsetParent !== null);
      }

      function openModal() {
        lastActiveElement = document.activeElement;
        modal.classList.add('modal-open');
        modal.setAttribute('aria-hidden', 'false');

        if (createFacilityTypeDropdown) createFacilityTypeDropdown.removeAttribute('open');
        if (createFacilityStatusDropdown) createFacilityStatusDropdown.removeAttribute('open');

        window.requestAnimationFrame(() => {
          if (createNameInput) {
            createNameInput.focus();
          } else {
            const focusables = getFocusableElements();
            if (focusables[0]) focusables[0].focus();
          }
        });
      }
      function closeModal() {
        modal.classList.remove('modal-open');
        modal.setAttribute('aria-hidden', 'true');
        if (lastActiveElement && typeof lastActiveElement.focus === 'function') {
          lastActiveElement.focus();
        }
      }

      if (openBtns && openBtns.length) {
        openBtns.forEach(btn => btn.addEventListener('click', openModal));
      }
      if (closeBtn) closeBtn.addEventListener('click', closeModal);
      if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
      if (modal) modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });

      document.addEventListener('keydown', function (e) {
        if (!modal || !modal.classList.contains('modal-open')) return;

        if (e.key === 'Escape') {
          e.preventDefault();
          closeModal();
          return;
        }

        if (e.key !== 'Tab') return;
        const focusables = getFocusableElements();
        if (!focusables.length) return;

        const first = focusables[0];
        const last = focusables[focusables.length - 1];

        if (e.shiftKey && document.activeElement === first) {
          e.preventDefault();
          last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
          e.preventDefault();
          first.focus();
        }
      });

      if (createForm) {
        createForm.addEventListener('submit', function () {
          if (createSubmitBtn) {
            createSubmitBtn.disabled = true;
            createSubmitBtn.classList.add('opacity-70');
          }
          if (cancelBtn) cancelBtn.disabled = true;
          if (closeBtn) closeBtn.disabled = true;
          if (createSubmitText) createSubmitText.textContent = 'Creating...';
        });
      }

      function applyDropdownSelection(wrapper, optionSelector, value) {
        if (!wrapper) return;
        wrapper.querySelectorAll(optionSelector).forEach(btn => {
          const isSelected = (btn.getAttribute('data-value') || '') === (value || '');
          btn.classList.toggle('bg-[#F5B301]', isSelected);
          btn.classList.toggle('text-gray-900', isSelected);
          btn.classList.toggle('font-medium', isSelected);

          const checkEl = btn.querySelector('svg.lucide-check, i[data-lucide="check"], svg[data-lucide="check"], svg[data-icon="check"]');
          if (checkEl) {
            checkEl.classList.toggle('opacity-100', isSelected);
            checkEl.classList.toggle('opacity-0', !isSelected);
          }
        });
      }

      function initCreateFacilityDropdowns() {
        const typeVal = (createFacilityTypeInput && createFacilityTypeInput.value) ? createFacilityTypeInput.value : 'Facility';
        if (createFacilityTypeLabel) createFacilityTypeLabel.textContent = typeVal;
        applyDropdownSelection(createFacilityTypeDropdown, '.create-facility-type-option', typeVal);

        const statusVal = (createFacilityStatusInput && createFacilityStatusInput.value) ? createFacilityStatusInput.value : 'available';
        if (createFacilityStatusLabel) createFacilityStatusLabel.textContent = statusVal;
        applyDropdownSelection(createFacilityStatusDropdown, '.create-facility-status-option', statusVal);

        document.querySelectorAll('.create-facility-type-option').forEach(btn => {
          btn.addEventListener('click', () => {
            const v = btn.getAttribute('data-value') || 'Facility';
            if (createFacilityTypeInput) createFacilityTypeInput.value = v;
            if (createFacilityTypeLabel) createFacilityTypeLabel.textContent = v;
            applyDropdownSelection(createFacilityTypeDropdown, '.create-facility-type-option', v);
            if (createFacilityTypeDropdown) createFacilityTypeDropdown.removeAttribute('open');
          });
        });

        document.querySelectorAll('.create-facility-status-option').forEach(btn => {
          btn.addEventListener('click', () => {
            const v = btn.getAttribute('data-value') || 'available';
            if (createFacilityStatusInput) createFacilityStatusInput.value = v;
            if (createFacilityStatusLabel) createFacilityStatusLabel.textContent = v;
            applyDropdownSelection(createFacilityStatusDropdown, '.create-facility-status-option', v);
            if (createFacilityStatusDropdown) createFacilityStatusDropdown.removeAttribute('open');
          });
        });

        if (window.lucide && window.lucide.createIcons) {
          window.lucide.createIcons();
        }

        // Re-apply selection after icons are converted to SVG
        window.requestAnimationFrame(() => {
          applyDropdownSelection(createFacilityTypeDropdown, '.create-facility-type-option', typeVal);
          applyDropdownSelection(createFacilityStatusDropdown, '.create-facility-status-option', statusVal);
        });
      }

      initCreateFacilityDropdowns();

      if (modal && modal.getAttribute('data-open-on-load') === 'true') {
        openModal();
      }

      // Edit modal handlers
      const editModal = document.getElementById('editFacilityModal');
      const closeEditBtn = document.getElementById('closeEditFacilityModal');
      const cancelEditBtn = document.getElementById('cancelEditFacility');
      const editForm = document.getElementById('editFacilityForm');

      function openEditModal() { editModal.classList.add('modal-open'); }
      function closeEditModal() { editModal.classList.remove('modal-open'); }

      document.querySelectorAll('.openEditFacilityBtn').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.getAttribute('data-id');
          const name = btn.getAttribute('data-name') || '';
          const location = btn.getAttribute('data-location') || '';
          const description = btn.getAttribute('data-description') || '';
          const status = btn.getAttribute('data-status') || 'available';

          document.getElementById('edit_name').value = name;
          document.getElementById('edit_location').value = location;
          document.getElementById('edit_description').value = description;
          document.getElementById('edit_status').value = status;

          // Make status field optional for occupied facilities
          const statusSelect = document.getElementById('edit_status');
          if (status === 'occupied') {
            statusSelect.required = false;
            statusSelect.classList.remove('border-red-500');
          } else {
            statusSelect.required = true;
          }

          editForm.setAttribute('action', `{{ url('facilities') }}/${id}`);

          // Try to preload current image using facility-specific path only
          const candidates = [
            `{{ url('storage/facilities') }}/${id}/cover.jpg`,
            `{{ url('storage/facilities') }}/${id}/cover.png`,
            `{{ url('storage/facilities') }}/${id}/cover.jpeg`,
            `{{ url('storage/facilities') }}/${id}/cover.webp`,
          ];
          const imgEl = document.getElementById('edit_image_preview');
          const removeInput = document.getElementById('edit_remove_image');
          removeInput.value = '0';
          // Probe images
          (async () => {
            let found = '';
            for (const url of candidates) {
              try {
                const head = await fetch(url, { method: 'HEAD' });
                if (head.ok) { found = url; break; }
              } catch (e) { }
            }
            if (found) {
              imgEl.src = found;
              imgEl.style.display = 'block';
            } else {
              imgEl.removeAttribute('src');
              imgEl.style.display = 'none';
            }
          })();

          openEditModal();
        });
      });

      if (closeEditBtn) closeEditBtn.addEventListener('click', closeEditModal);
      if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeEditModal);
      if (editModal) editModal.addEventListener('click', function (e) { if (e.target === editModal) closeEditModal(); });

      // Image overlay controls
      const fileInput = document.getElementById('edit_cover_image');
      const imgPreview = document.getElementById('edit_image_preview');
      const removeHidden = document.getElementById('edit_remove_image');
      const btnEditImage = document.getElementById('btnEditImage');
      const btnViewImage = document.getElementById('btnViewImage');
      const btnRemoveImage = document.getElementById('btnRemoveImage');
      const btnCloseOverlay = document.getElementById('btnCloseOverlay');
      const fullImageModal = document.getElementById('fullImageModal');
      const fullImageEl = document.getElementById('fullImageEl');
      const closeFullImageModal = document.getElementById('closeFullImageModal');

      if (btnEditImage) btnEditImage.addEventListener('click', () => fileInput && fileInput.click());
      if (btnRemoveImage) btnRemoveImage.addEventListener('click', () => {
        removeHidden.value = '1';
        imgPreview.style.display = 'none';
        fileInput.value = '';
      });
      if (btnCloseOverlay) btnCloseOverlay.addEventListener('click', (e) => {
        // Just closes overlay by forcing mouseout via blur; overlay hides on hover
        e.stopPropagation();
        (document.activeElement && document.activeElement.blur && document.activeElement.blur());
      });
      let wasFromEdit = false;
      function openFullImage(src, fromEdit = false) {
        if (!src) return;
        fullImageEl.src = src;
        fullImageModal.classList.add('modal-open');
        if (fromEdit) {
          wasFromEdit = true;
          editModal.classList.remove('modal-open');
        }
        lucide.createIcons();
      }
      if (btnViewImage) btnViewImage.addEventListener('click', () => openFullImage(imgPreview.src, true));
      const imgWrap = document.getElementById('editImageWrap');
      if (imgWrap) imgWrap.addEventListener('click', (e) => {
        // Allow clicking the image area to open viewer (but not when clicking edit/remove buttons)
        const t = e.target;
        const isButton = t.closest && t.closest('.img-edit-btn');
        if (!isButton && imgPreview && imgPreview.src) openFullImage(imgPreview.src, true);
      });
      function closeFullImage() {
        fullImageModal.classList.remove('modal-open');
        if (wasFromEdit) {
          editModal.classList.add('modal-open');
          wasFromEdit = false;
        }
      }
      if (closeFullImageModal) closeFullImageModal.addEventListener('click', closeFullImage);
      if (fullImageModal) fullImageModal.addEventListener('click', function (e) { if (e.target === fullImageModal) closeFullImage(); });
      if (fileInput) fileInput.addEventListener('change', () => {
        if (fileInput.files && fileInput.files[0]) {
          removeHidden.value = '0';
          const url = URL.createObjectURL(fileInput.files[0]);
          imgPreview.src = url;
          imgPreview.style.display = 'block';
        }
      });

      // View modal handlers
      const viewModal = document.getElementById('viewFacilityModal');
      const closeViewBtn = document.getElementById('closeViewFacilityModal');
      function openViewModal() { viewModal.classList.add('modal-open'); }
      function closeViewModal() { viewModal.classList.remove('modal-open'); }
      if (closeViewBtn) closeViewBtn.addEventListener('click', closeViewModal);
      if (viewModal) viewModal.addEventListener('click', function (e) { if (e.target === viewModal) closeViewModal(); });

      document.querySelectorAll('.openViewFacilityBtn').forEach(btn => {
        btn.addEventListener('click', async () => {
          const id = btn.getAttribute('data-id');
          try {
            const res = await fetch(`{{ url('/facilities') }}/${id}/ajax`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) throw new Error('Failed to load');
            const data = await res.json();
            if (!data.success) throw new Error('Invalid response');
            const f = data.facility;
            document.getElementById('vf_name').textContent = f.name || 'Facility Details';
            const badge = document.getElementById('vf_status_badge');
            badge.textContent = (f.status || 'available').charAt(0).toUpperCase() + (f.status || 'available').slice(1);
            badge.className = `badge badge-lg ${f.status === 'available' ? 'badge-success' : (f.status === 'occupied' ? 'badge-error' : 'badge-warning')}`;
            // location
            const locWrap = document.getElementById('vf_location_wrap');
            if (f.location) { locWrap.classList.remove('hidden'); document.getElementById('vf_location').textContent = f.location; } else { locWrap.classList.add('hidden'); }
            // desc
            const descWrap = document.getElementById('vf_description_wrap');
            if (f.description) { descWrap.classList.remove('hidden'); document.getElementById('vf_description').textContent = f.description; } else { descWrap.classList.add('hidden'); }
            document.getElementById('vf_reservations_count').textContent = f.reservations_count ?? 0;
            document.getElementById('vf_updated_at').textContent = f.updated_at || '—';

            // recent reservations
            const recentWrap = document.getElementById('vf_recent_reservations');
            recentWrap.innerHTML = '';
            if (Array.isArray(f.recent_reservations) && f.recent_reservations.length) {
              f.recent_reservations.forEach(r => {
                const color = r.status === 'approved' ? 'emerald' : (r.status === 'denied' ? 'red' : 'amber');
                const div = document.createElement('div');
                div.className = 'border-l-4 p-3 rounded-r-md';
                div.style.borderColor = `var(--color-modern-teal)`;
                div.innerHTML = `
                  <div class="flex justify-between items-start">
                    <div>
                      <p class="font-semibold text-sm">${r.reserver}</p>
                      <p class="text-xs text-gray-500">${r.start_time} - ${r.end_time}</p>
                    </div>
                    <div class="badge badge-sm badge-outline">${(r.status || '').charAt(0).toUpperCase() + (r.status || '').slice(1)}</div>
                  </div>`;
                recentWrap.appendChild(div);
              });
            } else {
              const empty = document.createElement('div');
              empty.className = 'text-center py-6 text-gray-500 text-sm';
              empty.textContent = 'No recent reservations.';
              recentWrap.appendChild(empty);
            }

            lucide.createIcons();
            openViewModal();
          } catch (e) {
            console.error(e);
            alert('Failed to load facility details.');
          }
        });
      });

      // View Room Modal handlers (for API data)
      const viewRoomModal = document.getElementById('viewRoomModal');
      const closeViewRoomBtn = document.getElementById('closeViewRoomModal');

      function openViewRoomModal() {
        viewRoomModal.classList.add('modal-open');
        lucide.createIcons();
      }
      function closeViewRoomModal() {
        viewRoomModal.classList.remove('modal-open');
      }

      // Make closeViewRoomModal available globally
      window.closeViewRoomModal = closeViewRoomModal;

      if (closeViewRoomBtn) closeViewRoomBtn.addEventListener('click', closeViewRoomModal);
      if (viewRoomModal) viewRoomModal.addEventListener('click', function (e) { if (e.target === viewRoomModal) closeViewRoomModal(); });

      document.querySelectorAll('.openViewRoomBtn').forEach(btn => {
        btn.addEventListener('click', () => {
          const name = btn.getAttribute('data-name') || 'Facility';
          const type = btn.getAttribute('data-type') || 'Facility';
          const description = btn.getAttribute('data-description') || 'No description available.';
          const status = btn.getAttribute('data-status') || 'available';
          const capacity = btn.getAttribute('data-capacity') || '-';
          const amenities = btn.getAttribute('data-amenities') || '';
          const image = btn.getAttribute('data-image') || '';

          // Set modal content
          document.getElementById('vr_name').textContent = name;
          document.getElementById('vr_type').textContent = type;
          document.getElementById('vr_description').textContent = description;
          document.getElementById('vr_capacity').textContent = capacity + ' pax';

          // Set image
          const imgEl = document.getElementById('vr_image');
          if (image) {
            imgEl.src = image;
          } else {
            imgEl.src = 'https://placehold.co/400x300?text=' + encodeURIComponent(name);
          }

          // Set status badge
          const statusBadge = document.getElementById('vr_status_badge');
          statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
          statusBadge.className = 'badge badge-lg ' + (
            status === 'available' ? 'badge-success' :
              status === 'occupied' ? 'badge-error' :
                status === 'reserved' ? 'badge-warning' :
                  'badge-ghost'
          );

          // Set amenities
          const amenitiesEl = document.getElementById('vr_amenities');
          if (amenities && amenities.trim()) {
            const amenitiesList = amenities.split(',').map(a => a.trim()).filter(a => a);
            if (amenitiesList.length > 0) {
              amenitiesEl.innerHTML = amenitiesList.map(a =>
                `<span class="badge badge-outline badge-sm">${a}</span>`
              ).join('');
            } else {
              amenitiesEl.innerHTML = '<span class="badge badge-outline badge-sm">No amenities listed</span>';
            }
          } else {
            amenitiesEl.innerHTML = '<span class="badge badge-outline badge-sm">No amenities listed</span>';
          }

          openViewRoomModal();
        });
      });

      // Free facility functionality
      document.querySelectorAll('.freeFacilityBtn').forEach(btn => {
        btn.addEventListener('click', async () => {
          const id = btn.getAttribute('data-id');
          const name = btn.getAttribute('data-name') || 'this facility';

          if (confirm(`Are you sure you want to free up ${name}? This will make it available for new reservations.`)) {
            try {
              const response = await fetch(`/facilities/${id}/free`, {
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                  'Accept': 'application/json',
                  'X-Requested-With': 'XMLHttpRequest'
                }
              });

              const data = await response.json();

              if (data.success) {
                // Show success message
                showNotification(data.message, 'success');

                // Reload the page to update the facility status
                setTimeout(() => {
                  window.location.reload();
                }, 1000);
              } else {
                showNotification(data.message || 'Failed to free facility', 'error');
              }
            } catch (error) {
              console.error('Error freeing facility:', error);
              showNotification('Error freeing facility', 'error');
            }
          }
        });
      });

      // Delete facility functionality
      const deleteModal = document.getElementById('deleteConfirmModal');
      const closeDeleteBtn = document.getElementById('closeDeleteModal');
      const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
      const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

      function openDeleteModal() { deleteModal.classList.add('modal-open'); }
      function closeDeleteModal() { deleteModal.classList.remove('modal-open'); }

      if (closeDeleteBtn) closeDeleteBtn.addEventListener('click', closeDeleteModal);
      if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', closeDeleteModal);
      if (deleteModal) deleteModal.addEventListener('click', function (e) { if (e.target === deleteModal) closeDeleteModal(); });

      document.querySelectorAll('.deleteFacilityBtn').forEach(btn => {
        btn.addEventListener('click', function () {
          const facilityId = this.getAttribute('data-id');
          const facilityName = this.getAttribute('data-name');
          const facilityLocation = this.getAttribute('data-location');
          const facilityStatus = this.getAttribute('data-status');
          const reservationsCount = parseInt(this.getAttribute('data-reservations')) || 0;
          const deleteUrl = this.getAttribute('data-url');

          // Validate required data
          if (!facilityId || !facilityName || !deleteUrl) {
            console.error('Missing required facility data:', { facilityId, facilityName, deleteUrl });
            showToast('Error: Missing facility information. Please try again.', 'error');
            return;
          }

          // Populate modal with facility data
          const nameEl = document.getElementById('deleteFacilityName');
          const locationEl = document.getElementById('deleteFacilityLocation');
          const statusEl = document.getElementById('deleteFacilityStatus');
          const reservationsEl = document.getElementById('deleteFacilityReservations');

          if (nameEl) nameEl.textContent = facilityName;
          if (locationEl) locationEl.textContent = facilityLocation || 'No location specified';
          if (statusEl) statusEl.textContent = facilityStatus ? facilityStatus.charAt(0).toUpperCase() + facilityStatus.slice(1) : 'Unknown';
          if (reservationsEl) reservationsEl.textContent = reservationsCount;

          // Show warning if facility has reservations or is occupied
          const warningMessage = document.getElementById('deleteWarningMessage');
          if (warningMessage) {
            if (facilityStatus === 'occupied' || reservationsCount > 0) {
              warningMessage.classList.remove('hidden');
            } else {
              warningMessage.classList.add('hidden');
            }
          }

          // Reset delete button state
          const deleteBtnText = document.getElementById('deleteBtnText');
          if (deleteBtnText) deleteBtnText.textContent = 'Delete Facility';

          if (confirmDeleteBtn) {
            confirmDeleteBtn.disabled = false;
            confirmDeleteBtn.innerHTML = `
              <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
              <span id="deleteBtnText">Delete Facility</span>
            `;

            // Store data for deletion
            confirmDeleteBtn.setAttribute('data-url', deleteUrl);
            confirmDeleteBtn.setAttribute('data-facility-id', facilityId);
            confirmDeleteBtn.setAttribute('data-facility-name', facilityName);
          }

          lucide.createIcons();
          openDeleteModal();
        });
      });

      // Handle delete confirmation
      if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', async function () {
          const deleteUrl = this.getAttribute('data-url');
          const facilityId = this.getAttribute('data-facility-id');
          const facilityName = this.getAttribute('data-facility-name');

          // Validate required attributes
          if (!deleteUrl || !facilityId || !facilityName) {
            console.error('Missing required attributes for deletion:', { deleteUrl, facilityId, facilityName });
            showToast('Error: Missing facility information. Please try again.', 'error');
            return;
          }

          const facilityCard = document.getElementById('facility-card-' + facilityId);

          if (!facilityCard) {
            console.error('Facility card not found for ID:', facilityId);
            showToast('Error: Facility card not found. Please refresh the page and try again.', 'error');
            return;
          }

          // Show loading state
          this.disabled = true;
          this.innerHTML = `
            <i class="loading loading-spinner loading-sm mr-2"></i>
            <span>Deleting...</span>
          `;

          try {
            const response = await fetch(deleteUrl, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              }
            });

            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            if (data.success !== undefined && !data.success) {
              throw new Error(data.message || 'Delete failed');
            }

            // Success - close modal and animate card removal
            closeDeleteModal();

            // Show success toast
            showToast(`${facilityName} has been deleted successfully.`, 'success');

            // Animate card removal
            if (facilityCard) {
              facilityCard.style.transition = 'all 0.5s ease-out';
              facilityCard.style.opacity = '0';
              facilityCard.style.margin = '0';
              facilityCard.style.padding = '0';
              facilityCard.style.height = '0';
              facilityCard.style.overflow = 'hidden';

              setTimeout(() => {
                facilityCard.remove();

                // Update stats cards
                updateFacilityStats();


                // Check if no facilities left
                const remainingCards = document.querySelectorAll('.facility-card');
                if (remainingCards.length === 0) {
                  showEmptyState();
                }
              }, 500);
            }

          } catch (error) {
            console.error('Delete error:', error);

            // Reset button state
            this.disabled = false;
            this.innerHTML = `
              <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
              <span id="deleteBtnText">Delete Facility</span>
            `;
            lucide.createIcons();

            // Show error toast with more user-friendly message
            const errorMessage = error.message.includes('getAttribute')
              ? 'An unexpected error occurred. Please refresh the page and try again.'
              : error.message;
            showToast(`Failed to delete facility: ${errorMessage}`, 'error');
          }
        });
      }

      // Helper function to update facility stats
      function updateFacilityStats() {
        const totalFacilities = document.querySelectorAll('.facility-card').length;
        const availableFacilities = document.querySelectorAll('.facility-card .badge-success').length;
        const occupiedFacilities = document.querySelectorAll('.facility-card .badge-error').length;

        // Update facility count in header
        const facilityCountElement = document.getElementById('facilityCount');
        if (facilityCountElement) {
          facilityCountElement.textContent = totalFacilities;
        }

        // Update stats cards if they exist
        const totalCard = document.querySelector('.text-3xl.font-bold');
        if (totalCard) {
          totalCard.textContent = totalFacilities;
        }
      }

      // Helper function to show empty state
      function showEmptyState() {
        const grid = document.querySelector('#facilitiesGridView .grid');
        if (grid) {
          // Double-check that there are really no facilities
          const remainingCards = document.querySelectorAll('.facility-card');
          if (remainingCards.length === 0) {
            grid.innerHTML = `
            <div class="col-span-full text-center py-12">
              <i data-lucide="building" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
              <h3 class="text-lg font-semibold text-gray-600 mb-2">No Facilities Found</h3>
              <p class="text-gray-500 mb-6">Add your first facility to get started.</p>
              <button type="button" id="openCreateFacilityModal" class="btn btn-primary btn-md hover:btn-primary-focus transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Add Facility
              </button>
            </div>
          `;
            lucide.createIcons();
          }
        }
      }

      // Toast notification function - uses global showNotification
      function showToast(message, type = 'info', duration = 3000) {
        // Use global showNotification if available (Soliera theme), otherwise use local fallback
        if (typeof window.showNotification === 'function') {
          window.showNotification(message, type, duration);
          return;
        }

        // Fallback to simple alert if global function not available
        alert(message);
      }

      // Create toast container if it doesn't exist
      function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'fixed bottom-4 right-4 z-50 space-y-2';
        document.body.appendChild(container);
        return container;
      }

      // Real-time facility stats update function
      async function updateFacilityStats() {
        try {
          const response = await fetch('/api/facilities/stats', {
            method: 'GET',
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          if (!response.ok) {
            throw new Error('Failed to fetch facility stats');
          }

          const data = await response.json();

          if (data.success) {
            // Update the summary cards with new data
            const totalFacilitiesEl = document.getElementById('total-facilities');
            const availableFacilitiesEl = document.getElementById('available-facilities');
            const occupiedFacilitiesEl = document.getElementById('occupied-facilities');
            const totalReservationsEl = document.getElementById('total-reservations');

            if (totalFacilitiesEl) totalFacilitiesEl.textContent = data.stats.total_facilities;
            if (availableFacilitiesEl) availableFacilitiesEl.textContent = data.stats.available_facilities;
            if (occupiedFacilitiesEl) occupiedFacilitiesEl.textContent = data.stats.occupied_facilities;
            if (totalReservationsEl) totalReservationsEl.textContent = data.stats.total_reservations;

            // Add visual feedback for changes
            [totalFacilitiesEl, availableFacilitiesEl, occupiedFacilitiesEl, totalReservationsEl].forEach(el => {
              if (el) {
                // Removed scale animation for static cards
              }
            });

            // Also update individual facility cards if we have detailed data
            if (data.facilities) {
              data.facilities.forEach(facility => {
                updateFacilityCard(facility);
              });
            }
          }
        } catch (error) {
          console.error('Error updating facility stats:', error);
        }
      }

      // Update individual facility card status
      function updateFacilityCard(facility) {
        const card = document.getElementById('facility-card-' + facility.id);
        if (!card) return;

        // Update status badge
        const statusBadge = card.querySelector('.facility-status-badge .badge');
        if (statusBadge) {
          statusBadge.className = `badge badge-lg ${facility.status === 'available' ? 'badge-success' : (facility.status === 'occupied' ? 'badge-error' : 'badge-warning')}`;
          statusBadge.textContent = facility.status.charAt(0).toUpperCase() + facility.status.slice(1);
        }

        // Update status indicator dot
        const statusDot = card.querySelector('.w-2.h-2.rounded-full');
        if (statusDot) {
          statusDot.className = `w-2 h-2 rounded-full ${facility.status === 'available' ? 'bg-green-500' : (facility.status === 'occupied' ? 'bg-red-500' : 'bg-gray-400')}`;
          statusDot.title = facility.status.charAt(0).toUpperCase() + facility.status.slice(1);
        }

        // Update reservations count if available
        const reservationsCount = card.querySelector('[data-reservations-count]');
        if (reservationsCount && facility.reservations_count !== undefined) {
          reservationsCount.textContent = facility.reservations_count;
        }

        // Add visual feedback for status change
        // Removed scale animation for static cards
      }

      // Set up real-time updates every 5 seconds
      setInterval(updateFacilityStats, 5000);

      // Also update stats when the page becomes visible (user switches back to tab)
      document.addEventListener('visibilitychange', function () {
        if (!document.hidden) {
          updateFacilityStats();
        }
      });
    });
  </script>
</body>

</html>