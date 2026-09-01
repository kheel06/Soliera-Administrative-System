<script>
  // Initialize lucide icons
  lucide.createIcons();
  
  // Check if mobile view
  function isMobileView() {
    return window.innerWidth < 1024; // Tailwind's lg breakpoint
  }

  // Toggle sidebar function - exposed globally for onclick handlers
  window.toggleSidebar = function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const sidebarLogo = document.getElementById('sidebar-logo');
    const sonlyLogo = document.getElementById('sonly');
    if (!sidebar) { return; }
    
    if (isMobileView()) {
      // Mobile/Tablet behavior - toggle visibility
      if (sidebar.classList.contains('translate-x-0')) {
        // Closing sidebar on mobile
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');
        if (overlay) overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      } else {
        // Opening sidebar on mobile
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        if (overlay) overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
      }
    } else {
      // Desktop behavior - toggle between expanded and collapsed
      const currentlyCollapsed = sidebar.classList.contains('collapsed') || sidebar.classList.contains('w-20') || sidebar.classList.contains('w-16');
      const nextCollapsed = !currentlyCollapsed;
      
      // Remove all width and collapsed classes
      sidebar.classList.remove('w-64', 'w-20', 'w-16', 'collapsed');
      
      if (nextCollapsed) {
        // Collapsed state - show only icons
        sidebar.classList.add('collapsed');
        sidebar.style.width = '4.5rem';
        localStorage.setItem('sidebarCollapsed', 'true');
        
        // Toggle logos
        if (sidebarLogo) sidebarLogo.classList.add('hidden');
        if (sonlyLogo) sonlyLogo.classList.remove('hidden');
        
        // Close all dropdowns when collapsing
        document.querySelectorAll('#sidebar .sidebar-dropdown input[type="checkbox"]').forEach(cb => {
          cb.checked = false;
        });
      } else {
        // Expanded state
        sidebar.classList.add('w-60');
        sidebar.style.width = '';
        localStorage.setItem('sidebarCollapsed', 'false');
        
        // Toggle logos
        if (sidebarLogo) sidebarLogo.classList.remove('hidden');
        if (sonlyLogo) sonlyLogo.classList.add('hidden');
      }
    }
    
    // Update dropdown indicators
    updateDropdownIndicators();
  }

  // Update dropdown indicators
  function updateDropdownIndicators() {
    const sidebar = document.getElementById('sidebar');
    const isCollapsed = (sidebar.classList.contains('collapsed') || sidebar.classList.contains('w-20') || sidebar.classList.contains('w-16')) && !isMobileView();
    const dropdownIcons = document.querySelectorAll('.dropdown-icon');
    
    dropdownIcons.forEach(icon => {
      if (isCollapsed) {
        const isOpen = icon.closest('.collapse').querySelector('input[type="checkbox"]').checked;
        icon.setAttribute('data-lucide', isOpen ? 'minus' : 'plus');
      } else {
        const isOpen = icon.closest('.collapse').querySelector('input[type="checkbox"]').checked;
        icon.setAttribute('data-lucide', isOpen ? 'chevron-down' : 'chevron-right');
      }
    });
    
    // Recreate all icons after updating attributes
    lucide.createIcons();
  }

  // Handle window resize
  function handleResize() {
    const sidebar = document.getElementById('sidebar');
    const sidebarLogo = document.getElementById('sidebar-logo');
    const sonlyLogo = document.getElementById('sonly');
    if (!sidebar) { return; }
    
    if (isMobileView()) {
      // On mobile, ensure proper transform classes and show full logo
      if (!sidebar.classList.contains('translate-x-0')) {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
      }
      sidebarLogo.classList.remove('hidden');
      sonlyLogo.classList.add('hidden');
          } else {
        // On desktop, apply the saved collapsed state
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        sidebar.classList.remove('-translate-x-full', 'translate-x-0', 'w-64', 'w-20', 'w-16', 'collapsed');
        
        if (isCollapsed) {
          sidebar.classList.add('collapsed');
          sidebar.style.width = '4.5rem';
          if (sidebarLogo) sidebarLogo.classList.add('hidden');
          if (sonlyLogo) sonlyLogo.classList.remove('hidden');
        } else {
          sidebar.classList.add('w-60');
          sidebar.style.width = '';
          if (sidebarLogo) sidebarLogo.classList.remove('hidden');
          if (sonlyLogo) sonlyLogo.classList.add('hidden');
        }
      }
    
    updateDropdownIndicators();
  }

  // Initialize sidebar
  function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarLogo = document.getElementById('sidebar-logo');
    const sonlyLogo = document.getElementById('sonly');
    if (!sidebar) { return; }

    if (isMobileView()) {
      // Start hidden on mobile with full logo
      sidebar.classList.remove('w-20', 'w-16', 'collapsed', 'translate-x-0');
      sidebar.classList.add('-translate-x-full', 'w-60');
      if (sidebarLogo) sidebarLogo.classList.remove('hidden');
      if (sonlyLogo) sonlyLogo.classList.add('hidden');
    } else {
      // Start with saved state on desktop
      const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      
      // Remove translate classes and all width/collapsed classes for desktop
      sidebar.classList.remove('-translate-x-full', 'translate-x-0', 'w-64', 'w-20', 'w-16', 'collapsed');
      
      // Set collapsed or expanded state
      if (isCollapsed) {
        sidebar.classList.add('collapsed');
        sidebar.style.width = '4.5rem';
        if (sidebarLogo) sidebarLogo.classList.add('hidden');
        if (sonlyLogo) sonlyLogo.classList.remove('hidden');
      } else {
        sidebar.classList.add('w-60');
        sidebar.style.width = '';
        if (sidebarLogo) sidebarLogo.classList.remove('hidden');
        if (sonlyLogo) sonlyLogo.classList.add('hidden');
      }

      // Toggle logos based on collapsed state
      if (isCollapsed) {
        if (sidebarLogo) sidebarLogo.classList.add('hidden');
        if (sonlyLogo) sonlyLogo.classList.remove('hidden');
      } else {
        if (sidebarLogo) sidebarLogo.classList.remove('hidden');
        if (sonlyLogo) sonlyLogo.classList.add('hidden');
      }
      
      // Close all dropdowns if collapsed
      if (isCollapsed) {
        document.querySelectorAll('#sidebar .collapse input[type="checkbox"]').forEach(cb => {
          cb.checked = false;
        });
      }
    }
    
    setTimeout(() => {
      sidebar.classList.add('loaded');
    }, 50);
    
    // Set up event listeners
    document.querySelectorAll('.collapse input[type="checkbox"]').forEach(checkbox => {
      checkbox.addEventListener('change', updateDropdownIndicators);
    });
    
    window.addEventListener('resize', handleResize);
    updateDropdownIndicators();
  }

 function displayPhilippineTime() {
  // Create a date object for Philippine time (UTC+8)
  const now = new Date();
  const options = { timeZone: 'Asia/Manila' };
  
  // Get individual components
  const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  
  // Convert to Manila time
  const manilaTime = new Date(now.toLocaleString('en-US', options));
  
  const dayName = days[manilaTime.getDay()];
  const month = months[manilaTime.getMonth()];
  const day = manilaTime.getDate();
  const year = manilaTime.getFullYear();
  
  let hours = manilaTime.getHours();
  const ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12;
  const hoursStr = hours.toString().padStart(2, '0');
  const minutes = manilaTime.getMinutes().toString().padStart(2, '0');
  const seconds = manilaTime.getSeconds().toString().padStart(2, '0');
  
  const formattedTime = `${dayName}, ${month} ${day}, ${year}, ${hoursStr}:${minutes}:${seconds} ${ampm}`;
  
  // Update the element with the current time
  const timeElement = document.getElementById('philippineTime');
  if (timeElement) {
    timeElement.textContent = formattedTime;
  }
}

// Initial call to display the time
displayPhilippineTime();

// Update the time every second
setInterval(displayPhilippineTime, 1000);

// Add event listener to ensure the function runs after DOM is loaded
 // Initialize when DOM loads
 document.addEventListener('DOMContentLoaded', initSidebar);

 // Global Notification Function with Soliera Design Theme
 // This function is available across all pages that include soliera_js
 if (typeof window.showNotification === 'undefined') {
   // Create toast container if it doesn't exist
   function getToastContainer() {
     let container = document.getElementById('soliera-toast-container');
     if (!container) {
       container = document.createElement('div');
       container.id = 'soliera-toast-container';
       container.className = 'soliera-toast-container';
       // Ensure it's appended to body and positioned correctly
       document.body.appendChild(container);
       // Force positioning to ensure it's in the viewport (bottom-right, not behind sidebar)
       container.style.cssText = 'position: fixed !important; bottom: 1rem !important; right: 1rem !important; z-index: 10000 !important; left: auto !important; top: auto !important;';
     }
     return container;
   }
   
   window.showNotification = function(message, type = 'info', duration = 3000) {
     // Remove duplicate question marks - keep only one
     message = message.replace(/\?+/g, '?');
     
     // Parse message - if it contains a colon, treat first part as title
     let title = '';
     let body = message;
     if (message.includes(':') && message.split(':').length > 1) {
       const parts = message.split(':');
       title = parts[0].trim();
       body = parts.slice(1).join(':').trim();
     }
     
     // If no title, use type as title
     if (!title) {
       const titleMap = {
         'success': 'Success',
         'error': 'Error',
         'warning': 'Warning',
         'info': 'Information'
       };
       title = titleMap[type] || 'Notification';
     }
     
     // Ensure title and body also have only one question mark each
     title = title.replace(/\?+/g, '?');
     body = body.replace(/\?+/g, '?');
     
     // Set icon based on type
     const iconMap = {
       'success': 'check-circle',
       'error': 'alert-circle',
       'warning': 'alert-triangle',
       'info': 'info'
     };
     const icon = iconMap[type] || 'info';
     
     // Get toast container
     const container = getToastContainer();
     
     // Create notification element with Soliera theme
     const notification = document.createElement('div');
     notification.className = 'soliera-toast';
     notification.setAttribute('role', 'alert');
     notification.setAttribute('aria-live', 'polite');
     
     // Build HTML structure
     notification.innerHTML = `
       <div class="soliera-toast-content">
         <div class="soliera-toast-icon">
           <i data-lucide="${icon}"></i>
         </div>
         <div class="soliera-toast-text">
           <div class="soliera-toast-title">${title}</div>
           <div class="soliera-toast-body">${body}</div>
         </div>
         <button class="soliera-toast-close" aria-label="Close notification" type="button">
           <i data-lucide="x"></i>
         </button>
       </div>
       <div class="soliera-toast-progress">
         <div class="soliera-toast-progress-bar" style="animation: progressBar ${duration}ms linear forwards;"></div>
       </div>
     `;
     
     // Add close button functionality
     const closeBtn = notification.querySelector('.soliera-toast-close');
     const closeNotification = () => {
       notification.style.opacity = '0';
       notification.style.transform = 'translateX(100%)';
       notification.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
       setTimeout(() => {
         if (notification.parentNode) {
           notification.remove();
         }
       }, 300);
     };
     
     closeBtn.addEventListener('click', closeNotification);
     
     // Append to container (flexbox will handle stacking automatically)
     container.appendChild(notification);
     
     // Force reflow to ensure animation starts
     notification.offsetHeight;
     
     // Initialize Lucide icons
     if (window.lucide && window.lucide.createIcons) {
       window.lucide.createIcons();
     }
     
     // Auto remove after duration
     setTimeout(() => {
       if (notification.parentNode) {
         closeNotification();
       }
     }, duration);
   };
 }
</script>

{{-- Legal Consent Modal Component (hidden across Legal Management pages) --}}
@if (!request()->is('legal*'))
  <x-legal-consent :open="false" />
@endif