<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CheckDepartmentAccountsTable extends Command
{
    protected $signature = 'dept-accounts:check';
    protected $description = 'Check if department_accounts table exists and show structure';

    public function handle()
    {
        $this->info('Checking department_accounts table...');
        $this->newLine();

        // Check if table exists
        $exists = Schema::hasTable('department_accounts');
        $this->info('Table exists: ' . ($exists ? 'YES' : 'NO'));
        $this->newLine();

        if ($exists) {
            // Show columns
            $this->info('Table columns:');
            $columns = Schema::getColumnListing('department_accounts');
            foreach ($columns as $column) {
                $this->line("  - {$column}");
            }
            $this->newLine();

            // Show row count
            try {
                $count = DB::table('department_accounts')->count();
                $this->info("Total rows: {$count}");
            } catch (\Exception $e) {
                $this->error("Error counting rows: " . $e->getMessage());
            }
        } else {
            $this->error('Table does not exist! Run: php artisan migrate');
        }
    }
}
