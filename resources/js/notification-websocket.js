/**
 * Real-time Notification WebSocket Client
 * Supports Pusher (recommended) with fallback to polling
 * Optimized for Soliera Executive Dashboard
 */

class NotificationWebSocketClient {
    constructor() {
        this.connected = false;
        this.reconnectAttempts = 0;
        this.maxReconnectAttempts = 10;
        this.reconnectDelay = 1000;
        this.pollInterval = null;
        this.echo = null;
        this.userId = null;
        this.lastNotificationCount = 0;

        // Configuration for Categories
        this.categories = {
            'visitor': { icon: 'user-check', color: 'text-green-300', bg: 'bg-green-600/30' },
            'document': { icon: 'file-text', color: 'text-blue-300', bg: 'bg-blue-600/30' },
            'contract': { icon: 'file-signature', color: 'text-yellow-300', bg: 'bg-yellow-600/30' },
            'approval': { icon: 'check-circle', color: 'text-cyan-300', bg: 'bg-cyan-600/30' },
            'permit': { icon: 'shield-check', color: 'text-indigo-300', bg: 'bg-indigo-600/30' },
            'legal': { icon: 'balance-scale', color: 'text-purple-300', bg: 'bg-purple-600/30' },
            'risk': { icon: 'alert-triangle', color: 'text-red-300', bg: 'bg-red-600/30' },
            'facility': { icon: 'building', color: 'text-emerald-300', bg: 'bg-emerald-600/30' },
            'system': { icon: 'settings', color: 'text-slate-300', bg: 'bg-slate-600/30' },
            'general': { icon: 'bell', color: 'text-white', bg: 'bg-blue-600/30' }
        };

        this.timeAgo = (date) => {
            const seconds = Math.floor((new Date() - new Date(date)) / 1000);
            let interval = seconds / 31536000;
            if (interval > 1) return Math.floor(interval) + " years ago";
            interval = seconds / 2592000;
            if (interval > 1) return Math.floor(interval) + " months ago";
            interval = seconds / 86400;
            if (interval > 1) return Math.floor(interval) + " days ago";
            interval = seconds / 3600;
            if (interval > 1) return Math.floor(interval) + " hours ago";
            interval = seconds / 60;
            if (interval > 1) return Math.floor(interval) + " minutes ago";
            return "Just now";
        };

        const userIdMeta = document.querySelector('meta[name="user-id"]');
        this.userId = userIdMeta ? userIdMeta.getAttribute('content') : null;

        this.init();
    }

    init() {
        if (this.canUsePusher()) {
            this.initPusher();
        } else {
            console.log('Pusher not available, using polling fallback');
            this.initPolling();
        }

        this.attachEventListeners();
    }

    canUsePusher() {
        return typeof window.Pusher !== 'undefined' &&
            typeof window.Echo !== 'undefined' &&
            window.broadcastConfig &&
            window.broadcastConfig.driver === 'pusher';
    }

    initPusher() {
        try {
            const config = window.broadcastConfig;
            this.echo = new window.Echo({
                broadcaster: 'pusher',
                key: config.key,
                cluster: config.cluster,
                encrypted: config.encrypted,
                forceTLS: true
            });
            this.subscribe();
        } catch (error) {
            console.error('WebSocket Error:', error);
            this.initPolling();
        }
    }

    subscribe() {
        if (!this.echo || !this.userId) return;

        const channel = this.echo.private(`user.${this.userId}`);

        channel.listen('.notification.created', (data) => {
            console.log('New Notification Received:', data);
            this.handleNewNotification(data);
        });

        channel.listen('.notification.updated', (data) => {
            this.handleNotificationUpdate(data);
        });

        console.log('WebSocket Subscribed to user.' + this.userId);
    }

    initPolling() {
        if (this.pollInterval) return;
        console.log('Notification polling started (3s interval)');
        this.pollInterval = setInterval(() => this.checkForNewNotifications(), 3000);
        this.checkForNewNotifications();
    }

    async checkForNewNotifications() {
        try {
            const response = await fetch('/api/notifications/count');
            const data = await response.json();
            const currentCount = data.count || 0;

            if (currentCount > this.lastNotificationCount) {
                this.refreshNotifications();
            }
            this.updateBadgeCount(currentCount);
            this.lastNotificationCount = currentCount;
        } catch (error) {
            console.error('Check Error:', error);
        }
    }

    handleNewNotification(data) {
        if (data && data.notification) {
            this.addNotificationToUI(data.notification);
            this.updateBadgeCount(data.unread_count || 0);
            this.showBrowserNotification(data.notification);
            this.playNotificationSound();
        }
    }

    handleNotificationUpdate(data) {
        if (data.action === 'read') {
            // Find existing item and mark it read visually
            const item = document.querySelector(`[data-notification-id="${data.notification_id}"]`);
            if (item) {
                item.classList.add('opacity-60');
                item.classList.remove('font-bold');
            }
        } else if (data.action === 'cleared') {
            this.removeNotificationFromUI(data.notification_id);
        } else if (data.action === 'all_read') {
            // Mark all visually read instead of removing
            const items = document.querySelectorAll('.notification-item');
            items.forEach(item => item.classList.add('opacity-60'));

            // Sync with navbar helper if available
            if (window.refreshNotificationDropdown) window.refreshNotificationDropdown();
        } else if (data.action === 'all_cleared') {
            this.clearAllNotificationsUI();
        }

        // Sync badge count across tabs immediately
        this.updateBadgeCount(data.unread_count ?? 0);
        this.lastNotificationCount = data.unread_count ?? 0;
    }

    addNotificationToUI(notification) {
        const container = document.getElementById('notificationsContainer');
        if (!container) return;

        // Remove empty state
        const empty = container.querySelector('.empty-notifications') || container.querySelector('li.text-center');
        if (empty) empty.remove();

        const item = this.createNotificationItem(notification);
        container.insertBefore(item, container.firstChild);

        // Limit to 10
        const items = container.querySelectorAll('.notification-item');
        if (items.length > 10) items[items.length - 1].remove();

        if (window.lucide) window.lucide.createIcons();
    }

    createNotificationItem(notification) {
        const li = document.createElement('li');
        li.className = 'px-3 py-2.5 hover:bg-blue-800/50 transition-all notification-item border-b border-blue-800/30 animate-fade-in-down';
        li.setAttribute('data-notification-id', notification.id);

        const d = notification.data || {};
        const category = d.category || d.model_type || 'general';
        const config = this.categories[category] || this.categories.general;

        const title = d.title || 'Notification';
        const message = d.message || '';
        const url = d.url || '#';
        const severity = d.severity || 'low';

        let severityBadge = '';
        if (severity === 'high') severityBadge = '<span class="px-1.5 py-0.5 bg-red-600 text-[9px] rounded-full uppercase font-bold ml-auto">Urgent</span>';
        if (severity === 'critical') severityBadge = '<span class="px-1.5 py-0.5 bg-red-800 text-[9px] rounded-full uppercase font-bold ml-auto animate-pulse">Critical</span>';

        li.innerHTML = `
            <a class="flex items-start gap-2.5 cursor-pointer" href="${url}" onclick="markAsRead('${notification.id}', '${url}'); return false;">
                <div class="p-2 rounded-full ${config.bg} flex-shrink-0">
                    <i data-lucide="${d.icon || config.icon}" class="text-base text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-1.5 mb-0.5">
                        <p class="font-semibold text-white text-xs truncate">${title}</p>
                        ${severityBadge}
                    </div>
                    <p class="text-xs text-blue-200 line-clamp-2 leading-relaxed">${message}</p>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-[10px] text-blue-300 flex items-center gap-1">
                            <i data-lucide="clock" class="w-2.5 h-2.5"></i>
                            ${this.timeAgo(notification.created_at)}
                        </p>
                        <p class="text-[9px] text-blue-400 capitalize opacity-60">${category}</p>
                    </div>
                </div>
            </a>
        `;
        return li;
    }

    updateBadgeCount(count) {
        const badge = document.getElementById('notificationBadge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
            if (count > 0) {
                badge.classList.add('animate-bounce');
                setTimeout(() => badge.classList.remove('animate-bounce'), 1000);
            }
        }
    }

    async refreshNotifications() {
        try {
            // Fetch ALL (read+unread) for the dropdown to prevent empty list after marking read
            const response = await fetch('/api/notifications/list?status=all&limit=10');
            const data = await response.json();
            if (data.success) {
                const container = document.getElementById('notificationsContainer');
                if (!container) return;

                container.innerHTML = '';
                if (!data.notifications || data.notifications.length === 0) {
                    this.showEmptyState();
                } else {
                    data.notifications.forEach(n => container.appendChild(this.createNotificationItem(n)));
                }

                // Update badge with latest count
                this.updateBadgeCount(data.unread_count ?? data.count ?? 0);

                if (window.lucide) window.lucide.createIcons();
            }
        } catch (error) {
            console.error('Refresh Error:', error);
        }
    }

    showEmptyState() {
        const container = document.getElementById('notificationsContainer');
        if (!container) return;
        container.innerHTML = `
            <li class="px-4 py-8 text-center empty-notifications">
                <div class="flex flex-col items-center gap-2">
                    <div class="p-3 rounded-full bg-blue-600/20">
                        <i data-lucide="bell-off" class="text-3xl text-blue-300"></i>
                    </div>
                    <p class="text-white font-semibold text-sm">No notifications</p>
                    <p class="text-xs text-blue-300">You're all caught up!</p>
                </div>
            </li>
        `;
        if (window.lucide) window.lucide.createIcons();
    }

    removeNotificationFromUI(id) {
        const item = document.querySelector(`[data-notification-id="${id}"]`);
        if (item) {
            item.classList.add('animate-fade-out');
            setTimeout(() => {
                item.remove();
                if (document.querySelectorAll('.notification-item').length === 0) this.showEmptyState();
            }, 300);
        }
    }

    clearAllNotificationsUI() {
        const container = document.getElementById('notificationsContainer');
        if (container) {
            container.innerHTML = '';
            this.showEmptyState();
        }
    }

    showBrowserNotification(notification) {
        if (!('Notification' in window)) return;
        if (Notification.permission === 'granted') {
            const d = notification.data || {};
            new Notification(d.title || 'System Alert', {
                body: d.message || '',
                icon: '/favicon.ico'
            });
        }
    }

    playNotificationSound() {
        // Optional: play a subtle beep
    }

    attachEventListeners() {
        const clearBtn = document.getElementById('clearAllNotificationsBtn');
        if (clearBtn) {
            clearBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                try {
                    const res = await fetch('/api/notifications/clear-all', { method: 'POST', headers: { 'X-CSRF-TOKEN': this.getCsrfToken() } });
                    const data = await res.json();
                    if (data.success) this.clearAllNotificationsUI();
                } catch (err) { console.error(err); }
            });
        }
    }

    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }
}

// Global Notification Helper (used in Navbar)
window.markAsRead = async function (id, url) {
    try {
        const res = await fetch(`/api/notifications/${id}/read`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') }
        });
        const data = await res.json();
        if (data.success && window.notificationClient) {
            window.notificationClient.removeNotificationFromUI(id);
            window.notificationClient.updateBadgeCount(data.unread_count);
        }
    } catch (err) { console.error(err); }
    if (url && url !== '#') window.location.href = url;
};

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('meta[name="user-id"]')?.getAttribute('content')) {
        window.notificationClient = new NotificationWebSocketClient();
    }
});
