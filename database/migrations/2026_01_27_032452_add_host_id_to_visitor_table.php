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
        Schema::table('visitor', function (Blueprint $table) {
            if (!Schema::hasColumn('visitor', 'host_id')) {
                $table->unsignedBigInteger('host_id')->nullable()->after('company');
                // $table->foreign('host_id')->references('id')->on('users'); // Optional: Add constraint if needed
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor', function (Blueprint $table) {
            $table->dropColumn('host_id');
        });
    }
};
