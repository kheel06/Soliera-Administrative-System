<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;
use App\Models\AccessLog;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index()
    {
        // Fetch all settings keyed by their key
        $settings = SystemSetting::all()->pluck('value', 'key');
        
        return view('settings', compact('settings'));
    }

    /**
     * Update system settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->input('settings') as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear cache if you cache settings
        Cache::forget('system_settings');

        // Log the action
        AccessController::logAction(
            auth()->id(),
            'settings_updated',
            'System settings updated by ' . auth()->user()->name
        );

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
