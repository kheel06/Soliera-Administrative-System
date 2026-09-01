<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bulk_visit_sessions', function (Blueprint $table) {
            $table->json('visitor_data')->nullable()->after('expected_headcount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bulk_visit_sessions', function (Blueprint $table) {
            $table->dropColumn('visitor_data');
        });
    }
};
