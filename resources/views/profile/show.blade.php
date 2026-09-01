@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="w-full max-w-6xl mx-auto">
    @if(session('error'))
        <div class="alert alert-error mb-4 shadow-lg">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($deptAccount)
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left Column - Profile Card -->
        <div class="lg:col-span-4">
            <div class="card bg-white shadow-xl rounded-2xl overflow-hidden">
                <!-- Profile Header with Gradient -->
                <div class="bg-gradient-to-br from-[#001F54] via-[#002a6b] to-[#003580] h-32 relative">
                    <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                        <div class="relative group">
                            <div class="w-28 h-28 rounded-full ring-4 ring-white shadow-xl overflow-hidden bg-white">
                                @if($deptAccount->profile_picture)
                                    <img src="{{ asset('storage/' . $deptAccount->profile_picture) }}" alt="Profile" class="w-full h-full object-cover" />
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#F7B32B] to-[#e09800] flex items-center justify-center">
                                        <span class="text-4xl font-bold text-white">{{ strtoupper(substr($deptAccount->employee_name ?? 'U', 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <!-- Camera overlay on hover -->
                            <label for="profile_picture_input" class="absolute inset-0 bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer flex items-center justify-center">
                                <i data-lucide="camera" class="w-8 h-8 text-white"></i>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Profile Info -->
                <div class="pt-16 pb-6 px-6 text-center">
                    <h2 class="text-xl font-bold text-gray-800">{{ $deptAccount->employee_name ?? 'User' }}</h2>
                    <p class="text-gray-500 text-sm mt-1">{{ $deptAccount->email ?? '' }}</p>
                    
                    <!-- Badges -->
                    <div class="flex flex-wrap gap-2 justify-center mt-4">
                        <span class="px-3 py-1 bg-[#001f54] text-white text-xs font-medium rounded-full">
                            {{ ucfirst($deptAccount->role ?? 'User') }}
                        </span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                            {{ $deptAccount->dept_name ?? 'N/A' }}
                        </span>
                        @if($deptAccount->status === 'active')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full flex items-center gap-1">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                Active
                            </span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">
                                {{ ucfirst($deptAccount->status ?? 'N/A') }}
                            </span>
                        @endif
                    </div>

                    <!-- Photo Actions -->
                    <div class="mt-6 flex justify-center gap-2">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="photo-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="employee_name" value="{{ $deptAccount->employee_name }}">
                            <input type="hidden" name="email" value="{{ $deptAccount->email }}">
                            <label for="profile_picture_input" class="btn btn-sm bg-[#F7B32B] hover:bg-[#e09800] text-white border-none gap-2 cursor-pointer">
                                <i data-lucide="upload" class="w-4 h-4"></i>
                                Upload Photo
                            </label>
                            <input type="file" name="profile_picture" id="profile_picture_input" class="hidden" accept="image/*" onchange="document.getElementById('photo-form').submit()">
                        </form>
                        @if($deptAccount->profile_picture)
                            <button type="button" onclick="removeProfilePicture()" class="btn btn-sm btn-ghost text-red-500 hover:bg-red-50 gap-2">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                Remove
                            </button>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 mt-2">JPG, PNG or GIF • Max 2MB</p>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100"></div>

                <!-- Account Info -->
                <div class="p-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Account Information</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center flex-shrink-0">
                                <i data-lucide="hash" class="w-5 h-5 text-[#F7B32B]"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-400">Employee ID</p>
                                <p class="text-sm font-medium text-gray-800 font-mono">{{ $deptAccount->employee_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center flex-shrink-0">
                                <i data-lucide="building-2" class="w-5 h-5 text-[#F7B32B]"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-400">Department ID</p>
                                <p class="text-sm font-medium text-gray-800 font-mono">{{ $deptAccount->Dept_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-[#001F54] flex items-center justify-center flex-shrink-0">
                                <i data-lucide="calendar" class="w-5 h-5 text-[#F7B32B]"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-400">Member Since</p>
                                <p class="text-sm font-medium text-gray-800">{{ now()->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="lg:col-span-8 space-y-6">
            <!-- Edit Profile Card -->
            <div class="card bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-[#001F54] px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <i data-lucide="user-cog" class="w-5 h-5 text-[#F7B32B]"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Personal Information</h3>
                            <p class="text-sm text-white/70">Update your personal details here</p>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium text-gray-700">Full Name</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="user" class="w-5 h-5"></i>
                                </span>
                                <input type="text" name="employee_name" value="{{ old('employee_name', $deptAccount->employee_name ?? '') }}" 
                                    class="input input-bordered w-full pl-11 focus:border-[#F7B32B] focus:ring-2 focus:ring-[#F7B32B]/20" required />
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium text-gray-700">Email Address</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                </span>
                                <input type="email" name="email" value="{{ old('email', $deptAccount->email ?? '') }}" 
                                    class="input input-bordered w-full pl-11 focus:border-[#F7B32B] focus:ring-2 focus:ring-[#F7B32B]/20" required />
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium text-gray-700">Employee ID</span>
                                <span class="label-text-alt text-gray-400">Cannot be changed</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="badge" class="w-5 h-5"></i>
                                </span>
                                <input type="text" value="{{ $deptAccount->employee_id ?? 'N/A' }}" 
                                    class="input input-bordered w-full pl-11 bg-gray-50 text-gray-500 cursor-not-allowed" disabled />
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium text-gray-700">Department</span>
                                <span class="label-text-alt text-gray-400">Cannot be changed</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="building" class="w-5 h-5"></i>
                                </span>
                                <input type="text" value="{{ $deptAccount->dept_name ?? 'N/A' }}" 
                                    class="input input-bordered w-full pl-11 bg-gray-50 text-gray-500 cursor-not-allowed" disabled />
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium text-gray-700">Role</span>
                                <span class="label-text-alt text-gray-400">Cannot be changed</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="shield" class="w-5 h-5"></i>
                                </span>
                                <input type="text" value="{{ ucfirst($deptAccount->role ?? 'User') }}" 
                                    class="input input-bordered w-full pl-11 bg-gray-50 text-gray-500 cursor-not-allowed" disabled />
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium text-gray-700">Account Status</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="activity" class="w-5 h-5"></i>
                                </span>
                                <div class="input input-bordered w-full pl-11 bg-gray-50 flex items-center cursor-not-allowed">
                                    @if($deptAccount->status === 'active')
                                        <span class="flex items-center gap-2 text-green-600 font-medium">
                                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="text-yellow-600 font-medium">{{ ucfirst($deptAccount->status ?? 'N/A') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-100">
                        <button type="submit" class="btn bg-[#F7B32B] hover:bg-[#e09800] text-white border-none gap-2 px-6">
                            <i data-lucide="save" class="w-5 h-5"></i>
                            Save Changes
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-ghost text-gray-600 gap-2">
                            <i data-lucide="x" class="w-5 h-5"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Security Card -->
            <div class="card bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-[#001F54] px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-5 h-5 text-[#F7B32B]"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Security Settings</h3>
                            <p class="text-sm text-white/70">Manage your account security preferences</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <button class="flex flex-col items-center gap-3 p-5 rounded-xl border-2 border-gray-100 hover:border-[#001F54] hover:bg-[#001F54]/5 transition-all group shadow-sm hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-[#001F54] flex items-center justify-center transition-colors">
                                <i data-lucide="key-round" class="w-6 h-6 text-[#F7B32B]"></i>
                            </div>
                            <div class="text-center">
                                <p class="font-medium text-gray-800">Change Password</p>
                                <p class="text-xs text-gray-500 mt-1">Update your password</p>
                            </div>
                        </button>
                        
                        <button class="flex flex-col items-center gap-3 p-5 rounded-xl border-2 border-gray-100 hover:border-[#001F54] hover:bg-[#001F54]/5 transition-all group shadow-sm hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-[#001F54] flex items-center justify-center transition-colors">
                                <i data-lucide="smartphone" class="w-6 h-6 text-[#F7B32B]"></i>
                            </div>
                            <div class="text-center">
                                <p class="font-medium text-gray-800">Two-Factor Auth</p>
                                <p class="text-xs text-gray-500 mt-1">Add extra security</p>
                            </div>
                        </button>
                        
                        <button class="flex flex-col items-center gap-3 p-5 rounded-xl border-2 border-gray-100 hover:border-[#001F54] hover:bg-[#001F54]/5 transition-all group shadow-sm hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-[#001F54] flex items-center justify-center transition-colors">
                                <i data-lucide="history" class="w-6 h-6 text-[#F7B32B]"></i>
                            </div>
                            <div class="text-center">
                                <p class="font-medium text-gray-800">Login History</p>
                                <p class="text-xs text-gray-500 mt-1">View recent activity</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card bg-white shadow-xl rounded-2xl p-8 text-center">
        <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="alert-triangle" class="w-8 h-8 text-yellow-600"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800">Profile Not Found</h3>
        <p class="text-gray-500 mt-2">Unable to load your profile information. Please contact support.</p>
    </div>
    @endif
</div>

<form action="{{ route('profile.remove_picture') }}" method="POST" id="remove-picture-form" class="hidden">
    @csrf
    @method('DELETE')
</form>

@include('partials.soliera_js')

@push('scripts')
<script>
    function removeProfilePicture() {
        if (confirm('Are you sure you want to remove your profile picture?')) {
            document.getElementById('remove-picture-form').submit();
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) lucide.createIcons();
    });
    
    // Show profile success toast notification and refresh avatar
    @if(session('profile_success'))
    (function() {
        function showProfileNotification() {
            if (typeof window.showNotification === 'function') {
                window.showNotification('{{ session('profile_success') }}', 'success', 5000);
            } else {
                // Wait for the function to be available (from soliera_js)
                setTimeout(showProfileNotification, 100);
            }
        }
        
        function refreshAvatar() {
            // Refresh navbar avatar if function is available
            if (typeof window.refreshNavbarAvatar === 'function') {
                @if($deptAccount && $deptAccount->profile_picture)
                    window.refreshNavbarAvatar('{{ $deptAccount->profile_picture }}');
                @else
                    window.refreshNavbarAvatar(null);
                @endif
            } else {
                // Fallback: reload page after a short delay to show updated avatar
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(showProfileNotification, 300);
                setTimeout(refreshAvatar, 500);
            });
        } else {
            setTimeout(showProfileNotification, 300);
            setTimeout(refreshAvatar, 500);
        }
    })();
    @endif
</script>
@endpush
@endsection
