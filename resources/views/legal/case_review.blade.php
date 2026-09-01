<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Case Review - {{ $case->case_title }} - Soliera</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @vite(['resources/css/soliera.css'])

  <style>
    :root {
      --brand-navy: #2C3E50;
      --brand-gold: #F7A923;
      --brand-navy-light: #3d5166;
      --brand-gold-light: #ffc254;
      --bg-surface: #ffffff;
      --bg-subtle: #f8fafc;
      --border-default: #e2e8f0;
      --text-main: #1e293b;
      --text-muted: #64748b;
    }

    .btn.btn-primary {
      background-color: var(--brand-navy) !important;
      border-color: var(--brand-navy) !important;
      color: white !important;
    }

    .btn.btn-primary:hover {
      background-color: var(--brand-navy-light) !important;
      border-color: var(--brand-navy-light) !important;
    }

    .btn.btn-accent {
      background-color: var(--brand-gold) !important;
      border-color: var(--brand-gold) !important;
      color: var(--brand-navy) !important;
    }

    /* Workflow Progress Bar */
    .workflow-progress {
      position: relative;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 2rem 0;
    }

    .workflow-step {
      position: relative;
      z-index: 10;
      display: flex;
      flex-direction: column;
      align-items: center;
      flex: 1;
    }

    .workflow-step-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 3px solid #e5e7eb;
      background: white;
      transition: all 0.3s ease;
    }

    .workflow-step.active .workflow-step-icon {
      background: var(--color-regal-navy);
      border-color: var(--color-regal-navy);
      box-shadow: 0 0 0 4px rgba(247, 169, 35, 0.2);
    }

    .workflow-step.completed .workflow-step-icon {
      background: #22c55e;
      border-color: #22c55e;
    }

    .workflow-step-label {
      margin-top: 0.5rem;
      font-size: 0.875rem;
      font-weight: 600;
      color: #6b7280;
    }

    .workflow-step.active .workflow-step-label {
      color: #1f2937;
    }

    .workflow-step.completed .workflow-step-label {
      color: #22c55e;
    }

    .workflow-line {
      position: absolute;
      top: 25px;
      left: 0;
      right: 0;
      height: 3px;
      background: #e5e7eb;
      z-index: 1;
    }

    .workflow-line-progress {
      height: 100%;
      background: #22c55e;
      transition: width 0.5s ease;
    }

    /* Tabs */
    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    .tab-btn {
      padding: 1rem 1.5rem;
      border-bottom: 3px solid transparent;
      color: #6b7280;
      font-weight: 600;
      transition: all 0.2s;
      cursor: pointer;
    }

    .tab-btn:hover {
      color: #1f2937;
      background: #f3f4f6;
    }

    .tab-btn.disabled {
      color: #9ca3af !important;
      cursor: not-allowed !important;
      opacity: 0.6;
    }

    .tab-btn.disabled:hover {
      color: #9ca3af !important;
      background: transparent !important;
    }

    .tab-btn.active {
      color: #F7A923;
      border-bottom-color: #F7A923;
      background: #fff;
    }

    /* Evidence Cards */
    .evidence-card {
      transition: all 0.2s ease;
    }

    .evidence-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    /* Timeline */
    .timeline-item {
      position: relative;
      padding-left: 2rem;
      padding-bottom: 2rem;
      border-left: 2px solid #e5e7eb;
    }

    .timeline-item:last-child {
      border-left-color: transparent;
      padding-bottom: 0;
    }

    .timeline-dot {
      position: absolute;
      left: -0.5rem;
      top: 0;
      width: 1rem;
      height: 1rem;
      border-radius: 50%;
      background: #F7A923;
      border: 3px solid white;
      box-shadow: 0 0 0 2px #e5e7eb;
    }

    /* Print Styles for Docket */
    @media print {
      body * {
        visibility: hidden;
      }
      .printable-docket, .printable-docket * {
        visibility: visible;
      }
      .printable-docket {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
      }
      .tab-btn, .btn, .sidebar, .navbar, .no-print {
        display: none !important;
      }
      /* Ensure colors print */
      .printable-docket {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
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
      <main
        class="flex-1 overflow-y-auto bg-gray-50 p-6 {{ $case->workflow_stage === 'closed' ? 'bg-gray-100 opacity-95 grayscale-[20%]' : '' }}">
        @if($case->workflow_stage === 'closed')
          <div class="alert alert-info shadow-sm mb-4 border-l-4 border-blue-500 rounded-lg">
            <i data-lucide="lock" class="w-5 h-5"></i>
            <div>
              <h3 class="font-bold text-sm">ARCHIVED RECORD</h3>
              <div class="text-xs">This case is CLOSED and locked. No further modifications are allowed.</div>
            </div>
          </div>
        @endif
        <!-- Back button and header -->
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center">
            <a href="{{ route('legal.case_deck') }}" class="btn btn-ghost btn-sm mr-4">
              <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </a>
            <div>
              <h1 class="text-3xl font-bold text-gray-800">
                {{ $case->case_type === 'visitor_violation' ? preg_replace('/(\s*[\-\–\—]\s*).*$/u', '', $case->case_title) : $case->case_title }}
              </h1>
              <p class="text-gray-600">Case #{{ $case->case_number }}</p>
            </div>
          </div>
          <div class="flex gap-2">
            @php
              $requirements = [];
              if ($case->workflow_stage === 'filing') {
                if (!$case->case_type)
                  $requirements[] = 'Case Type';
                if (!$case->incident_date)
                  $requirements[] = 'Incident Date';
                if (!$case->incident_location)
                  $requirements[] = 'Location';
                if (!$case->employee_involved && !($case->visitor->name ?? null))
                  $requirements[] = 'People Involved';
                if (!$case->priority)
                  $requirements[] = 'Priority';
                if (!$case->case_description)
                  $requirements[] = 'Description';
              } elseif ($case->workflow_stage === 'investigation') {
                if (!$case->investigation_notes)
                  $requirements[] = 'Investigation Notes';
                if (!$case->investigation_findings)
                  $requirements[] = 'Investigation Findings';
                // Optional: if ($case->evidence()->count() === 0) $requirements[] = 'Evidence';
              } elseif ($case->workflow_stage === 'review') {
                // Review stage transition is usually via specific action buttons in the tab
                $requirements[] = 'Requires Review Action (Approve/Return/Reject)';
              } elseif ($case->workflow_stage === 'resolution') {
                if (!$case->resolution_decision)
                  $requirements[] = 'Resolution Decision';
                if (!$case->resolution_notes)
                  $requirements[] = 'Resolution Notes';
              }
              $isGated = count($requirements) > 0 && $case->workflow_stage !== 'review';
            @endphp

            @if($case->workflow_stage !== 'closed' && $case->workflow_stage !== 'review')
              <div @if($isGated) class="tooltip tooltip-left" data-tip="Missing: {{ implode(', ', $requirements) }}"
              @endif>
                <button onclick="openStageTransitionModal()"
                  class="btn btn-primary {{ $isGated ? 'btn-disabled opacity-50' : 'hover:scale-105 active:scale-95' }} transition-all"
                  @if($isGated) disabled @endif>
                  <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>
                  Advance Stage
                </button>
              </div>
            @endif
          </div>
        </div>

        <!-- Workflow Progress -->
        <div class="card bg-white shadow-lg mb-6">
          <div class="card-body">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
              <i data-lucide="git-branch" class="w-5 h-5 mr-2 text-blue-600"></i>
              Workflow Progress
            </h3>
            <div class="workflow-progress">
              <div class="workflow-line">
                <div class="workflow-line-progress"
                  style="width: {{ ['filing' => 0, 'investigation' => 25, 'review' => 50, 'resolution' => 75, 'closed' => 100][$case->workflow_stage] }}%">
                </div>
              </div>

              @foreach(['filing', 'investigation', 'review', 'resolution', 'closed'] as $index => $stage)
                <div
                  class="workflow-step {{ $case->workflow_stage === $stage ? 'active' : '' }} {{ array_search($case->workflow_stage, ['filing', 'investigation', 'review', 'resolution', 'closed']) > $index ? 'completed' : '' }}">
                  <div class="workflow-step-icon">
                    <i data-lucide="{{ ['filing' => 'file-text', 'investigation' => 'search', 'review' => 'clipboard-check', 'resolution' => 'check-circle', 'closed' => 'archive'][$stage] }}"
                      class="w-6 h-6"></i>
                  </div>
                  <span class="workflow-step-label">{{ ucfirst($stage) }}</span>
                  @if($case->workflow_stage === $stage)
                    <span class="text-xs text-gray-500 mt-1">{{ $case->days_in_current_stage }} days</span>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        </div>



        <!-- Tabs Navigation -->
        <div class="card bg-white shadow-lg">
          <div class="border-b border-gray-200">
            <div class="flex overflow-x-auto">
              <button class="tab-btn" onclick="switchTab('overview')" id="tab-overview">
                <i data-lucide="info" class="w-4 h-4 inline mr-2"></i>
                Overview
              </button>
              <button class="tab-btn {{ in_array($case->workflow_stage, ['filing']) ? 'disabled' : '' }}" 
                      onclick="{{ in_array($case->workflow_stage, ['filing']) ? 'return false' : 'switchTab(\'investigation\')' }}" 
                      id="tab-investigation"
                      {{ in_array($case->workflow_stage, ['filing']) ? 'disabled' : '' }}>
                <i data-lucide="search" class="w-4 h-4 inline mr-2"></i>
                Investigation
                @if(in_array($case->workflow_stage, ['filing']))
                  <i data-lucide="lock" class="w-3 h-3 ml-1 text-gray-400"></i>
                @endif
              </button>
              <button class="tab-btn {{ in_array($case->workflow_stage, ['filing', 'investigation']) ? 'disabled' : '' }}" 
                      onclick="{{ in_array($case->workflow_stage, ['filing', 'investigation']) ? 'return false' : 'switchTab(\'review\')' }}" 
                      id="tab-review"
                      {{ in_array($case->workflow_stage, ['filing', 'investigation']) ? 'disabled' : '' }}>
                <i data-lucide="shield-check" class="w-4 h-4 inline mr-2"></i>
                Review
                @if(in_array($case->workflow_stage, ['filing', 'investigation']))
                  <i data-lucide="lock" class="w-3 h-3 ml-1 text-gray-400"></i>
                @endif
              </button>
              <button class="tab-btn {{ in_array($case->workflow_stage, ['filing', 'investigation', 'review']) ? 'disabled' : '' }}" 
                      onclick="{{ in_array($case->workflow_stage, ['filing', 'investigation', 'review']) ? 'return false' : 'switchTab(\'resolution\')' }}" 
                      id="tab-resolution"
                      {{ in_array($case->workflow_stage, ['filing', 'investigation', 'review']) ? 'disabled' : '' }}>
                <i data-lucide="check-circle" class="w-4 h-4 inline mr-2"></i>
                Resolution
                @if(in_array($case->workflow_stage, ['filing', 'investigation', 'review']))
                  <i data-lucide="lock" class="w-3 h-3 ml-1 text-gray-400"></i>
                @endif
              </button>
              <button class="tab-btn" onclick="switchTab('activity')" id="tab-activity">
                <i data-lucide="activity" class="w-4 h-4 inline mr-2"></i>
                Activity Log
              </button>
              <button class="tab-btn" onclick="switchTab('docket')" id="tab-docket">
                <i data-lucide="scale" class="w-4 h-4 inline mr-2"></i>
                Case Docket
              </button>
            </div>
          </div>

          <div class="card-body p-6">
            <!-- TAB 1: OVERVIEW -->
            <div id="content-overview" class="tab-content">
              <h3 class="text-xl font-bold mb-4">Case Overview</h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                  <h4 class="font-semibold text-gray-700 flex items-center">
                    <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                    Basic Information
                  </h4>
                  <div class="pl-6 space-y-3">
                    <div>
                      <label class="text-sm text-gray-600">Case Type</label>
                      <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $case->case_type)) }}</p>
                    </div>
                    <div>
                      <label class="text-sm text-gray-600">Status</label>
                      <p class="font-medium">
                        <span
                          class="badge {{ $case->status === 'pending' ? 'badge-warning' : ($case->status === 'completed' ? 'badge-success' : 'badge-error') }}">
                          {{ ucfirst($case->status) }}
                        </span>
                      </p>
                    </div>
                    <div>
                      <label class="text-sm text-gray-600">Created Date</label>
                      <p class="font-medium">{{ $case->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                  </div>
                </div>

                <!-- Incident Details -->
                <div class="space-y-4">
                  <h4 class="font-semibold text-gray-700 flex items-center">
                    <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                    Incident Details
                  </h4>
                  <div class="pl-6 space-y-3">
                    <div>
                      <label class="text-sm text-gray-600">Person Involved</label>
                      <p class="font-medium">
                        {{ $case->employee_involved ?: ($case->visitor->name ?? 'Not specified') }}
                      </p>
                    </div>
                    <div>
                      <label class="text-sm text-gray-600">Incident Date</label>
                      <p class="font-medium">
                        {{ $case->incident_date ? $case->incident_date->format('M d, Y h:i A') : 'Not specified' }}
                      </p>
                    </div>
                    <div>
                      <label class="text-sm text-gray-600">Location</label>
                      <p class="font-medium">{{ $case->incident_location ?? 'Not specified' }}</p>
                    </div>

                  </div>
                </div>
              </div>

              <!-- Description -->
              <div class="mt-6">
                <h4 class="font-semibold text-gray-700 mb-2">Case Description</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                  <p class="text-gray-700 whitespace-pre-wrap">{{ $case->case_description }}</p>
                </div>
              </div>
            </div>

            <!-- TAB 2: INVESTIGATION (Standardized) -->
            <div id="content-investigation" class="tab-content group/investigation">
              <!-- Investigation Header -->
              <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                  <h3 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <span class="p-2 bg-[var(--brand-navy)] text-white rounded-xl shadow-lg">
                      <i data-lucide="search" class="w-6 h-6"></i>
                    </span>
                    Investigation Details
                  </h3>
                  <p class="text-slate-500 mt-1 font-medium pl-12">Case analysis and evidence for #{{ $case->case_number }}</p>
                </div>
                @if($case->workflow_stage === 'investigation' && auth()->user()->role === 'Administrator' && $case->workflow_stage !== 'closed')
                  <button onclick="openInvestigationNoteModal()" 
                    class="btn btn-primary border-none px-6 rounded-xl hover:scale-105 transition-transform">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    Manage Findings
                  </button>
                @endif
              </div>

              <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Primary Investigation Data (Left) -->
                <div class="lg:col-span-8 space-y-6">
                  
                  <!-- Key Findings Card -->
                  <div class="bg-white border-t-4 border-t-[var(--brand-gold)] border-x border-b border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
                      <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-5 h-5 text-[var(--brand-navy)]"></i>
                        Key Findings
                      </h4>
                      <span class="px-2 py-0.5 bg-slate-100 text-[10px] uppercase font-black tracking-widest text-slate-500 rounded">Internal</span>
                    </div>
                    <div class="p-6">
                      @if($case->investigation_findings)
                        <p class="text-slate-700 leading-relaxed font-medium">
                          {{ $case->investigation_findings }}
                        </p>
                      @else
                        <p class="text-slate-400 italic text-sm">No findings documented yet.</p>
                      @endif
                    </div>
                  </div>

                  <!-- Investigation Notes -->
                  <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3 bg-slate-50/30">
                      <i data-lucide="file-text" class="w-5 h-5 text-[var(--brand-navy)]"></i>
                      <h4 class="font-bold text-slate-800">Process Notes</h4>
                    </div>
                    <div class="p-6">
                      @if($case->investigation_notes)
                        <p class="text-slate-600 whitespace-pre-wrap leading-relaxed text-sm">
                          {{ $case->investigation_notes }}
                        </p>
                      @else
                        <div class="flex flex-col items-center justify-center py-8 text-slate-300">
                          <p class="font-medium text-slate-400 text-sm italic">No detailed notes recorded.</p>
                        </div>
                      @endif
                    </div>
                  </div>

                  <!-- Timeline Grid -->
                  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-4">
                      <div class="p-2 bg-slate-50 rounded-lg text-[var(--brand-navy)]">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                      </div>
                      <div>
                        <p class="text-[10px] font-black uppercase tracking-tighter text-slate-400">Started</p>
                        <p class="font-bold text-slate-700 text-xs">{{ $case->investigation_started_at ? $case->investigation_started_at->format('M d, Y') : '---' }}</p>
                      </div>
                    </div>
                    <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-4">
                      <div class="p-2 bg-slate-50 rounded-lg text-[var(--brand-navy)]">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                      </div>
                      <div>
                        <p class="text-[10px] font-black uppercase tracking-tighter text-slate-400">Duration</p>
                        <p class="font-bold text-slate-700 text-xs">
                           @if($case->investigation_started_at)
                              {{ $case->investigation_started_at->diffInDays($case->investigation_completed_at ?? now()) }} Days
                           @else
                              ---
                           @endif
                        </p>
                      </div>
                    </div>
                    <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-4">
                      <div class="p-2 bg-slate-50 rounded-lg text-[var(--brand-navy)]">
                        <i data-lucide="circle-dot" class="w-5 h-5"></i>
                      </div>
                      <div>
                        <p class="text-[10px] font-black uppercase tracking-tighter text-slate-400">Status</p>
                        <span class="badge badge-sm font-bold border-none {{ $case->investigation_completed_at ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                          {{ $case->investigation_completed_at ? 'Finalized' : 'Active' }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Secondary Panels (Right) -->
                <div class="lg:col-span-4 space-y-6">
                  <!-- Evidence -->
                  <div class="bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col">
                    <div class="px-5 py-3 border-b border-slate-100 flex items-center justify-between">
                      <h4 class="font-bold text-slate-800 flex items-center gap-2 text-sm">
                        <i data-lucide="paperclip" class="w-4 h-4 text-[var(--brand-navy)]"></i>
                         Evidence ({{ $case->evidence->count() }})
                      </h4>
                      <button onclick="openUploadEvidenceModal()" class="btn btn-primary btn-xs">
                        <i data-lucide="plus" class="w-3 h-3"></i>
                        Add Evidence
                      </button>
                    </div>
                    <div class="p-4 space-y-2 max-h-[300px] overflow-y-auto custom-scrollbar">
                      @forelse($case->evidence as $evidence)
                        <div class="group flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-xl hover:border-[var(--brand-gold)] transition-all">
                          <div class="flex items-center gap-3 overflow-hidden">
                             <i data-lucide="file-check" class="w-4 h-4 text-slate-400"></i>
                             <p class="text-xs font-bold text-slate-700 truncate" title="{{ $evidence->title }}">{{ $evidence->title }}</p>
                          </div>
                          <a href="{{ asset('storage/' . $evidence->file_path) }}" target="_blank" class="text-[var(--brand-navy)] hover:text-[var(--brand-gold)]">
                            <i data-lucide="download" class="w-4 h-4"></i>
                          </a>
                        </div>
                      @empty
                        <p class="text-center py-6 text-xs font-bold text-slate-300 uppercase tracking-widest">No Documents</p>
                      @endforelse
                    </div>
                  </div>

                  <!-- Witnesses -->
                  <div class="bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col">
                    <div class="px-5 py-3 border-b border-slate-100 flex items-center justify-between">
                      <h4 class="font-bold text-slate-800 flex items-center gap-2 text-sm">
                        <i data-lucide="users" class="w-4 h-4 text-[var(--brand-navy)]"></i>
                         Witnesses ({{ $case->witnesses->count() }})
                      </h4>
                      <button onclick="openAddWitnessModal()" class="btn btn-primary btn-xs">
                        <i data-lucide="plus" class="w-3 h-3"></i>
                        Add Witness
                      </button>
                    </div>
                    <div class="p-4 space-y-2 max-h-[300px] overflow-y-auto custom-scrollbar">
                      @forelse($case->witnesses as $witness)
                        <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-100 rounded-xl">
                          <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[var(--brand-navy)] text-[10px] font-black">
                             {{ substr($witness->witness_name, 0, 1) }}
                          </div>
                          <div class="overflow-hidden">
                            <p class="text-xs font-bold text-slate-700 truncate">{{ $witness->witness_name }}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $witness->witness_department }}</p>
                          </div>
                        </div>
                      @empty
                        <p class="text-center py-6 text-xs font-bold text-slate-300 uppercase tracking-widest">No Witnesses</p>
                      @endforelse
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- TAB 4: REVIEW (New Actionable Tab) -->
            <div id="content-review" class="tab-content">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold">Case Review & Validation</h3>
                <span
                  class="badge @if($case->workflow_stage === 'review') badge-primary animate-pulse @else badge-ghost @endif">
                  {{ $case->workflow_stage === 'review' ? 'Current Active Stage' : 'Stage Overview' }}
                </span>
              </div>

              <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                  <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
                    <h4 class="font-bold text-blue-800 mb-2 flex items-center gap-2">
                      <i data-lucide="shield-check" class="w-5 h-5"></i>
                      Admin Validation Requirements
                    </h4>
                    <ul class="text-sm text-blue-700 space-y-2">
                      <li class="flex items-center gap-2">
                        <i data-lucide="{{ $case->investigation_notes ? 'check-circle' : 'circle' }}"
                          class="w-4 h-4 {{ $case->investigation_notes ? 'text-green-600' : 'text-gray-400' }}"></i>
                        Complete Investigation Notes
                      </li>
                      <li class="flex items-center gap-2">
                        <i data-lucide="{{ $case->investigation_findings ? 'check-circle' : 'circle' }}"
                          class="w-4 h-4 {{ $case->investigation_findings ? 'text-green-600' : 'text-gray-400' }}"></i>
                        Clear Investigation Findings
                      </li>
                      <li class="flex items-center gap-2">
                        <i data-lucide="{{ $case->evidence()->count() > 0 ? 'check-circle' : 'circle' }}"
                          class="w-4 h-4 {{ $case->evidence()->count() > 0 ? 'text-green-600' : 'text-gray-400' }}"></i>
                        Supporting Evidence ({{ $case->evidence()->count() }} uploaded)
                      </li>
                    </ul>
                  </div>

                  @if($case->workflow_stage === 'review')
                    <div class="card bg-white border border-gray-200 shadow-sm">
                      <div class="card-body">
                        <h4 class="font-bold text-gray-800 mb-4">Final Review Decision</h4>
                        <p class="text-sm text-gray-600 mb-6">As an Administrator, you handle the final validation. Choose
                          the path for this case based on the gathered data.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                          <button onclick="handleReviewAction('approve')"
                            class="btn btn-outline border-green-500 text-green-700 hover:bg-green-500 hover:text-white flex-col h-auto py-4 gap-2">
                            <i data-lucide="check-square" class="w-6 h-6"></i>
                            <div class="text-center">
                              <div class="font-bold">Approve</div>
                              <div class="text-[10px] font-normal">Ready for Resolution</div>
                            </div>
                          </button>

                          <button onclick="handleReviewAction('return')"
                            class="btn btn-outline border-amber-500 text-amber-700 hover:bg-amber-500 hover:text-white flex-col h-auto py-4 gap-2">
                            <i data-lucide="rotate-ccw" class="w-6 h-6"></i>
                            <div class="text-center">
                              <div class="font-bold">Return</div>
                              <div class="text-[10px] font-normal">Needs More Info</div>
                            </div>
                          </button>

                          <button onclick="handleReviewAction('reject')"
                            class="btn btn-outline border-red-500 text-red-700 hover:bg-red-500 hover:text-white flex-col h-auto py-4 gap-2">
                            <i data-lucide="x-circle" class="w-6 h-6"></i>
                            <div class="text-center">
                              <div class="font-bold">Reject</div>
                              <div class="text-[10px] font-normal">Not Approved</div>
                            </div>
                          </button>
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="bg-gray-100 rounded-xl p-10 text-center">
                      <i data-lucide="lock" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                      <p class="text-gray-500">Case must be in Review stage to perform validation actions.</p>
                    </div>
                  @endif
                </div>

                <div class="space-y-6">
                  <div class="card bg-gray-50 border border-gray-100">
                    <div class="card-body p-4">
                      <h4 class="text-sm font-bold text-gray-700 uppercase mb-3">Auditor Notes</h4>
                      <div class="bg-white p-3 rounded border border-gray-100 text-xs min-h-[100px]">
                        @forelse($case->activities()->where('action_type', 'stage_changed')->get() as $activity)
                          <div class="mb-2 pb-2 @if(!$loop->last) border-b @endif">
                            <span
                              class="font-bold text-blue-600 block">{{ $activity->created_at->format('M d, Y') }}</span>
                            <span
                              class="text-gray-600 italic">"{{ $activity->changes['notes'] ?? 'No notes recorded.' }}"</span>
                          </div>
                        @empty
                          <p class="text-gray-400">No transition notes recorded.</p>
                        @endforelse
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- TAB 5: RESOLUTION (Standardized) -->
            <div id="content-resolution" class="tab-content">
              <!-- Resolution Header -->
              <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                  <h3 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <span class="p-2 bg-[var(--brand-navy)] text-white rounded-xl shadow-lg">
                      <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </span>
                    Case Resolution
                  </h3>
                  <p class="text-slate-500 mt-1 font-medium pl-12">Finalized documents and measures</p>
                </div>
                @if(auth()->user()->role === 'Administrator' && $case->workflow_stage === 'resolution' && !$case->resolution_decision)
                  <button onclick="openResolutionModal()" 
                    class="btn btn-primary border-none px-6 rounded-xl hover:scale-105 transition-transform">
                    <i data-lucide="gavel" class="w-4 h-4 mr-2"></i>
                    Issue Decision
                  </button>
                @endif
              </div>

              @if($case->workflow_stage === 'resolution' || $case->workflow_stage === 'closed')
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                  <!-- Main Decision Card -->
                  <div class="lg:col-span-8 space-y-6">
                    
                    @if($case->resolution_decision)
                      <div class="bg-white border-l-4 border-l-[var(--brand-navy)] border-y border-r border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
                          <h4 class="font-bold text-slate-800 flex items-center gap-2">
                             <i data-lucide="file-check" class="w-5 h-5 text-[var(--brand-navy)]"></i>
                             Official Decision
                          </h4>
                          @php
                            $badgeClass = match($case->resolution_decision) {
                              'approved' => 'bg-emerald-100 text-emerald-700',
                              'rejected' => 'bg-red-100 text-red-700',
                              default => 'bg-slate-100 text-slate-700'
                            };
                          @endphp
                          <span class="badge {{ $badgeClass }} font-bold border-none">{{ strtoupper($case->resolution_decision) }}</span>
                        </div>
                        <div class="p-6">
                           <div class="flex items-start gap-4 mb-6">
                             <div class="p-3 bg-slate-50 rounded-xl text-[var(--brand-navy)]">
                               <i data-lucide="calendar" class="w-6 h-6"></i>
                             </div>
                             <div>
                               <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Date Finalized</p>
                               <p class="font-bold text-slate-700">{{ $case->resolved_at ? $case->resolved_at->format('M d, Y · h:i A') : '---' }}</p>
                             </div>
                           </div>
                           
                           <div class="space-y-4">
                             <h5 class="text-xs font-black uppercase tracking-widest text-slate-400">Resolution Summary</h5>
                             <p class="text-sm text-slate-600 leading-relaxed italic bg-slate-50 p-4 rounded-xl border border-slate-100">
                               {{ $case->resolution_notes ?? 'No summary notes documented.' }}
                             </p>
                           </div>
                        </div>
                      </div>
                    @else
                      <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-12 text-center">
                        <i data-lucide="layers" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                        <h4 class="font-bold text-slate-400 uppercase tracking-widest text-sm">Awaiting Decision</h4>
                      </div>
                    @endif
                  </div>

                  <!-- Secondary Panels (Right) -->
                  <div class="lg:col-span-4 space-y-6">
                    <!-- Disciplinary Actions -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
                      <div class="px-5 py-3 border-b border-slate-100">
                        <h4 class="font-bold text-slate-800 flex items-center gap-2 text-sm">
                          <i data-lucide="user-x" class="w-4 h-4 text-red-400"></i>
                          Disciplinary
                        </h4>
                      </div>
                      <div class="p-5">
                        @if($case->disciplinary_actions)
                          <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $case->disciplinary_actions }}</p>
                        @else
                          <p class="text-[10px] text-slate-300 font-black uppercase text-center py-2">None Recorded</p>
                        @endif
                      </div>
                    </div>

                    <!-- Preventive Measures -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
                      <div class="px-5 py-3 border-b border-slate-100">
                        <h4 class="font-bold text-slate-800 flex items-center gap-2 text-sm">
                          <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                          Preventive
                        </h4>
                      </div>
                      <div class="p-5">
                        @if($case->preventive_measures)
                          <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $case->preventive_measures }}</p>
                        @else
                          <p class="text-[10px] text-slate-300 font-black uppercase text-center py-2">None Recorded</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @else
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-20 text-center">
                  <i data-lucide="lock" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                  <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Resolution Locked</p>
                  <p class="text-[10px] text-slate-400 mt-1">Available at the final workflow stage.</p>
                </div>
              @endif
            </div>

                       <!-- TAB 6: ACTIVITY LOG (Standardized) -->
            <div id="content-activity" class="tab-content group/activity">
              <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                <div>
                  <h3 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <span class="p-2 bg-[var(--brand-navy)] text-white rounded-xl shadow-lg">
                      <i data-lucide="history" class="w-6 h-6"></i>
                    </span>
                    Activity Audit
                  </h3>
                  <p class="text-slate-500 mt-1 font-medium pl-12">Full system history for Case #{{ $case->case_number }}</p>
                </div>

                <div class="flex items-center gap-2 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm">
                  <i data-lucide="search" class="w-4 h-4 ml-2 text-slate-400"></i>
                  <input type="text" id="activitySearch" placeholder="Search..."
                    class="input input-sm border-none bg-transparent focus:ring-0 w-32 text-xs font-bold">
                </div>
              </div>

              @if($case->activities->count() > 0)
                <div class="relative pl-8">
                  <div class="absolute left-3 top-0 bottom-0 w-0.5 bg-slate-100 rounded-full"></div>

                  <div class="space-y-6" id="activityTimeline">
                    @foreach($case->activities as $activity)
                      <div class="activity-entry relative group/item"
                           data-content="{{ strtolower($activity->action_description) }}"
                           data-action="{{ strtolower($activity->action_type ?? '') }}">
                        <div class="absolute -left-[29px] top-1 w-2.5 h-2.5 rounded-full bg-white border-2 border-[var(--brand-navy)] z-10"></div>

                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm hover:border-[var(--brand-gold)] transition-all">
                          <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                              <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-black uppercase text-[var(--brand-navy)] tracking-widest">
                                  {{ $activity->action_description }}
                                </span>
                                <span class="text-slate-300">•</span>
                                <span class="text-[10px] font-bold text-slate-400">
                                  {{ $activity->created_at->diffForHumans() }}
                                </span>
                              </div>

                              <p class="text-[11px] text-slate-500 font-medium">
                                Performed by
                                <span class="text-slate-800 font-bold">{{ $activity->user_name ?? 'System' }}</span>
                              </p>

                              @if($activity->changes)
                                <div class="mt-3 bg-slate-50 rounded-xl p-3 border border-slate-100">
                                  @php
                                    $changes = is_string($activity->changes) ? json_decode($activity->changes, true) : $activity->changes;
                                    $changes = is_array($changes) ? $changes : [];
                                  @endphp

                                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($changes as $k => $v)
                                      @if(!is_array($v) && $k !== 'notes')
                                        <div class="flex items-center justify-between text-[10px] border-b border-slate-200/50 py-1">
                                          <span class="font-black text-slate-400 uppercase tracking-tighter">
                                            {{ str_replace('_', ' ', $k) }}
                                          </span>
                                          <span class="font-bold text-slate-700">{{ $v }}</span>
                                        </div>
                                      @endif
                                    @endforeach
                                  </div>
                                </div>
                              @endif
                            </div>

                            <div class="text-right flex flex-col items-end">
                              <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                                {{ $activity->created_at->format('M d, Y') }}
                              </p>
                              <p class="text-[9px] font-medium text-slate-400">
                                {{ $activity->created_at->format('h:i A') }}
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              @else
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-16 text-center">
                  <i data-lucide="inbox" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                  <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No Activity Yet</p>
                  <p class="text-[10px] text-slate-400 mt-1">No actions recorded for this case.</p>
                </div>
              @endif
            </div>

            <!-- TAB 7: CASE DOCKET (Official Legal Format) -->
            <div id="content-docket" class="tab-content">
              <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                <div>
                  <h3 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <span class="p-2 bg-[var(--brand-navy)] text-white rounded-xl shadow-lg">
                      <i data-lucide="scroll" class="w-6 h-6"></i>
                    </span>
                    Official Case Docket
                  </h3>
                  <p class="text-slate-500 mt-1 font-medium pl-12">Certified judicial record and activity ledger</p>
                </div>
                <button onclick="window.print()" class="btn btn-outline btn-sm gap-2 rounded-lg">
                  <i data-lucide="printer" class="w-4 h-4"></i>
                  Print Docket
                </button>
              </div>

              <!-- Official Docket Layout -->
              <div class="bg-white border-2 border-slate-200 rounded-3xl overflow-hidden shadow-xl max-w-4xl mx-auto printable-docket">
                <!-- Formal Header -->
                <div class="p-10 border-b-4 border-slate-800 bg-slate-50">
                  <div class="text-center mb-10">
                    <h2 class="text-xl font-serif font-black uppercase tracking-[0.2em] text-slate-900 mb-1">Soliera Administrative Services</h2>
                    <h3 class="text-sm font-serif font-bold uppercase tracking-widest text-slate-600">Legal Management Division</h3>
                    <div class="w-24 h-1 bg-slate-900 mx-auto mt-4"></div>
                  </div>

                  <!-- Case Caption -->
                  <div class="grid grid-cols-12 gap-4 font-serif">
                    <div class="col-span-12 md:col-span-5 border-r border-slate-300 pr-6">
                      <p class="font-black text-sm uppercase mb-1">Complainant / Petitioner:</p>
                      <p class="text-lg font-bold text-slate-800 mb-4">SOLIERA ADMINISTRATIVE DEPT</p>

                      <div class="text-center my-4 font-black italic text-slate-400">- versus -</div>

                      <p class="font-black text-sm uppercase mb-1">Respondent / Defendant:</p>
                      <p class="text-lg font-bold text-slate-800">
                        {{ $case->employee_involved ?: ($case->visitor->name ?? 'UNKNOWN RESPONDENT') }}
                      </p>
                    </div>

                    <div class="col-span-12 md:col-span-7 pl-6">
                      <div class="space-y-4">
                        <div class="flex justify-between border-b border-slate-200 pb-1">
                          <span class="text-xs font-black uppercase text-slate-500">Docket Number:</span>
                          <span class="text-sm font-black text-slate-900">{{ $case->case_number }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1">
                          <span class="text-xs font-black uppercase text-slate-500">Case Type:</span>
                          <span class="text-sm font-bold text-slate-700">{{ strtoupper(str_replace('_', ' ', $case->case_type)) }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1">
                          <span class="text-xs font-black uppercase text-slate-500">Filing Date:</span>
                          <span class="text-sm font-bold text-slate-700">{{ $case->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1">
                          <span class="text-xs font-black uppercase text-slate-500">Status:</span>
                          <span class="text-sm font-black text-slate-900 uppercase">{{ $case->statusLabel }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- The Docket Ledger -->
                <div class="p-0">
                  <table class="table-fixed w-full border-collapse">
                    <thead>
                      <tr class="bg-slate-900 text-white font-serif uppercase tracking-widest text-[10px]">
                        <th class="p-4 w-1/4 text-center border-r border-slate-700">Date / Time</th>
                        <th class="p-4 w-3/4 text-left">Entry of Proceeding / Action Taken</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 font-serif">
                      @foreach($case->activities()->oldest()->get() as $activity)
                        <tr class="hover:bg-slate-50 transition-colors">
                          <td class="p-6 text-center align-top border-r border-slate-100">
                            <p class="font-bold text-slate-900 text-sm">{{ $activity->created_at->format('m/d/Y') }}</p>
                            <p class="text-[10px] text-slate-400 font-black">{{ $activity->created_at->format('H:i:s') }}</p>
                          </td>
                          <td class="p-6 align-top">
                            <div class="flex flex-col gap-2">
                              <span class="inline-block px-2 py-0.5 bg-slate-100 text-[10px] font-black uppercase tracking-wider text-slate-600 rounded self-start">
                                {{ strtoupper(str_replace('_', ' ', $activity->action_type)) }}
                              </span>
                              <p class="text-sm text-slate-800 font-medium leading-relaxed uppercase">
                                {{ $activity->action_description }}
                              </p>
                              <div class="flex items-center gap-2 mt-1">
                                <i data-lucide="user" class="w-3 h-3 text-slate-300"></i>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                                  Attested By: {{ $activity->user_name }}
                                </span>
                              </div>
                            </div>
                          </td>
                        </tr>
                      @endforeach

                      @if($case->workflow_stage === 'closed')
                        <tr class="bg-slate-50">
                          <td class="p-6 text-center align-top border-r border-slate-100">
                            <p class="font-black text-slate-900 text-sm italic">*** END ***</p>
                          </td>
                          <td class="p-6 align-top">
                            <div class="flex flex-col items-center justify-center py-4">
                              <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Archived and Closed</p>
                              <p class="text-xs font-serif italic text-slate-400 mt-2">No further entries allowed for this docket.</p>
                            </div>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>

                <!-- Professional Footer -->
                <div class="p-10 bg-slate-50 border-t border-slate-200 text-center">
                  <p class="text-[10px] font-black uppercase tracking-[0.5em] text-slate-300">Certified Official Record</p>
                  <p class="text-[9px] text-slate-400 mt-2">Generated on {{ now()->format('M d, Y · H:i:s') }} · Project Soliera - ERP Administrative Module</p>
                </div>
              </div>
            </div>

            <script>
              // Frontend Filtering & Search Logic (Activity Tab)
              document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('activitySearch');
                const actionFilter = document.getElementById('actionFilter'); // optional (kung wala sa UI, ok lang)
                const entries = document.querySelectorAll('.activity-entry');

                function filterEntries() {
                  const searchTerm = (searchInput?.value || '').toLowerCase();
                  const selectedAction = actionFilter ? actionFilter.value : '';

                  entries.forEach(entry => {
                    const action = (entry.dataset.action || '');
                    const content = (entry.dataset.content || '');

                    const actionMatch = !selectedAction || action === selectedAction;
                    const searchMatch = content.includes(searchTerm);

                    if (actionMatch && searchMatch) {
                      entry.style.display = 'block';
                    } else {
                      entry.style.display = 'none';
                    }
                  });
                }

                searchInput?.addEventListener('input', filterEntries);
                actionFilter?.addEventListener('change', filterEntries);
              });
            </script>

          </div> <!-- /card-body -->
        </div> <!-- /card -->
      </main>
    </div> <!-- /main content wrapper -->
  </div> <!-- /layout wrapper -->

  <!-- MODALS -->

  <!-- Stage Transition Modal -->
  <div id="stageTransitionModal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg mb-4">Advance Workflow Stage</h3>
      <p class="text-sm text-gray-600 mb-4">
        Current stage: <span class="font-semibold">{{ ucfirst($case->workflow_stage) }}</span>
      </p>
      <form id="stageTransitionForm">
        @csrf
        <input type="hidden" name="current_stage" value="{{ $case->workflow_stage }}">
        <div class="form-control mb-4">
          <label class="label">
            <span class="label-text font-bold">
              {{ $case->workflow_stage === 'resolution' ? 'Final Closing Remarks' : 'Transition Notes' }}
            </span>
          </label>
          <textarea id="transitionNotes" name="notes"
            class="textarea textarea-bordered focus:ring-2 focus:ring-blue-500" rows="4"
            placeholder="{{ $case->workflow_stage === 'resolution' ? 'Add final closing remarks before archiving...' : 'Add any notes about this transition...' }}"></textarea>
          @if($case->workflow_stage === 'resolution')
            <p class="text-[10px] text-gray-500 mt-2 px-1">Note: This will move the case to the final ARCHIVED state. No
              more edits possible.</p>
          @endif
        </div>
        <div class="modal-action">
          <button type="button" onclick="closeStageTransitionModal()"
            class="btn btn-ghost hover:bg-gray-200">Cancel</button>
          <button type="submit" id="confirmTransitionBtn" class="btn btn-primary px-8">
            {{ $case->workflow_stage === 'resolution' ? 'Finalize & Close' : 'Confirm Transition' }}
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Upload Evidence Modal -->
  <div id="uploadEvidenceModal" class="modal">
    <div class="modal-box max-w-2xl">
      <h3 class="font-bold text-lg mb-4">Upload Evidence</h3>
      <form action="{{ route('legal.cases.evidence', $case->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Evidence Type*</span></label>
            <select name="evidence_type" class="select select-bordered" required>
              <option value="">Select type</option>
              <option value="document">Document</option>
              <option value="photo">Photo</option>
              <option value="video">Video</option>
              <option value="audio">Audio</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Title*</span></label>
            <input type="text" name="evidence_description" class="input input-bordered" required
              placeholder="Brief title for this evidence">
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Description</span></label>
            <textarea name="description" class="textarea textarea-bordered" rows="2"
              placeholder="Optional description"></textarea>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">File*</span></label>
            <input type="file" name="evidence_file" class="file-input file-input-bordered w-full" required>
            <label class="label"><span class="label-text-alt">Max file size: 10MB</span></label>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Collection Date*</span></label>
            <input type="date" name="evidence_date" class="input input-bordered" required>
          </div>
        </div>
        <div class="modal-action">
          <button type="button" onclick="closeUploadEvidenceModal()" class="btn btn-ghost">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i data-lucide="upload" class="w-4 h-4 mr-2"></i>
            Upload
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Add Witness Modal -->
  <div id="addWitnessModal" class="modal">
    <div class="modal-box max-w-2xl">
      <h3 class="font-bold text-lg mb-4">Add Witness</h3>
      <form action="{{ route('legal.cases.witness.add', $case->id) }}" method="POST">
        @csrf
        <div class="space-y-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Witness Name*</span></label>
            <input type="text" name="witness_name" class="input input-bordered" required>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="form-control">
              <label class="label"><span class="label-text">Department</span></label>
              <input type="text" name="witness_department" class="input input-bordered">
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Position</span></label>
              <input type="text" name="witness_position" class="input input-bordered">
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="form-control">
              <label class="label"><span class="label-text">Contact Number</span></label>
              <input type="text" name="witness_contact" class="input input-bordered">
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Email</span></label>
              <input type="email" name="witness_email" class="input input-bordered">
            </div>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Statement Type</span></label>
            <select name="statement_type" class="select select-bordered">
              <option value="written">Written Statement</option>
              <option value="verbal">Verbal Statement</option>
              <option value="video">Video Statement</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Statement</span></label>
            <textarea name="statement" class="textarea textarea-bordered" rows="4"
              placeholder="Record witness statement here..."></textarea>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Statement Date</span></label>
            <input type="datetime-local" name="statement_date" class="input input-bordered">
          </div>
        </div>
        <div class="modal-action">
          <button type="button" onclick="closeAddWitnessModal()" class="btn btn-ghost">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
            Add Witness
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Investigation Note Modal -->
  <div id="investigationNoteModal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg mb-4">Add Investigation Note</h3>
      <form action="{{ route('legal.cases.investigation.note', $case->id) }}" method="POST">
        @csrf
        <div class="form-control mb-4">
          <label class="label"><span class="label-text">Investigation Note*</span></label>
          <textarea name="investigation_notes" class="textarea textarea-bordered" rows="6" required
            placeholder="Add investigation notes...">{{ $case->investigation_notes }}</textarea>
        </div>
        <div class="form-control mb-4">
          <label class="label"><span class="label-text">Investigation Findings</span></label>
          <textarea name="investigation_findings" class="textarea textarea-bordered" rows="4"
            placeholder="Final investigation findings...">{{ $case->investigation_findings }}</textarea>
        </div>
        <div class="modal-action">
          <button type="button" onclick="closeInvestigationNoteModal()" class="btn btn-ghost">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Notes</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Resolution Modal -->
  <div id="resolutionModal" class="modal">
    <div class="modal-box max-w-2xl">
      <h3 class="font-bold text-lg mb-4">Case Resolution</h3>
      <form action="{{ route('legal.cases.resolution', $case->id) }}" method="POST">
        @csrf
        <div class="space-y-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Resolution Decision*</span></label>
            <select name="resolution_decision" class="select select-bordered" required>
              <option value="">Select decision</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
              <option value="dismissed">Dismissed</option>
              <option value="settled">Settled</option>
              <option value="pending">Pending Further Review</option>
            </select>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Resolution Notes*</span></label>
            <textarea name="resolution_notes" class="textarea textarea-bordered" rows="4" required
              placeholder="Explain the resolution decision..."></textarea>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Disciplinary Actions</span></label>
            <textarea name="disciplinary_actions" class="textarea textarea-bordered" rows="3"
              placeholder="List any disciplinary actions taken..."></textarea>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Preventive Measures</span></label>
            <textarea name="preventive_measures" class="textarea textarea-bordered" rows="3"
              placeholder="List preventive measures..."></textarea>
          </div>

          @if($case->case_type === 'facility_damage' || $case->case_type === 'property_damage')
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mt-4">
              <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                <i data-lucide="wrench" class="w-4 h-4"></i>
                Facility Damage Details
              </h4>
              <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                  <label class="label"><span class="label-text text-xs uppercase font-bold">Estimated Cost
                      (₱)</span></label>
                  <input type="number" name="amount" class="input input-bordered" placeholder="0.00"
                    value="{{ $case->amount }}">
                </div>
                <div class="form-control">
                  <label class="label"><span class="label-text text-xs uppercase font-bold">Repair Status</span></label>
                  <select name="repair_status" class="select select-bordered text-sm">
                    <option value="none">N/A</option>
                    <option value="pending">Pending Repair</option>
                    <option value="in_progress">Under Repair</option>
                    <option value="repaired">Fixed / Repaired</option>
                  </select>
                </div>
              </div>
              <div class="mt-3">
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="checkbox" name="mark_facility_unavailable" class="checkbox checkbox-warning" value="1">
                  <span class="text-sm font-semibold">Mark Facility as Unavailable during repair?</span>
                </label>
              </div>
            </div>
          @endif
        </div>
        <div class="modal-action">
          <button type="button" onclick="closeResolutionModal()" class="btn btn-ghost">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit Resolution</button>
        </div>
      </form>
    </div>
  </div>

  @include('partials.soliera_js')

  <script>
    lucide.createIcons();

    // Tab switching with persistence
    function switchTab(tabName) {
      try {
        // Check if tab is disabled
        const tabElement = document.getElementById('tab-' + tabName);
        if (tabElement && tabElement.classList.contains('disabled')) {
          return false;
        }

        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

        const contentElement = document.getElementById('content-' + tabName);
        
        if (contentElement) contentElement.classList.add('active');
        if (tabElement) tabElement.classList.add('active');

        // Save active tab to localStorage
        localStorage.setItem('activeTab', tabName);
        
        // Update URL hash
        window.location.hash = tabName;

        lucide.createIcons();
      } catch (error) {
        console.error('Error switching tab:', error);
      }
    }

    // Restore active tab on page load
    function restoreActiveTab() {
      // Try to get tab from URL hash first, then localStorage
      let activeTab = window.location.hash.substring(1) || localStorage.getItem('activeTab') || 'overview';
      
      // Validate that the tab exists and is not disabled
      const tabElement = document.getElementById('tab-' + activeTab);
      if (!tabElement || tabElement.classList.contains('disabled')) {
        activeTab = 'overview'; // fallback to overview
      }
      
      switchTab(activeTab);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
      restoreActiveTab();
    });

    // Modal Handle Transition
    document.getElementById('stageTransitionForm')?.addEventListener('submit', function (e) {
      e.preventDefault();
      const notes = document.getElementById('transitionNotes')?.value || '';
      const btn = document.getElementById('confirmTransitionBtn');

      if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="loading loading-spinner loading-sm"></span> <span class="loading-text">Processing...</span>';
      }

      submitTransition(null, notes, null);
    });

    // Modal functions
    function openStageTransitionModal() {
      document.getElementById('stageTransitionModal')?.classList.add('modal-open');
    }
    function closeStageTransitionModal() {
      document.getElementById('stageTransitionModal')?.classList.remove('modal-open');
    }
    function openUploadEvidenceModal() {
      document.getElementById('uploadEvidenceModal')?.classList.add('modal-open');
    }
    function closeUploadEvidenceModal() {
      document.getElementById('uploadEvidenceModal')?.classList.remove('modal-open');
    }
    function openAddWitnessModal() {
      document.getElementById('addWitnessModal')?.classList.add('modal-open');
    }
    function closeAddWitnessModal() {
      document.getElementById('addWitnessModal')?.classList.remove('modal-open');
    }
    function openInvestigationNoteModal() {
      document.getElementById('investigationNoteModal')?.classList.add('modal-open');
    }
    function closeInvestigationNoteModal() {
      document.getElementById('investigationNoteModal')?.classList.remove('modal-open');
    }
    function openResolutionModal() {
      document.getElementById('resolutionModal')?.classList.add('modal-open');
    }
    function closeResolutionModal() {
      document.getElementById('resolutionModal')?.classList.remove('modal-open');
    }

    function handleReviewAction(action) {
      let title = '';
      let text = '';
      let confirmBtnColor = '';
      let status = '';
      let nextStage = '';

      if (action === 'approve') {
        title = 'Approve for Resolution';
        text = 'This case will move to the Resolution stage.';
        confirmBtnColor = '#22c55e';
        status = 'resolved';
        nextStage = 'resolution';
      } else if (action === 'return') {
        title = 'Return to Investigation';
        text = 'Please specify what additional information is needed.';
        confirmBtnColor = '#f59e0b';
        status = 'needs_more_info';
        nextStage = 'investigation';
      } else if (action === 'reject') {
        title = 'Reject Case';
        text = 'This case will be marked as Not Approved and moved to Resolution for finalizing.';
        confirmBtnColor = '#ef4444';
        status = 'not_approved';
        nextStage = 'resolution';
      }

      Swal.fire({
        title: title,
        text: text,
        input: 'textarea',
        inputPlaceholder: 'Add transition notes...',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        confirmButtonColor: confirmBtnColor,
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          submitTransition(nextStage, result.value, status);
        }
      });
    }

    function submitTransition(nextStage, notes, status) {
      const url = "{{ route('legal.cases.transition', $case->id) }}";
      const btn = document.getElementById('confirmTransitionBtn');
      
      // Create AbortController for timeout
      const controller = new AbortController();
      const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 second timeout

      fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
          current_stage: "{{ $case->workflow_stage }}",
          next_stage: nextStage,
          notes: notes,
          status: status
        }),
        signal: controller.signal
      })
      .then(async response => {
        clearTimeout(timeoutId);
        
        // Check if response is ok
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const contentType = response.headers.get("content-type") || '';
        if (contentType.includes("application/json")) {
          const data = await response.json();
          if (data.success) {
            // Update UI dynamically instead of reloading
            updateWorkflowStage(data.stage || nextStage);
            
            // Show success message
            Swal.fire('Success!', 'Case stage updated.', 'success').then(() => {
              // Auto-switch to the next available tab
              switchToNextAvailableTab(data.stage || nextStage);
            });
          } else {
            throw new Error(data.message || 'Failed to update stage.');
          }
        } else {
          const text = await response.text();
          console.error('Server returned non-JSON response:', text);
          throw new Error('Server returned an unexpected response. Please try again.');
        }
      })
      .catch(error => {
        clearTimeout(timeoutId);
        
        console.error('Transition error:', error);
        
        let errorMessage = 'An error occurred while updating the case stage.';
        
        if (error.name === 'AbortError') {
          errorMessage = 'Request timed out. The server is taking too long to respond. Please try again.';
        } else if (error.message) {
          errorMessage = error.message;
        }
        
        Swal.fire('Error', errorMessage, 'error');
      })
      .finally(() => {
        // Always reset button state
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = "{{ $case->workflow_stage === 'resolution' ? 'Finalize & Close' : 'Confirm Transition' }}";
        }
      });
    }

    // Update workflow stage UI dynamically (optimized)
    function updateWorkflowStage(newStage) {
      // Use requestAnimationFrame for smoother updates
      requestAnimationFrame(() => {
        // Update workflow progress bar
        const progressMap = {
          'filing': 0,
          'investigation': 25,
          'review': 50,
          'resolution': 75,
          'closed': 100
        };
        
        const progressBar = document.querySelector('.workflow-line-progress');
        if (progressBar) {
          progressBar.style.transition = 'width 0.5s ease-in-out';
          progressBar.style.width = (progressMap[newStage] || 0) + '%';
        }

        // Update workflow steps efficiently
        const stages = ['filing', 'investigation', 'review', 'resolution', 'closed'];
        const currentStageIndex = stages.indexOf(newStage);
        
        const workflowSteps = document.querySelectorAll('.workflow-step');
        workflowSteps.forEach((step, index) => {
          const isActive = index === currentStageIndex;
          const isCompleted = index < currentStageIndex;
          
          // Use classList.toggle for better performance
          step.classList.toggle('active', isActive);
          step.classList.toggle('completed', isCompleted);
        });

        // Enable/disable tabs based on new stage
        updateTabStates(newStage);
      });
    }

    // Update tab enabled/disabled states (optimized)
    function updateTabStates(currentStage) {
      const tabConfig = {
        'filing': ['investigation', 'review', 'resolution'],
        'investigation': ['review', 'resolution'],
        'review': ['resolution'],
        'resolution': [],
        'closed': []
      };

      const disabledTabs = tabConfig[currentStage] || [];
      
      // Batch DOM updates for better performance
      requestAnimationFrame(() => {
        // Enable all tabs first
        document.querySelectorAll('.tab-btn').forEach(tab => {
          tab.classList.remove('disabled');
          tab.disabled = false;
          
          // Update onclick handler efficiently
          const tabName = tab.id.replace('tab-', '');
          tab.onclick = function() {
            switchTab(tabName);
          };
          
          // Remove lock icons efficiently
          const lockIcon = tab.querySelector('i[data-lucide="lock"]');
          if (lockIcon) lockIcon.remove();
        });

        // Disable appropriate tabs
        disabledTabs.forEach(tabName => {
          const tab = document.getElementById('tab-' + tabName);
          if (tab) {
            tab.classList.add('disabled');
            tab.disabled = true;
            tab.onclick = function() { return false; };
            
            // Add lock icon if not present
            if (!tab.querySelector('i[data-lucide="lock"]')) {
              const lockIcon = document.createElement('i');
              lockIcon.setAttribute('data-lucide', 'lock');
              lockIcon.className = 'w-3 h-3 ml-1 text-gray-400';
              tab.appendChild(lockIcon);
            }
          }
        });
        
        // Reinitialize Lucide icons once
        lucide.createIcons();
      });
    }

    // Switch to the next available tab after stage transition
    function switchToNextAvailableTab(newStage) {
      const stageToTabMap = {
        'investigation': 'investigation',
        'review': 'review', 
        'resolution': 'resolution',
        'closed': 'activity' // Go to activity log when closed
      };
      
      const targetTab = stageToTabMap[newStage];
      if (targetTab) {
        switchTab(targetTab);
      }
    }

    // Delete functions
    function deleteEvidence(id) {
      Swal.fire({
        title: 'Delete Evidence?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`/legal/cases/evidence/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
          })
          .then(r => r.json())
          .then(data => {
            if (data.success) location.reload();
          });
        }
      });
    }

    function deleteWitness(id) {
      Swal.fire({
        title: 'Remove Witness?',
        text: 'This will remove the witness record from this case.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`/legal/cases/witness/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
          })
          .then(r => r.json())
          .then(data => {
            if (data.success) location.reload();
          });
        }
      });
    }

    // ✅ FIXED: Close modals when clicking outside (kumpleto na closing braces)
    document.querySelectorAll('.modal').forEach(modal => {
      modal.addEventListener('click', function (e) {
        if (e.target === modal) {
          modal.classList.remove('modal-open');
        }
      });
    });
  </script>
</body>
</html>
