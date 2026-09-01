@auth
    @php
        $systemSettings = \Illuminate\Support\Facades\Cache::remember('system_settings', 60*24, function() {
            return \App\Models\SystemSetting::pluck('value', 'key');
        });
        
        // Check if session timeout is enabled (default to true to match system defaults)
        $isTimeoutEnabled = ($systemSettings['security.session_timeout_enabled'] ?? 'true') === 'true';
        
        // Get timeout duration (default to config or 120 minutes)
        $timeoutMinutes = (int)($systemSettings['security.session_timeout_minutes'] ?? config('session.lifetime', 120));
    @endphp

    @if($isTimeoutEnabled)
        @include('partials.session-timeout-modal')

        <script src="{{ asset('js/session-timeout.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof SessionTimeoutManager === 'function') {
                    window.sessionTimeoutManager = new SessionTimeoutManager({{ $timeoutMinutes }} * 60 * 1000);
                }
            });
        </script>
    @endif
@endauth
