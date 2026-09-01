<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Access | Department Accounts</title>
  @include('partials.favicon')
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

        <!-- Page Header -->
        <div class="mb-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-xl bg-[#001F54] flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6 text-[#F7B32B]"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-800">Department Accounts</h1>
                <p class="text-gray-500 text-sm">Manage and monitor department user accounts</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
          <!-- Total Accounts -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Accounts</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="da_total_count">{{ $stats['total'] ?? 0 }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Active Accounts -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Active Accounts</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="da_active_count">{{ $stats['active'] ?? 0 }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="user-check" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>

          <!-- Inactive Accounts -->
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Inactive Accounts</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="da_inactive_count">{{ $stats['inactive'] ?? 0 }}</p>
              </div>
              <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
                <i data-lucide="user-x" class="w-5 h-5 text-[#F7B32B]"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Department Accounts Management Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <!-- Table Header -->
          <div class="bg-[#001F54] px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
              <h3 class="text-lg font-semibold text-white flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                  <i data-lucide="users" class="w-4 h-4 text-[#F7B32B]"></i>
                </div>
                Department Accounts List
              </h3>
              <span class="text-sm text-white/80 bg-white/10 px-3 py-1.5 rounded-full">
                {{ count($departmentAccounts) }} accounts
              </span>
            </div>
          </div>

          <div class="p-6">
            @if(count($departmentAccounts) === 0)
              <div class="flex flex-col items-center py-16">
                <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                  <i data-lucide="users" class="w-8 h-8 text-blue-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No Department Accounts Found</h3>
                <p class="text-gray-400 text-sm">No department accounts available at the moment.</p>
              </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              @foreach($departmentAccounts as $account)
              @php
                $status = strtolower($account->status ?? 'inactive');
                $badgeClass = $status === 'active' ? 'badge-success' : 'badge-warning';
              @endphp
              <div class="dept-account-card group bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5" data-account-id="{{ $account->Dept_no }}">
                <div class="p-4 flex items-start gap-3">
                  <div class="w-12 h-12 rounded-xl overflow-hidden ring-2 ring-offset-2 ring-offset-white ring-[#001F54] flex-shrink-0">
                    @if($account->profile_picture)
                      @php
                        $avatarVersion = '';
                        if (preg_match('/_(\\d+)\\./', $account->profile_picture, $matches)) {
                          $avatarVersion = '?v=' . $matches[1];
                        } else {
                          $filePath = storage_path('app/public/' . $account->profile_picture);
                          if (file_exists($filePath)) {
                            $avatarVersion = '?v=' . filemtime($filePath);
                          }
                        }
                      @endphp
                      <img src="{{ asset('storage/' . $account->profile_picture) }}{{ $avatarVersion }}" alt="{{ $account->employee_name }}" class="w-full h-full object-cover" />
                    @else
                      <div class="w-full h-full bg-[#001F54] flex items-center justify-center">
                        <span class="text-[#F7B32B] font-semibold text-sm">{{ strtoupper(substr($account->employee_name ?? 'U', 0, 1)) }}</span>
                      </div>
                    @endif
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                      <div class="min-w-0">
                        <div class="font-semibold text-gray-800 truncate">{{ $account->employee_name ?? 'Unknown' }}</div>
                        <div class="text-xs text-blue-600 truncate">{{ $account->email ?? 'No email' }}</div>
                      </div>
                      <span class="badge badge-sm {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                    </div>
                    <div class="mt-3 flex flex-wrap items-center gap-2">
                      <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">{{ $account->dept_name ?? 'Unknown' }}</span>
                      <span class="text-xs text-gray-600">{{ $account->role ?? 'No role' }}</span>
                    </div>
                  </div>
                </div>
                <div class="px-4 pb-4 flex items-center justify-end gap-2">
                  @if(auth()->user()->role === 'Administrator' || auth()->user()->role === 'Super Admin')
                  <button onclick="openEditModal({{ $account->Dept_no }})" class="btn btn-xs">
                    <i data-lucide="edit-2" class="w-4 h-4 mr-1"></i> Edit
                  </button>
                  @endif
                </div>
              </div>
              @endforeach
            </div>
            @endif
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Toast Container -->
  <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

  <!-- Edit Account Modal -->
  <div id="editAccountModal" class="modal">
    <div class="modal-box w-11/12 max-w-md" onclick="event.stopPropagation()">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-800">Edit Account</h3>
        <button onclick="closeEditModal()" class="btn btn-sm btn-circle btn-ghost">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>
      <form id="editAccountForm" class="space-y-4">
        <div>
          <label class="label text-sm font-semibold">Employee Name</label>
          <input id="ea_name" type="text" class="input input-bordered w-full" />
        </div>
        <div>
          <label class="label text-sm font-semibold">Role</label>
          <input id="ea_role" type="text" class="input input-bordered w-full" />
        </div>
        <div>
          <label class="label text-sm font-semibold">Status</label>
          <select id="ea_status" class="select select-bordered w-full">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
        <div class="flex justify-end gap-2 pt-2">
          <button type="button" class="btn btn-outline" onclick="closeEditModal()">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- View Account Modal -->
  <div id="viewAccountModal" class="modal">
    <div class="modal-box w-11/12 max-w-2xl animate-scaleIn" onclick="event.stopPropagation()">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center">
            <i data-lucide="user" class="w-5 h-5 text-[#F7B32B]"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-800" id="va_title">Employee Details</h3>
        </div>
        <button onclick="closeViewModal()" class="btn btn-sm btn-circle btn-ghost">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <!-- Loading State -->
      <div id="va_loading" class="py-8 text-center">
        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-blue-50">
          <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-blue-600"></i>
        </div>
        <p class="text-gray-600">Loading employee details...</p>
      </div>

      <!-- Error State -->
      <div id="va_error" class="hidden">
        <div class="alert alert-error">
          <i data-lucide="alert-triangle" class="w-5 h-5"></i>
          <span id="va_error_text">Unable to load employee details.</span>
        </div>
      </div>

      <!-- Content -->
      <div id="va_content" class="hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[55vh] overflow-y-auto">
          <div class="space-y-2">
            <div>
              <div class="text-xs uppercase tracking-wide text-gray-500">Employee Name</div>
              <div class="text-gray-900 font-semibold" id="va_name">—</div>
            </div>
            <div>
              <div class="text-xs uppercase tracking-wide text-gray-500">Email</div>
              <div class="text-gray-900" id="va_email">—</div>
            </div>
          </div>
          <div class="space-y-2">
            <div>
              <div class="text-xs uppercase tracking-wide text-gray-500">Department</div>
              <div class="text-gray-900" id="va_department">—</div>
            </div>
            <div>
              <div class="text-xs uppercase tracking-wide text-gray-500">Role</div>
              <div class="text-gray-900" id="va_role">—</div>
            </div>
            <div>
              <div class="text-xs uppercase tracking-wide text-gray-500">Status</div>
              <div id="va_status" class="inline-flex items-center gap-2">
                <span class="badge badge-sm">—</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Meta -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
          <div class="p-3 rounded-lg bg-gray-50 border border-gray-100">
            <div class="text-xs uppercase tracking-wide text-gray-500">Employee ID</div>
            <div class="text-gray-900" id="va_employee_id">—</div>
          </div>
          <div class="p-3 rounded-lg bg-gray-50 border border-gray-100">
            <div class="text-xs uppercase tracking-wide text-gray-500">Department No.</div>
            <div class="text-gray-900" id="va_dept_no">—</div>
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-gray-200">
        <button id="va_edit_btn" class="btn btn-primary">
          <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
          Edit
        </button>
        <button onclick="closeViewModal()" class="btn btn-outline">Close</button>
      </div>
    </div>
  </div>



  @include('partials.soliera_js')
  
  <script>
    // Initialize Lucide icons
    lucide.createIcons();
    

    // Account action functions
    let currentViewAccountId = null;
    function openViewModalShell() {
      const modal = document.getElementById('viewAccountModal');
      if (modal) modal.classList.add('modal-open');
      // Reset states
      document.getElementById('va_loading').classList.remove('hidden');
      document.getElementById('va_error').classList.add('hidden');
      document.getElementById('va_content').classList.add('hidden');
    }

    function closeViewModal() {
      const modal = document.getElementById('viewAccountModal');
      if (modal) modal.classList.remove('modal-open');
      currentViewAccountId = null;
    }

    async function viewAccount(accountId) {
      currentViewAccountId = accountId;
      openViewModalShell();
      try {
        const res = await fetch(`{{ url('/access/department-accounts') }}/${accountId}`, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Failed to load account');

        const acc = data.account || {};
        document.getElementById('va_name').textContent = acc.employee_name || 'Unknown';
        document.getElementById('va_email').textContent = acc.email || '—';
        document.getElementById('va_department').textContent = acc.dept_name || '—';
        document.getElementById('va_role').textContent = acc.role || '—';
        document.getElementById('va_employee_id').textContent = acc.employee_id || '—';
        document.getElementById('va_dept_no').textContent = acc.Dept_no || '—';

        const status = (acc.status || 'inactive').toLowerCase();
        const badge = document.querySelector('#va_status .badge');
        if (badge) {
          badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
          badge.className = `badge badge-sm ${status === 'active' ? 'badge-success' : 'badge-warning'}`;
        }

        // Wire edit button
        const editBtn = document.getElementById('va_edit_btn');
        if (editBtn) {
          editBtn.onclick = function () {
            closeViewModal();
            openEditModal(accountId);
          };
        }

        document.getElementById('va_loading').classList.add('hidden');
        document.getElementById('va_content').classList.remove('hidden');
        lucide.createIcons();
      } catch (e) {
        console.error(e);
        document.getElementById('va_loading').classList.add('hidden');
        document.getElementById('va_error_text').textContent = e.message || 'Unable to load employee details.';
        document.getElementById('va_error').classList.remove('hidden');
        lucide.createIcons();
      }
    }

    // Edit modal helpers
    let editingAccountId = null;
    async function openEditModal(accountId) {
      try {
        const res = await fetch(`{{ url('/access/department-accounts') }}/${accountId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
        const data = await res.json();
        if (!data.success) throw new Error('Failed to load account');
        editingAccountId = accountId;
        document.getElementById('ea_name').value = data.account.employee_name || '';
        document.getElementById('ea_role').value = data.account.role || '';
        document.getElementById('ea_status').value = data.account.status || 'inactive';
        document.getElementById('editAccountModal').classList.add('modal-open');
      } catch (e) {
        showToast('Unable to load account for editing', 'error');
      }
    }
    function closeEditModal(){
      document.getElementById('editAccountModal').classList.remove('modal-open');
      editingAccountId = null;
    }


    // Wire confirm button
    document.addEventListener('DOMContentLoaded', function() {
      // Edit submit
      const editForm = document.getElementById('editAccountForm');
      if (editForm) {
        editForm.addEventListener('submit', async function(e){
          e.preventDefault();
          if (!editingAccountId) return;
          const payload = {
            employee_name: document.getElementById('ea_name').value,
            role: document.getElementById('ea_role').value,
            status: document.getElementById('ea_status').value,
          };
          try {
            const res = await fetch(`{{ url('/access/department-accounts') }}/${editingAccountId}`, {
              method: 'PUT',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
              },
              body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (!data.success) throw new Error(data.message || 'Update failed');
            showToast('Account updated successfully', 'success');
            closeEditModal();
            // Update UI row
            const row = document.querySelector(`tr[data-account-id="${editingAccountId}"]`);
            if (row) {
              row.querySelector('td:first-child .font-medium').textContent = data.account.employee_name || 'Unknown';
              row.querySelector('td:nth-child(3) .text-sm').textContent = data.account.role || 'No role assigned';
              const badge = row.querySelector('td:nth-child(4) .badge');
              const st = data.account.status || 'inactive';
              if (badge) {
                badge.textContent = st.charAt(0).toUpperCase() + st.slice(1);
                badge.className = `badge ${st === 'active' ? 'badge-success' : 'badge-warning'} badge-sm`;
              }
              if (window.__updateDeptCards) window.__updateDeptCards();
            }
          } catch (err) {
            showToast('Unable to update account. Please try again.', 'error');
          }
        });
      }
    });

    // Toast
    function showToast(message, type = 'info', duration = 3000) {
      // Use global showNotification if available (Soliera theme), otherwise use local fallback
      if (typeof window.showNotification === 'function') {
        window.showNotification(message, type, duration);
        return;
      }
      
      // Fallback to simple alert if global function not available
      alert(message);
    }


    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
      function updateCountsFromTable() {
        const cards = Array.from(document.querySelectorAll('.dept-account-card'));
        const total = cards.length;
        const active = cards.filter(c => (c.querySelector('.badge')?.textContent || '').trim().toLowerCase() === 'active').length;
        const inactive = total - active;

        const totalEl = document.getElementById('da_total_count');
        const activeEl = document.getElementById('da_active_count');
        const inactiveEl = document.getElementById('da_inactive_count');
        if (totalEl) totalEl.textContent = total;
        if (activeEl) activeEl.textContent = active;
        if (inactiveEl) inactiveEl.textContent = inactive;
      }

      updateCountsFromTable();

      window.__updateDeptCards = updateCountsFromTable;
    });

  </script>
</body>
</html>
