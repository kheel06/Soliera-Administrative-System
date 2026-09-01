<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // e.g., 'security', 'general'
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('system_settings')->insert([
            [
                'key' => 'security.enable_2fa',
                'value' => 'true',
                'group' => 'security',
                'description' => 'Enable Two-Factor Authentication for all roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'security.session_timeout_enabled',
                'value' => 'true',
                'group' => 'security',
                'description' => 'Enable Session Timeout',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'security.session_timeout_minutes',
                'value' => '120', // Default 2 hours
                'group' => 'security',
                'description' => 'Session Timeout in minutes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
