<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Legal | Case Deck</title>
  @include('partials.favicon')
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @vite(['resources/css/app.css', 'resources/css/soliera.css', 'resources/js/app.js'])

  <style>
    /* CSS Variables for consistent styling */
    :root {
      --color-regal-navy: #F7A923;
      --color-charcoal-ink: #2C3E50;
      --color-snow-mist: #f3f4f6;
      --color-white: #ffffff;
      --color-modern-teal: #0d9488;
      --color-golden-ember: #E6940F;
      --color-danger-red: #dc2626;
      --color-button-secondary: #E6940F;
    }

    /* Force button primary to use orange-yellow */
    .btn.btn-primary {
      background-color: #F7A923 !important;
      border-color: #F7A923 !important;
      color: #2C3E50 !important;
    }

    .btn.btn-primary:hover {
      background-color: #E6940F !important;
      border-color: #E6940F !important;
    }

    /* SweetAlert2 Custom Styling */
    .swal2-popup {
      font-family: inherit;
      border-radius: 12px !important;
    }

    .swal2-confirm {
      background-color: #ef4444 !important;
      border: none !important;
      padding: 12px 24px !important;
      border-radius: 8px !important;
      font-weight: 600 !important;
      color: white !important;
      margin-right: 8px !important;
    }

    .swal2-cancel {
      background-color: #6b7280 !important;
      border: none !important;
      padding: 12px 24px !important;
      border-radius: 8px !important;
      font-weight: 600 !important;
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
    }

    /* Modal styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(4px);
    }

    .modal.modal-open {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .modal-box {
      background: white;
      border-radius: 12px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      max-height: 90vh;
      overflow-y: auto;
      animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
      from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    /* Form styling */
    .form-control {
      margin-bottom: 1rem;
    }

    .label {
      margin-bottom: 0.5rem;
    }

    .label-text {
      font-weight: 600;
      color: #374151;
    }

    .input,
    .select,
    .textarea {
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 0.75rem;
      transition: border-color 0.2s ease;
    }

    .input:focus,
    .select:focus,
    .textarea:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Select element styling */
    .select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
      background-position: right 0.5rem center;
      background-repeat: no-repeat;
      background-size: 1.5em 1.5em;
      padding-right: 2.5rem;
    }

    /* File upload zone styling */
    #uploadZone {
      transition: all 0.2s ease;
    }

    #uploadZone:hover {
      border-color: #3b82f6;
      background-color: #eff6ff;
    }

    /* Loading spinner */
    .loading {
      display: inline-block;
      width: 1rem;
      height: 1rem;
      border: 2px solid #f3f3f3;
      border-top: 2px solid #3b82f6;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
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
          <div class="toast toast-bottom toast-end">
            <div class="alert alert-success">
              <i data-lucide="check-circle" class="w-5 h-5"></i>
              <span>{{ session('success') }}</span>
            </div>
          </div>
        @endif

        @if(session('error'))
          <div class="toast toast-bottom toast-end">
            <div class="alert alert-error">
              <i data-lucide="alert-circle" class="w-5 h-5"></i>
              <span>{{ session('error') }}</span>
            </div>
          </div>
        @endif

        <!-- Page Header -->
        <div class="mb-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-xl bg-[#001F54] flex items-center justify-center">
                <i data-lucide="shield-alert" class="w-6 h-6 text-[#F7B32B]"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-800">Violation & Compliance Cases</h1>
                <p class="text-gray-500 text-sm">Track and manage employee violations and compliance issues</p>
              </div>
            </div>
            @if(auth()->user()->role === 'Administrator')
              <button onclick="openAddCaseModal()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#F7B32B] text-[#001F54] hover:bg-[#f5a623] transition-all shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Report Incident
              </button>
            @endif
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <!-- Total Cases -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">All Cases</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_cases'] ?? 0 }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="briefcase" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Completed Cases -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Completed</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['approved_cases'] ?? 0 }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Awaiting Review -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Awaiting Review</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['pending_cases'] ?? 0 }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="clock" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Not Approved -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Not Approved</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['declined_cases'] ?? 0 }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="x-circle" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>
        </div>





        <!-- Cases Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <!-- Table Header -->
          <div class="bg-[#001F54] px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
              <h3 class="text-lg font-semibold text-white flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                  <i data-lucide="briefcase" class="w-4 h-4 text-[#F7B32B]"></i>
                </div>
                <div>
                  <span>Legal Cases</span>
                  <p class="text-sm text-white/70 font-normal">{{ $cases->count() ?? 0 }} of
                    {{ $stats['total_cases'] ?? 0 }} cases
                  </p>
                </div>
              </h3>
              <div class="flex items-center gap-3">
                <!-- Search Field -->
                <div class="relative w-full sm:w-64">
                  <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4"></i>
                  </span>
                  <input type="text" id="caseSearchInput" placeholder="Search cases..."
                    class="w-full pl-10 pr-4 py-2 bg-white text-gray-800 rounded-lg border-0 text-sm focus:ring-2 focus:ring-blue-300 placeholder-gray-400">
                </div>

                <!-- Priority Filter Toggle (Icon-only) -->
                <div class="dropdown dropdown-end">
                  <button id="priorityFilterBtn" tabindex="0"
                    class="btn btn-xs sm:btn-sm bg-gradient-to-r from-[#F7B32B] to-[#f59e0b] text-gray-800 border-none hover:shadow-md transition-all flex items-center justify-center w-8 sm:w-10"
                    title="Filter by Priority">
                    <i data-lucide="filter" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                  </button>
                  <ul tabindex="0"
                    class="dropdown-content z-[30] menu p-2 shadow-xl bg-base-100 rounded-xl w-52 text-xs sm:text-sm border border-gray-100 mt-2">
                    <div class="px-4 py-2 border-b border-gray-50 mb-1">
                      <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Priority Type</span>
                    </div>
                    <li><a onclick="setPriorityFilter('')" class="hover:bg-gray-50 flex items-center gap-3 py-2.5">
                        <div class="w-2 h-2 rounded-full bg-gray-300"></div> All Priorities
                      </a></li>
                    <li><a onclick="setPriorityFilter('urgent')" class="hover:bg-red-50 flex items-center gap-3 py-2.5">
                        <div class="w-2 h-2 rounded-full bg-red-500"></div> Urgent
                      </a></li>
                    <li><a onclick="setPriorityFilter('high')"
                        class="hover:bg-orange-50 flex items-center gap-3 py-2.5">
                        <div class="w-2 h-2 rounded-full bg-orange-500"></div> High
                      </a></li>
                    <li><a onclick="setPriorityFilter('medium')"
                        class="hover:bg-amber-50 flex items-center gap-3 py-2.5">
                        <div class="w-2 h-2 rounded-full bg-amber-500"></div> Medium
                      </a></li>
                    <li><a onclick="setPriorityFilter('low')"
                        class="hover:bg-emerald-50 flex items-center gap-3 py-2.5">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div> Low
                      </a></li>
                  </ul>
                </div>
                <input type="hidden" id="priorityFilterValue" value="">
              </div>
            </div>
          </div>

          <!-- Table -->
          <div class="overflow-x-auto">
            <table class="table w-full">
              <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                  <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">#
                  </th>
                  <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Case
                    Information</th>
                  <th class="text-center py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">
                    Type</th>
                  <th class="text-center py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-36">
                    Person Involved</th>
                  <th class="text-center py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">
                    Incident Date</th>
                  <th class="text-center py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">
                    Status</th>
                  <th class="text-center py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">
                    Priority</th>
                  <th class="text-center py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">
                    Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                @forelse($cases ?? collect() as $index => $case)
                  <tr class="hover:bg-gray-50/50 transition-colors duration-200" data-case-id="{{ $case->id }}"
                    data-priority="{{ strtolower($case->priority ?? 'medium') }}">
                    <!-- ID Column -->
                    <td class="py-3 px-4">
                      <span class="text-sm font-medium text-gray-400">#{{ $index + 1 }}</span>
                    </td>

                    <!-- Case Information Column -->
                    <td class="py-3 px-4">
                      <div class="flex items-center gap-3">
                        <!-- Case Icon -->
                        <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center flex-shrink-0">
                          <span class="text-sm font-bold text-[#F7B32B]">
                            {{ strtoupper(substr($case->case_title ?? 'UC', 0, 2)) }}
                          </span>
                        </div>

                        <!-- Case Info -->
                        <div class="min-w-0">
                          <h4 class="font-medium text-gray-800 text-sm truncate max-w-[200px]">
                            @php
                              $displayTitle = $case->case_title ?? 'Untitled Case';
                              if ($case->case_type === 'visitor_violation') {
                                // Strip name from title if it follows "Visitor Violation - Name" pattern
                                $displayTitle = preg_replace('/(\s*[\-\–\—]\s*).*$/u', '', $displayTitle);
                              }
                            @endphp
                            {{ $displayTitle }}
                          </h4>
                          <p class="text-xs text-gray-400">#{{ $case->case_number ?? 'LC-2025-0000' }}</p>
                        </div>
                      </div>
                    </td>

                    <!-- Type Column -->
                    <td class="py-4 px-4 text-center">
                      @if($case->case_type)
                        @php
                          $violationTypes = [
                            'theft' => 'Theft',
                            'hr_policy_violation' => 'HR Policy',
                            'hr_policy' => 'HR Policy',
                            'workplace_harassment' => 'Harassment',
                            'harassment' => 'Harassment',
                            'fraud' => 'Fraud',
                            'safety_violation' => 'Safety',
                            'safety' => 'Safety',
                            'insubordination' => 'Insubordination',
                            'attendance_violation' => 'Attendance',
                            'attendance' => 'Attendance',
                            'confidentiality_breach' => 'Confidentiality',
                            'confidentiality' => 'Confidentiality',
                            'property_damage' => 'Property Damage',
                            'property' => 'Property Damage',
                            'facility_damage' => 'Facility Damage',
                            'guest_complaint' => 'Guest Complaint',
                            'complaint' => 'Guest Complaint',
                            'regulatory_violation' => 'Regulatory',
                            'regulatory' => 'Regulatory',
                            'violation' => 'Policy Violation',
                            'visitor_violation' => 'Visitor violation',
                            'other' => 'Other'
                          ];
                          $displayType = $violationTypes[$case->case_type] ?? ucfirst(str_replace('_', ' ', $case->case_type));
                        @endphp
                        <span
                          class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                          {{ $displayType }}
                        </span>
                      @else
                        <span class="text-xs text-gray-400">Not specified</span>
                      @endif
                    </td>

                    <!-- Person Involved Column -->
                    <td class="py-4 px-4 text-center">
                      @if($case->employee_involved)
                        <span class="text-sm text-gray-700">{{ $case->employee_involved }}</span>
                      @elseif($case->visitor)
                        <span class="text-sm text-gray-700">{{ $case->visitor->name }}</span>
                      @else
                        <span class="text-xs text-gray-400">Not specified</span>
                      @endif
                    </td>

                    <!-- Incident Date Column -->
                    <td class="py-4 px-4 text-center">
                      @if($case->incident_date)
                        <span
                          class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($case->incident_date)->format('M d, Y') }}</span>
                      @else
                        <span class="text-xs text-gray-400">—</span>
                      @endif
                    </td>

                    <!-- Status Column -->
                    <td class="py-4 px-4 text-center">
                      @php
                        $statusConfig = [
                          'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'clock', 'label' => 'Pending'],
                          'ongoing' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'play-circle', 'label' => 'Ongoing'],
                          'completed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'check-circle', 'label' => 'Completed'],
                          'awaiting_review' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'icon' => 'clock', 'label' => 'Awaiting Review'],
                          'rejected' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'x-circle', 'label' => 'Rejected'],
                          'active' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'play-circle', 'label' => 'Active'],
                          'on_hold' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200', 'icon' => 'pause-circle', 'label' => 'On Hold'],
                          'escalated' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon' => 'arrow-up-circle', 'label' => 'Escalated']
                        ];
                        $status = $statusConfig[$case->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-200', 'icon' => 'help-circle', 'label' => ucfirst($case->status)];
                      @endphp
                      <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }} border {{ $status['border'] }}">
                        <i data-lucide="{{ $status['icon'] }}" class="w-3.5 h-3.5"></i>
                        {{ $status['label'] }}
                      </span>
                    </td>

                    <!-- Priority Column -->
                    <td class="py-4 px-4 text-center">
                      @php
                        $priority = $case->priority ?? 'medium';
                        $priorityConfig = [
                          'urgent' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'label' => 'Urgent'],
                          'high' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200', 'label' => 'High'],
                          'medium' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => 'Medium'],
                          'low' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'Low']
                        ];
                        $priorityInfo = $priorityConfig[$priority] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-200', 'label' => ucfirst($priority)];
                      @endphp
                      <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $priorityInfo['bg'] }} {{ $priorityInfo['text'] }} border {{ $priorityInfo['border'] }}">
                        {{ $priorityInfo['label'] }}
                      </span>
                    </td>

                    <!-- Actions Column -->
                    <td class="py-4 px-4">
                      <div class="flex items-center justify-center gap-1">
                        <!-- Review Button -->
                        <a href="{{ route('legal.cases.review', $case->id ?? 1) }}"
                          class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110 hover:shadow-md"
                          style="background: linear-gradient(135deg, #F7A923 0%, #E6940F 100%); color: #1f2937;"
                          title="Review Case">
                          <i data-lucide="search" class="w-4 h-4"></i>
                        </a>

                        <!-- Delete Button -->
                        <button onclick="deleteCase({{ $case->id ?? 1 }})"
                          class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110 hover:shadow-md bg-gray-100 text-gray-600 hover:bg-red-100 hover:text-red-600"
                          title="Delete Case">
                          <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="py-16 text-center">
                      <div class="flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                          <i data-lucide="shield-check" class="w-10 h-10 text-blue-300"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No Violation Cases Found</h3>
                        <p class="text-gray-500 text-sm mb-4">Track employee violations and compliance issues</p>
                        @if(auth()->user()->role === 'Administrator')
                          <button onclick="openAddCaseModal()"
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-[#F7B32B] text-[#001F54] hover:bg-[#f5a623] transition-all text-sm font-medium">
                            <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                            Report Incident
                          </button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          @if(isset($cases) && $cases->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
              {{ $cases->links() }}
            </div>
          @endif
        </div>
      </main>
    </div>
  </div>

  <!-- Add New Case Modal -->
  <div id="addCaseModal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl bg-white text-gray-800 rounded-xl shadow-2xl"
      onclick="event.stopPropagation()">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
            <i data-lucide="shield-alert" class="w-6 h-6 text-red-600"></i>
          </div>
          <div>
            <h2 class="text-2xl font-bold text-gray-800" style="color: var(--color-charcoal-ink);">Report Incident /
              Compliance Issue</h2>
            <p class="text-sm text-gray-500">Submit a new legal case for review and investigation</p>
          </div>
        </div>
        <button onclick="closeAddCaseModal()" class="btn btn-sm btn-circle btn-ghost">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <form action="{{ route('legal.store') }}" method="POST" id="addCaseForm">
        @csrf

        <!-- Form Sections -->
        <div class="space-y-8">
          <!-- Basic Information Section -->
          <div class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center gap-2 mb-4">
              <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
              <h3 class="text-lg font-semibold text-gray-800">Basic Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Case Title -->
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Case Title*
                </label>
                <input type="text" name="case_title" id="caseTitle"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  value="{{ old('case_title') }}" placeholder="Enter case title" required>
                <p class="mt-1 text-sm text-gray-500">
                  Enter a descriptive title for the legal case
                </p>
              </div>

              <!-- Violation Template -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Violation Template
                </label>
                <select id="violationTemplate"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                  <option value="">Select a template (optional)</option>
                  <option value="theft_template">Theft / Stealing Template</option>
                  <option value="hr_policy_template">HR Policy Violation Template</option>
                  <option value="harassment_template">Workplace Harassment Template</option>
                  <option value="safety_template">Safety Violation Template</option>
                  <option value="attendance_template">Attendance Violation Template</option>
                  <option value="confidentiality_template">Confidentiality Breach Template</option>
                  <option value="property_damage_template">Property Damage Template</option>
                  <option value="guest_complaint_template">Guest Complaint Template</option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Choose a template to auto-fill violation details
                </p>
              </div>

              <!-- Violation Type -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Violation Type*
                </label>
                <select name="case_type" id="caseType"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  required>
                  <option value="">Select violation type</option>
                  <option value="theft" {{ old('case_type') == 'theft' ? 'selected' : '' }}>Theft / Stealing</option>
                  <option value="hr_policy_violation" {{ old('case_type') == 'hr_policy_violation' ? 'selected' : '' }}>HR
                    Policy Violation</option>
                  <option value="workplace_harassment" {{ old('case_type') == 'workplace_harassment' ? 'selected' : '' }}>
                    Workplace Harassment</option>
                  <option value="fraud" {{ old('case_type') == 'fraud' ? 'selected' : '' }}>Fraud / Misrepresentation
                  </option>
                  <option value="safety_violation" {{ old('case_type') == 'safety_violation' ? 'selected' : '' }}>Safety
                    Violation</option>
                  <option value="insubordination" {{ old('case_type') == 'insubordination' ? 'selected' : '' }}>
                    Insubordination</option>
                  <option value="attendance_violation" {{ old('case_type') == 'attendance_violation' ? 'selected' : '' }}>
                    Attendance Violation</option>
                  <option value="confidentiality_breach" {{ old('case_type') == 'confidentiality_breach' ? 'selected' : '' }}>Confidentiality Breach</option>
                  <option value="property_damage" {{ old('case_type') == 'property_damage' ? 'selected' : '' }}>Property
                    Damage</option>
                  <option value="guest_complaint" {{ old('case_type') == 'guest_complaint' ? 'selected' : '' }}>Guest
                    Complaint</option>
                  <option value="regulatory_violation" {{ old('case_type') == 'regulatory_violation' ? 'selected' : '' }}>
                    Regulatory Violation</option>
                  <option value="other" {{ old('case_type') == 'other' ? 'selected' : '' }}>Other Violation</option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Select the type of violation or compliance issue
                </p>
              </div>

              <!-- Priority -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Priority*
                </label>
                <select name="priority" id="priority"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  required>
                  <option value="">Select priority</option>
                  <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                  <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                  <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                  <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                  Set the priority level for this case
                </p>
              </div>
            </div>
          </div>

          <!-- Violation Details Section -->
          <div class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center gap-2 mb-4">
              <i data-lucide="alert-triangle" class="w-5 h-5 text-orange-600"></i>
              <h3 class="text-lg font-semibold text-gray-800">Violation Details</h3>
            </div>

            <div class="space-y-6">
              <!-- Violation Description -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Violation Description*
                </label>
                <textarea name="case_description" id="caseDescription"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                  rows="4" placeholder="Describe the violation in detail..."
                  required>{{ old('case_description') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">
                  Provide detailed description of the violation, including what happened, when, where, and who was
                  involved
                </p>
              </div>
            </div>
          </div>

          <!-- Incident Information Section -->
          <div class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center gap-2 mb-4">
              <i data-lucide="map-pin" class="w-5 h-5 text-green-600"></i>
              <h3 class="text-lg font-semibold text-gray-800">Incident Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Person Involved
                </label>
                <input type="text" name="employee_involved"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  value="{{ old('employee_involved') }}" placeholder="Enter employee name or ID">
                <p class="mt-1 text-sm text-gray-500">
                  Name or employee ID of the person involved in the violation
                </p>
              </div>

              <!-- Incident Date -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Incident Date
                </label>
                <input type="datetime-local" name="incident_date"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  value="{{ old('incident_date') }}">
                <p class="mt-1 text-sm text-gray-500">
                  When did the violation occur?
                </p>
              </div>

              <!-- Location -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Location
                </label>
                <input type="text" name="incident_location"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  value="{{ old('incident_location') }}" placeholder="e.g., Hotel Lobby, Restaurant, Room 205">
                <p class="mt-1 text-sm text-gray-500">
                  Where did the violation occur?
                </p>
              </div>


            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">
              <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
              All required fields must be completed before submission
            </div>
            <div class="flex gap-3">
              <button type="button" onclick="closeAddCaseModal()" class="btn btn-ghost">
                Cancel
              </button>
              <button type="submit" class="btn btn-primary bg-red-600 hover:bg-red-700 text-white">
                <i data-lucide="shield-alert" class="w-5 h-5 mr-2"></i>
                Report Incident
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>


  @include('partials.soliera_js')

  <style>
    /* Ensure modal is properly centered */
    .modal {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .modal-box {
      margin: auto;
      max-height: 90vh;
      overflow-y: auto;
    }
  </style>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Role-based access control
    const userRole = '{{ auth()->user()->role }}';





    function setPriorityFilter(value) {
      document.getElementById('priorityFilterValue').value = value;
      const btn = document.getElementById('priorityFilterBtn');
      if (!btn) return;

      if (value) {
        btn.classList.replace('from-[#F7B32B]', 'from-blue-600');
        btn.classList.replace('to-[#f59e0b]', 'to-blue-700');
        btn.classList.add('text-white');
        btn.classList.remove('text-gray-800');
      } else {
        btn.classList.replace('from-blue-600', 'from-[#F7B32B]');
        btn.classList.replace('to-blue-700', 'to-[#f59e0b]');
        btn.classList.remove('text-white');
        btn.classList.add('text-gray-800');
      }
      filterCases();
    }

    // Search and filter functionality
    function filterCases() {
      const searchTerm = document.getElementById('caseSearchInput')?.value?.toLowerCase() || '';
      const priorityFilter = document.getElementById('priorityFilterValue')?.value || '';

      const rows = document.querySelectorAll('tbody tr[data-case-id]');

      rows.forEach(row => {
        let showRow = true;

        // Search filter
        if (searchTerm) {
          const title = row.querySelector('td:nth-child(2) h4')?.textContent?.toLowerCase() || '';
          const subtitle = row.querySelector('td:nth-child(2) p')?.textContent?.toLowerCase() || '';
          const employee = row.querySelector('td:nth-child(4)')?.textContent?.toLowerCase() || '';
          if (!title.includes(searchTerm) && !subtitle.includes(searchTerm) && !employee.includes(searchTerm)) {
            showRow = false;
          }
        }

        // Priority filter
        if (priorityFilter && showRow) {
          const priority = row.dataset.priority;
          if (priority !== priorityFilter) {
            showRow = false;
          }
        }

        // Show/hide row
        row.style.display = showRow ? '' : 'none';
      });
    }

    function clearFilters() {
      const caseSearch = document.getElementById('caseSearchInput');
      if (caseSearch) caseSearch.value = '';
      setPriorityFilter('');
    }

    // Case actions
    function deleteCase(caseId) {
      Swal.fire({
        title: 'Delete Legal Case',
        text: 'Are you sure you want to delete this legal case? This action cannot be undone and will permanently remove the case from the system.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'DELETE CASE',
        cancelButtonText: 'CANCEL',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
        focusCancel: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Proceed with deletion
          fetch(`/legal/cases/${caseId}`, {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                showEnhancedToast('Legal case deleted successfully!', 'success', 'check-circle', 'The case has been permanently removed from the system.');
                // Remove the row from the table
                const row = document.querySelector(`tr[data-case-id="${caseId}"]`);
                if (row) {
                  row.remove();
                } else {
                  // Fallback: find row by looking for the delete button with the caseId
                  const deleteButton = document.querySelector(`button[onclick="deleteCase(${caseId})"]`);
                  if (deleteButton) {
                    const tableRow = deleteButton.closest('tr');
                    if (tableRow) {
                      tableRow.remove();
                    }
                  }
                }
              } else {
                showEnhancedToast('Error deleting case: ' + (data.message || 'Unknown error'), 'error', 'alert-circle', 'Please try again or contact support if the issue persists.');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              showEnhancedToast('Error deleting case: ' + error.message, 'error', 'alert-circle', 'Please try again or contact support if the issue persists.');
            });
        }
      });
    }









    // Violation Templates
    const violationTemplates = {
      theft_template: {
        title: 'Theft Incident Report',
        description: 'INCIDENT REPORT - THEFT\n\nDate of Incident: [DATE]\nTime of Incident: [TIME]\nLocation: [LOCATION]\n\nDescription:\nA theft incident was reported involving [EMPLOYEE_NAME]. The incident occurred when [DETAILED_DESCRIPTION].\n\nItems Stolen:\n- [ITEM_1]\n- [ITEM_2]\n\nWitnesses:\n- [WITNESS_1]\n- [WITNESS_2]\n\nAction Taken:\n- Security was notified immediately\n- CCTV footage was reviewed\n- Police report filed (if applicable)\n\nRecommendations:\n- [RECOMMENDATION_1]\n- [RECOMMENDATION_2]',
        type: 'theft',
        priority: 'high'
      },
      hr_policy_template: {
        title: 'HR Policy Violation Report',
        description: 'HR POLICY VIOLATION REPORT\n\nEmployee: [EMPLOYEE_NAME]\nDepartment: [DEPARTMENT]\nPosition: [POSITION]\n\nViolation Details:\nThe employee has violated the following HR policy: [POLICY_NAME]\n\nSpecific Violation:\n[VIOLATION_DETAILS]\n\nPolicy Reference:\n[POLICY_REFERENCE]\n\nPrevious Violations:\n- [PREVIOUS_VIOLATION_1]\n- [PREVIOUS_VIOLATION_2]\n\nRecommended Action:\n- [ACTION_1]\n- [ACTION_2]\n\nHR Representative: [HR_REP_NAME]\nDate: [DATE]',
        type: 'hr_policy_violation',
        priority: 'normal'
      },
      harassment_template: {
        title: 'Workplace Harassment Complaint',
        description: 'WORKPLACE HARASSMENT COMPLAINT\n\nComplainant: [COMPLAINANT_NAME]\nAccused: [ACCUSED_NAME]\nDate of Incident: [DATE]\nLocation: [LOCATION]\n\nNature of Harassment:\n[DESCRIPTION_OF_HARASSMENT]\n\nWitnesses:\n- [WITNESS_1]\n- [WITNESS_2]\n\nEvidence:\n- [EVIDENCE_1]\n- [EVIDENCE_2]\n\nImmediate Actions Taken:\n- [ACTION_1]\n- [ACTION_2]\n\nInvestigation Required: YES/NO\n\nHR Representative: [HR_REP_NAME]\nDate: [DATE]',
        type: 'workplace_harassment',
        priority: 'urgent'
      },
      safety_template: {
        title: 'Safety Violation Report',
        description: 'SAFETY VIOLATION REPORT\n\nEmployee: [EMPLOYEE_NAME]\nDepartment: [DEPARTMENT]\nDate: [DATE]\nTime: [TIME]\nLocation: [LOCATION]\n\nSafety Violation:\n[VIOLATION_DESCRIPTION]\n\nPotential Hazards:\n- [HAZARD_1]\n- [HAZARD_2]\n\nImmediate Actions Taken:\n- [ACTION_1]\n- [ACTION_2]\n\nCorrective Measures:\n- [MEASURE_1]\n- [MEASURE_2]\n\nSafety Officer: [SAFETY_OFFICER]\nDate: [DATE]',
        type: 'safety_violation',
        priority: 'high'
      },
      attendance_template: {
        title: 'Attendance Violation Report',
        description: 'ATTENDANCE VIOLATION REPORT\n\nEmployee: [EMPLOYEE_NAME]\nEmployee ID: [EMPLOYEE_ID]\nDepartment: [DEPARTMENT]\n\nViolation Type:\n- [ ] Late arrival\n- [ ] Early departure\n- [ ] Unauthorized absence\n- [ ] Excessive breaks\n\nDetails:\n[VIOLATION_DETAILS]\n\nPrevious Violations:\n- [PREVIOUS_1]\n- [PREVIOUS_2]\n\nCorrective Action:\n- [ACTION_1]\n- [ACTION_2]\n\nSupervisor: [SUPERVISOR_NAME]\nDate: [DATE]',
        type: 'attendance_violation',
        priority: 'normal'
      },
      confidentiality_template: {
        title: 'Confidentiality Breach Report',
        description: 'CONFIDENTIALITY BREACH REPORT\n\nEmployee: [EMPLOYEE_NAME]\nDepartment: [DEPARTMENT]\nDate: [DATE]\n\nBreach Details:\n[BREACH_DESCRIPTION]\n\nConfidential Information Involved:\n- [INFO_1]\n- [INFO_2]\n\nPotential Impact:\n[IMPACT_ASSESSMENT]\n\nImmediate Actions:\n- [ACTION_1]\n- [ACTION_2]\n\nPrevention Measures:\n- [MEASURE_1]\n- [MEASURE_2]\n\nHR Representative: [HR_REP_NAME]\nDate: [DATE]',
        type: 'confidentiality_breach',
        priority: 'high'
      },
      property_damage_template: {
        title: 'Property Damage Report',
        description: 'PROPERTY DAMAGE REPORT\n\nDate: [DATE]\nTime: [TIME]\nLocation: [LOCATION]\n\nDamage Description:\n[DAMAGE_DESCRIPTION]\n\nEstimated Cost: [COST]\n\nCause:\n- [ ] Accidental\n- [ ] Intentional\n- [ ] Negligence\n- [ ] Other: [OTHER_CAUSE]\n\nWitnesses:\n- [WITNESS_1]\n- [WITNESS_2]\n\nActions Taken:\n- [ACTION_1]\n- [ACTION_2]\n\nInsurance Claim: YES/NO\n\nReported by: [REPORTER_NAME]\nDate: [DATE]',
        type: 'property_damage',
        priority: 'normal'
      },
      guest_complaint_template: {
        title: 'Guest Complaint - Legal Action Required',
        description: 'GUEST COMPLAINT - LEGAL ACTION REQUIRED\n\nGuest Name: [GUEST_NAME]\nRoom Number: [ROOM_NUMBER]\nCheck-in Date: [CHECKIN_DATE]\nCheck-out Date: [CHECKOUT_DATE]\n\nComplaint Details:\n[COMPLAINT_DESCRIPTION]\n\nStaff Involved:\n- [STAFF_1]\n- [STAFF_2]\n\nEvidence:\n- [EVIDENCE_1]\n- [EVIDENCE_2]\n\nGuest Demands:\n[GUEST_DEMANDS]\n\nLegal Implications:\n[LEGAL_IMPLICATIONS]\n\nRecommended Action:\n- [ACTION_1]\n- [ACTION_2]\n\nManager: [MANAGER_NAME]\nDate: [DATE]',
        type: 'guest_complaint',
        priority: 'high'
      }
    };

    // Event listeners
    document.addEventListener('DOMContentLoaded', function () {
      // Violation template handler
      const templateSelect = document.getElementById('violationTemplate');
      if (templateSelect) {
        templateSelect.addEventListener('change', function () {
          const template = violationTemplates[this.value];
          if (template) {
            document.getElementById('caseTitle').value = template.title;
            document.getElementById('caseDescription').value = template.description;
            document.getElementById('caseType').value = template.type;
            document.getElementById('priority').value = template.priority;
          }
        });
      }

      // Search and filter event listeners
      const caseSearch = document.getElementById('caseSearchInput');
      if (caseSearch) caseSearch.addEventListener('input', filterCases);

      // File input change event listener
      const fileInput = document.getElementById('legal_document');
      if (fileInput) {
        fileInput.addEventListener('change', function (e) {
          if (e.target.files.length > 0) {
            updateFilePreview(e.target.files[0]);
            analyzeDocument(e.target.files[0]);
          }
        });
      }

      // Form submission handler
      const addCaseForm = document.getElementById('addCaseForm');
      if (addCaseForm) {
        addCaseForm.addEventListener('submit', function (e) {
          e.preventDefault();
          handleFormSubmission();
        });
      }
    });

    // Handle form submission
    function handleFormSubmission() {
      const form = document.getElementById('addCaseForm');
      const formData = new FormData(form);

      // Show loading state
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<i class="loading loading-spinner"></i> Creating Case...';
      submitBtn.disabled = true;

      fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Show success message
            showToast('Legal case created successfully!', 'success');
            // Close modal
            closeAddCaseModal();
            // Reload page to show new case
            setTimeout(() => window.location.reload(), 1000);
          } else {
            throw new Error(data.message || 'Failed to create case');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Error creating case: ' + error.message, 'error');
          // Restore submit button
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
        });
    }


    // Enhanced toast notification function - uses global showNotification
    function showEnhancedToast(title, type = 'info', icon = 'info', description = '') {
      // Use global showNotification if available (Soliera theme)
      const message = description ? `${title}: ${description}` : title;
      const duration = type === 'error' ? 6000 : 4000;

      if (typeof window.showNotification === 'function') {
        window.showNotification(message, type, duration);
        return;
      }

      // Fallback to simple alert if global function not available
      alert(message);
    }

    // Legacy toast function for backward compatibility
    function showToast(message, type = 'info', duration = 3000) {
      if (typeof window.showNotification === 'function') {
        window.showNotification(message, type, duration);
        return;
      }
      alert(message);
    }

    // Modal functions for Add New Case
    function openAddCaseModal() {
      const modal = document.getElementById('addCaseModal');
      if (modal && modal.classList) {
        modal.classList.add('modal-open');
        document.body.style.overflow = 'hidden';

        // Initialize Lucide icons in modal
        lucide.createIcons();
      }
    }

    function closeAddCaseModal() {
      const modal = document.getElementById('addCaseModal');
      if (modal && modal.classList) {
        modal.classList.remove('modal-open');
        document.body.style.overflow = 'auto';
      }

      // Reset form
      const form = document.getElementById('addCaseForm');
      if (form) {
        form.reset();
      }

      // Hide file preview and AI analysis
      const filePreview = document.getElementById('filePreview');
      const aiAnalysis = document.getElementById('aiAnalysis');
      if (filePreview && filePreview.classList) {
        filePreview.classList.add('hidden');
      }
      if (aiAnalysis && aiAnalysis.classList) {
        aiAnalysis.classList.add('hidden');
      }
    }




    // Form validation and submission
    function handleFormSubmission() {
      const form = document.getElementById('addCaseForm');
      const formData = new FormData(form);
      const requiredFields = ['case_title', 'case_type', 'priority', 'case_description'];

      // Validate required fields
      let isValid = true;
      requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field && field.classList) {
          if (!field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
          } else {
            field.classList.remove('border-red-500');
          }
        }
      });

      if (!isValid) {
        showToast('Please fill in all required fields', 'error');
        return;
      }

      // Show loading state
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<i class="loading loading-spinner"></i> Submitting...';
      submitBtn.disabled = true;

      // Submit form
      fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            closeAddCaseModal();
            setTimeout(() => window.location.reload(), 1000);
          } else {
            throw new Error(data.message || 'Failed to submit report');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Error submitting report: ' + error.message, 'error');
        })
        .finally(() => {
          // Reset button state
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
        });
    }

    // Event listeners for modal
    document.addEventListener('DOMContentLoaded', function () {

      // Form submission handler
      const addCaseForm = document.getElementById('addCaseForm');
      if (addCaseForm) {
        addCaseForm.addEventListener('submit', function (e) {
          e.preventDefault();
          handleFormSubmission();
        });
      }

      // Close modal when clicking outside
      const modal = document.getElementById('addCaseModal');
      if (modal) {
        modal.addEventListener('click', function (e) {
          if (e.target === modal) {
            closeAddCaseModal();
          }
        });
      }

      // Auto-hide session notifications after 5 seconds
      setTimeout(() => {
        document.querySelectorAll('.toast').forEach(toast => {
          if (toast) {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s ease-out';
            setTimeout(() => {
              if (toast.parentNode) {
                toast.remove();
              }
            }, 500);
          }
        });
      }, 5000);
    });
  </script>
</body>

</html>
