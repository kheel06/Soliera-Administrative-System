<?php

namespace App\Http\Controllers;

use App\Models\DeptAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Get the current user's department account
     */
    private function getDeptAccount()
    {
        $empId = session('emp_id');
        
        if (empty($empId)) {
            // Try to get from authenticated user if available
            try {
                $user = auth()->user();
                if ($user && $user->employee_id) {
                    $empId = $user->employee_id;
                } elseif ($user && $user->email) {
                    // Extract employee_id from email if it's in format "empid@domain"
                    if (strpos($user->email, '@') !== false) {
                        $empId = substr($user->email, 0, strpos($user->email, '@'));
                    }
                }
            } catch (\Throwable $e) {
                // Ignore errors from users table not existing
            }
        }
        
        if ($empId) {
            return DeptAccount::where('employee_id', $empId)->first();
        }
        
        return null;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $deptAccount = $this->getDeptAccount();
        
        return view('profile.edit', [
            'deptAccount' => $deptAccount,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $deptAccount = $this->getDeptAccount();
        
        if (!$deptAccount) {
            return Redirect::route('profile.show')->with('error', 'Department account not found.');
        }

        // Validate the request
        $validated = $request->validate([
            'employee_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            try {
                // Delete old profile picture if exists
                if ($deptAccount->profile_picture && Storage::disk('public')->exists($deptAccount->profile_picture)) {
                    Storage::disk('public')->delete($deptAccount->profile_picture);
                }

                // Ensure directory exists
                if (!Storage::disk('public')->exists('profile_pictures')) {
                    Storage::disk('public')->makeDirectory('profile_pictures');
                }

                // Store new profile picture
                $file = $request->file('profile_picture');
                $filename = 'profile_' . $deptAccount->employee_id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profile_pictures', $filename, 'public');
                $validated['profile_picture'] = $path;
            } catch (\Exception $e) {
                return Redirect::route('profile.show')->with('error', 'Failed to upload profile picture: ' . $e->getMessage());
            }
        }

        // Update department account
        $deptAccount->employee_name = $validated['employee_name'];
        $deptAccount->email = $validated['email'];
        
        if (isset($validated['profile_picture'])) {
            $deptAccount->profile_picture = $validated['profile_picture'];
        }
        
        $deptAccount->save();

        return Redirect::route('profile.show')->with('profile_success', 'Profile updated successfully!');
    }

    /**
     * Display the user's profile information.
     */
    public function show(Request $request): View
    {
        $deptAccount = $this->getDeptAccount();
        
        return view('profile.show', [
            'deptAccount' => $deptAccount,
        ]);
    }

    /**
     * Remove the user's profile picture.
     */
    public function removeProfilePicture(Request $request): RedirectResponse
    {
        $deptAccount = $this->getDeptAccount();

        if ($deptAccount) {
            // Delete profile picture if exists
            if ($deptAccount->profile_picture && Storage::disk('public')->exists($deptAccount->profile_picture)) {
                Storage::disk('public')->delete($deptAccount->profile_picture);
            }

            $deptAccount->profile_picture = null;
            $deptAccount->save();
        }

        return Redirect::route('profile.show')->with('profile_success', 'Profile picture removed successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // This functionality is disabled since we're using department_accounts
        return Redirect::route('profile.show')->with('error', 'Account deletion is not available.');
    }
}
