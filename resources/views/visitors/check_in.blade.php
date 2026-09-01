@extends('layouts.app')

@section('title', 'Visitors | Check-In')

@section('content')
    <div class="py-12" x-data="{ 
            activeTab: 'single',
            groupName: '',
            hostId: '',
            purpose: 'Meeting',
            timeIn: '{{ now()->format('Y-m-d\TH:i') }}',
            timeOut: '{{ now()->addHours(4)->format('Y-m-d\TH:i') }}',
            notes: '',
            visitors: [{ id: Date.now(), name: '', phone: '' }],
            qrGenerated: false,

            addVisitor() { 
                this.visitors.push({ id: Date.now(), name: '', phone: '' });
            },
            removeVisitor(index) { 
                if(this.visitors.length > 1) {
                    this.visitors.splice(index, 1);
                }
            },
            groupPassId: 'PASS-' + Math.random().toString(36).substr(2, 8).toUpperCase(),
            get isGroupValid() {
                return this.groupName && this.hostId && this.visitors.every(v => v.name && v.phone);
            },
            updateQRCode() {
                if (this.isGroupValid) {
                    const qrContainer = document.getElementById('group-qr-code');
                    if (qrContainer) {
                        qrContainer.innerHTML = '';
                        new QRCode(qrContainer, {
                            text: this.groupPassId,
                            width: 160,
                            height: 160,
                            colorDark : '#0a1e3b',
                            colorLight : '#ffffff',
                            correctLevel : QRCode.CorrectLevel.H
                        });
                        this.qrGenerated = true;
                    }
                } else {
                    this.qrGenerated = false;
                    const qrContainer = document.getElementById('group-qr-code');
                    if (qrContainer) qrContainer.innerHTML = '';
                }
            },
            async registerGroup() {
                if (!this.isGroupValid) return;
                
                try {
                    const response = await fetch('{{ route('visitors.pre_registrations.bulk_store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            groupName: this.groupName,
                            hostId: this.hostId,
                            purpose: this.purpose,
                            timeIn: this.timeIn,
                            timeOut: this.timeOut,
                            notes: this.notes,
                            visitors: this.visitors.map(v => ({ name: v.name, phone: v.phone }))
                        })
                    });
                    
                    const result = await response.json();
                    if (result.success) {
                        window.location.href = result.redirect;
                    } else {
                        alert('Registration failed: ' + (result.message || 'Unknown error'));
                    }
                } catch (error) {
                    console.error('Error during bulk registration:', error);
                    alert('An error occurred during registration.');
                }
            }
        }" x-init="
            $watch('visitors', () => updateQRCode());
            $watch('groupName', () => updateQRCode());
            $watch('hostId', () => updateQRCode());
        ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6 text-[#0a1e3b]">
                <div>
                    <h2 class="text-3xl font-black tracking-tight">Visitor Check-in</h2>
                    <p class="text-sm font-medium text-gray-500">Register new guests and generate group access passes.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('visitors.badges') }}"
                        class="px-5 py-2.5 bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2 shadow-lg shadow-orange-500/20">
                        <i data-lucide="ticket" class="w-3.5 h-3.5"></i> View Badges
                    </a>
                    <a href="{{ route('visitors.pre_registrations') }}"
                        class="px-5 py-2.5 bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2 shadow-lg shadow-orange-500/20">
                        <i data-lucide="clipboard-list" class="w-3.5 h-3.5"></i> Pre-registrations
                    </a>
                </div>
            </div>

            <div class="flex bg-gray-100/50 p-1.5 rounded-2xl mb-8 w-fit border border-gray-200 shadow-sm">
                <button @click="activeTab = 'single'"
                    :class="activeTab === 'single' ? 'bg-white shadow-md text-blue-600' : 'text-gray-500'"
                    class="px-8 py-3 rounded-xl text-xs uppercase font-black transition-all duration-300 flex items-center gap-2.5">
                    <i data-lucide="user" class="w-4 h-4"></i> Single Visitor
                </button>
                <button @click="activeTab = 'bulk'"
                    :class="activeTab === 'bulk' ? 'bg-white shadow-md text-blue-600' : 'text-gray-500'"
                    class="px-8 py-3 rounded-xl text-xs uppercase font-black transition-all duration-300 flex items-center gap-2.5">
                    <i data-lucide="users" class="w-4 h-4"></i> Bulk Registration
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Check-in Form Column -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Single Visitor Section -->
                    <div x-show="activeTab === 'single'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-white rounded-3xl p-8 border border-gray-100 shadow-xl shadow-gray-200/50">
                        <h3
                            class="text-xs font-black text-gray-400 mb-8 flex items-center gap-3 uppercase tracking-[0.2em]">
                            <div class="w-1.5 h-4 bg-blue-500 rounded-full"></div>
                            New Visitor
                        </h3>

                        <form action="{{ route('visitor.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">Full
                                        Name *</label>
                                    <input type="text" name="name" required
                                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-medium"
                                        placeholder="Juan Dela Cruz">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">Department</label>
                                    <select name="department" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-medium">
                                        <option value="">Select Department...</option>
                                        <option value="HR1">HR1</option>
                                        <option value="HR2">HR2</option>
                                        <option value="HR3">HR3</option>
                                        <option value="HR4">HR4</option>
                                        <option value="Logistics 1">Logistics 1</option>
                                        <option value="Logistics 2">Logistics 2</option>
                                        <option value="Financial">Financial</option>
                                        <option value="Core 1">Core 1</option>
                                        <option value="Core 2">Core 2</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">Email</label>
                                    <input type="email" name="email"
                                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-medium"
                                        placeholder="juan@sk.com">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">Phone
                                        Number *</label>
                                    <input type="tel" name="contact" required
                                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-medium"
                                        placeholder="0912 345 6789">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">Time In</label>
                                    <input type="datetime-local" name="time_in" value="{{ now()->format('Y-m-d\TH:i') }}"
                                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-medium">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">Expected Time Out</label>
                                    <input type="datetime-local" name="expected_time_out" value="{{ now()->addHours(4)->format('Y-m-d\TH:i') }}"
                                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-medium">
                                </div>
                            </div>

                            <div class="border-t border-gray-50 pt-8 mb-8">
                                <h4
                                    class="text-xs font-black text-gray-400 mb-6 flex items-center gap-3 uppercase tracking-[0.2em]">
                                    <div class="w-1.5 h-4 bg-orange-500 rounded-full"></div>
                                    Visitor Details
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">Host
                                            Employee *</label>
                                        <select name="host_id" required
                                            class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all outline-none text-sm font-medium">
                                            <option value="">Select Host...</option>
                                            @foreach(\App\Models\User::all() as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->department }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">Purpose
                                            of Visit</label>
                                        <select name="purpose"
                                            class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all outline-none text-sm font-medium">
                                            <option>Meeting</option>
                                            <option>Interview</option>
                                            <option>Delivery</option>
                                            <option>Maintenance</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">Room</label>
                                        <select name="room" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all outline-none text-sm font-medium">
                                            <option value="">Select Room...</option>
                                            <option value="Conference Room A">Conference Room A</option>
                                            <option value="Conference Room B">Conference Room B</option>
                                            <option value="Conference Room C">Conference Room C</option>
                                            <option value="Meeting Room 1">Meeting Room 1</option>
                                            <option value="Meeting Room 2">Meeting Room 2</option>
                                            <option value="Meeting Room 3">Meeting Room 3</option>
                                            <option value="Board Room">Board Room</option>
                                            <option value="Training Room">Training Room</option>
                                            <option value="Office 101">Office 101</option>
                                            <option value="Office 102">Office 102</option>
                                            <option value="Office 201">Office 201</option>
                                            <option value="Office 202">Office 202</option>
                                            <option value="Lobby">Lobby</option>
                                            <option value="Reception">Reception</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-1">ID Presented</label>
                                        <select name="id_type" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3.5 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-medium">
                                            <option value="">Select ID Type...</option>
                                            <option value="philnational_id">National ID (PhilSys)</option>
                                            <option value="drivers_license">Driver's License</option>
                                            <option value="passport">Passport</option>
                                            <option value="umid">UMID / SSS / GSIS</option>
                                            <option value="voters_id">Voter's ID</option>
                                            <option value="tin_id">TIN ID</option>
                                            <option value="postal_id">Postal ID</option>
                                            <option value="prc_id">PRC ID</option>
                                            <option value="barangay_id">Barangay ID</option>
                                            <option value="company_id">Company / Employee ID</option>
                                            <option value="school_id">School ID</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 bg-blue-50/50 p-6 rounded-3xl border border-blue-100/50 mb-10">
                                <input type="hidden" name="profile_photo" id="profilePhotoInput">
                                <input type="checkbox" name="nda_signed" id="nda"
                                    class="w-6 h-6 rounded-lg border-gray-200 text-blue-600 focus:ring-blue-500/20">
                                <label for="nda" class="text-sm font-bold text-gray-700 cursor-pointer">Visitor has signed
                                    the NDA / Safety Waiver</label>
                            </div>

                            <div class="flex justify-end gap-4">
                                <button type="button"
                                    class="px-10 py-4 bg-gray-100 text-gray-500 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-gray-200 transition-all">Cancel</button>
                                <button type="submit"
                                    class="px-12 py-4 bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-xl shadow-orange-500/20 hover:scale-[1.02] transform transition-all active:scale-95">Complete
                                    Check-in</button>
                            </div>
                        </form>
                    </div>

                    <!-- Bulk Registration Section -->
                    <div x-show="activeTab === 'bulk'" x-cloak x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-white rounded-3xl p-10 border border-gray-100 shadow-xl shadow-gray-200/50">

                        <div class="flex flex-col md:flex-row gap-10">
                            <!-- Form Column -->
                            <div class="flex-1 space-y-10">
                                <div class="space-y-8">
                                    <h3
                                        class="text-xs font-black text-gray-400 flex items-center gap-3 uppercase tracking-[0.2em]">
                                        <div class="w-1.5 h-4 bg-blue-600 rounded-full"></div>
                                        Group Information
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Group
                                                Name *</label>
                                            <input type="text" x-model="groupName"
                                                class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-bold"
                                                placeholder="e.g. Sales Team Delegation">
                                        </div>
                                        <div class="space-y-2">
                                            <label
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Host
                                                Employee *</label>
                                            <select x-model="hostId"
                                                class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-bold">
                                                <option value="">Select Host...</option>
                                                @foreach(\App\Models\User::all() as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="space-y-2">
                                            <label
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Purpose
                                                of Visit</label>
                                            <select x-model="purpose"
                                                class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-bold">
                                                <option>Meeting</option>
                                                <option>Interview</option>
                                                <option>Delivery</option>
                                                <option>Maintenance</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                        <div class="space-y-2">
                                            <label
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Expected
                                                Time In</label>
                                            <input type="datetime-local" x-model="timeIn"
                                                class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-bold">
                                        </div>
                                        <div class="space-y-2">
                                            <label
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Expected
                                                Time Out</label>
                                            <input type="datetime-local" x-model="timeOut"
                                                class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-bold">
                                        </div>
                                        <div class="md:col-span-2 space-y-2">
                                            <label
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Notes
                                                / Special Instructions</label>
                                            <textarea x-model="notes" rows="2"
                                                class="w-full bg-gray-50 border-gray-100 rounded-2xl py-3 px-5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-sm font-bold"
                                                placeholder="Any special needs or instructions..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <div class="flex justify-between items-center">
                                        <h3
                                            class="text-xs font-black text-gray-400 flex items-center gap-3 uppercase tracking-[0.2em]">
                                            <div class="w-1.5 h-4 bg-orange-500 rounded-full"></div>
                                            Visitors List
                                        </h3>
                                        <button @click="addVisitor()" type="button"
                                            class="px-5 py-2.5 bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2 shadow-lg shadow-orange-500/20">
                                            <i data-lucide="plus-circle" class="w-4 h-4"></i> Add Person
                                        </button>
                                    </div>

                                    <div class="space-y-4 max-h-[420px] overflow-y-auto pr-4 custom-scrollbar">
                                        <template x-for="(visitor, index) in visitors" :key="visitor.id">
                                            <div
                                                class="flex items-center gap-5 p-4 bg-gray-50/50 rounded-3xl border border-gray-100 group hover:bg-white hover:border-blue-200 hover:shadow-lg hover:shadow-blue-500/5 transition-all animate-fadeIn">
                                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-black text-xs flex items-center justify-center border-2 border-white shadow-sm"
                                                    x-text="index + 1"></div>
                                                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <input type="text" x-model="visitor.name"
                                                        class="w-full bg-transparent border-b border-gray-200 py-1.5 focus:border-blue-500 outline-none text-sm font-bold placeholder:font-normal placeholder:text-gray-300"
                                                        placeholder="Full Name *">
                                                    <input type="tel" x-model="visitor.phone"
                                                        class="w-full bg-transparent border-b border-gray-200 py-1.5 focus:border-blue-500 outline-none text-sm font-bold placeholder:font-normal placeholder:text-gray-300"
                                                        placeholder="Phone Number *">
                                                </div>
                                                <button @click="removeVisitor(index)" type="button"
                                                    class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- QR Column -->
                            <div class="w-full md:w-[280px] space-y-6 flex flex-col items-center">
                                <div
                                    class="w-full aspect-square bg-white border-2 border-dashed border-gray-200 rounded-[2.5rem] flex flex-col items-center justify-center relative overflow-hidden group">
                                    <div id="group-qr-code"
                                        class="z-10 transition-transform duration-500 group-hover:scale-110"></div>
                                    <template x-if="!qrGenerated">
                                        <div
                                            class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center space-y-3">
                                            <div
                                                class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center animate-pulse">
                                                <i data-lucide="qr-code" class="w-8 h-8 text-gray-300"></i>
                                            </div>
                                            <p
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-relaxed">
                                                Fill in group name & host to generate shared QR</p>
                                        </div>
                                    </template>
                                    <div x-show="qrGenerated"
                                        class="absolute bottom-6 px-4 py-2 bg-[#0a1e3b] text-white text-[9px] font-black uppercase tracking-widest rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                        Group Access Code</div>
                                </div>

                                <button x-show="qrGenerated"
                                    class="w-fit px-10 py-2.5 bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] rounded-xl text-[9px] font-black uppercase tracking-[0.1em] shadow-xl shadow-orange-500/20 transform hover:-translate-y-0.5 active:scale-95 transition-all mt-[-1rem]">
                                    Print Shared Pass
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 mt-12 pt-8 border-t border-gray-50">
                            <button type="button"
                                class="px-8 py-3 bg-white border border-gray-200 text-gray-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:text-gray-600 hover:bg-gray-50 transition-all">Discard</button>
                            <button type="button" @click="registerGroup()" :disabled="!isGroupValid"
                                :class="isGroupValid ? 'bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] shadow-orange-500/20' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                class="px-12 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl transition-all">
                                Register
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Statistics Column -->
                <div class="space-y-8">
                    <!-- Photo Capture -->
                    <div x-show="activeTab === 'single'" x-transition
                        class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl shadow-gray-200/50">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Identity Capture</h3>
                            <span class="px-2 py-1 bg-blue-50 text-blue-600 text-[8px] font-black uppercase rounded-lg">Live
                                Feed</span>
                        </div>
                        <div
                            class="aspect-square bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden relative group">
                            <video id="cameraFeed" class="w-full h-full object-cover hidden" style="transform: scaleX(-1);"
                                autoplay playsinline></video>
                            <img id="photoPreview" class="w-full h-full object-cover hidden" />
                            <div id="cameraPlaceholder"
                                class="flex flex-col items-center gap-3 text-gray-300 transition-transform group-hover:scale-110">
                                <i data-lucide="camera" class="w-12 h-12"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest">Tap to start</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mt-6">
                            <button type="button" id="startCameraButton"
                                class="py-3 bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] rounded-xl text-[9px] font-black uppercase tracking-widest shadow-lg shadow-orange-500/20 aspect-auto transition-all">Start</button>
                            <button type="button" id="captureButton"
                                class="hidden py-3 bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] rounded-xl text-[9px] font-black uppercase tracking-widest shadow-lg shadow-orange-500/20 aspect-auto transition-all">Capture</button>
                            <button type="button" id="retakeButton"
                                class="hidden col-span-2 py-3 bg-gray-100 text-gray-500 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-200 transition-all text-center">Take
                                Another</button>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl shadow-gray-200/50">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Recent Check-ins</h3>
                        <div class="space-y-6">
                            @forelse($recentCheckins as $checkin)
                                <div class="flex items-center gap-4 group">
                                    <div
                                        class="flex-none w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 font-black text-xs flex items-center justify-center border border-blue-100 transform group-hover:rotate-12 transition-all">
                                        {{ strtoupper(substr($checkin->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-black text-[#0a1e3b] truncate uppercase tracking-wider">
                                            {{ $checkin->name }}</p>
                                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                            {{ $checkin->purpose }} •
                                            {{ $checkin->time_in ? \Carbon\Carbon::parse($checkin->time_in)->diffForHumans() : 'Just now' }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10">
                                    <i data-lucide="clock" class="w-8 h-8 text-gray-100 mx-auto mb-3"></i>
                                    <p class="text-[9px] font-black text-gray-300 uppercase tracking-[0.2em]">No Recent Pulse
                                    </p>
                                </div>
                            @endforelse
                        </div>
                        <a href="{{ route('visitors.badges') }}"
                            class="mt-8 block w-full py-3 bg-gray-50 text-gray-400 text-center rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-blue-50 hover:text-blue-500 transition-all">Pulse
                            History</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Camera Logic
            const startBtn = document.getElementById('startCameraButton');
            const captureBtn = document.getElementById('captureButton');
            const retakeBtn = document.getElementById('retakeButton');
            const video = document.getElementById('cameraFeed');
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('cameraPlaceholder');
            const photoInput = document.getElementById('profilePhotoInput');
            let stream = null;

            startBtn.addEventListener('click', async () => {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    video.srcObject = stream;
                    video.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    preview.classList.add('hidden');
                    startBtn.classList.add('hidden');
                    captureBtn.classList.remove('hidden');
                    retakeBtn.classList.add('hidden');
                } catch (err) {
                    alert("Camera access denied.");
                }
            });

            captureBtn.addEventListener('click', () => {
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0);
                const dataUrl = canvas.toDataURL('image/jpeg');
                preview.src = dataUrl;
                photoInput.value = dataUrl;
                video.classList.add('hidden');
                preview.classList.remove('hidden');
                if (stream) stream.getTracks().forEach(track => track.stop());
                captureBtn.classList.add('hidden');
                retakeBtn.classList.remove('hidden');
            });

            retakeBtn.addEventListener('click', () => {
                photoInput.value = '';
                preview.classList.add('hidden');
                startBtn.click();
            });

            // Re-initialize icons for dynamic content
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
@endpush