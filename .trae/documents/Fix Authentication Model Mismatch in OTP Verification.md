## Goal
Fix the login issue where users cannot access the dashboard after entering the OTP.

## Root Cause
- The `config/auth.php` is configured to use `App\Models\DeptAccount` as the authentication provider for the default `web` guard.
- However, the `verifyOtp` method in `userController.php` creates a shadow `App\Models\User` record and logs *that* user in via `Auth::login($laravelUser)`.
- **The Mismatch:** When the session is saved, it stores the ID of the `User` model. On the next request, Laravel's auth driver uses the configured provider (`DeptAccount`) to try and find a record with that ID. Since `User` IDs and `DeptAccount` IDs (Dept_no) do not match, the lookup fails or returns the wrong record, resulting in the user being logged out or invalid.

## Implementation
### 1) Update `userController.php`
- In the `verifyOtp` method:
  - Keep the code that syncs/creates the `User` record (as a fallback or for other system compatibility), or simply ignore it if it's not needed.
  - **Critical Change:** Change `Auth::login($laravelUser)` to `Auth::login($deptAccount)`.
  - This ensures the session stores the `DeptAccount` ID, which matches the configured auth provider.

### 2) Verification
- The `DeptAccount` model already implements `Authenticatable`, so it is compatible with `Auth::login`.
- This change aligns the code with `config/auth.php`.

## Files to Update
- `app/Http/Controllers/userController.php`

Confirm and I will apply this fix immediately.