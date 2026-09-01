/**
 * Session Timeout Manager
 * Handles frontend session expiration tracking and warning modal
 */
class SessionTimeoutManager {
    constructor(lifetimeMs) {
        // Ensure minimum lifetime of 1 minute (60000ms) to prevent immediate logout
        // Subtract 30 seconds buffer to preempt server-side timeout
        this.lifetimeMs = Math.max(lifetimeMs - 30000, 60000);
        this.warningTimeMs = 60000; // Show warning 60 seconds before expiry
        this.activityExtendCooldownMs = 60000; // don't spam backend on every move
        this.heartbeatIntervalMs = Math.max(60000, Math.floor(this.lifetimeMs / 4)); // periodic keep-alive

        // Debug logging
        console.log('SessionTimeoutManager initialized:', {
            lifetimeMs: this.lifetimeMs,
            lifetimeMinutes: this.lifetimeMs / 60000,
            warningTimeMs: this.warningTimeMs,
            heartbeatIntervalMs: this.heartbeatIntervalMs
        });

        // Timers
        this.warningTimer = null;
        this.logoutTimer = null;
        this.countdownInterval = null;
        this.heartbeatInterval = null;
        this.lastExtendAt = Date.now();

        // DOM Elements
        this.modal = document.getElementById('sessionTimeoutModal');
        this.countdownEl = document.getElementById('countdown');
        this.extendBtn = document.getElementById('extendSessionBtn');
        this.logoutBtn = document.getElementById('logoutNowBtn');

        // Initialize
        if (this.modal && this.extendBtn && this.logoutBtn) {
            this.init();
        } else {
            console.warn('SessionTimeoutManager: Required elements not found');
        }
    }

    init() {
        this.startTimers();
        this.bindEvents();
        this.bindActivityListeners();
        this.startHeartbeat();
    }

    startTimers() {
        this.clearTimers();

        // Set warning timer
        const warningDelay = this.lifetimeMs - this.warningTimeMs;
        if (warningDelay > 0) {
            this.warningTimer = setTimeout(() => this.showWarning(), warningDelay);
        }

        // Set logout timer
        this.logoutTimer = setTimeout(() => this.logout(), this.lifetimeMs);
    }

    clearTimers() {
        if (this.warningTimer) clearTimeout(this.warningTimer);
        if (this.logoutTimer) clearTimeout(this.logoutTimer);
        if (this.countdownInterval) clearInterval(this.countdownInterval);
        if (this.heartbeatInterval) clearInterval(this.heartbeatInterval);
    }

    showWarning() {
        this.modal.classList.add('modal-open');
        this.startCountdown();
    }

    hideWarning() {
        this.modal.classList.remove('modal-open');
        if (this.countdownInterval) clearInterval(this.countdownInterval);
    }

    startCountdown() {
        let secondsLeft = this.warningTimeMs / 1000;
        this.updateCountdownDisplay(secondsLeft);

        this.countdownInterval = setInterval(() => {
            secondsLeft--;
            this.updateCountdownDisplay(secondsLeft);

            if (secondsLeft <= 0) {
                clearInterval(this.countdownInterval);
                this.logout();
            }
        }, 1000);
    }

    updateCountdownDisplay(seconds) {
        if (this.countdownEl) {
            this.countdownEl.textContent = Math.max(0, Math.ceil(seconds));
        }
    }

    bindEvents() {
        // Extend session
        this.extendBtn.addEventListener('click', () => this.extendSession());

        // Logout now
        this.logoutBtn.addEventListener('click', () => this.logout());
    }

    bindActivityListeners() {
        const resetAndMaybeExtend = () => {
            this.startTimers(); // restart warning/logout countdowns

            // Throttle backend calls to at most once per activity cooldown
            const now = Date.now();
            if (now - this.lastExtendAt > this.activityExtendCooldownMs) {
                this.extendSession(true); // silent keep-alive
            }
        };

        ['click', 'keydown', 'mousemove', 'scroll', 'touchstart'].forEach(evt =>
            document.addEventListener(evt, resetAndMaybeExtend, { passive: true })
        );
    }

    startHeartbeat() {
        // Periodic keep-alive even without noticeable activity (e.g., watching dashboard)
        this.heartbeatInterval = setInterval(() => this.extendSession(true), this.heartbeatIntervalMs);
    }

    extendSession(silent = false) {
        // Optimistic UI update
        this.hideWarning();
        this.startTimers(); // Reset timers immediately
        this.lastExtendAt = Date.now();

        // Call backend to extend session
        fetch('/session/extend', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
            .then(response => {
                if (response.status === 401) {
                    // User is no longer authenticated - logout
                    console.warn('Session expired - user not authenticated');
                    this.logout();
                    return;
                }
                if (!response.ok) {
                    if (!silent) console.error('Failed to extend session:', response.status);
                }
            })
            .catch(error => {
                if (!silent) console.error('Error extending session:', error);
            });
    }

    logout() {
        this.clearTimers();

        // Use fetch to handle 419 errors gracefully
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ _token: csrfToken })
        })
            .then(response => {
                if (response.ok || response.status === 419 || response.status === 401) {
                    // Determine login URL (could be /login or /admin/login depending on context, defaulting to /login)
                    window.location.href = '/login';
                } else {
                    // Fallback for other errors
                    console.error('Logout failed with status:', response.status);
                    window.location.href = '/login';
                }
            })
            .catch(error => {
                console.error('Logout error:', error);
                // Network error or other issue - force redirect
                window.location.href = '/login';
            });
    }
}
