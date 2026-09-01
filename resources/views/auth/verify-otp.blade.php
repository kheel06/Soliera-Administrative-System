<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify OTP - Soliera Hotel</title>
    
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    @vite('resources/css/app.css')
</head>
<body>
   <section class="relative w-full h-screen">

  <!-- Background image with overlay -->
  <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ asset('images/defaults/hotel3.jpg') }}');"></div>
    <div class="absolute inset-0 bg-black/40 z-10"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/70 z-10"></div>
  
  <!-- Content container -->
<div class="relative z-10 w-full h-full flex items-center justify-center p-4">
  <!-- Left Side - Background Logo and Welcome -->
  <div class="absolute left-8 top-8 max-md:hidden">
    <div class="text-center">
      <a href="/">
        <img data-aos="zoom-in" data-aos-delay="100" class="w-32 mb-4 hover:scale-105 transition-all" src="{{asset('images/logo/logofinal.png')}}" alt="">
      </a>
    </div>
  </div>
  
  <!-- Centered OTP Form -->
  <div class="w-full max-w-md mx-auto px-4">
      <div class="bg-gradient-to-br from-amber-900/20 to-amber-800/30 backdrop-blur-lg p-8 rounded-2xl shadow-2xl border border-amber-700/30">
    <!-- Card Header -->
    <div class="mb-8 text-center flex justify-center items-center flex-col">
      <div class="w-16 h-16 bg-amber-950 flex items-center justify-center mb-6 shadow-lg rounded-full">
        <i class="bx bx-lock text-2xl text-yellow-400"></i>
      </div>
      <h2 class="text-3xl font-bold text-white mb-2 drop-shadow-lg">Soliera OTP Verification</h2>
      <p class="text-white text-sm drop-shadow-md">
        Enter the 6-digit code sent to your device
      </p>
      
      <!-- Success Message -->
      @if(session('success'))
        <div class="mt-4 p-3 bg-green-500/20 border border-green-500/30 rounded-lg">
          <p class="text-green-400 text-sm">{{ session('success') }}</p>
        </div>
      @endif
      
      <!-- Error Message -->
      @if(session('error'))
        <div class="mt-4 p-3 bg-red-500/20 border border-red-500/30 rounded-lg">
          <p class="text-red-400 text-sm">{{ session('error') }}</p>
        </div>
      @endif
      
      <!-- Validation Errors -->
      @if($errors->any())
        <div class="mt-4 p-3 bg-red-500/20 border border-red-500/30 rounded-lg">
          @foreach($errors->all() as $error)
            <p class="text-red-400 text-sm">{{ $error }}</p>
          @endforeach
        </div>
      @endif
    </div>
    
    <!-- Card Body -->
    <div>
      <form action="{{ route('otp.verify.submit') }}" method="POST" id="otpForm">
        @csrf
        <input type="hidden" name="employee_id" value="{{ session('otp_employee_id') }}">
        <!-- Debug info -->
        <input type="hidden" name="debug_info" value="form_submitted">
        
        <!-- OTP Input -->
        <div class="mb-6">
          <div class="flex justify-center space-x-3 mb-4">
            <input type="text" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 text-white" maxlength="1" pattern="[0-9]">
            <input type="text" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 text-white" maxlength="1" pattern="[0-9]">
            <input type="text" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 text-white" maxlength="1" pattern="[0-9]">
            <input type="text" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 text-white" maxlength="1" pattern="[0-9]">
            <input type="text" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 text-white" maxlength="1" pattern="[0-9]">
            <input type="text" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 text-white" maxlength="1" pattern="[0-9]">
          </div>
          <input type="hidden" id="otp_code" name="otp_code" value="{{ old('otp_code') }}">
          @error('otp_code')
            <p class="text-red-400 text-xs mt-1 text-center">{{ $message }}</p>
          @enderror
        </div>
        
        <!-- Resend Timer -->
        <div class="mb-6 text-center">
          <div class="text-white text-sm drop-shadow-md">
            Resend OTP in <span id="resendTimer" class="text-blue-400 font-bold">01:00</span>
          </div>
          <button 
            type="button" 
            class="text-white hover:text-yellow-400 text-sm font-medium drop-shadow-md mt-2 hidden"
            onclick="resendOTP()"
            id="resendBtn"
          >
            Resend OTP
          </button>
        </div>
        
        <!-- Verify Button -->
        <button 
          type="submit" 
          class="w-full bg-[#F7A923] hover:bg-[#E6940F] text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 mb-4 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center shadow-lg hover:shadow-xl"
          id="verifyBtn"
          disabled
        >
          <span id="verifyBtnText">Verify</span>
        </button>
        
        <!-- Back to Login -->
        <div class="text-center">
          <a href="/employeelogin" class="text-white hover:text-gray-200 text-sm flex items-center justify-center drop-shadow-md">
            <i class="bx bx-arrow-back mr-1"></i>
            Back to Login
          </a>
        </div>
        
        
      </form>
      </div>
  </div>
</div>

<!-- Security Message -->
<div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-center">
  <p class="text-gray-400 text-sm">Secured with enterprise-grade encryption</p>
</div>

</section>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>

<script>
// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing OTP verification...');
    
    // Check if there's a login success message and redirect
    @if(session('login_success'))
        console.log('Login successful! Redirecting to dashboard...');
        showNotification('{{ session("login_success") }}', 'success');
        // Redirect immediately
        window.location.href = '{{ route("dashboard") }}';
        return; // Exit early
    @endif
    
    // Get OTP inputs and other elements
    const otpInputs = document.querySelectorAll('.otp-input');
    const otpCodeHidden = document.getElementById('otp_code');
    const verifyBtn = document.getElementById('verifyBtn');
    const resendBtn = document.getElementById('resendBtn');
    const timerElement = document.getElementById('timer');
    const resendTimerElement = document.getElementById('resendTimer');
    const otpForm = document.getElementById('otpForm');
    
    // Focus on first OTP input
    if (otpInputs[0]) otpInputs[0].focus();
    
    // Debug: Log session data
    console.log('OTP Session Data:', {
        employee_id: '{{ session("otp_employee_id") }}',
        user_data: @json(session('otp_user_data'))
    });
    
    // Debug: Log form action URL
    console.log('Form action URL:', otpForm ? otpForm.action : 'Form not found');
    console.log('Form method:', otpForm ? otpForm.method : 'Form not found');
    
    // Timer for OTP expiry (10 minutes)
    let timeLeft = 600; // 10 minutes in seconds
    const timer = setInterval(() => {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        if (timerElement) {
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
        
        if (timeLeft <= 0) {
            clearInterval(timer);
            if (timerElement) {
                timerElement.textContent = 'Expired';
                timerElement.className = 'text-red-400 font-bold';
            }
            if (otpInput) otpInput.disabled = true;
            if (verifyBtn) verifyBtn.disabled = true;
        }
        timeLeft--;
    }, 1000);
    
    // Resend timer (60 seconds) - formatted as MM:SS
    let resendTimeLeft = 60;
    const resendTimer = setInterval(() => {
        if (resendTimerElement) {
            const minutes = Math.floor(resendTimeLeft / 60);
            const seconds = resendTimeLeft % 60;
            resendTimerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
        
        if (resendTimeLeft <= 0) {
            clearInterval(resendTimer);
            if (resendTimerElement && resendTimerElement.parentElement) {
                resendTimerElement.parentElement.style.display = 'none';
            }
            if (resendBtn) {
                resendBtn.classList.remove('hidden');
                resendBtn.disabled = false;
            }
        }
        resendTimeLeft--;
    }, 1000);
    
    // Handle OTP inputs
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Limit to single digit
            if (this.value.length > 1) {
                this.value = this.value.slice(0, 1);
            }
            
            // Move to next input if current is filled
            if (this.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
            
            // Update hidden input with complete OTP
            updateOTPCode();
            
            // Enable/disable button based on complete OTP
            updateVerifyButton();
        });
        
        input.addEventListener('keydown', function(e) {
            // Handle backspace - move to previous input if current is empty
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
        
        input.addEventListener('paste', function(e) {
                e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
            if (pastedData.length === 6) {
                pastedData.split('').forEach((digit, i) => {
                    if (otpInputs[i]) {
                        otpInputs[i].value = digit;
                    }
                });
                updateOTPCode();
                updateVerifyButton();
                otpInputs[5].focus();
            }
        });
    });
    
    // Function to update hidden OTP code input
    function updateOTPCode() {
        const otpCode = Array.from(otpInputs).map(input => input.value).join('');
        if (otpCodeHidden) {
            otpCodeHidden.value = otpCode;
        }
    }
    
    // Function to update verify button state
    function updateVerifyButton() {
        const otpCode = Array.from(otpInputs).map(input => input.value).join('');
        if (verifyBtn) {
            if (otpCode.length === 6) {
                verifyBtn.disabled = false;
                verifyBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                verifyBtn.disabled = true;
                verifyBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    }
    
    // Handle form submission
    if (otpForm) {
        otpForm.addEventListener('submit', function(e) {
            // Get OTP code from individual inputs
            const otpCode = Array.from(otpInputs).map(input => input.value).join('');
            
            // Update hidden input with OTP code
            if (otpCodeHidden) {
                otpCodeHidden.value = otpCode;
            }
            
            // Validate OTP code
            if (!otpCode || otpCode.length !== 6) {
                e.preventDefault();
                showNotification('Please enter a valid 6-digit OTP code', 'error');
                return false;
            }
            
            // Show loading state
            if (verifyBtn) {
                verifyBtn.disabled = true;
                const btnText = verifyBtn.querySelector('#verifyBtnText');
                if (btnText) {
                    btnText.innerHTML = '<i class="bx bx-loader-alt animate-spin mr-2"></i>Verifying...';
                }
            }
            
            // Disable all OTP inputs during submission
            otpInputs.forEach(input => input.disabled = true);
            
            // Form will submit normally - allow default behavior
            console.log('Submitting form with OTP:', otpCode);
            console.log('Form action:', otpForm.action);
            console.log('Form method:', otpForm.method);
            
            // Don't prevent default - let form submit normally
            return true;
        });
    }
    
    // Resend OTP function
    window.resendOTP = function() {
        console.log('Resend OTP clicked');
        if (resendBtn && resendBtn.disabled) return;
        
        if (resendBtn) {
            resendBtn.disabled = true;
            resendBtn.textContent = 'Sending...';
        }
        
        fetch('{{ route("otp.resend") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                employee_id: '{{ session("otp_employee_id") }}'
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Resend response:', data);
            if (data.success) {
                // Reset timers
                timeLeft = 600;
                resendTimeLeft = 60;
                clearInterval(timer);
                clearInterval(resendTimer);
                
                // Restart timers
                timeLeft = 600; // Reset to 10 minutes
                resendTimeLeft = 60; // Reset to 60 seconds
                
                const newTimer = setInterval(() => {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    if (timerElement) {
                        timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                    }
                    
                    if (timeLeft <= 0) {
                        clearInterval(newTimer);
                        if (timerElement) {
                            timerElement.textContent = 'Expired';
                            timerElement.className = 'text-red-400 font-bold';
                        }
                        if (otpInputs) otpInputs.forEach(inp => inp.disabled = true);
                        if (verifyBtn) verifyBtn.disabled = true;
                    }
                    timeLeft--;
                }, 1000);
                
                // Reset UI for resend
                if (resendTimerElement && resendTimerElement.parentElement) {
                    resendTimerElement.parentElement.style.display = 'block';
                }
                if (resendBtn) {
                    resendBtn.classList.add('hidden');
                }
                
                const newResendTimer = setInterval(() => {
                    if (resendTimerElement) {
                        const minutes = Math.floor(resendTimeLeft / 60);
                        const seconds = resendTimeLeft % 60;
                        resendTimerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                    }
                    
                    if (resendTimeLeft <= 0) {
                        clearInterval(newResendTimer);
                        if (resendTimerElement && resendTimerElement.parentElement) {
                            resendTimerElement.parentElement.style.display = 'none';
                        }
                        if (resendBtn) {
                            resendBtn.classList.remove('hidden');
                            resendBtn.disabled = false;
                        }
                    }
                    resendTimeLeft--;
                }, 1000);
                
                // Show success message
                showNotification('New OTP sent to your email!', 'success');
            } else {
                showNotification(data.message || 'Failed to resend OTP', 'error');
                if (resendBtn) {
                    resendBtn.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Resend Error:', error);
            showNotification('Failed to resend OTP', 'error');
            if (resendBtn) {
                resendBtn.disabled = false;
            }
        });
    };
    
    
    
    // Show notification function
    // Use Soliera-themed toast notification (same as soliera_js.blade.php)
    if (typeof window.showNotification === 'undefined') {
      // Create toast container if it doesn't exist
      function getToastContainer() {
        let container = document.getElementById('soliera-toast-container');
        if (!container) {
          container = document.createElement('div');
          container.id = 'soliera-toast-container';
          container.className = 'soliera-toast-container';
          document.body.appendChild(container);
        }
        return container;
      }
      
      window.showNotification = function(message, type = 'info', duration = 3000) {
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
    
    console.log('OTP verification initialized successfully!');
});
</script>

</body>
</html>
