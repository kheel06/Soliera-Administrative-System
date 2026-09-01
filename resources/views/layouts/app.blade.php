<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="user-id" content="{{ auth()->id() ?? auth()->user()->Dept_no ?? '' }}">
    @endauth

    <title>@yield('title', 'Dashboard') | Soliera</title>

    @include('partials.favicon')

    <!-- DaisyUI and Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Scripts -->
    <link href="{{ asset('css/custom-sidebar.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/soliera.css', 'resources/css/sidebar-collapse.css', 'resources/css/icon-standardization.css', 'resources/js/app.js'])

    <!-- Pusher/Echo for WebSocket (if configured) -->
    @if(config('broadcasting.default') === 'pusher')
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.min.js"></script>
    @endif

    <!-- Broadcast Configuration -->
    <script>
        window.broadcastConfig = {
            driver: '{{ config("broadcasting.default", "null") }}',
            @if(config('broadcasting.default') === 'pusher')
                key: '{{ config("broadcasting.connections.pusher.key") }}',
                cluster: '{{ config("broadcasting.connections.pusher.options.cluster", "mt1") }}',
                encrypted: {{ config("broadcasting.connections.pusher.options.encrypted", true) ? 'true' : 'false' }},
            @endif
        };
    </script>

    <!-- Notification WebSocket Client -->
    @vite('resources/js/notification-websocket.js')
</head>

<body class="bg-base-200 h-screen overflow-hidden">
    @include('partials.page-loader')

    <div class="flex w-full h-screen">
        <!-- Sidebar -->
        @include('partials.sidebarr')
        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Header -->
            @include('partials.navbar')
            <!-- Page Content -->
            <main class="flex-1 px-4 md:px-6 pt-4 pb-4 overflow-y-auto">
                @if(session('success') && !session('login_success'))
                    <div class="alert alert-success mb-4">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error mb-4">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Modals Section (for proper z-index layering) -->
    @yield('modals')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Show login success toast notification -->
    @if(session('login_success'))
        <script>
            (function () {
                function showLoginNotification() {
                    if (typeof window.showNotification === 'function') {
                        window.showNotification('{{ session('login_success') }}', 'success', 5000);
                    } else {
                        // Wait for the function to be available (from soliera_js)
                        setTimeout(showLoginNotification, 100);
                    }
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', function () {
                        setTimeout(showLoginNotification, 300);
                    });
                } else {
                    setTimeout(showLoginNotification, 300);
                }
            })();
        </script>
    @endif

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>

    @stack('scripts')
</body>

</html>