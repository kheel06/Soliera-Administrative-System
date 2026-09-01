@extends('layouts.app')

@section('title', 'Compliance | Permits')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Permit Status Board</h1>
                <p class="text-sm text-gray-500 mt-1">Monitor regulatory permits, licenses, and renewals.</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <button type="button" onclick="document.getElementById('addPermitModal').classList.add('modal-open')" 
                    class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200 shadow-sm">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Add Permit
                </button>
            </div>
        </div>

        <!-- Metrics/KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Permits</h3>
                        <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="shield" class="w-6 h-6 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Expiring (30 Days)</h3>
                        <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['expiring'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="alert-triangle" class="w-6 h-6 text-amber-500"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-semibold {{ ($stats['expiring'] ?? 0) > 0 ? 'text-red-600' : 'text-gray-500' }}">
                    <i data-lucide="info" class="w-3.5 h-3.5 mr-1.5"></i>
                    <span>{{ ($stats['expiring'] ?? 0) > 0 ? 'Urgent Renewals' : 'In Grace Period' }}</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Renewals in Progress</h3>
                        <p class="text-3xl font-bold mt-1 text-gray-900">{{ $stats['renewing'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="refresh-cw" class="w-6 h-6 text-amber-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Fully Compliant</h3>
                        <p class="text-3xl font-bold mt-1 text-emerald-600">{{ $stats['compliant_pct'] ?? 0 }}%</p>
                    </div>
                    <div class="p-3 bg-[#0a1e3b] rounded-xl shadow-inner">
                        <i data-lucide="check-circle" class="w-6 h-6 text-amber-500"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-semibold text-emerald-600">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5 mr-1.5"></i>
                    <span>High Compliance Score</span>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <!-- Filters & Search -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 p-4">
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
                <!-- Status Tabs -->
                <div class="flex bg-gray-50 p-1 rounded-xl w-full md:w-auto">
                    <a href="{{ route('compliance.permits') }}" 
                        class="px-6 py-2 text-xs font-bold rounded-lg transition-all {{ !request('filter') ? 'bg-white shadow-sm text-[#0a1e3b]' : 'text-gray-500 hover:text-gray-700' }}">
                        All Permits
                    </a>
                    <a href="{{ route('compliance.permits', ['filter' => 'critical']) }}" 
                        class="px-6 py-2 text-xs font-bold rounded-lg transition-all {{ request('filter') == 'critical' ? 'bg-white shadow-sm text-red-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Critical
                    </a>
                    <a href="{{ route('compliance.permits', ['filter' => 'archived']) }}" 
                        class="px-6 py-2 text-xs font-bold rounded-lg transition-all {{ request('filter') == 'archived' ? 'bg-white shadow-sm text-gray-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Archived
                    </a>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <form action="{{ route('compliance.permits') }}" method="GET" class="relative flex-grow md:flex-grow-0">
                        @if(request('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                        @endif
                        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search permits..." 
                            class="pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-[#EDA900] focus:border-[#EDA900] w-full md:w-64">
                    </form>

                    <!-- Filter Dropdown -->
                    <div class="relative" x-data="{ openFilters: false }" @click.away="openFilters = false">
                        <button @click="openFilters = !openFilters"
                            class="px-3 py-2 rounded-lg bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] flex items-center gap-2 transition-colors duration-200">
                            <i data-lucide="filter" class="w-4 h-4 text-[#0A1829]"></i>
                        </button>
                        <div x-show="openFilters"
                            class="absolute right-0 z-20 mt-2 w-72 origin-top-right rounded-md bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none p-4"
                            style="display: none;">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-sm font-semibold text-gray-700">Filters</h3>
                                <a href="{{ route('compliance.permits') }}"
                                    class="text-xs text-[#0A1829] hover:text-gray-900">Clear All</a>
                            </div>
                            <form action="{{ route('compliance.permits') }}" method="GET" class="space-y-3">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if(request('filter'))
                                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                                @endif

                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                                    <select name="status" class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        <option value="">All Statuses</option>
                                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Expiring Soon" {{ request('status') == 'Expiring Soon' ? 'selected' : '' }}>Expiring Soon</option>
                                        <option value="Renewal in Progress" {{ request('status') == 'Renewal in Progress' ? 'selected' : '' }}>Renewal in Progress</option>
                                        <option value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="Archived" {{ request('status') == 'Archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Issuing Authority</label>
                                    <select name="authority" class="w-full text-sm border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        <option value="">All Authorities</option>
                                        @foreach($authorities as $authority)
                                            <option value="{{ $authority }}" {{ request('authority') == $authority ? 'selected' : '' }}>{{ $authority }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit"
                                    class="w-full bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] text-sm font-medium py-2 rounded-lg transition-colors duration-200">Apply
                                    Filters</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permits Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-bold">Permit Name</th>
                            <th class="px-6 py-4 font-bold text-center">Issuing Authority</th>
                            <th class="px-6 py-4 font-bold text-center">Expiration Date</th>
                            <th class="px-6 py-4 font-bold text-center">Status</th>
                            <th class="px-6 py-4 font-bold text-center">Compliance</th>
                            <th class="px-6 py-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($permits as $permit)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-900 group-hover:text-amber-600 transition-colors">{{ $permit->name }}</div>
                                <div class="text-[10px] text-gray-400 mt-0.5 font-medium uppercase tracking-tighter">Ref: {{ $permit->reference_number ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-5 text-center font-medium text-gray-600">{{ $permit->issuing_authority }}</td>
                            <td class="px-6 py-5 text-center">
                                @if($permit->expiration_date)
                                    <div class="text-sm {{ $permit->expiration_date <= now()->addDays(30) ? 'text-red-500 font-bold' : 'text-gray-900 font-medium' }}">
                                        {{ $permit->expiration_date->format('M d, Y') }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-0.5 font-medium uppercase tracking-tighter">{{ $permit->expiration_date->diffForHumans() }}</div>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $statusClass = match($permit->status) {
                                        'Valid', 'Active' => 'bg-emerald-100 text-emerald-700',
                                        'Expiring Soon' => 'bg-red-100 text-red-700',
                                        'Renewal in Progress' => 'bg-amber-100 text-amber-700',
                                        'Expired' => 'bg-gray-100 text-gray-700',
                                        'Archived' => 'bg-slate-100 text-slate-600',
                                        default => 'bg-blue-100 text-blue-700',
                                    };
                                @endphp
                                <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-md {{ $statusClass }}">{{ $permit->status }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $permit->compliance_score ?? 0 }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-gray-600 min-w-[40px]">{{ $permit->compliance_score ?? 0 }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-1">
                                    <button onclick="editPermit({{ $permit->id }})" class="p-2 hover:bg-amber-50 rounded-lg text-[#0a1e3b] hover:text-amber-600 transition-colors" title="Edit Permit">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('compliance.permits.destroy', $permit->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permit?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 hover:bg-red-50 rounded-lg text-gray-400 hover:text-red-500 transition-colors" title="Delete Permit">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="p-4 bg-gray-50 rounded-full mb-3">
                                        <i data-lucide="file-x" class="w-10 h-10 text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-400 font-medium">No permits found in this category</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($permits->hasPages())
                <div class="bg-white px-6 py-4 border-t border-gray-100">
                    {{ $permits->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add Permit Modal -->
    <div id="addPermitModal" class="modal">
        <div class="modal-box w-11/12 max-w-4xl bg-white text-gray-800 rounded-3xl p-8">
            <div class="flex justify-between items-center mb-8 border-b pb-4 border-gray-50">
                <div>
                    <h3 class="text-2xl font-bold text-[#0a1e3b]">Add New Compliance Permit</h3>
                    <p class="text-sm text-gray-500">Register a new regulatory document into the system.</p>
                </div>
                <button type="button" onclick="document.getElementById('addPermitModal').classList.remove('modal-open')" class="btn btn-sm btn-circle btn-ghost">
                    <i data-lucide="x" class="w-5 h-5 text-gray-400"></i>
                </button>
            </div>

            <form action="{{ route('compliance.permits.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Permit Name</label>
                        <input type="text" name="name" required class="input input-bordered w-full rounded-xl" placeholder="e.g. Business Permit 2024">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Issuing Authority</label>
                        <input type="text" name="issuing_authority" required class="input input-bordered w-full rounded-xl" placeholder="e.g. City Government">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Reference Number</label>
                        <input type="text" name="reference_number" class="input input-bordered w-full rounded-xl" placeholder="e.g. BP-2024-XXXX">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Expiration Date</label>
                        <input type="date" name="expiration_date" required class="input input-bordered w-full rounded-xl">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Status</label>
                        <select name="status" required class="select select-bordered w-full rounded-xl font-medium">
                            <option value="Active">Active</option>
                            <option value="Expiring Soon">Expiring Soon</option>
                            <option value="Renewal in Progress">Renewal in Progress</option>
                            <option value="Expired">Expired</option>
                            <option value="Archived">Archived</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Compliance Score (%)</label>
                        <input type="number" name="compliance_score" value="100" min="0" max="100" class="input input-bordered w-full rounded-xl">
                    </div>
                </div>
                <div class="mb-8">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Notes</label>
                    <textarea name="notes" rows="3" class="textarea textarea-bordered w-full rounded-xl" placeholder="Additional details..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addPermitModal').classList.remove('modal-open')" class="btn btn-ghost rounded-xl">Cancel</button>
                    <button type="submit" class="btn bg-[#0a1e3b] hover:bg-[#1a2e4b] text-white border-none rounded-xl px-12">Save Permit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Permit Modal -->
    <div id="editPermitModal" class="modal">
        <div class="modal-box w-11/12 max-w-4xl bg-white text-gray-800 rounded-3xl p-8">
            <div class="flex justify-between items-center mb-8 border-b pb-4 border-gray-50">
                <div>
                    <h3 class="text-2xl font-bold text-[#0a1e3b]">Edit Compliance Permit</h3>
                    <p class="text-sm text-gray-500">Update permit details and status.</p>
                </div>
                <button type="button" onclick="document.getElementById('editPermitModal').classList.remove('modal-open')" class="btn btn-sm btn-circle btn-ghost">
                    <i data-lucide="x" class="w-5 h-5 text-gray-400"></i>
                </button>
            </div>

            <form id="editPermitForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Permit Name</label>
                        <input type="text" name="name" id="edit_name" required class="input input-bordered w-full rounded-xl">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Issuing Authority</label>
                        <input type="text" name="issuing_authority" id="edit_issuing_authority" required class="input input-bordered w-full rounded-xl">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Reference Number</label>
                        <input type="text" name="reference_number" id="edit_reference_number" class="input input-bordered w-full rounded-xl">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Expiration Date</label>
                        <input type="date" name="expiration_date" id="edit_expiration_date" required class="input input-bordered w-full rounded-xl">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Status</label>
                        <select name="status" id="edit_status" required class="select select-bordered w-full rounded-xl font-medium">
                            <option value="Active">Active</option>
                            <option value="Expiring Soon">Expiring Soon</option>
                            <option value="Renewal in Progress">Renewal in Progress</option>
                            <option value="Expired">Expired</option>
                            <option value="Archived">Archived</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Compliance Score (%)</label>
                        <input type="number" name="compliance_score" id="edit_compliance_score" min="0" max="100" class="input input-bordered w-full rounded-xl">
                    </div>
                </div>
                <div class="mb-8">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Notes</label>
                    <textarea name="notes" id="edit_notes" rows="3" class="textarea textarea-bordered w-full rounded-xl"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editPermitModal').classList.remove('modal-open')" class="btn btn-ghost rounded-xl">Cancel</button>
                    <button type="submit" class="btn bg-amber-500 hover:bg-amber-600 text-white border-none rounded-xl px-12">Update Permit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editPermit(id) {
            fetch(`/compliance/permits/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editPermitForm').action = `/compliance/permits/${id}`;
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_issuing_authority').value = data.issuing_authority;
                    document.getElementById('edit_reference_number').value = data.reference_number || '';
                    document.getElementById('edit_expiration_date').value = data.expiration_date ? data.expiration_date.split('T')[0] : '';
                    document.getElementById('edit_status').value = data.status;
                    document.getElementById('edit_compliance_score').value = data.compliance_score;
                    document.getElementById('edit_notes').value = data.notes || '';
                    
                    document.getElementById('editPermitModal').classList.add('modal-open');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection

