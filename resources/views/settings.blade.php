@extends('layouts.app')

@section('title', 'Settings | General')

@section('content')
<div class="py-6 space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage system configurations and preferences.</p>
        </div>
    </div>

    <!-- Settings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Profile Settings -->
        <a href="{{ route('profile.show') }}" class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all hover:border-blue-300">
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-lg bg-blue-50 text-blue-600 group-hover:bg-blue-100 transition-colors">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">My Profile</h3>
                    <p class="text-sm text-gray-500">Update your personal information, password, and account details.</p>
                </div>
            </div>
        </a>

        @if(auth()->user()->role === 'Admin Manager' || auth()->user()->role === 'Owner')
        <!-- User Management -->
        <a href="{{ route('access.users') }}" class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all hover:border-blue-300">
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-lg bg-purple-50 text-purple-600 group-hover:bg-purple-100 transition-colors">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">User Management</h3>
                    <p class="text-sm text-gray-500">Manage users, roles, and access permissions.</p>
                </div>
            </div>
        </a>

        <!-- Department Accounts -->
        <a href="{{ route('access.department_accounts') }}" class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all hover:border-blue-300">
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100 transition-colors">
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Department Accounts</h3>
                    <p class="text-sm text-gray-500">Manage department-level access and credentials.</p>
                </div>
            </div>
        </a>

        <!-- Audit Logs -->
        <a href="{{ route('access.audit_logs') }}" class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all hover:border-blue-300">
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-lg bg-orange-50 text-orange-600 group-hover:bg-orange-100 transition-colors">
                    <i data-lucide="activity" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Audit Logs</h3>
                    <p class="text-sm text-gray-500">View system-wide activity logs and security events.</p>
                </div>
            </div>
        </a>

        <!-- Integration & Sync -->
        <a href="{{ route('integration-sync.index') }}" class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all hover:border-blue-300">
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-lg bg-teal-50 text-teal-600 group-hover:bg-teal-100 transition-colors">
                    <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Integration & Sync</h3>
                    <p class="text-sm text-gray-500">Manage external integrations and data synchronization.</p>
                </div>
            </div>
        </a>
        @endif

    </div>

    @if(auth()->user()->role === 'Admin Manager' || auth()->user()->role === 'Owner')
    <!-- System Security Settings -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mt-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">System Security Settings</h2>
            <p class="text-sm text-gray-500">Configure global security settings for all users.</p>
        </div>
        <div class="p-6">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    
                    <!-- 2FA Setting -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-medium text-gray-900">Two-Factor Authentication (2FA)</label>
                            <p class="text-sm text-gray-500">Enable or disable OTP email verification for all roles.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="settings[security.enable_2fa]" value="false">
                            <input type="checkbox" name="settings[security.enable_2fa]" value="true" class="sr-only peer" {{ ($settings['security.enable_2fa'] ?? 'true') === 'true' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <hr>

                    <!-- Session Timeout Setting -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-medium text-gray-900">Session Timeout</label>
                            <p class="text-sm text-gray-500">Automatically log out inactive users.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="settings[security.session_timeout_enabled]" value="false">
                            <input type="checkbox" name="settings[security.session_timeout_enabled]" value="true" class="sr-only peer" {{ ($settings['security.session_timeout_enabled'] ?? 'true') === 'true' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Session Timeout Duration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Timeout Duration (Minutes)</label>
                        <input type="number" name="settings[security.session_timeout_minutes]" value="{{ $settings['security.session_timeout_minutes'] ?? 120 }}" class="mt-1 block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Save Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
