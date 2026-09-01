<!-- Session Timeout Modal -->
<div id="sessionTimeoutModal" class="modal modal-bottom sm:modal-middle" role="dialog">
    <div class="modal-box">
        <div class="text-center">
            <div class="mb-4">
                <i class="fas fa-exclamation-triangle text-warning text-6xl"></i>
            </div>
            <h3 class="font-bold text-lg mb-2">Session Warning</h3>
            <p class="text-base-content/70 mb-4">
                Your session will expire in <span id="countdown" class="font-bold text-primary">60</span> seconds due to inactivity.
            </p>
            <p class="text-sm text-base-content/50 mb-6">
                Click "Stay Logged In" to extend your session, or you will be automatically logged out.
            </p>
        </div>
        
        <div class="modal-action justify-center">
            <button id="extendSessionBtn" class="btn btn-primary">
                <i class="fas fa-clock mr-2"></i>
                Stay Logged In
            </button>
            <button id="logoutNowBtn" class="btn btn-ghost">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Logout Now
            </button>
        </div>
    </div>
</div>
