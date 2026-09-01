<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add profile_picture column if it doesn't exist
            if (!Schema::hasColumn('users', 'profile_picture')) {
                // Check if department column exists to place it after
                if (Schema::hasColumn('users', 'department')) {
                    $table->string('profile_picture')->nullable()->after('department');
                } else {
                    $table->string('profile_picture')->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'profile_picture')) {
                $table->dropColumn('profile_picture');
            }
        });
    }
};
