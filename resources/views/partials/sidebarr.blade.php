<div
  class="bg-[#001f54] flex flex-col h-screen transition-all duration-300 ease-in-out shadow-xl flex-shrink-0 fixed lg:relative z-50 -translate-x-full lg:translate-x-0 w-60"
  id="sidebar">
  <!-- Sidebar Header -->
  <div class="flex items-center justify-center flex-shrink-0 px-3 py-6">
    <div class="flex items-center justify-center flex-1">
      <img id="sidebar-logo" src="{{asset('images/logo/logofinal.png')}}" alt="Soliera Logo"
        class="h-28 w-auto object-contain sidebar-logo-transition">
      <img id="sonly" class="hidden w-14 h-14 object-contain" src="{{asset('images/logo/sonly.png')}}" alt="Soliera">
    </div>
    <!-- Mobile Close Button -->
    <button onclick="toggleSidebar()"
      class="lg:hidden absolute right-3 top-4 p-2 rounded-lg hover:bg-blue-800/50 text-white transition-all duration-200">
      <i data-lucide="x" class="w-5 h-5"></i>
    </button>
  </div>

  <!-- Navigation Menu - Scrollable -->
  <div class="flex-1 overflow-y-auto overflow-x-hidden sidebar-scroll" style="flex: 1 1 auto; min-height: 0;">
    <nav class="px-3 py-4 space-y-1">
      @php
        $roleService = app(\App\Services\RolePermissionService::class);
        $userRole = $roleService->getUserRole();
      @endphp

      <!-- Section Label -->
      @if($userRole !== 'Admin Manager')
        <div class="px-3 py-2 mb-1">
          <span class="text-[10px] font-semibold uppercase tracking-widest text-blue-300/70 sidebar-text">Main Menu</span>
        </div>
      @endif

      <!-- 1. Admin Manager (System Admin) -->
      @if($userRole === 'Admin Manager')
        {{-- Admin Dashboard Removed
        <a href="{{ route('dashboard') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="layout-dashboard" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Admin Dashboard</span>
          </div>
        </a>
        --}}

        <div class="px-3 py-2 mt-3 mb-1">
          <span class="text-[10px] font-semibold uppercase tracking-widest text-blue-300/70 sidebar-text">System
            Management</span>
        </div>

        <a href="{{ route('access.department_accounts') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('access.department_accounts*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="users" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Department Accounts</span>
          </div>
        </a>
        <a href="{{ route('access.audit_logs') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('access.audit_logs') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="activity" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Audit Logs</span>
          </div>
        </a>
        <a href="{{ route('settings.index') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="settings" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Settings</span>
          </div>
        </a>

        <div class="px-3 py-2 mt-3 mb-1">
          <span
            class="text-[10px] font-semibold uppercase tracking-widest text-blue-300/70 sidebar-text">Administration</span>
        </div>

        <a href="{{ route('vault.documents.index_new') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('vault.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="files" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Central Vault</span>
          </div>
        </a>
        <a href="{{ route('facilities.reservations.list') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('facilities.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="calendar-check" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Resource Desk</span>
          </div>
        </a>
        <a href="{{ route('visitors.pre_registrations') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="users" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Visitor Desk</span>
          </div>
        </a>
        <a href="{{ route('compliance.permits') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('compliance.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="file-check" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Compliance Records</span>
          </div>
        </a>

        <!-- 2. Owner -->
      @elseif($userRole === 'Owner')
        <a href="{{ route('executive.overview') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.overview') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="layout-dashboard" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Governance Overview</span>
          </div>
        </a>
        <a href="{{ route('executive.risk') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.risk') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="shield-alert" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Risk & Compliance</span>
          </div>
        </a>
        <a href="{{ route('executive.approvals') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.approvals') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="check-square" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Approvals</span>
          </div>
        </a>

        <div class="px-3 py-2 mt-3 mb-1">
          <span class="text-[10px] font-semibold uppercase tracking-widest text-blue-300/70 sidebar-text">Executive
            Desks</span>
        </div>

        <a href="{{ route('executive.contracts') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.contracts') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="gavel" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Legal Governance</span>
          </div>
        </a>
        <a href="{{ route('executive.permits') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.permits') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="file-check" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Compliance Center</span>
          </div>
        </a>
        <a href="{{ route('executive.facilities.calendar') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.facilities.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="building" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Resource Oversight</span>
          </div>
        </a>
        <a href="{{ route('executive.retention') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.retention') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="archive" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Doc Vault</span>
          </div>
        </a>
        <a href="{{ route('executive.sensitive_log') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.sensitive_log') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="users" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Visitor Oversight</span>
          </div>
        </a>
        <a href="{{ route('executive.kpis') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.kpis') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="bar-chart-2" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Reports & Audit</span>
          </div>
        </a>
        <!-- Added Audit Logs for Executive -->
        <a href="{{ route('executive.audit_logs') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('executive.audit_logs') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="file-search" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Audit Logs</span>
          </div>
        </a>

        <!-- 3. Legal Officer -->
      @elseif($userRole === 'Legal Officer')
        {{-- Legal Dashboard Removed
        <a href="{{ route('dashboard') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="layout-dashboard" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Legal Dashboard</span>
          </div>
        </a>
        --}}

        <div class="px-3 py-2 mt-3 mb-1">
          <span class="text-[10px] font-semibold uppercase tracking-widest text-blue-300/70 sidebar-text">Legal
            Workspace</span>
        </div>

        <a href="{{ route('legal.contracts.workspace') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('legal.contracts.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="file-text" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Contracts Workspace</span>
          </div>
        </a>
        <a href="{{ route('legal.cases.desk') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('legal.cases.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="briefcase" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Cases & Disputes</span>
          </div>
        </a>
        <a href="{{ route('legal.templates') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('legal.templates') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="copy" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Templates & Clauses</span>
          </div>
        </a>
        <a href="{{ route('legal.ai.insights') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('legal.ai.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="brain" class="sidebar-icon"></i></div>
            <span class="sidebar-text">AI Legal Assistant</span>
          </div>
        </a>
        <a href="{{ route('vault.documents.index_new') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('vault.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="folder-lock" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Legal Vault</span>
          </div>
        </a>

        <!-- 4. Compliance Lead -->
      @elseif($userRole === 'Compliance Lead')
        <a href="{{ route('compliance.dashboard') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('compliance.dashboard') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="layout-dashboard" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Compliance Dashboard</span>
          </div>
        </a>

        <div class="px-3 py-2 mt-3 mb-1">
          <span class="text-[10px] font-semibold uppercase tracking-widest text-blue-300/70 sidebar-text">Compliance
            Workspace</span>
        </div>

        <a href="{{ route('compliance.permits') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('compliance.permits*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="clipboard-check" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Permits</span>
          </div>
        </a>
        <a href="{{ route('compliance.renewals') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('compliance.renewals') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="refresh-cw" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Renewals</span>
          </div>
        </a>
        <a href="{{ route('compliance.evidence') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('compliance.evidence') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="file-text" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Evidence</span>
          </div>
        </a>
        <a href="{{ route('compliance.corrective_actions') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('compliance.corrective_actions') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="alert-triangle" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Corrective Actions</span>
          </div>
        </a>
        <a href="{{ route('compliance.ai.insights') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('compliance.ai.insights') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="brain" class="sidebar-icon"></i></div>
            <span class="sidebar-text">AI Insights</span>
          </div>
        </a>

        <!-- 7. Security Supervisor -->
      @elseif($userRole === 'Security Supervisor')
        <div class="px-3 py-2 mt-3 mb-1">
          <span class="text-[10px] font-semibold uppercase tracking-widest text-blue-300/70 sidebar-text">Security
            Operations</span>
        </div>

        <a href="{{ route('visitors.check_in_form') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.check_in_form') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="user-check" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Visitor Check-in</span>
          </div>
        </a>
        <a href="{{ route('visitors.check_out_form') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.check_out_form') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="log-out" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Visitor Check-out</span>
          </div>
        </a>
        <a href="{{ route('visitors.badges') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.badges') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="credit-card" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Badges</span>
          </div>
        </a>
        <a href="{{ route('visitors.incidents') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.incidents') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="alert-circle" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Incidents</span>
          </div>
        </a>
        <a href="{{ route('visitors.zones') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.zones') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="map" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Zones</span>
          </div>
        </a>
        <a href="{{ route('facilities.calendar.view') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('facilities.calendar.view') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="calendar" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Facility Monitor</span>
          </div>
        </a>

        <!-- 6. Front Office Manager -->
      @elseif($userRole === 'Front Office Manager')
        {{-- Front Desk Dashboard Removed
        <a href="{{ route('dashboard') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="layout-dashboard" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Front Desk Dashboard</span>
          </div>
        </a>
        --}}

        <div class="px-3 py-2 mt-3 mb-1">
          <span class="text-[10px] font-semibold uppercase tracking-widest text-blue-300/70 sidebar-text">Front
            Desk</span>
        </div>

        <a href="{{ route('visitors.pre_registrations') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.pre_registrations') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="users" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Pre-Registrations</span>
          </div>
        </a>
        <a href="{{ route('visitors.check_in_form') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.check_in_form') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="user-check" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Check-in</span>
          </div>
        </a>
        <a href="{{ route('visitors.check_out_form') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.check_out_form') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="log-out" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Check-out</span>
          </div>
        </a>
        <a href="{{ route('visitors.badges') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('visitors.badges') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="credit-card" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Badges</span>
          </div>
        </a>
        <a href="{{ route('front-office.guest-profiles') }}" class="sidebar-link block">
          <div class="sidebar-item {{ request()->routeIs('front-office.guest-profiles') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper"><i data-lucide="contact" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Guest Profiles</span>
          </div>
        </a>

        <!-- 9. Default Fallback -->
      @else
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
          class="sidebar-link block">
          <div class="sidebar-item">
            <div class="sidebar-icon-wrapper"><i data-lucide="log-out" class="sidebar-icon"></i></div>
            <span class="sidebar-text">Logout</span>
          </div>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
          @csrf
        </form>
      @endif

      <!-- Sync Management (Global for Admins) -->
      @if(in_array($userRole, ['Admin Manager', 'Owner']))
        <a href="{{ route('integration-sync.index') }}" class="sidebar-link block mt-4">
          <div class="sidebar-item {{ request()->routeIs('integration-sync.*') ? 'active' : '' }}">
            <div class="sidebar-icon-wrapper">
              <i data-lucide="refresh-cw" class="sidebar-icon"></i>
            </div>
            <span class="sidebar-text">Sync Management</span>
          </div>
        </a>
      @endif

    </nav>
  </div>
</div>
<div class="sidebar-overlay fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

<style>
  /* ===== SIDEBAR BASE STYLES ===== */
  #sidebar {
    background: #001f54;
  }

  /* Smooth scrollbar */
  .sidebar-scroll {
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
  }

  .sidebar-scroll::-webkit-scrollbar {
    width: 4px;
  }

  .sidebar-scroll::-webkit-scrollbar-track {
    background: transparent;
  }

  .sidebar-scroll::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
  }

  .sidebar-scroll::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.2);
  }

  /* ===== SIDEBAR ITEMS ===== */
  .sidebar-item {
    display: flex;
    align-items: center;
    padding: 0.625rem 0.75rem;
    font-size: 0.8125rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.85);
    border-radius: 0.5rem;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    margin-bottom: 2px;
  }

  .sidebar-item:hover {
    background: rgba(59, 130, 246, 0.25);
    color: #ffffff;
  }

  .sidebar-item.active {
    background: rgba(59, 130, 246, 0.35);
    color: #ffffff;
  }

  /* ===== ICON STYLES ===== */
  .sidebar-icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 0.5rem;
    background: rgba(59, 130, 246, 0.15);
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .sidebar-item:hover .sidebar-icon-wrapper {
    background: rgba(59, 130, 246, 0.3);
  }

  .sidebar-item.active .sidebar-icon-wrapper {
    background: rgba(59, 130, 246, 0.4);
  }

  .sidebar-icon {
    width: 18px;
    height: 18px;
    color: #F7B32B;
    transition: all 0.2s ease;
  }

  .sidebar-text {
    margin-left: 0.75rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  /* ===== CHEVRON ANIMATION ===== */
  .sidebar-chevron {
    width: 16px;
    height: 16px;
    color: rgba(255, 255, 255, 0.4);
    transition: transform 0.1s ease-out, color 0.1s ease-out;
    flex-shrink: 0;
    transition-delay: 0s;
  }

  .sidebar-dropdown input:checked+label .sidebar-chevron {
    transform: rotate(90deg);
    color: rgba(255, 255, 255, 0.8);
    transition: transform 0.15s ease-in, color 0.15s ease-in;
    transition-delay: 0s;
  }

  /* ===== SUBMENU STYLES ===== */
  .sidebar-submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.1s ease-out, opacity 0.1s ease-out, padding 0.1s ease-out;
    opacity: 0;
    padding-left: 2.75rem;
    padding-top: 0;
    padding-bottom: 0;
    transition-delay: 0s;
  }

  .sidebar-dropdown input:checked~.sidebar-submenu {
    max-height: 300px;
    opacity: 1;
    padding-top: 0.25rem;
    padding-bottom: 0.25rem;
    transition: max-height 0.15s ease-in, opacity 0.15s ease-in, padding 0.15s ease-in;
    transition-delay: 0s;
  }

  .sidebar-submenu-item {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.65);
    border-radius: 0.375rem;
    transition: all 0.2s ease;
    margin-bottom: 2px;
  }

  .sidebar-submenu-item:hover {
    background: rgba(59, 130, 246, 0.2);
    color: #ffffff;
  }

  .sidebar-submenu-item.active {
    background: rgba(59, 130, 246, 0.3);
    color: #ffffff;
  }

  .sidebar-submenu-icon {
    width: 14px;
    height: 14px;
    color: #F7B32B;
    opacity: 0.7;
    flex-shrink: 0;
  }

  .sidebar-submenu-item.active .sidebar-submenu-icon {
    opacity: 1;
  }

  /* ===== MOBILE STYLES ===== */
  @media (max-width: 1023px) {
    #sidebar {
      position: fixed;
      z-index: 50;
      width: 15rem;
      left: 0;
      top: 0;
      bottom: 0;
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #sidebar.translate-x-0 {
      transform: translateX(0);
    }

    #sidebar.-translate-x-full {
      transform: translateX(-100%);
    }

    #sidebar.translate-x-0~.sidebar-overlay {
      display: block !important;
    }
  }

  @media (min-width: 1024px) {
    .sidebar-overlay {
      display: none !important;
    }
  }

  /* ===== COLLAPSED SIDEBAR ===== */
  /* Support w-16, w-20, and collapsed class */
  #sidebar.w-16,
  #sidebar.w-20,
  #sidebar.collapsed {
    width: 4.5rem !important;
  }

  /* Hide ALL text, labels, and chevron elements when collapsed */
  #sidebar.w-16 .sidebar-text,
  #sidebar.w-16 .sidebar-chevron,
  #sidebar.collapsed .sidebar-text,
  #sidebar.collapsed .sidebar-chevron,
  #sidebar.w-16 [data-lucide="chevron-right"],
  #sidebar.w-20 [data-lucide="chevron-right"],
  #sidebar.collapsed [data-lucide="chevron-right"],
  #sidebar.w-16 .sidebar-dropdown label i:last-child,
  #sidebar.w-20 .sidebar-dropdown label i:last-child,
  #sidebar.collapsed .sidebar-dropdown label i:last-child,
  #sidebar.w-16 span:not(.sidebar-icon),
  #sidebar.w-20 span:not(.sidebar-icon),
  #sidebar.collapsed span:not(.sidebar-icon),
  #sidebar.w-16 .sidebar-text,
  #sidebar.w-20 .sidebar-text,
  #sidebar.collapsed .sidebar-text,
  #sidebar.w-16 nav span,
  #sidebar.w-20 nav span,
  #sidebar.collapsed nav span {
    display: none !important;
    opacity: 0 !important;
    width: 0 !important;
    height: 0 !important;
    visibility: hidden !important;
    overflow: hidden !important;
    margin: 0 !important;
    padding: 0 !important;
  }

  /* Center icon wrapper only - hide all text content */
  #sidebar.w-16 .sidebar-item,
  #sidebar.w-20 .sidebar-item,
  #sidebar.collapsed .sidebar-item {
    justify-content: center;
    padding: 0.5rem;
    background: transparent !important;
  }

  /* Hide flex-1 text containers in dropdown labels */
  #sidebar.w-16 .sidebar-item .flex-1,
  #sidebar.w-20 .sidebar-item .flex-1,
  #sidebar.collapsed .sidebar-item .flex-1 {
    display: none !important;
    width: 0 !important;
    opacity: 0 !important;
  }

  #sidebar.w-16 .sidebar-item:hover,
  #sidebar.w-20 .sidebar-item:hover,
  #sidebar.collapsed .sidebar-item:hover {
    background: transparent !important;
  }

  #sidebar.w-16 .sidebar-item.active,
  #sidebar.w-20 .sidebar-item.active,
  #sidebar.collapsed .sidebar-item.active {
    background: transparent !important;
  }

  #sidebar.w-16 .sidebar-item:hover,
  #sidebar.collapsed .sidebar-item:hover {
    background: transparent !important;
  }

  #sidebar.w-16 .sidebar-item.active,
  #sidebar.collapsed .sidebar-item.active {
    background: transparent !important;
  }

  /* Only show the icon wrapper box - ensure it's centered and visible */
  #sidebar.w-16 .sidebar-icon-wrapper,
  #sidebar.w-20 .sidebar-icon-wrapper,
  #sidebar.collapsed .sidebar-icon-wrapper {
    margin: 0 auto;
    width: 40px;
    height: 40px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
  }

  /* Ensure icons are visible */
  #sidebar.w-16 .sidebar-icon,
  #sidebar.w-20 .sidebar-icon,
  #sidebar.collapsed .sidebar-icon {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    width: 18px !important;
    height: 18px !important;
  }

  #sidebar.w-16 .sidebar-item:hover .sidebar-icon-wrapper,
  #sidebar.w-20 .sidebar-item:hover .sidebar-icon-wrapper,
  #sidebar.collapsed .sidebar-item:hover .sidebar-icon-wrapper {
    background: rgba(59, 130, 246, 0.3);
  }

  #sidebar.w-16 .sidebar-item.active .sidebar-icon-wrapper,
  #sidebar.w-20 .sidebar-item.active .sidebar-icon-wrapper,
  #sidebar.collapsed .sidebar-item.active .sidebar-icon-wrapper {
    background: rgba(59, 130, 246, 0.4);
  }

  #sidebar.w-16 .sidebar-item:hover .sidebar-icon-wrapper,
  #sidebar.collapsed .sidebar-item:hover .sidebar-icon-wrapper {
    background: rgba(59, 130, 246, 0.3);
  }

  #sidebar.w-16 .sidebar-item.active .sidebar-icon-wrapper,
  #sidebar.collapsed .sidebar-item.active .sidebar-icon-wrapper {
    background: rgba(59, 130, 246, 0.4);
  }

  /* Force close all submenus when collapsed */
  #sidebar.w-16 .sidebar-submenu,
  #sidebar.w-20 .sidebar-submenu,
  #sidebar.collapsed .sidebar-submenu,
  #sidebar.w-16 .sidebar-dropdown input:checked~.sidebar-submenu,
  #sidebar.w-20 .sidebar-dropdown input:checked~.sidebar-submenu,
  #sidebar.collapsed .sidebar-dropdown input:checked~.sidebar-submenu {
    max-height: 0 !important;
    opacity: 0 !important;
    display: none !important;
    padding: 0 !important;
    overflow: hidden !important;
  }

  /* Hide section labels when collapsed */
  #sidebar.w-16 .px-3.py-2,
  #sidebar.collapsed .px-3.py-2,
  #sidebar.w-16 nav>div:not(.sidebar-dropdown):not(.sidebar-link):not(a),
  #sidebar.collapsed nav>div:not(.sidebar-dropdown):not(.sidebar-link):not(a) {
    display: none !important;
  }

  /* Show small logo when collapsed */
  #sidebar.w-16 #sonly,
  #sidebar.w-20 #sonly,
  #sidebar.collapsed #sonly {
    display: block !important;
    width: 2.5rem;
    height: 2.5rem;
    margin: 0 auto;
  }

  /* Hide main logo when collapsed */
  #sidebar.w-16 #sidebar-logo,
  #sidebar.w-20 #sidebar-logo,
  #sidebar.collapsed #sidebar-logo {
    display: none !important;
  }

  /* Hide mobile close button when collapsed */
  #sidebar.w-16 button[onclick="toggleSidebar()"],
  #sidebar.w-20 button[onclick="toggleSidebar()"],
  #sidebar.collapsed button[onclick="toggleSidebar()"] {
    display: none !important;
  }

  /* Disable pointer events on dropdown checkbox when collapsed */
  #sidebar.w-16 .sidebar-dropdown input[type="checkbox"],
  #sidebar.w-20 .sidebar-dropdown input[type="checkbox"],
  #sidebar.collapsed .sidebar-dropdown input[type="checkbox"] {
    pointer-events: none !important;
  }

  /* Make dropdown labels act like regular links when collapsed */
  #sidebar.w-16 .sidebar-dropdown label,
  #sidebar.w-20 .sidebar-dropdown label,
  #sidebar.collapsed .sidebar-dropdown label {
    pointer-events: none;
  }

  #sidebar.w-16 .sidebar-dropdown,
  #sidebar.w-20 .sidebar-dropdown,
  #sidebar.collapsed .sidebar-dropdown {
    pointer-events: auto;
  }

  /* Reduce nav padding when collapsed */
  #sidebar.w-16 nav,
  #sidebar.w-20 nav,
  #sidebar.collapsed nav {
    padding: 0.5rem !important;
  }

  #sidebar.w-16 nav .space-y-1>*,
  #sidebar.w-20 nav .space-y-1>*,
  #sidebar.collapsed nav .space-y-1>* {
    margin-bottom: 0.25rem;
  }

  /* Logo transition */
  .sidebar-logo-transition {
    transition: opacity 0.3s ease, transform 0.3s ease;
  }

  /* Smooth width transition for sidebar */
  #sidebar {
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* Transition for text hiding */
  .sidebar-text {
    transition: opacity 0.2s ease, width 0.2s ease;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const dropdownToggles = document.querySelectorAll('#sidebar .sidebar-dropdown input[type="checkbox"]');

    // Accordion behavior - only one dropdown open at a time
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('change', () => {
        if (toggle.checked) {
          dropdownToggles.forEach(other => {
            if (other !== toggle) {
              other.checked = false;
            }
          });
        }
      });
    });

    // Close all dropdowns when sidebar collapses
    function closeAllDropdowns() {
      dropdownToggles.forEach(toggle => {
        toggle.checked = false;
      });
    }

    // Watch for sidebar collapse (class changes)
    const observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.attributeName === 'class') {
          const isCollapsed = sidebar.classList.contains('w-16') || sidebar.classList.contains('collapsed');
          if (isCollapsed) {
            closeAllDropdowns();
          }
        }
      });
    });

    observer.observe(sidebar, { attributes: true });

    // Also handle width style changes
    const resizeObserver = new ResizeObserver(entries => {
      for (let entry of entries) {
        if (entry.contentRect.width <= 80) {
          closeAllDropdowns();
        }
      }
    });

    resizeObserver.observe(sidebar);
  });
</script>