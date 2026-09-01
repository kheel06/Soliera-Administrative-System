@php
  // Try config first (recommended), fallback to env
  $recaptchaSiteKey = config('services.recaptcha.site_key', env('RECAPTCHA_SITE_KEY', ''));
  $hasRecaptcha = !empty($recaptchaSiteKey) && strlen(trim($recaptchaSiteKey)) > 0;
  // Debug: uncomment to see if key is being read
  // dd($recaptchaSiteKey, $hasRecaptcha);
@endphp
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="referrer" content="origin">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Soliera Hotel - Department Login</title>
  @include('partials.favicon')

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <section class="relative w-full h-screen">

    <!-- Background image with overlay -->
    <div class="absolute inset-0 bg-cover bg-center z-0"
      style="background-image: url('{{ asset('images/defaults/hotel3.jpg') }}')"></div>
    <div class="absolute inset-0 bg-black/40 z-10"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/70 z-10"></div>

    <!-- Content container -->
    <div class="relative z-10 w-full h-full flex justify-center items-center  p-4">
      <div class="w-1/2 flex justify-center items-center max-md:hidden">
        <div class="max-w-lg p-8">
          <!-- Hotel & Restaurant Illustration -->
          <div class="text-center mb-8">
            <a href="/">
              <img data-aos="zoom-in" data-aos-delay="100" class="w-full max-h-52 hover:scale-105 transition-all"
                src="{{asset('images/logo/logofinal.png')}}" alt="">
            </a>
            <h1 data-aos="zoom-in-up" data-aos-delay="200" class="text-3xl font-bold text-white mb-2">Welcome to <span
                class="text-[#F7B32B]">Soliera<span> Hotel & Restaurant</h1>
            <p data-aos="zoom-in-up" data-aos-delay="300" class="text-white/80"> Savor The Stay, Dine With Elegance</p>
          </div>




        </div>
      </div>

      <div class="w-1/2 flex justify-center items-center max-md:w-full">
        <div class="max-w-md w-full bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-2xl border border-white/20">
          <!-- Card Header -->
          <div class="mb-6 text-center flex justify-center items-center flex-col">

            <h2 class="text-2xl font-bold text-white">Sign in to your account</h2>
            <p class="text-white/80 mt-1">Enter your credentials to continue</p>

            <!-- Error Messages -->
            @if($errors->any())
              <div class="mt-4 p-4 bg-red-500/20 border border-red-500/30 rounded-lg w-full animate-pulse">
                <div class="flex items-start gap-2">
                  <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                      clip-rule="evenodd" />
                  </svg>
                  <ul class="text-red-400 text-sm list-disc list-inside">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            @endif

            <!-- Success/Info Messages -->
            @if(session('success'))
              <div class="mt-4 p-4 bg-green-500/20 border border-green-500/30 rounded-lg w-full animate-pulse">
                <div class="flex items-start gap-2">
                  <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd" />
                  </svg>
                  <p class="text-green-400 text-sm">{{ session('success') }}</p>
                </div>
              </div>
            @endif

            @if(session('error'))
              <div class="mt-4 p-4 bg-red-500/20 border border-red-500/30 rounded-lg w-full animate-pulse">
                <div class="flex items-start gap-2">
                  <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                      clip-rule="evenodd" />
                  </svg>
                  <p class="text-red-400 text-sm">{{ session('error') }}</p>
                </div>
              </div>
            @endif

            @if(session('warning'))
              <div class="mt-4 p-4 bg-yellow-500/20 border border-yellow-500/30 rounded-lg w-full animate-pulse">
                <div class="flex items-start gap-2">
                  <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                      clip-rule="evenodd" />
                  </svg>
                  <p class="text-yellow-400 text-sm">{{ session('warning') }}</p>
                </div>
              </div>
            @endif
          </div>

          <!-- Card Body -->
          <div>
            <form action="/loginuser" method="POST" id="loginForm">
              <!-- Email Input -->
              @csrf
              <div class="mb-4">
                <label class="block text-white/90 text-sm font-medium mb-2" for="email">
                  Employee ID
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-white/50" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                      <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                  </div>
                  <input id="email" type="text"
                    class="w-full pl-10 pr-3 py-3 bg-white/5 border border-white/20 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent placeholder-white/50"
                    placeholder="Your ID" required name="employee_id">
                </div>
              </div>

              <!-- Password Input with Toggle -->
              <div class="mb-6">
                <label class="block text-white/90 text-sm font-medium mb-2" for="password">
                  Password
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                  </div>
                  <input id="password" type="password"
                    class="w-full pl-10 pr-10 py-3 bg-white/5 border {{ $errors->has('password') ? 'border-red-500' : 'border-white/20' }} text-white rounded-lg focus:outline-none focus:ring-2 {{ $errors->has('password') ? 'focus:ring-red-500/50' : 'focus:ring-blue-500/50' }} focus:border-transparent placeholder-white/50"
                    placeholder="••••••••" required name="password">
                  @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                  @enderror
                  <button type="button"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-white/50 hover:text-white focus:outline-none"
                    onclick="togglePasswordVisibility()">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                      fill="currentColor">
                      <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                      <path fill-rule="evenodd"
                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                        clip-rule="evenodd" />
                    </svg>
                    <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                      viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd"
                        d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                        clip-rule="evenodd" />
                      <path
                        d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                    </svg>
                  </button>
                </div>
              </div>

              <!-- reCAPTCHA or Math Fallback -->
              @php
                $showMathCaptcha = session('use_math_captcha') || $errors->has('math_captcha') || $errors->has('captcha_error');
              @endphp

              <!-- Always include both but control visibility via JS/Server logic -->
              @if($hasRecaptcha)
                <div class="mb-6" id="recaptcha-container-block" style="{{ $showMathCaptcha ? 'display:none;' : '' }}">
                  <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-4">
                    <!-- Header with shield icon -->
                    <div class="flex items-center gap-2 mb-3">
                      <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd" />
                      </svg>
                      <span class="text-white font-medium text-sm">Verify you're human</span>
                    </div>
                    <!-- reCAPTCHA widget -->
                    <div class="flex justify-center items-center min-h-[78px]">
                      <div id="recaptcha-widget"></div>
                    </div>
                  </div>
                </div>
              @endif

              <div class="mb-6 {{ $showMathCaptcha ? '' : 'hidden' }}" id="math-captcha-container-block"
                style="{{ $showMathCaptcha ? 'display:block;' : 'display:none;' }}">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-4">
                  <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                    </svg>
                    <span class="text-white font-medium text-sm">Security Check (Offline Fallback)</span>
                  </div>

                  <div class="mb-3 text-white/90 text-sm">
                    @if($errors->has('captcha_error'))
                      <div class="mb-2 text-red-300">{{ $errors->first('captcha_error') }}</div>
                    @endif
                    Please solve this problem: <span
                      class="font-bold text-lg ml-1">{{ $math_captcha_question ?? '?' }}</span>
                  </div>

                  <input type="number" name="math_captcha"
                    class="w-full px-4 py-3 rounded-lg bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-white/30 focus:ring-0 transition-colors"
                    placeholder="Enter the result" {{ $showMathCaptcha ? 'required' : '' }}>
                  @error('math_captcha')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <!-- Sign In Button -->
              <button type="submit" class="w-full btn-primary btn flex items-center justify-center gap-3 transition-all"
                id="loginSubmitBtn">
                <span class="btn-spinner hidden" aria-hidden="true">
                  <span
                    class="inline-block h-5 w-5 border-2 border-white/60 border-t-transparent rounded-full animate-spin"></span>
                </span>
                <span class="btn-text">Sign in</span>
              </button>
            </form>
          </div>
        </div>
      </div>



    </div>


  </section>

  @if($hasRecaptcha)
    <script>
      var recaptchaWidgetId = null;
      var recaptchaSiteKey = '{{ $recaptchaSiteKey }}';
      var hasRendered = false;
      function enableOfflineCaptcha() {
        const recaptchaContainer = document.getElementById('recaptcha-container-block');
        const mathCaptchaContainer = document.getElementById('math-captcha-container-block');
        if (recaptchaContainer) recaptchaContainer.style.display = 'none';
        if (mathCaptchaContainer) {
          mathCaptchaContainer.classList.remove('hidden');
          mathCaptchaContainer.style.display = 'block';
          const mathInput = mathCaptchaContainer.querySelector('input[name="math_captcha"]');
          if (mathInput) mathInput.required = true;
        }
      }
      window.renderRecaptcha = function () {
        try {
          var el = document.getElementById('recaptcha-widget');
          if (!el || hasRendered) return;
          recaptchaWidgetId = grecaptcha.render('recaptcha-widget', {
            sitekey: recaptchaSiteKey,
            theme: 'light'
          });
          hasRendered = true;
        } catch (e) {
          console.error('reCAPTCHA render error:', e);
          enableOfflineCaptcha();
        }
      };
    </script>
    <script src="https://www.recaptcha.net/recaptcha/api.js?onload=renderRecaptcha&render=explicit&hl=en" async
      defer></script>
    <script>
      setTimeout(function () {
        if (typeof grecaptcha === 'undefined') {
          console.warn('reCAPTCHA script not available, enabling fallback');
          enableOfflineCaptcha();
        }
      }, 5000);
    </script>
  @endif
  <style>
    @keyframes shake {

      0%,
      100% {
        transform: translateX(0);
      }

      10%,
      30%,
      50%,
      70%,
      90% {
        transform: translateX(-5px);
      }

      20%,
      40%,
      60%,
      80% {
        transform: translateX(5px);
      }
    }

    .shake {
      animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
    }

    /* Gold/Amber Focus Styles */
    .focus-gold:focus {
      border-color: #F7B32B !important;
      box-shadow: 0 0 0 2px rgba(247, 179, 43, 0.3) !important;
    }

    .attempt-bar {
      height: 4px;
      flex: 1;
      border-radius: 2px;
      background-color: rgba(255, 255, 255, 0.1);
      transition: background-color 0.3s ease;
    }

    .attempt-bar.active {
      background-color: #ef4444;
      /* red-500 */
    }
  </style>

  <script>
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eye-icon');
      const eyeSlashIcon = document.getElementById('eye-slash-icon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
      }
    }

    document.addEventListener('DOMContentLoaded', function () {
      console.log('Soliera Login System Loaded');

      const form = document.getElementById('loginForm');
      const submitBtn = document.getElementById('loginSubmitBtn');
      const card = form.closest('.bg-white\\/10') || form.closest('.bg-white\\/5');
      let attemptsCount = parseInt(localStorage.getItem('login_attempts')) || 0;
      let lockoutTimer = null;

      // Persistence Check on Load
      function checkPersistentLockout() {
        const expiry = localStorage.getItem('lockout_expiry');
        if (expiry) {
          const remaining = Math.ceil((parseInt(expiry) - Date.now()) / 1000);
          if (remaining > 0) {
            startLockout(remaining);
            showError('Account temporarily locked. Please wait.');
          } else {
            localStorage.removeItem('lockout_expiry');
            localStorage.removeItem('login_attempts');
            attemptsCount = 0;
          }
        }

        // Restore bars if there were attempts
        if (attemptsCount > 0 && !localStorage.getItem('lockout_expiry')) {
          const barsContainer = document.querySelector('.attempts-bars-container');
          if (barsContainer) barsContainer.classList.remove('hidden');
          for (let i = 1; i <= attemptsCount; i++) {
            const bar = document.getElementById(`bar-${i}`);
            if (bar) bar.classList.add('active');
          }
        }
      }

      // Refresh CSRF token periodically
      function refreshCSRF() {
        fetch('/refresh-csrf', { method: 'GET', credentials: 'same-origin' })
          .then(res => res.json())
          .then(data => {
            if (data.csrf_token) {
              const metaToken = document.querySelector('meta[name="csrf-token"]');
              if (metaToken) metaToken.setAttribute('content', data.csrf_token);
              const csrfInput = form.querySelector('input[name="_token"]');
              if (csrfInput) csrfInput.value = data.csrf_token;
            }
          })
          .catch(console.warn);
      }
      setInterval(refreshCSRF, 5 * 60 * 1000);

      if (!form) return;

      // Add attempt bars to the UI if they don't exist
      let barsContainer = document.querySelector('.attempts-bars-container');
      if (!barsContainer) {
        barsContainer = document.createElement('div');
        barsContainer.className = 'attempts-bars-container hidden flex gap-2 mt-4 px-1';
        barsContainer.innerHTML = `
          <div class="attempt-bar" id="bar-1"></div>
          <div class="attempt-bar" id="bar-2"></div>
          <div class="attempt-bar" id="bar-3"></div>
        `;
        form.appendChild(barsContainer);
      }

      // Initialize state
      checkPersistentLockout();

      function triggerShake() {
        if (!card) return;
        card.classList.remove('shake');
        void card.offsetWidth; // trigger reflow
        card.classList.add('shake');
        setTimeout(() => card.classList.remove('shake'), 500);
      }

      function startLockout(seconds) {
        let remaining = seconds;
        submitBtn.disabled = true;

        // Set persistence if not already set
        if (!localStorage.getItem('lockout_expiry')) {
          localStorage.setItem('lockout_expiry', Date.now() + (seconds * 1000));
        }

        // Disable all visible inputs and the recaptcha
        const inputs = form.querySelectorAll('input:not([type="hidden"])');
        inputs.forEach(i => i.disabled = true);

        const recaptchaBlock = document.getElementById('recaptcha-container-block') || document.getElementById('math-captcha-container-block');
        if (recaptchaBlock) {
          recaptchaBlock.style.pointerEvents = 'none';
          recaptchaBlock.style.opacity = '0.5';
        }

        const btnText = submitBtn.querySelector('.btn-text');
        const spinner = submitBtn.querySelector('.btn-spinner');

        spinner.classList.add('hidden');
        if (lockoutTimer) clearInterval(lockoutTimer);

        lockoutTimer = setInterval(() => {
          remaining--;
          btnText.innerText = `Locked (${remaining}s)`;

          if (remaining <= 0) {
            clearInterval(lockoutTimer);
            lockoutTimer = null;
            submitBtn.disabled = false;

            // Re-enable everything
            inputs.forEach(i => i.disabled = false);
            if (recaptchaBlock) {
              recaptchaBlock.style.pointerEvents = 'auto';
              recaptchaBlock.style.opacity = '1';
            }

            btnText.innerText = 'Sign in';
            attemptsCount = 0;
            localStorage.removeItem('lockout_expiry');
            localStorage.removeItem('login_attempts');

            // Reset bars
            const barsContainer = document.querySelector('.attempts-bars-container');
            if (barsContainer) barsContainer.classList.add('hidden');
            document.querySelectorAll('.attempt-bar').forEach(bar => bar.classList.remove('active'));
            // Remove error message
            const err = document.getElementById('global-error-container');
            if (err) err.remove();
          }
        }, 1000);
      }

      function showError(message) {
        const existing = document.getElementById('global-error-container');
        if (existing) existing.remove();

        const errorContainer = document.createElement('div');
        errorContainer.id = 'global-error-container';
        errorContainer.className = 'mt-4 p-3 bg-red-500/20 border border-red-500/30 rounded-lg w-full flex items-center gap-2 text-red-400';
        errorContainer.innerHTML = `
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <span class="text-xs font-medium">${message}</span>
        `;

        const cardHeader = document.querySelector('.mb-6.text-center');
        if (cardHeader) cardHeader.appendChild(errorContainer);
        else form.parentNode.insertBefore(errorContainer, form);
      }

      form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (submitBtn.disabled && lockoutTimer) return;

        const spinner = submitBtn.querySelector('.btn-spinner');
        const btnText = submitBtn.querySelector('.btn-text');

        // UI Loading State
        submitBtn.disabled = true;
        spinner.classList.remove('hidden');
        btnText.classList.add('opacity-0');

        // Clear field errors
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500', 'focus:ring-red-500/50'));
        document.querySelectorAll('.text-red-400').forEach(el => el.remove());

        const formData = new FormData(form);

        fetch('/loginuser', {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
          }
        })
          .then(async response => {
            let body = {};
            try {
              body = await response.json();
            } catch (err) {
              console.error('Failed to parse JSON:', err);
            }
            return { status: response.status, body };
          })
          .then(({ status, body }) => {
            if (status === 200 && body.success) {
              localStorage.removeItem('login_attempts');
              localStorage.removeItem('lockout_expiry');
              window.location.href = body.redirect;
            } else {
              // UI Reset
              submitBtn.disabled = false;
              spinner.classList.add('hidden');
              btnText.classList.remove('opacity-0');

              // Always increment attempts on non-success
              attemptsCount++;
              localStorage.setItem('login_attempts', attemptsCount);
              triggerShake();

              // Reset reCAPTCHA for next attempt
              if (typeof grecaptcha !== 'undefined') grecaptcha.reset();

              // Update Bars
              if (attemptsCount <= 3) {
                const barsContainer = document.querySelector('.attempts-bars-container');
                if (barsContainer) barsContainer.classList.remove('hidden');
                const bar = document.getElementById(`bar-${attemptsCount}`);
                if (bar) bar.classList.add('active');
              }

              // Handle Field/Validation Errors
              if (body.errors) {
                Object.keys(body.errors).forEach(field => {
                  const input = document.querySelector(`[name="${field}"]`);
                  if (input) {
                    input.classList.add('border-red-500');
                  }
                });
              }

              // Handle Account Lock (429)
              if (status === 429) {
                showError('Account temporarily locked. Please wait 30 seconds.');
                startLockout(30);
                return;
              }

              // Handle Normal Failures
              const remaining = Math.max(0, 3 - attemptsCount);
              if (remaining > 0) {
                showError(`Invalid credentials. ${remaining} attempt(s) remaining.`);
              } else {
                showError('Too many failed attempts. Account locked.');
                startLockout(30);
              }
            }
          })
          .catch(error => {
            console.error('Fetch Error:', error);
            submitBtn.disabled = false;
            spinner.classList.add('hidden');
            btnText.classList.remove('opacity-0');
            showError('Unable to connect. Please check your internet.');
          });
      });

      // Apply focus-gold class to inputs
      document.querySelectorAll('input').forEach(input => {
        input.classList.add('focus-gold');
      });
    });
  </script>


</body>

</html>