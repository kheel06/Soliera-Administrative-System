<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DeptAccount;
use App\Services\SystemNotificationService;
use Illuminate\Support\Facades\DB;

// Find Michael or current logged in user
$user = auth()->user();
if (!$user) {
    $user = DeptAccount::where('employee_name', 'like', '%Michael%')->first();
}

if ($user) {
    echo "Sending realtime notification to: " . ($user->employee_name ?? $user->name) . " (ID: " . ($user->Dept_no ?? $user->id) . ")\n";

    // Broadcast a test notification
    try {
        SystemNotificationService::broadcastNotification([
            'notifiable_id' => $user->Dept_no ?? $user->id,
            'notifiable_type' => get_class($user),
            'data' => [
                'title' => 'Real-time Signal Detected',
                'message' => 'This alert was pushed via WebSocket at ' . date('H:i:s') . '. No reload required.',
                'icon' => 'activity',
                'url' => route('notifications.index'),
                'category' => 'risk',
                'severity' => 'critical'
            ]
        ]);
        echo "SUCCESS: Notification broadcasted. Check your dashboard now!\n";
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
} else {
    echo "User Michael or current user not found. Please log in or ensure Michael exists in department_accounts.\n";
}
