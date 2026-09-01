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
        // Cleanup from previous failed attempts
        if (Schema::hasColumn('documents', 'folder_id')) {
            Schema::table('documents', function (Blueprint $table) {
                // We assume no FK exists because previous attempt failed to create it
                // If this fails, we'll know
                $table->dropColumn('folder_id');
            });
        }

        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id')->nullable()->after('id');
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['folder_id']);
            $table->dropColumn('folder_id');
        });
    }
};
