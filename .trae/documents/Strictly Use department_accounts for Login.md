## Goal
Fix the login function to strictly use the `department_accounts` table and remove dependencies on the `users` table that might be causing conflicts or confusion.

## Root Cause
- The `verifyOtp` method currently creates/updates a record in the `users` table (`User` model) before logging in the `DeptAccount`.
- The user explicitly requested to use the `department_accounts` table.
- The synchronization with the `users` table is redundant and potential source of error (e.g., if `users` table has strict constraints or if `Auth::login` was confused in previous versions).
- We need to ensure the `DeptAccount` model is fully ready for authentication.

## Implementation
### 1) Update `userController.php`
- In `verifyOtp` method:
  - **Remove** the `\App\Models\User::updateOrCreate(...)` block.
  - Ensure `Auth::login($deptAccount)` is the only authentication call.
  - Update any logging or logic that referenced `$laravelUser` to use `$deptAccount`.

### 2) Verify `DeptAccount` Model
- Ensure `DeptAccount` model correctly maps to `department_accounts` table (already verified).
- Ensure it extends `Authenticatable` (already verified).

## Files to Update
- `app/Http/Controllers/userController.php`

Confirm and I will remove the `User` model usage and finalize the `department_accounts` login flow.