class SessionTimeoutManager {
    constructor(sessionLifetime) {
        this.sessionLifetime = sessionLifetime || 120000; // Default 120 minutes in milliseconds
        this.warningTime = 60000; // Show warning 60 seconds before timeout
        this.checkInterval = 30000; // Check every 30 seconds
        this.warningShown = false;
        this.countdownInterval = null;
        this.timeoutId = null;
        this.lastActivity = Date.now();
        
        this.init();
    }
    
    init() {
        // Track user activity
        this.trackActivity();
        
        // Start checking session
        this.startSessionCheck();
        
        // Setup modal buttons
        this.setupModalButtons();
    }
    
    trackActivity() {
        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
        
        events.forEach(event => {
            document.addEventListener(event, () => {
                this.lastActivity = Date.now();
                
                // If warning is shown and user is active, hide warning
                if (this.warningShown) {
                    this.hideWarning();
                }
            }, true);
        });
    }
    
    startSessionCheck() {
        setInterval(() => {
            const inactiveTime = Date.now() - this.lastActivity;
            const timeUntilTimeout = this.sessionLifetime - inactiveTime;
            
            // Show warning when approaching timeout
            if (timeUntilTimeout <= this.warningTime && timeUntilTimeout > 0 && !this.warningShown) {
                this.showWarning(timeUntilTimeout);
            }
            
            // Logout if session expired
            if (timeUntilTimeout <= 0) {
                this.logout();
            }
        }, this.checkInterval);
    }
    
    showWarning(timeUntilTimeout) {
        this.warningShown = true;
        const modal = document.getElementById('sessionTimeoutModal');
        
        // Show modal
        if (modal) {
            modal.showModal();
        }
        
        // Start countdown
        this.startCountdown(Math.floor(timeUntilTimeout / 1000));
    }
    
    hideWarning() {
        this.warningShown = false;
        const modal = document.getElementById('sessionTimeoutModal');
        
        // Hide modal
        if (modal) {
            modal.close();
        }
        
        // Clear countdown
        if (this.countdownInterval) {
            clearInterval(this.countdownInterval);
            this.countdownInterval = null;
        }
    }
    
    startCountdown(seconds) {
        const countdownElement = document.getElementById('countdown');
        
        this.countdownInterval = setInterval(() => {
            seconds--;
            
            if (countdownElement) {
                countdownElement.textContent = seconds;
                
                // Change color when time is running out
                if (seconds <= 10) {
                    countdownElement.classList.add('text-error');
                } else {
                    countdownElement.remove('text-error');
                }
            }
            
            if (seconds <= 0) {
                clearInterval(this.countdownInterval);
                this.logout();
            }
        }, 1000);
    }
    
    setupModalButtons() {
        const extendBtn = document.getElementById('extendSessionBtn');
        const logoutBtn = document.getElementById('logoutNowBtn');
        
        if (extendBtn) {
            extendBtn.addEventListener('click', () => {
                this.extendSession();
            });
        }
        
        if (logoutBtn) {
            logoutBtn.addEventListener('click', () => {
                this.logout();
            });
        }
    }
    
    async extendSession() {
        try {
            // Ping server to extend session
            const response = await fetch('/session/extend', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            });
            
            if (response.ok) {
                this.lastActivity = Date.now();
                this.hideWarning();
                
                // Show success notification
                if (typeof window.showNotification === 'function') {
                    window.showNotification('Session extended successfully', 'success', 3000);
                }
            } else {
                // If extend fails, logout
                this.logout();
            }
        } catch (error) {
            console.error('Failed to extend session:', error);
            this.logout();
        }
    }
    
    logout() {
        // Clear any running intervals
        if (this.countdownInterval) {
            clearInterval(this.countdownInterval);
        }
        
        // Redirect to logout
        window.location.href = '/logout';
    }
}
