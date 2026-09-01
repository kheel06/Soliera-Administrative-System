<header class="bg-base-100 shadow-sm z-40 border-b border-base-300 dark:border-gray-700" data-theme="light">
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <button onclick="toggleSidebar()" aria-label="Toggle sidebar" class="relative z-50 btn btn-ghost btn-sm hover:bg-base-300 transition-all hover:scale-105 pointer-events-auto cursor-pointer">
            <i data-lucide="menu" class="text-xl md:text-2xl lg:text-3xl transition-all duration-300 ease-in-out hover:text-accent"></i>
          </button>
        </div>
       <div class="flex items-center gap-4">
         <!-- Time Display -->
         <div class="flex items-center">
           <span id="philippineTime" class="font-medium text-sm text-gray-600 whitespace-nowrap">{{ now()->timezone('Asia/Manila')->format('D, M j, Y, h:i:s A') }}</span>
         </div>
         
          <!-- Notification Dropdown -->
           <div class="dropdown dropdown-end">
             <!-- Button -->
             <button id="notification-button" onclick="handleNotificationClick(this)" tabindex="0" class="btn btn-ghost btn-circle relative cursor-pointer w-12 h-12 md:w-14 md:h-14 transition-transform hover:scale-105">
                 <i data-lucide="bell" class="text-2xl md:text-3xl lg:text-[38px] transition-all duration-300 ease-in-out hover:text-accent"></i>
                 @php
                  $unreadCount = 0;
                  try {
                    $account = auth()->user();
                    if ($account) {
                      $unreadCount = \Illuminate\Support\Facades\DB::table('notifications')
                        ->where('notifiable_id', $account->Dept_no ?? $account->id)
                        ->where('notifiable_type', get_class($account))
                        ->whereNull('read_at')
                        ->count();
                    }
                  } catch (\Throwable $e) {
                    $unreadCount = 0;
                  }
                 @endphp
                 <span id="notificationBadge" 
                       class="absolute top-[8px] right-[8px] flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white border-2 border-white shadow-sm z-10" 
                       style="display: {{ $unreadCount > 0 ? 'flex' : 'none' }};">
                   {{ $unreadCount }}
                 </span>
             </button>
             
             <!-- Dropdown Content -->
             <ul tabindex="0" class="dropdown-content mt-3 z-[100] bg-[#001f54] rounded-2xl shadow-2xl border border-blue-700/50 overflow-hidden w-80 md:w-96 p-0">
               <!-- Header -->
               <li class="px-4 py-3 border-b border-blue-700/50 flex items-center justify-between bg-[#001f54]">
                 <div class="flex items-center gap-2">
                   <div class="p-1.5 rounded-lg bg-blue-600/20">
                     <i data-lucide="bell" class="w-4 h-4 text-white"></i>
                   </div>
                   <span class="font-bold text-white text-sm uppercase tracking-wider">Notifications</span>
                 </div>
                 <button class="text-blue-300 hover:text-white text-[10px] uppercase font-bold flex items-center gap-1.5 cursor-pointer transition-all hover:bg-white/5 px-2 py-1 rounded-md" id="clearAllNotificationsBtn">
                   <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                   <span>Clear All</span>
                 </button>
               </li>

               
               <!-- Items Container -->
               <div class="max-h-[300px] overflow-y-auto soliera-scrollbar" id="notificationsContainer">
                 @php
                  $notifications = collect();
                  try {
                    $account = auth()->user();
                    if ($account) {
                      $rawNotifications = \Illuminate\Support\Facades\DB::table('notifications')
                        ->where('notifiable_id', $account->Dept_no ?? $account->id)
                        ->where('notifiable_type', get_class($account))
                        ->whereNull('read_at')
                        ->latest()
                        ->take(10)
                        ->get();

                      $notifications = $rawNotifications->map(function ($n) {
                        $n->data = json_decode($n->data, true);
                        return $n;
                      });
                    }
                  } catch (\Throwable $e) {
                    $notifications = collect();
                  }
                 @endphp
                 
                 @if($notifications->count() > 0)
                   @foreach($notifications as $n)
                     @php
                      $d = $n->data;
                      $category = $d['category'] ?? $d['model_type'] ?? 'general';
                      $severity = $d['severity'] ?? 'low';
                      $categoriesArr = [
                        'visitor' => ['icon' => 'user-check', 'bg' => 'bg-emerald-600/30'],
                        'document' => ['icon' => 'file-text', 'bg' => 'bg-blue-600/30'],
                        'folder' => ['icon' => 'folder', 'bg' => 'bg-blue-500/30'],
                        'contract' => ['icon' => 'file-signature', 'bg' => 'bg-amber-600/30'],
                        'approval' => ['icon' => 'check-circle', 'bg' => 'bg-cyan-600/30'],
                        'permit' => ['icon' => 'shield-check', 'bg' => 'bg-indigo-600/30'],
                        'legal' => ['icon' => 'balance-scale', 'bg' => 'bg-purple-600/30'],
                        'risk' => ['icon' => 'alert-triangle', 'bg' => 'bg-rose-600/30'],
                        'facility' => ['icon' => 'building', 'bg' => 'bg-sky-600/30'],
                        'ai_analysis' => ['icon' => 'brain', 'bg' => 'bg-fuchsia-600/30'],
                        'template' => ['icon' => 'layout', 'bg' => 'bg-teal-600/30'],
                        'clause' => ['icon' => 'list', 'bg' => 'bg-orange-600/30'],
                        'integration' => ['icon' => 'refresh-cw', 'bg' => 'bg-slate-600/30'],
                        'system' => ['icon' => 'settings', 'bg' => 'bg-gray-600/30'],
                      ];
                      $config = $categoriesArr[$category] ?? ['icon' => 'bell', 'bg' => 'bg-blue-600/30'];
                     @endphp
                     <li class="px-4 py-3 hover:bg-blue-800/40 transition-all notification-item border-b border-blue-800/20" data-notification-id="{{ $n->id }}" data-category="{{ $category }}" data-severity="{{ $severity }}">
                       <a class="flex items-start gap-3.5 cursor-pointer" onclick="markAsRead('{{ $n->id }}', '{{ $d['url'] ?? '#' }}'); return false;">
                         <div class="p-2.5 rounded-full {{ $config['bg'] }} flex-shrink-0">
                           <i data-lucide="{{ $d['icon'] ?? $config['icon'] }}" class="text-base text-white"></i>
                         </div>
                         <div class="flex-1 min-w-0">
                           <div class="flex items-center gap-2 mb-0.5">
                                <p class="font-bold text-white text-xs truncate">{{ $d['title'] ?? 'Update' }}</p>
                                @if($severity === 'high') <span class="px-1.5 py-0.5 bg-red-600 text-[8px] rounded-full uppercase font-bold text-white ml-auto">Urgent</span> @endif
                                @if($severity === 'critical') <span class="px-1.5 py-0.5 bg-red-800 text-[8px] rounded-full uppercase font-bold text-white ml-auto animate-pulse">Critical</span> @endif
                           </div>
                           <p class="text-[11px] text-blue-100/90 leading-relaxed">{{ $d['message'] ?? '' }}</p>
                           <div class="flex items-center justify-between mt-1.5">
                              <p class="text-[9px] text-blue-400 font-medium flex items-center gap-1">
                                <i data-lucide="clock" class="w-2.5 h-2.5"></i>
                                {{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}
                              </p>
                              <p class="text-[8px] text-blue-500 uppercase tracking-tighter opacity-60">{{ $category }}</p>
                           </div>
                         </div>
                       </a>
                     </li>
                   @endforeach
                 @else
                   <li class="px-4 py-12 text-center empty-notifications">
                     <div class="flex flex-col items-center gap-3">
                       <div class="p-4 rounded-full bg-blue-600/10 border border-blue-600/20">
                         <i data-lucide="bell-off" class="text-4xl text-blue-500/50"></i>
                       </div>
                       <p class="text-white font-bold text-sm">Quiet Day</p>
                       <p class="text-[11px] text-blue-300/70">No new notifications to show.</p>
                     </div>
                   </li>
                 @endif
               </div>
               
               <!-- Footer -->
               <li class="px-4 py-3 border-t border-blue-700/50 bg-[#001f54]">
                 <a href="{{ route('notifications.index') }}" class="w-full py-2 bg-blue-600/20 hover:bg-blue-600/40 rounded-xl text-center text-white font-bold text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 transition-all group border border-blue-600/30">
                   <i data-lucide="layout-grid" class="w-3.5 h-3.5 group-hover:rotate-90 transition-transform"></i>
                   <span>View All Notifications</span>
                 </a>
               </li>
             </ul>
           </div>
          <!-- User Dropdown -->
          @php
            // Resolve current employee_id with fallbacks
            $navEmpId = session('emp_id');
            $navDisplayName = 'User';
            $navDisplayRole = 'User';
            $navProfilePicture = null;
            $navProfilePictureVersion = null;

            // Try to get from auth user if available
            try {
              $authUser = auth()->user();
              if ($authUser) {
                if (empty($navEmpId)) {
                  $navEmpId = $authUser->employee_id ?? null;
                }
                if (empty($navEmpId) && $authUser->email) {
                  if (strpos($authUser->email, '@') !== false) {
                    $navEmpId = substr($authUser->email, 0, strpos($authUser->email, '@'));
                  }
                }
                $navDisplayName = $authUser->name ?? 'User';
                $navDisplayRole = $authUser->role ?? 'User';
                $navProfilePicture = $authUser->profile_picture ?? null;
              }
            } catch (\Throwable $e) {
              // Silently ignore if users table doesn't exist
            }

            // Always prefer department_accounts data if we have an employee_id
            if (!empty($navEmpId)) {
              try {
                $navDeptUser = \Illuminate\Support\Facades\DB::table('department_accounts')->where('employee_id', $navEmpId)->first();
                if ($navDeptUser) {
                  $navDisplayName = $navDeptUser->employee_name ?: $navDisplayName;
                  $navDisplayRole = $navDeptUser->role ?: $navDisplayRole;
                  $navProfilePicture = $navDeptUser->profile_picture ?: $navProfilePicture;

                  // Generate cache-busting version from profile_picture path (contains timestamp)
                  if ($navProfilePicture) {
                    // Extract timestamp from filename if available (format: profile_EMPLOYEEID_TIMESTAMP.ext)
                    if (preg_match('/_(\d+)\./', $navProfilePicture, $matches)) {
                      $navProfilePictureVersion = $matches[1];
                    } else {
                      // Fallback to file modification time if file exists
                      $filePath = storage_path('app/public/' . $navProfilePicture);
                      if (file_exists($filePath)) {
                        $navProfilePictureVersion = filemtime($filePath);
                      } else {
                        $navProfilePictureVersion = time();
                      }
                    }
                  }
                }
              } catch (\Throwable $e) { /* silent fallback */
              }
            }
          @endphp
          <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle avatar cursor-pointer hover:ring-2 hover:ring-[#F7B32B] transition-all">
              <div class="w-10 rounded-full overflow-hidden ring-2 ring-offset-2 ring-offset-base-100 ring-[#001f54]">
                @if($navProfilePicture)
                  <img src="{{ asset('storage/' . $navProfilePicture) }}@if($navProfilePictureVersion)?v={{ $navProfilePictureVersion }}@endif" alt="User Avatar" class="w-full h-full object-cover" id="navbar-avatar-img" />
                @else
                  <div class="w-full h-full bg-gradient-to-br from-[#F7B32B] to-[#e09800] flex items-center justify-center" id="navbar-avatar-fallback">
                    <span class="text-sm font-bold text-white">{{ strtoupper(substr($navDisplayName ?? 'U', 0, 1)) }}</span>
                  </div>
                @endif
              </div>
            </label>
            <ul tabindex="0" class="dropdown-content menu mt-3 z-[100] w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden p-0">
              <!-- User Profile Section -->
              <li class="menu-title !p-0 !m-0 !bg-transparent" style="padding: 0 !important; margin: 0 !important; background: transparent !important;">
                <div class="flex items-center gap-3 p-4 w-full cursor-default rounded-t-lg" style="background: linear-gradient(135deg, #001f54 0%, #003087 100%) !important; color: white !important;">
                  <div class="avatar">
                    <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-white/30">
                      @if($navProfilePicture)
                        <img src="{{ asset('storage/' . $navProfilePicture) }}@if($navProfilePictureVersion)?v={{ $navProfilePictureVersion }}@endif" alt="User Avatar" class="w-full h-full object-cover" id="navbar-dropdown-avatar-img" />
                      @else
                        <div class="w-full h-full bg-gradient-to-br from-[#F7B32B] to-[#e09800] flex items-center justify-center" id="navbar-dropdown-avatar-fallback">
                          <span class="text-xl font-bold text-white">{{ strtoupper(substr($navDisplayName ?? 'U', 0, 1)) }}</span>
                        </div>
                      @endif
                    </div>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="font-semibold text-white truncate text-base" style="color: white !important;">{{ $navDisplayName ?? 'User' }}</p>
                    <p class="text-xs text-blue-200 font-medium" style="color: #bfdbfe !important;">{{ ucfirst($navDisplayRole ?? 'User') }}</p>
                  </div>
                </div>
              </li>
              
              <!-- Menu Items -->
              <div class="p-2">
                <li>
                  <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-gray-50 rounded-lg transition-all cursor-pointer group">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                      <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <div>
                      <span class="font-medium">My Profile</span>
                      <p class="text-xs text-gray-400">View your profile</p>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-gray-50 rounded-lg transition-all cursor-pointer group">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                      <i data-lucide="settings" class="w-5 h-5 text-gray-600"></i>
                    </div>
                    <div>
                      <span class="font-medium">Settings</span>
                      <p class="text-xs text-gray-400">Manage preferences</p>
                    </div>
                  </a>
                </li>
              </div>
              
              <!-- Sign Out -->
              <div class="border-t border-gray-100 p-2">
                <li>
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg transition-all cursor-pointer group">
                    <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                      <i data-lucide="log-out" class="w-5 h-5 text-red-500"></i>
                    </div>
                    <div>
                      <span class="font-medium">Sign Out</span>
                      <p class="text-xs text-red-400">Log out of your account</p>
                    </div>
                  </a>
                </li>
              </div>
            </ul>
            <!-- Hidden logout form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
              @csrf
            </form>
          </div>
        </div>
      </div>
    </div>
</header>

@include('partials.session-timeout-assets')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Philippine Time Display
    function updatePhilippineTime() {
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
        hours = hours ? hours : 12; // 0 becomes 12
        const hoursStr = hours.toString().padStart(2, '0');
        const minutes = manilaTime.getMinutes().toString().padStart(2, '0');
        const seconds = manilaTime.getSeconds().toString().padStart(2, '0');
        
        const formattedTime = `${dayName}, ${month} ${day}, ${year}, ${hoursStr}:${minutes}:${seconds} ${ampm}`;
        
        const timeElement = document.getElementById('philippineTime');
        if (timeElement) {
            timeElement.textContent = formattedTime;
        }
    }
    
    // Update time immediately and then every second
    updatePhilippineTime();
    setInterval(updatePhilippineTime, 1000);

    const clearAllBtn = document.getElementById('clearAllNotificationsBtn');
    const notificationButton = document.getElementById('notification-button');
    
    // Function to show notification messages
    const showLocalNotification = (message, type = 'info') => {
        if (window.showNotification) {
            window.showNotification(message, type);
        } else {
            console.log(`[Notification ${type}]: ${message}`);
        }
    };

    // Robust Handler for Bell Click
    window.handleNotificationClick = function() {
        // 1. Instant UI update
        const badge = document.getElementById('notificationBadge');
        if (badge) {
            badge.style.display = 'none';
            badge.textContent = '0';
            badge.classList.add('hidden');
        }

        // 2. Persist state globally (across tabs) as fallback
        localStorage.setItem('notifications_last_clear_all', Date.now());

        // 3. Mark as read in DB
        fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Notifications marked as read');
            // 4. Update other tabs via custom event if they are on same origin
            window.dispatchEvent(new CustomEvent('notifications:cleared_all'));
            
            // 5. Refresh the list to show them as "read" (less opaque)
            refreshNotificationDropdown();
        })
        .catch(err => console.error('Failed to mark notifications read:', err));
    };

    // Attach listener to bell button
    if (notificationButton) {
        notificationButton.addEventListener('click', handleNotificationClick);
        // Also handle focus for keyboard navigation/DaisyUI dropdown opening
        notificationButton.addEventListener('focus', function() {
            if (parseInt(document.getElementById('notificationBadge')?.textContent || '0') > 0) {
                handleNotificationClick();
            }
        });
    }

    // Clear All Notifications button functionality
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (confirm('Are you sure you want to clear all notifications permanently?')) {
                fetch('/api/notifications/clear-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const container = document.getElementById('notificationsContainer');
                        if (container) container.innerHTML = '';
                        window.refreshNotificationDropdown();
                        showLocalNotification('All notifications cleared successfully!', 'success');
                    }
                })
                .catch(err => console.error('Error clearing:', err));
            }
        });
    }

    // Individual Mark as Read
    window.markAsRead = async function(id, url) {
        try {
            await fetch(`/notifications/${id}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            
            if (url && url !== '#') {
                window.location.href = url;
            } else {
                refreshNotificationDropdown();
            }
        } catch (e) {
            console.error('Error:', e);
            if (url && url !== '#') window.location.href = url;
        }
    };

    // Refresh UI Logic
    window.refreshNotificationDropdown = async function() {
        const container = document.getElementById('notificationsContainer');
        const badge = document.getElementById('notificationBadge');
        if (!container) return;

        try {
            const response = await fetch('/api/notifications/list?status=all&limit=10');
            const data = await response.json();
            if (!data || !data.success) return;

            // Real-time check: If cleared recently in another tab (via localStorage), override count
            const lastCleared = localStorage.getItem('notifications_last_clear_all');
            const recentlyCleared = lastCleared && (Date.now() - parseInt(lastCleared) < 10000);
            
            const currentUnread = recentlyCleared ? 0 : (data.unread_count ?? data.count ?? 0);
            
            if (badge) {
                badge.textContent = currentUnread;
                badge.style.display = currentUnread > 0 ? 'flex' : 'none';
                if (currentUnread > 0) badge.classList.remove('hidden'); else badge.classList.add('hidden');
            }

            container.innerHTML = '';
            if (!data.notifications || data.notifications.length === 0) {
                container.innerHTML = `
                    <li class="px-4 py-12 text-center empty-notifications">
                      <div class="flex flex-col items-center gap-3">
                        <div class="p-4 rounded-full bg-blue-600/10">
                          <i data-lucide="bell-off" class="text-4xl text-blue-500/50"></i>
                        </div>
                        <p class="text-white font-bold text-sm">Quiet Day</p>
                        <p class="text-[11px] text-blue-300/70">No new notifications to show.</p>
                      </div>
                    </li>
                `;
            } else {
                data.notifications.forEach(n => {
                    const li = document.createElement('li');
                    li.className = `px-4 py-3 hover:bg-blue-800/40 transition-all notification-item border-b border-blue-800/20 ${n.read_at ? 'opacity-60' : ''}`;
                    const d = n.data || {};
                    const category = d.category || d.model_type || 'general';
                    const severity = d.severity || 'low';
                    
                    li.innerHTML = `
                       <a class="flex items-start gap-3.5 cursor-pointer" onclick="markAsRead('${n.id}', '${d.url || '#'}'); return false;">
                         <div class="p-2.5 rounded-full bg-blue-600/30 flex-shrink-0">
                           <i data-lucide="${d.icon || 'bell'}" class="text-base text-white"></i>
                         </div>
                         <div class="flex-1 min-w-0">
                           <div class="flex items-center gap-2 mb-0.5">
                                <p class="font-bold text-white text-xs truncate">${d.title || 'Update'}</p>
                                ${severity === 'high' ? '<span class="px-1.5 py-0.5 bg-red-600 text-[8px] rounded-full uppercase font-bold text-white ml-auto">Urgent</span>' : ''}
                           </div>
                           <p class="text-[11px] text-blue-100/90 leading-relaxed">${d.message || ''}</p>
                         </div>
                       </a>
                    `;
                    container.appendChild(li);
                });
            }
            if (window.lucide) window.lucide.createIcons();
        } catch (e) {
            console.error('Refresh failed:', e);
        }
    };

    // Cross-tab Synchronization fallback
    window.addEventListener('storage', (e) => {
        if (e.key === 'notifications_last_clear_all') {
            refreshNotificationDropdown();
        }
    });
    
    window.addEventListener('notifications:cleared_all', refreshNotificationDropdown);

    // Initial time update
    updatePhilippineTime();
    setInterval(updatePhilippineTime, 1000);

    // Poll for new notifications if websocket is not available
    let lastNotifCount = {{ $unreadCount ?? 0 }};
    setInterval(async () => {
        if (window.notificationClient && window.notificationClient.echo) return; 
        
        try {
            const res = await fetch('/api/notifications/count');
            const data = await res.json();
            
            // Respect recent clear actions (within 5 seconds)
            const recentlyCleared = window.lastBadgeClearTime && (Date.now() - window.lastBadgeClearTime < 5000);
            
            if (recentlyCleared) return;

            if (data.count !== lastNotifCount) {
                lastNotifCount = data.count;
                const badge = document.getElementById('notificationBadge');
                if (badge) {
                    badge.textContent = data.count;
                    badge.style.display = data.count > 0 ? 'flex' : 'none';
                    if (data.count > 0) badge.classList.remove('hidden');
                    else badge.classList.add('hidden');
                }
            }
        } catch (e) {}
    }, 15000);
});
</script>
