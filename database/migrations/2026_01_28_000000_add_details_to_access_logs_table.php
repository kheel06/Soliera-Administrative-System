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
        if (!Schema::hasTable('access_logs')) {
            Schema::create('access_logs', function (Blueprint $table) {
                $table->id();
                $table->string('user_id')->nullable();
                $table->string('action');
                $table->text('description')->nullable();
                $table->string('ip_address')->nullable();
                $table->text('details')->nullable();
                $table->unsignedBigInteger('document_id')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamps();
                
                $table->index(['document_id', 'action']);
            });
        } else {
            Schema::table('access_logs', function (Blueprint $table) {
                // Ensure ip_address column exists
                if (!Schema::hasColumn('access_logs', 'ip_address')) {
                    $table->string('ip_address')->nullable()->after('description');
                }

                // Add details column if it doesn't exist
                if (!Schema::hasColumn('access_logs', 'details')) {
                    $table->text('details')->nullable()->after('ip_address');
                }
                
                // Ensure other columns exist just in case
                if (!Schema::hasColumn('access_logs', 'document_id')) {
                    $table->unsignedBigInteger('document_id')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('access_logs', 'metadata')) {
                    $table->json('metadata')->nullable()->after('description');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to drop the table in down() if we just added columns, 
        // but for safety in this specific "fix" migration, we'll just drop columns if they were added.
        // If we created the table, we should technically drop it, but detecting that state is hard.
        // We'll leave the table as is to avoid data loss.
        
        if (Schema::hasTable('access_logs')) {
            Schema::table('access_logs', function (Blueprint $table) {
                if (Schema::hasColumn('access_logs', 'details')) {
                    $table->dropColumn('details');
                }
            });
        }
    }
};
