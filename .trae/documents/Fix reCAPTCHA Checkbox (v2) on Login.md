## Goal
Restore the standard Google reCAPTCHA v2 "I'm not a robot" checkbox on the login page so it looks and behaves like your second screenshot, with a math fallback if the script cannot load.

## Root Cause
- The login page was switched to an "Easy Check Mode" (custom checkbox) and the Google reCAPTCHA JS was removed, so the v2 widget cannot render.
- Rendering is gated by a site key (`services.recaptcha.site_key` / `RECAPTCHA_SITE_KEY`). If that is empty or the JS is blocked, nothing shows.

## Implementation
### 1) Configuration
- Ensure keys exist in config and .env:
  - config/services.php: `recaptcha => ['site_key' => env('RECAPTCHA_SITE_KEY'), 'secret_key' => env('RECAPTCHA_SECRET_KEY')]`
  - .env: set `RECAPTCHA_SITE_KEY=` and `RECAPTCHA_SECRET_KEY=` with valid values.

### 2) Blade (login.blade.php)
- Replace the current Easy Check block with the v2 widget container:
  - Keep the existing header "Verify you're human".
  - Add `<div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>` inside the card.
- Load the official script once:
  - `<script src="https://www.recaptcha.net/recaptcha/api.js?hl=en" async defer></script>` (use recaptcha.net to avoid local tracking protection).
- Keep the math fallback block as-is, but hidden by default (only show on error or timeout).

### 3) JS Behavior
- Keep a 5s timeout: if the reCAPTCHA script fails to load, switch to math fallback (the code already supports this pattern).
- On submit, you do not need custom code to collect `g-recaptcha-response`; the v2 widget adds it automatically. Remove Easy Check synchronization code.

### 4) Controller (userController.php)
- Remove the "skipped" bypass branch.
- When `$hasRecaptcha` is true, require and verify `g-recaptcha-response` against `https://www.recaptcha.net/recaptcha/api/siteverify` with the secret key.
- If verification fails or times out, show math fallback (existing logic already does this).

### 5) Verification
- Visit /login and confirm the checkbox shows and can be clicked.
- Confirm `g-recaptcha-response` is posted in the form payload.
- Test negative path: block the script (or disconnect network) and confirm the math fallback appears.

### 6) Optional (Dev Convenience)
- Add an environment flag `RECAPTCHA_DISABLE=true` to force math fallback in local dev without changing templates. When true, `$hasRecaptcha=false` so the widget will not render.

## Files to Update
- resources/views/auth/login.blade.php (widget markup and script include)
- app/Http/Controllers/userController.php (remove bypass, keep server-side verify)
- config/services.php (keys mapping) and .env (actual keys)

Confirm and I will implement these changes immediately and verify on your localhost.