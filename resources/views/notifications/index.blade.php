@extends('layouts.app')

@section('title', 'Executive Activity Center')

@section('content')
<div class="min-h-screen bg-[#001f54] py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter mb-2">
                    Activity <span class="text-blue-500">Center</span>
                </h1>
                <p class="text-blue-300 font-medium">Monitoring system-wide signals and executive alerts.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="join bg-blue-900/40 p-1 rounded-2xl border border-blue-700/50">
                    <button class="join-item btn btn-sm btn-ghost text-white {{ $status === 'all' ? 'bg-blue-600' : '' }}" onclick="window.location.href='?status=all'">ALL</button>
                    <button class="join-item btn btn-sm btn-ghost text-white {{ $status === 'unread' ? 'bg-blue-600' : '' }}" onclick="window.location.href='?status=unread'">UNREAD</button>
                </div>
                
                <button id="clearAllBtn" class="btn btn-sm bg-red-600/20 hover:bg-red-600 border-red-600/50 text-white rounded-xl gap-2 transition-all">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    <span class="hidden md:inline">Purge Log</span>
                </button>
            </div>
        </div>

        <!-- System Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-900/30 border border-blue-700/30 rounded-2xl p-4 flex items-center gap-4">
                <div class="p-3 rounded-xl bg-blue-600/20">
                    <i data-lucide="bell" class="w-6 h-6 text-blue-400"></i>
                </div>
                <div>
                    <p class="text-[10px] text-blue-400 uppercase font-black tracking-widest">Total</p>
                    <p class="text-2xl font-bold text-white">{{ count($notifications) }}</p>
                </div>
            </div>
            <div class="bg-blue-900/30 border border-blue-700/30 rounded-2xl p-4 flex items-center gap-4">
                <div class="p-3 rounded-xl bg-yellow-600/20">
                    <i data-lucide="mail-warning" class="w-6 h-6 text-yellow-400"></i>
                </div>
                <div>
                    <p class="text-[10px] text-yellow-400 uppercase font-black tracking-widest">Unread</p>
                    <p class="text-2xl font-bold text-white">{{ $notifications->where('read_at', null)->count() }}</p>
                </div>
            </div>
            <div class="bg-blue-900/30 border border-blue-700/30 rounded-2xl p-4 flex items-center gap-4">
                <div class="p-3 rounded-xl bg-red-600/20">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-red-400"></i>
                </div>
                <div>
                    <p class="text-[10px] text-red-400 uppercase font-black tracking-widest">Urgent</p>
                    <p class="text-2xl font-bold text-white">
                        @php 
                            $urgentCount = $notifications->filter(function($n){ 
                                $d = is_string($n->data) ? json_decode($n->data, true) : $n->data;
                                return ($d['severity'] ?? '') === 'high' || ($d['severity'] ?? '') === 'critical';
                            })->count();
                        @endphp
                        {{ $urgentCount }}
                    </p>
                </div>
            </div>
            <div class="bg-blue-900/30 border border-blue-700/30 rounded-2xl p-4 flex items-center gap-4">
                <div class="p-3 rounded-xl bg-emerald-600/20">
                    <i data-lucide="activity" class="w-6 h-6 text-emerald-400"></i>
                </div>
                <div>
                    <p class="text-[10px] text-emerald-400 uppercase font-black tracking-widest">System</p>
                    <p class="text-2xl font-bold text-white">Online</p>
                </div>
            </div>
        </div>

        <!-- Notifications Feed -->
        <div class="bg-blue-900/20 border border-blue-700/30 rounded-3xl overflow-hidden shadow-2xl">
            <div id="notificationsList" class="divide-y divide-blue-800/30">
                @forelse($notifications as $notification)
                    @php
                        $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                        $title = $data['title'] ?? 'System Update';
                        $message = $data['message'] ?? $data['body'] ?? '';
                        $url = $data['url'] ?? '#';
                        $category = $data['category'] ?? $data['model_type'] ?? 'general';
                        $severity = $data['severity'] ?? 'low';
                        $isRead = !is_null($notification->read_at);
                        
                        $categoriesArr = [
                            'visitor' => ['icon' => 'user-check', 'bg' => 'bg-green-600/20', 'text' => 'text-green-400'],
                            'document' => ['icon' => 'file-text', 'bg' => 'bg-blue-600/20', 'text' => 'text-blue-400'],
                            'contract' => ['icon' => 'file-signature', 'bg' => 'bg-yellow-600/20', 'text' => 'text-yellow-400'],
                            'approval' => ['icon' => 'check-circle', 'bg' => 'bg-cyan-600/20', 'text' => 'text-cyan-400'],
                            'permit' => ['icon' => 'shield-check', 'bg' => 'bg-indigo-600/20', 'text' => 'text-indigo-400'],
                            'risk' => ['icon' => 'alert-triangle', 'bg' => 'bg-red-600/20', 'text' => 'text-red-400'],
                            'general' => ['icon' => 'bell', 'bg' => 'bg-slate-600/20', 'text' => 'text-slate-400'],
                        ];
                        $config = $categoriesArr[$category] ?? $categoriesArr['general'];
                    @endphp
                    <div class="group p-6 hover:bg-white/5 transition-all duration-300 relative {{ $isRead ? 'opacity-60' : '' }}" data-notification-id="{{ $notification->id }}">
                        <div class="flex items-start gap-6">
                            <!-- Left: Icon -->
                            <div class="relative">
                                <div class="p-4 rounded-2xl {{ $config['bg'] }} border border-white/5 group-hover:scale-110 transition-transform">
                                    <i data-lucide="{{ $data['icon'] ?? $config['icon'] }}" class="w-6 h-6 {{ $config['text'] }}"></i>
                                </div>
                                @if(!$isRead)
                                    <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-4 w-4 bg-blue-500 border-2 border-[#001f54]"></span>
                                    </span>
                                @endif
                            </div>

                            <!-- Middle: Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-1">
                                    <h3 class="font-bold text-white text-lg tracking-tight">
                                        {{ $title }}
                                    </h3>
                                    @if($severity === 'high' || $severity === 'critical')
                                        <span class="px-2 py-0.5 bg-red-600 rounded-md text-[10px] font-black text-white uppercase tracking-tighter animate-pulse">
                                            {{ $severity }}
                                        </span>
                                    @endif
                                    <span class="px-2 py-0.5 bg-blue-800/40 rounded-md text-[10px] font-bold text-blue-300 uppercase tracking-tighter">
                                        {{ $category }}
                                    </span>
                                </div>
                                <p class="text-blue-100/70 text-sm leading-relaxed mb-4 max-w-3xl">
                                    {{ $message }}
                                </p>
                                <div class="flex items-center gap-6">
                                    <div class="flex items-center gap-2 text-[11px] font-bold text-blue-400/60 uppercase tracking-widest">
                                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                    @if($notification->read_at)
                                        <div class="flex items-center gap-2 text-[11px] font-bold text-emerald-400/60 uppercase tracking-widest">
                                            <i data-lucide="check-check" class="w-3.5 h-3.5"></i>
                                            Acknowledge {{ \Carbon\Carbon::parse($notification->read_at)->diffForHumans() }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Right: Actions -->
                            <div class="flex flex-col gap-2">
                                @if($url && $url !== '#')
                                    <a href="{{ $url }}" class="btn btn-circle bg-blue-600 hover:bg-blue-500 border-none text-white shadow-lg transition-all" onclick="markAsRead('{{ $notification->id }}')">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                @endif
                                <button onclick="clearNotification('{{ $notification->id }}')" class="btn btn-circle bg-white/5 hover:bg-red-600 border-none text-blue-300 hover:text-white transition-all">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-32 text-center">
                        <div class="flex flex-col items-center gap-6">
                            <div class="p-8 rounded-full bg-blue-900/40 border border-blue-700/30">
                                <i data-lucide="bell-off" class="w-20 h-20 text-blue-700"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-white uppercase mb-2">Clean Slate</h3>
                                <p class="text-blue-300">No signals detected in the current filter.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="p-8 border-t border-blue-800/30 bg-black/20">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lucide adjustment
    if (window.lucide) window.lucide.createIcons();

    // Clear all button handler
    const clearAllBtn = document.getElementById('clearAllBtn');
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function() {
            if (confirm('Initiate system-wide notification purge?')) {
                clearAllNotifications();
            }
        });
    }
});

async function markAsRead(id) {
    try {
        const res = await fetch(`/api/notifications/${id}/read`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const data = await res.json();
        if (data.success) {
            const item = document.querySelector(`[data-notification-id="${id}"]`);
            if (item) {
                item.classList.add('opacity-60');
                const dot = item.querySelector('.animate-ping');
                if (dot) dot.parentElement.remove();
            }
        }
    } catch (e) { console.error(e); }
}

async function clearNotification(id) {
    try {
        const res = await fetch(`/api/notifications/${id}/clear`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const data = await res.json();
        if (data.success) {
            const item = document.querySelector(`[data-notification-id="${id}"]`);
            if (item) {
                item.classList.add('animate-fade-out');
                setTimeout(() => item.remove(), 300);
            }
        }
    } catch (e) { console.error(e); }
}

async function clearAllNotifications() {
    try {
        const res = await fetch('/api/notifications/clear-all', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const data = await res.json();
        if (data.success) {
            window.location.reload();
        }
    } catch (e) { console.error(e); }
}
</script>

<style>
.animate-fade-out {
    animation: fadeOut 0.3s forwards;
}
@keyframes fadeOut {
    from { opacity: 1; transform: scale(1); }
    to { opacity: 0; transform: scale(0.95); }
}
</style>
@endsection
