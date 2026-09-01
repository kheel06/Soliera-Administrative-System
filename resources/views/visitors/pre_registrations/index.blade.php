@extends('layouts.app')

@section('title', 'Visitors | Pre-Registrations')

@section('content')
    <!-- Load QRCode library early -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <div x-data="{ newRequestOpen: false }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Visitor Pre-registrations</h2>
                        <p class="text-sm text-gray-600">Review and approve upcoming visitor requests.</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('visitors.check_in_form') }}"
                            class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                            <i data-lucide="printer" class="w-4 h-4"></i>
                            Check-in Desk
                        </a>
                        <button @click="newRequestOpen = true"
                            class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            New Request
                        </button>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="flex justify-between items-center mb-6">
                    <!-- Tabs for quick status filtering (Optional, keeping consistent with design) -->
                    <!-- Tabs for quick status filtering -->
                    <div class="flex bg-gray-50 p-1 rounded-xl w-full md:w-auto">
                        <a href="{{ route('visitors.pre_registrations', ['status' => 'pending']) }}"
                            class="px-6 py-2 text-xs font-bold rounded-lg transition-all {{ request('status', 'pending') == 'pending' ? 'bg-white shadow-sm text-[#0a1e3b]' : 'text-gray-500 hover:text-gray-700' }}">
                            Pending ({{ $stats['pending'] ?? 0 }})
                        </a>
                        <a href="{{ route('visitors.pre_registrations', ['status' => 'approved']) }}"
                            class="px-6 py-2 text-xs font-bold rounded-lg transition-all {{ request('status') == 'approved' ? 'bg-white shadow-sm text-[#0a1e3b]' : 'text-gray-500 hover:text-gray-700' }}">
                            Approved ({{ $stats['approved'] ?? 0 }})
                        </a>
                        <a href="{{ route('visitors.pre_registrations', ['status' => 'denied']) }}"
                            class="px-6 py-2 text-xs font-bold rounded-lg transition-all {{ request('status') == 'denied' ? 'bg-white shadow-sm text-red-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Denied ({{ $stats['denied'] ?? 0 }})
                        </a>
                    </div>

                    <div class="flex gap-2">
                        <form method="GET" action="{{ route('visitors.pre_registrations') }}" class="relative">
                            <input type="hidden" name="status" value="{{ request('status', 'pending') }}">
                            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search visitors..."
                                class="pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-[#EDA900] focus:border-[#EDA900]">
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
                                    <a href="{{ route('visitors.pre_registrations') }}"
                                        class="text-xs text-[#0A1829] hover:text-gray-900">Clear All</a>
                                </div>
                                <form method="GET" action="{{ route('visitors.pre_registrations') }}" class="space-y-3">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="status" value="{{ request('status', 'pending') }}">

                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Date Range</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                                class="w-full text-xs border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                                class="w-full text-xs border-gray-300 rounded-md focus:ring-[#EDA900] focus:border-[#EDA900]">
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] text-sm font-medium py-2 rounded-lg transition-colors duration-200">Apply
                                        Filters</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Requests List (Cards) -->
                <div x-data="{ 
                                detailModalOpen: false,
                                selectedGroup: null,
                                showDetails(group) {
                                    this.selectedGroup = group;
                                    this.detailModalOpen = true;
                                    this.$nextTick(() => {
                                        this.retryQR('modal-qr-' + group.group_name.replace(/\s+/g, '-'), group);
                                        if (window.lucide) {
                                            window.lucide.createIcons();
                                        }
                                    });
                                },
                                retryQR(elementId, group, attempts = 0) {
                                    if (attempts > 5) return;
                                    if (typeof QRCode === 'undefined') {
                                        setTimeout(() => this.retryQR(elementId, group, attempts + 1), 200);
                                        return;
                                    }
                                    this.generateGroupQR(elementId, group);
                                },
                                 generateGroupQR(elementId, group) {
                                    const qrContainer = document.getElementById(elementId);
                                    if (!qrContainer) return;

                                    qrContainer.innerHTML = '';
                                    
                                    try {
                                        new QRCode(qrContainer, {
                                            text: group.pass_id || ('PASS-' + Math.random().toString(36).substr(2, 8).toUpperCase()),
                                            width: 128,
                                            height: 128,
                                            colorDark : '#0a1e3b',
                                            colorLight : '#ffffff',
                                            correctLevel : QRCode.CorrectLevel.H
                                        });
                                    } catch (e) {
                                        console.error('QR Generation failed:', e);
                                    }
                                }
                            }">
                    <div class="grid grid-cols-1 gap-6">
                        @forelse($pendingRequests as $request)
                            <div
                                class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl shadow-gray-200/50 flex flex-col md:flex-row gap-8 items-start md:items-center relative overflow-hidden group">
                                <!-- Status Badge -->
                                <div class="absolute top-6 right-8">
                                    <span
                                        class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                                                                {{ $request->status === 'pending' ? 'bg-blue-50 text-blue-600' : ($request->status === 'approved' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600') }}">
                                        {{ $request->status === 'pending' ? 'Pending Approval' : ucfirst($request->status) }}
                                    </span>
                                </div>

                                <!-- QR Preview -->
                                <div class="w-32 h-32 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0"
                                    x-init="$nextTick(() => retryQR('card-qr-{{ $loop->index }}', {{ json_encode($request) }}))">
                                    <div id="card-qr-{{ $loop->index }}" class="scale-75"></div>
                                </div>

                                <!-- Group Info -->
                                <div class="flex-grow space-y-3">
                                    <div>
                                        <h3 class="text-xl font-black text-[#0a1e3b]">{{ $request->group_name }}</h3>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                            Host: {{ $request->host->name ?? 'Unknown' }} -
                                            {{ $request->host->department ?? 'General' }}
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-6 items-center">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center">
                                                <i data-lucide="users" class="w-4 h-4 text-blue-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">
                                                    Visitors</p>
                                                <p class="text-sm font-bold text-[#0a1e3b]">{{ $request->visitor_count }}
                                                    visitor(s)</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center">
                                                <i data-lucide="briefcase" class="w-4 h-4 text-purple-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">
                                                    Purpose</p>
                                                <p class="text-sm font-bold text-[#0a1e3b]">{{ $request->purpose }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center">
                                                <i data-lucide="clock" class="w-4 h-4 text-orange-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">
                                                    Registered</p>
                                                <p class="text-sm font-bold text-[#0a1e3b]">
                                                    {{ $request->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex gap-3 pt-4">
                                        <button @click="showDetails({{ json_encode($request) }})"
                                            class="flex items-center gap-2 px-6 py-2 bg-gray-50 hover:bg-gray-100 text-[#0a1e3b] text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> View Details
                                        </button>

                                        @if($request->status === 'pending')
                                            <form action="{{ route('visitors.pre_registrations.bulk_status') }}" method="POST">
                                                @csrf
                                                @foreach($request->member_ids as $id)
                                                    <input type="hidden" name="ids[]" value="{{ $id }}">
                                                @endforeach
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit"
                                                    class="flex items-center gap-2 px-6 py-2 bg-[#0a1e3b] hover:bg-blue-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-blue-900/10">
                                                    <i data-lucide="check" class="w-3.5 h-3.5"></i> Approve All
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('visitors.pre_registrations.bulk_status') }}" method="POST"
                                            onsubmit="return confirm('Remove this request?')">
                                            @csrf
                                            @foreach($request->member_ids as $id)
                                                <input type="hidden" name="ids[]" value="{{ $id }}">
                                            @endforeach
                                            <input type="hidden" name="status" value="denied">
                                            <button type="submit"
                                                class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="bg-white rounded-[2rem] p-12 border border-gray-100 shadow-xl shadow-gray-200/50 text-center space-y-4">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto">
                                    <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-[#0a1e3b]">No Requests Found</h3>
                                    <p class="text-sm font-medium text-gray-400">There are no pre-registrations matching your
                                        criteria.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Details Modal -->
                    <template x-if="detailModalOpen">
                        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 lg:p-12">
                            <div class="absolute inset-0 bg-[#0a1e3b]/40 backdrop-blur-sm" @click="detailModalOpen = false">
                            </div>

                            <div class="relative bg-white rounded-[3rem] shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">

                                <!-- Modal Header -->
                                <div
                                    class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-white sticky top-0 z-10">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-[#EDA900]/10 rounded-2xl flex items-center justify-center">
                                            <i data-lucide="layout-grid" class="w-6 h-6 text-[#EDA900]"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-[#0a1e3b]"
                                                x-text="selectedGroup.group_name"></h3>
                                            <p
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">
                                                Group details and visitor list</p>
                                        </div>
                                    </div>
                                    <button @click="detailModalOpen = false"
                                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                                        <i data-lucide="x" class="w-5 h-5"></i>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="flex-grow overflow-y-auto px-10 py-8 space-y-10 custom-scrollbar">
                                    <div class="flex flex-col md:flex-row gap-10 items-start">
                                        <!-- Large QR -->
                                        <div class="w-full md:w-48 space-y-4">
                                            <div
                                                class="aspect-square bg-white border-2 border-dashed border-gray-200 rounded-[2rem] flex items-center justify-center overflow-hidden">
                                                <div :id="'modal-qr-' + selectedGroup.group_name.replace(/\s+/g, '-')">
                                                </div>
                                            </div>
                                            <p
                                                class="text-[8px] font-black text-gray-400 uppercase tracking-widest text-center">
                                                Group access pass</p>
                                        </div>

                                        <!-- Summary Info -->
                                        <div class="flex-grow space-y-8">
                                            <!-- Quick Info Grid -->
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-6">
                                                <div class="space-y-1.5">
                                                    <p
                                                        class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                                        Status</p>
                                                    <div>
                                                        <span
                                                            class="inline-block px-4 py-1.5 bg-[#0a1e3b] text-white text-[10px] font-black uppercase rounded-xl"
                                                            x-text="selectedGroup.status"></span>
                                                    </div>
                                                </div>
                                                <div class="space-y-1.5">
                                                    <p
                                                        class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                                        Purpose</p>
                                                    <p class="font-bold text-[#0a1e3b] text-base"
                                                        x-text="selectedGroup.purpose"></p>
                                                </div>
                                                <div class="sm:col-span-2 space-y-1.5 border-t border-gray-50 pt-4">
                                                    <p
                                                        class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                                        Host Information</p>
                                                    <p class="font-bold text-[#0a1e3b] text-base"
                                                        x-text="selectedGroup.host ? (selectedGroup.host.name + ' - ' + (selectedGroup.host.department || 'General')) : 'N/A'">
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Schedule Section -->
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <!-- Time In Card -->
                                                <div
                                                    class="p-4 rounded-3xl bg-orange-50/50 border border-orange-100/50 flex items-center gap-4">
                                                    <div
                                                        class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center flex-shrink-0">
                                                        <i data-lucide="calendar-check" class="w-6 h-6 text-orange-500"></i>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p
                                                            class="text-[10px] font-black text-orange-600/60 uppercase tracking-widest leading-none mb-1.5">
                                                            Expected Time In</p>
                                                        <p class="font-black text-[#0a1e3b] truncate"
                                                            x-text="new Date(selectedGroup.scheduled_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })">
                                                        </p>
                                                        <p class="text-xs font-bold text-gray-400"
                                                            x-text="new Date(selectedGroup.scheduled_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })">
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Time Out Card -->
                                                <template x-if="selectedGroup.expected_time_out">
                                                    <div
                                                        class="p-4 rounded-3xl bg-red-50/50 border border-red-100/50 flex items-center gap-4">
                                                        <div
                                                            class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center flex-shrink-0">
                                                            <i data-lucide="calendar-x" class="w-6 h-6 text-red-500"></i>
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p
                                                                class="text-[10px] font-black text-red-600/60 uppercase tracking-widest leading-none mb-1.5">
                                                                Expected Time Out</p>
                                                            <p class="font-black text-[#0a1e3b] truncate"
                                                                x-text="new Date(selectedGroup.expected_time_out).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })">
                                                            </p>
                                                            <p class="text-xs font-bold text-gray-400"
                                                                x-text="new Date(selectedGroup.expected_time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Visitors List -->
                                    <div class="space-y-6">
                                        <div class="flex items-center justify-between">
                                            <h4
                                                class="text-[10px] font-black text-[#0a1e3b] uppercase tracking-widest px-1">
                                                Visitor List (<span x-text="selectedGroup.visitor_count"></span>)</h4>
                                        </div>

                                        <div class="space-y-3">
                                            <template x-for="(visitor, index) in selectedGroup.visitors"
                                                :key="visitor.id || index">
                                                <div
                                                    class="flex items-center gap-4 p-5 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                                    <!-- Index Circle -->
                                                    <div class="w-12 h-12 rounded-full bg-[#0a1e3b] text-white flex items-center justify-center font-black text-sm shadow-lg shadow-blue-900/20"
                                                        x-text="index + 1"></div>

                                                    <!-- Info -->
                                                    <div class="flex-grow">
                                                        <p class="text-base font-black text-[#0a1e3b]"
                                                            x-text="visitor.name"></p>
                                                        <p class="text-xs font-bold text-gray-400 tracking-wide"
                                                            x-text="visitor.phone || 'No phone provided'"></p>
                                                    </div>

                                                    <!-- Status Badge -->
                                                    <div class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest"
                                                        :class="{
                                                                        'bg-green-50 text-green-600': visitor.status === 'approved',
                                                                        'bg-blue-50 text-blue-600': visitor.status === 'pending',
                                                                        'bg-red-50 text-red-600': visitor.status === 'denied' || visitor.status === 'cancelled'
                                                                     }" x-text="visitor.status"></div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="px-10 py-8 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                                    <button @click="detailModalOpen = false"
                                        class="px-8 py-3 bg-white border border-gray-200 text-[#0a1e3b] text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-gray-100 transition-all">
                                        Close
                                    </button>

                                    <template x-if="selectedGroup.status === 'pending'">
                                        <form action="{{ route('visitors.pre_registrations.bulk_status') }}" method="POST">
                                            @csrf
                                            <template x-for="id in selectedGroup.member_ids">
                                                <input type="hidden" name="ids[]" :value="id">
                                            </template>
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit"
                                                class="px-10 py-3 bg-[#0a1e3b] text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-blue-900/20 transform hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-2">
                                                <i data-lucide="check" class="w-4 h-4"></i> Approve All Visitors
                                            </button>
                                        </form>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- New Request Modal (Alpine.js) -->
        <div x-show="newRequestOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/50 transition-opacity" @click="newRequestOpen = false"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl transform transition-all p-6">
                <h3 class="font-bold text-lg mb-4 text-[#0A1829]">New Visitor Request</h3>
                <form method="POST" action="{{ route('visitors.pre_registrations.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Visitor Info -->
                        <div class="form-control">
                            <label class="label"><span class="label-text">Visitor Name *</span></label>
                            <input type="text" name="name" required class="input input-bordered w-full"
                                placeholder="John Doe">
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Company</span></label>
                            <input type="text" name="company" class="input input-bordered w-full" placeholder="Acme Corp">
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Email</span></label>
                            <input type="email" name="email" class="input input-bordered w-full"
                                placeholder="john@example.com">
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Phone</span></label>
                            <input type="text" name="phone" class="input input-bordered w-full"
                                placeholder="+1 234 567 890">
                        </div>

                        <!-- Visit Details -->
                        <div class="form-control">
                            <label class="label"><span class="label-text">Host *</span></label>
                            <select name="host_id" required class="select select-bordered w-full">
                                <option value="">Select Host</option>
                                @foreach($hosts as $host)
                                    <option value="{{ $host->id }}">{{ $host->name }} ({{ $host->department ?? 'General' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Purpose *</span></label>
                            <select name="purpose" required class="select select-bordered w-full">
                                <option value="Meeting">Meeting</option>
                                <option value="Interview">Interview</option>
                                <option value="Delivery">Delivery</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Date *</span></label>
                            <input type="date" name="scheduled_date" required min="{{ date('Y-m-d') }}"
                                class="input input-bordered w-full">
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Time *</span></label>
                            <input type="time" name="scheduled_time" required class="input input-bordered w-full">
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Special Instructions</span></label>
                            <textarea name="special_instructions" class="textarea textarea-bordered h-20"
                                placeholder="e.g. Needs safety gear, VIP access..."></textarea>
                        </div>
                    </div>

                    <div class="modal-action mt-6 flex justify-end gap-2">
                        <button type="button" class="btn" @click="newRequestOpen = false">Cancel</button>
                        <button type="submit" class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] border-none btn">Submit
                            Request</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection