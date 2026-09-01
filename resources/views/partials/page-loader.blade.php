<!-- Page Loading Spinner -->
<div id="page-loader" class="page-loader">
    <div class="page-loader-spinner"></div>
</div>

<!-- Show loader immediately on page load/refresh (before main JS loads) -->
<script>
    (function() {
        if (window.__pageLoaderInitialized) {
            return;
        }
        window.__pageLoaderInitialized = true;

        const loader = document.getElementById('page-loader');
        const hideLoader = function() {
            document.querySelectorAll('.page-loader').forEach(function(el) {
                el.classList.remove('active');
            });
        };

        const showLoader = function() {
            document.querySelectorAll('.page-loader').forEach(function(el) {
                el.classList.add('active');
            });
        };

        if (loader) {
            // Always show loader on initial page load/refresh
            showLoader();
            
            // Detect if this is a page refresh/reload
            try {
                const navigationType = performance.getEntriesByType('navigation')[0];
                const isReload = navigationType && (
                    navigationType.type === 'reload' || 
                    navigationType.type === 'navigate'
                );
                
                // Show loader immediately for all page loads
                if (isReload || document.readyState === 'loading' || document.readyState === 'interactive') {
                    showLoader();
                }
            } catch (e) {
                // Performance API not available, loader already shown above
            }
        }

        window.addEventListener('load', hideLoader);

        window.addEventListener('pageshow', function() {
            hideLoader();
        });

        window.addEventListener('focus', hideLoader);

        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                hideLoader();
            }
        });
        
        // Show loader when page is being hidden (navigating away or refreshing)
        window.addEventListener('pagehide', function() {
            showLoader();
        });
        
        // Show loader on beforeunload (refresh, close tab, etc.)
        window.addEventListener('beforeunload', function() {
            showLoader();
        });
    })();
</script>
