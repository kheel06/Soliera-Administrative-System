@extends('layouts.app')

@section('title', 'Visitors | Badges')

@section('content')
    <div class="py-12 no-print" x-data="{ 
        detailModalOpen: false,
        selectedGroup: null,
        openModal(group) {
            this.selectedGroup = group;
            this.detailModalOpen = true;
            this.$nextTick(() => {
                if (window.lucide) window.lucide.createIcons();
            });
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Visitor Badges</h2>
                    <p class="text-sm text-gray-600">Print and manage active visitor passes.</p>
                </div>
                <a href="{{ route('visitors.check_in_form') }}" class="btn btn-primary btn-sm gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i> Check In New Visitor
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-6">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($visitors as $visitor)
                    <div class="card bg-white shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="card-body p-5">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="avatar {{ !$visitor->profile_photo_url ? 'placeholder' : '' }}">
                                        <div class="bg-neutral text-neutral-content rounded-full w-12 h-12 overflow-hidden flex items-center justify-center">
                                            @if($visitor->is_bulk)
                                                <div class="bg-blue-100 text-blue-600 w-full h-full flex items-center justify-center font-bold text-lg">
                                                    {{ $visitor->visitor_count }}
                                                </div>
                                            @elseif($visitor->profile_photo_url)
                                                <img src="{{ url($visitor->profile_photo_url) }}" alt="{{ $visitor->name }}"
                                                    class="object-cover w-full h-full"
                                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($visitor->name) }}&background=1e293b&color=fff&size=100';">
                                            @else
                                                <span class="text-lg">{{ strtoupper(substr($visitor->name, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-gray-800 truncate" title="{{ $visitor->is_bulk ? $visitor->company : $visitor->name }}">
                                            {{ $visitor->is_bulk ? $visitor->company : $visitor->name }}
                                        </h3>
                                        <p class="text-xs text-gray-500">{{ $visitor->department ?? 'No Department' }}</p>
                                    </div>
                                </div>
                                <span
                                    class="badge badge-sm {{ $visitor->status === 'active' || $visitor->status === 'approved' ? 'badge-success' : 'badge-ghost' }}">
                                    @if($visitor->is_bulk) Group @else {{ ucfirst($visitor->status) }} @endif
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-xs text-gray-600 mb-4">
                                <div class="col-span-2 flex justify-between border-b border-gray-50 pb-1 mb-1">
                                    <span class="text-gray-400">Pass ID:</span>
                                    <span class="font-mono font-medium text-gray-800">{{ $visitor->pass_id }}</span>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Host</p>
                                    <p class="font-medium truncate">{{ $visitor->host_employee ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Room</p>
                                    <p class="font-medium truncate text-blue-600">{{ $visitor->room ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Time In</p>
                                    <p class="font-medium">{{ $visitor->time_in ? \Carbon\Carbon::parse($visitor->time_in)->format('M d, H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Time Out</p>
                                    <p class="font-medium">{{ $visitor->expected_time_out ? \Carbon\Carbon::parse($visitor->expected_time_out)->format('M d, H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Purpose</p>
                                    <p class="font-medium truncate">{{ $visitor->purpose ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Phone</p>
                                    <p class="font-medium truncate">{{ $visitor->contact ?? $visitor->phone ?? 'N/A' }}</p>
                                </div>
                                @if(!$visitor->is_bulk)
                                <div class="col-span-2">
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Email</p>
                                    <p class="font-medium truncate">{{ $visitor->email ?? 'N/A' }}</p>
                                </div>
                                @else
                                <div class="col-span-2">
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Group Size</p>
                                    <p class="font-medium">{{ $visitor->visitor_count }} Visitors</p>
                                </div>
                                @endif
                            </div>

                            <div class="card-actions flex flex-col gap-2">
                                @if($visitor->is_bulk)
                                    <button @click="openModal({{ json_encode($visitor) }})" 
                                        class="btn btn-sm btn-outline gap-2 w-full">
                                        <i data-lucide="eye" class="w-4 h-4"></i> VIEW DETAILS
                                    </button>
                                @endif
                                <a href="{{ route('visitor.pass.print', $visitor->id) }}"
                                    class="btn btn-sm btn-primary gap-2 w-full">
                                    <i data-lucide="printer" class="w-4 h-4"></i> PRINT / PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-lg border border-dashed border-gray-300">
                        <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <i data-lucide="ticket" class="w-8 h-8 text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No Active Badges</h3>
                        <p class="text-gray-500 mt-1">Check in a visitor to generate a badge.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Detail Modal (Alpine.js) -->
        <template x-if="detailModalOpen">
            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Backdrop -->
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="detailModalOpen = false" aria-hidden="true"></div>

                    <!-- Modal panel -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-gray-100">
                        <div class="bg-white">
                            <!-- Header -->
                            <div class="px-10 py-8 border-b border-gray-50 flex items-center justify-between bg-white sticky top-0 z-10">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-3xl bg-blue-50 flex items-center justify-center flex-shrink-0 border border-blue-100/50">
                                        <i data-lucide="users" class="w-8 h-8 text-[#0a1e3b]"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-[#0a1e3b] uppercase tracking-tight" x-text="selectedGroup.company"></h3>
                                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2 mt-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Active Visitor Group
                                        </p>
                                    </div>
                                </div>
                                <button @click="detailModalOpen = false" class="p-3 hover:bg-gray-100 rounded-2xl transition-all text-gray-400 hover:text-gray-600">
                                    <i data-lucide="x" class="w-6 h-6"></i>
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="px-10 py-10 space-y-12 max-h-[65vh] overflow-y-auto custom-scrollbar">
                                <div class="flex flex-col lg:flex-row gap-12">
                                    <!-- Summary Info -->
                                    <div class="flex-grow space-y-8">
                                        <!-- Quick Info Grid -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-6">
                                            <div class="space-y-1.5">
                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</p>
                                                <div>
                                                    <span class="inline-block px-4 py-1.5 bg-[#0a1e3b] text-white text-[10px] font-black uppercase rounded-xl" x-text="selectedGroup.status"></span>
                                                </div>
                                            </div>
                                            <div class="space-y-1.5">
                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Purpose</p>
                                                <p class="font-bold text-[#0a1e3b] text-base" x-text="selectedGroup.purpose"></p>
                                            </div>
                                            <div class="sm:col-span-2 space-y-1.5 border-t border-gray-50 pt-4">
                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Host Information</p>
                                                <p class="font-bold text-[#0a1e3b] text-base" x-text="selectedGroup.host_employee"></p>
                                            </div>
                                        </div>

                                        <!-- Schedule Section -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div class="p-4 rounded-3xl bg-orange-50/50 border border-orange-100/50 flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="calendar-check" class="w-6 h-6 text-orange-500"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[10px] font-black text-orange-600/60 uppercase tracking-widest leading-none mb-1.5">Check In Time</p>
                                                    <p class="font-black text-[#0a1e3b] truncate" x-text="selectedGroup.time_in ? new Date(selectedGroup.time_in).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'Not Checked In'"></p>
                                                </div>
                                            </div>

                                            <div class="p-4 rounded-3xl bg-red-50/50 border border-red-100/50 flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="calendar-x" class="w-6 h-6 text-red-500"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[10px] font-black text-red-600/60 uppercase tracking-widest leading-none mb-1.5">Expected Time Out</p>
                                                    <p class="font-black text-[#0a1e3b] truncate" x-text="selectedGroup.expected_time_out ? new Date(selectedGroup.expected_time_out).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'N/A'"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Visitors List -->
                                <div class="space-y-6">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-[10px] font-black text-[#0a1e3b] uppercase tracking-widest px-1">Visitor List (<span x-text="selectedGroup.visitor_count"></span>)</h4>
                                    </div>

                                    <div class="space-y-3">
                                        <template x-for="(visitor, index) in selectedGroup.visitors" :key="visitor.id || index">
                                            <div class="flex items-center gap-4 p-5 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                                <div class="w-12 h-12 rounded-full bg-[#0a1e3b] text-white flex items-center justify-center font-black text-sm shadow-lg shadow-blue-900/20" x-text="index + 1"></div>
                                                <div class="flex-grow">
                                                    <p class="text-base font-black text-[#0a1e3b]" x-text="visitor.name"></p>
                                                    <div class="flex items-center gap-4">
                                                        <p class="text-xs font-bold text-gray-400 tracking-wide" x-text="visitor.phone || 'No phone'"></p>
                                                        <span class="text-gray-200">|</span>
                                                        <p class="text-xs font-mono text-gray-400" x-text="visitor.pass_id"></p>
                                                    </div>
                                                </div>
                                                <div class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-green-50 text-green-600" x-text="visitor.status"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="px-10 py-8 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                                <button @click="detailModalOpen = false" class="px-8 py-3 bg-white border border-gray-200 text-[#0a1e3b] text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-gray-100 transition-all">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Hidden Print Container - This is what gets printed -->
    <div id="printContainer" class="print-only">
        <div class="print-page">
            <div class="print-badge-card" id="printBadgeCard">
                <!-- Badge content will be injected here by JavaScript -->
            </div>
        </div>
    </div>

    <style>
        /* Hide print container normally */
        .print-only {
            display: none;
        }

        /* Print-specific styles */
        @media print {

            /* Hide everything except print container */
            body * {
                visibility: hidden;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }

            .print-only {
                display: block !important;
                visibility: visible !important;
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: #f8fafc;
                z-index: 99999;
            }

            .print-only,
            .print-only * {
                visibility: visible !important;
            }

            .print-page {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                box-sizing: border-box;
            }

            /* Force print colors */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            @page {
                margin: 0;
                size: A4 portrait;
            }
        }

        /* Badge Card Styles (for printing) */
        .print-badge-card {
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        .badge-wrapper {
            width: 380px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            display: flex;
        }

        .badge-left {
            width: 40%;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f172a 100%);
            padding: 20px 15px;
            text-align: center;
            color: white;
        }

        .badge-right {
            width: 60%;
            background: #fff;
            padding: 15px 18px;
        }

        .badge-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .badge-logo {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logo-circle {
            width: 22px;
            height: 22px;
            background: #14b8a6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .logo-text {
            color: white;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .visitor-tag {
            background: #f59e0b;
            color: white;
            font-size: 9px;
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 15px;
            text-transform: uppercase;
        }

        .photo-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
        }

        .photo-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #f59e0b;
            overflow: hidden;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-initial {
            font-size: 36px;
            font-weight: bold;
            color: #64748b;
        }

        .verified-badge {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 24px;
            height: 24px;
            background: #14b8a6;
            border: 3px solid #1e3a5f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        .visitor-name {
            color: white;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .dept-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            color: #e2e8f0;
            padding: 5px 16px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .info-row {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .info-box {
            flex: 1;
            background: #f1f5f9;
            border-radius: 8px;
            padding: 12px 14px;
        }

        .info-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            color: #0f172a;
            font-weight: bold;
        }

        .bottom-section {
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

        .pass-section {
            flex: 1;
        }

        .pass-box {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 10px;
        }

        .pass-id {
            font-size: 15px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #0f172a;
        }

        .wear-text {
            font-size: 11px;
            color: #14b8a6;
            font-weight: bold;
        }

        .qr-section {
            text-align: center;
        }

        .qr-code {
            width: 65px;
            height: 65px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 4px;
            background: white;
        }

        .scan-label {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 4px;
        }
    </style>

    <script>
        function printVisitorBadge(id, name, dept, host, validUntil, passId, photoUrl) {
            const container = document.getElementById('printBadgeCard');

            // Generate QR code URL
            const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${passId}`;

            // Generate photo HTML
            const photoHtml = photoUrl
                ? `<img src="${photoUrl}" alt="Photo">`
                : `<span class="photo-initial">${name.charAt(0).toUpperCase()}</span>`;

            // Inject badge HTML
            container.innerHTML = `
                            <div class="badge-wrapper">
                                <div class="badge-left">
                                    <div class="badge-header">
                                        <div class="badge-logo">
                                            <div class="logo-circle">S</div>
                                            <span class="logo-text">SOLIERA</span>
                                        </div>
                                        <span class="visitor-tag">VISITOR</span>
                                    </div>

                                    <div class="photo-wrapper">
                                        <div class="photo-circle">
                                            ${photoHtml}
                                        </div>
                                        <div class="verified-badge">✓</div>
                                    </div>

                                    <div class="visitor-name">${name}</div>
                                    <div class="dept-badge">${dept}</div>
                                </div>

                                <div class="badge-right">
                                    <div class="info-row">
                                        <div class="info-box">
                                            <div class="info-label">HOST</div>
                                            <div class="info-value">${host}</div>
                                        </div>
                                        <div class="info-box">
                                            <div class="info-label">VALID UNTIL</div>
                                            <div class="info-value">${validUntil}</div>
                                        </div>
                                    </div>

                                    <div class="bottom-section">
                                        <div class="pass-section">
                                            <div class="pass-box">
                                                <div class="info-label">PASS ID</div>
                                                <div class="pass-id">${passId}</div>
                                            </div>
                                            <div class="wear-text">ⓘ WEAR BADGE AT ALL TIMES</div>
                                        </div>
                                        <div class="qr-section">
                                            <img src="${qrUrl}" class="qr-code" alt="QR Code">
                                            <div class="scan-label">Scan to verify</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

            // Small delay to ensure content is rendered, then print
            setTimeout(() => {
                window.print();
            }, 100);
        }
    </script>
@endsection