<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FacilityRequestNotificationService;
use App\Models\DeptAccount;
use Illuminate\Support\Facades\Log;

class TestNotifications extends Command
{
    protected $signature = 'notifications:test';
    protected $description = 'Test notification system and diagnose issues';

    public function handle()
    {
        $this->info('Testing Notification System...');
        $this->newLine();

        // 1. Check all department accounts and their roles
        $this->info('1. Checking all department accounts and roles...');
        $allAccounts = DeptAccount::select('Dept_no', 'email', 'role', 'employee_name', 'status')->get();
        $this->info("   Total department accounts: {$allAccounts->count()}");
        foreach ($allAccounts as $account) {
            $role = $account->role ?? 'NULL';
            $status = $account->status ?? 'NULL';
            $email = $account->email ?? 'N/A';
            $this->line("   - {$account->employee_name} ({$email}) - ID: {$account->Dept_no}, Role: {$role}, Status: {$status}");
        }
        $this->newLine();
        
        // 1b. Check admin department accounts
        $this->info('1b. Finding admin department accounts...');
        $service = new FacilityRequestNotificationService();
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('getAdminUsers');
        $method->setAccessible(true);
        $adminAccounts = $method->invoke($service);
        
        $this->info("   Found {$adminAccounts->count()} admin department accounts:");
        foreach ($adminAccounts as $account) {
            $email = $account->email ?? 'N/A';
            $this->line("   - {$account->employee_name} ({$email}) - ID: {$account->Dept_no}, Role: " . ($account->role ?? 'N/A') . ", Status: " . ($account->status ?? 'N/A'));
        }
        $this->newLine();
        
        // 1c. Check notifications table
        $this->info('1c. Checking notifications table...');
        try {
            $tableExists = \Illuminate\Support\Facades\Schema::hasTable('notifications');
            $this->info("   Notifications table exists: " . ($tableExists ? 'YES' : 'NO'));
            if ($tableExists) {
                $count = \Illuminate\Support\Facades\DB::table('notifications')->count();
                $this->info("   Total notifications in database: {$count}");
            }
        } catch (\Exception $e) {
            $this->error("   Error checking table: " . $e->getMessage());
        }
        $this->newLine();

        // 2. Check if queue is working
        $this->info('2. Testing queue worker...');
        try {
            \App\Jobs\IngestCore1Events::dispatch();
            $this->info('   ✓ Job dispatched successfully');
        } catch (\Exception $e) {
            $this->error('   ✗ Error dispatching job: ' . $e->getMessage());
        }
        $this->newLine();

        // 3. Check recent notifications
        $this->info('3. Checking recent notifications...');
        $recentNotifications = \Illuminate\Notifications\DatabaseNotification::where('type', \App\Notifications\NewFacilityRequestNotification::class)
            ->latest()
            ->take(5)
            ->get();
        
        $this->info("   Found {$recentNotifications->count()} recent notifications");
        foreach ($recentNotifications as $notif) {
            $data = $notif->data;
            $this->line("   - ID: {$notif->id}, Title: " . ($data['title'] ?? 'N/A') . ", Read: " . ($notif->read_at ? 'Yes' : 'No'));
        }
        $this->newLine();

        // 4. Check logs (read last 50 lines efficiently)
        $this->info('4. Recent log entries...');
        $logFile = storage_path('logs/laravel.log');
        if (file_exists($logFile)) {
            try {
                // Read last 50 lines efficiently using tail-like approach
                $handle = fopen($logFile, 'r');
                if ($handle) {
                    fseek($handle, -1, SEEK_END);
                    $lines = [];
                    $currentLine = '';
                    $pos = ftell($handle);
                    
                    // Read backwards
                    while ($pos >= 0 && count($lines) < 50) {
                        $char = fgetc($handle);
                        if ($char === "\n") {
                            if (!empty($currentLine)) {
                                array_unshift($lines, strrev($currentLine));
                                $currentLine = '';
                            }
                        } else {
                            $currentLine .= $char;
                        }
                        fseek($handle, --$pos);
                    }
                    if (!empty($currentLine)) {
                        array_unshift($lines, strrev($currentLine));
                    }
                    fclose($handle);
                    
                    // Filter for notification-related lines
                    $found = 0;
                    foreach ($lines as $line) {
                        if (stripos($line, 'notification') !== false || stripos($line, 'core1events') !== false) {
                            $this->line('   ' . trim($line));
                            $found++;
                            if ($found >= 5) break; // Limit to 5 matches
                        }
                    }
                    if ($found === 0) {
                        $this->line('   No recent notification-related log entries found');
                    }
                }
            } catch (\Exception $e) {
                $this->line('   Error reading log file: ' . $e->getMessage());
            }
        } else {
            $this->line('   Log file not found');
        }
        $this->newLine();

        $this->info('Test complete!');
    }
}
