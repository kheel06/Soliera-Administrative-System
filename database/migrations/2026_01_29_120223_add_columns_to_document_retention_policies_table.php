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
        Schema::table('document_retention_policies', function (Blueprint $table) {
            if (!Schema::hasColumn('document_retention_policies', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('document_retention_policies', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('document_retention_policies', 'retention_period')) {
                $table->string('retention_period')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_retention_policies', function (Blueprint $table) {
            $table->dropColumn(['name', 'description', 'retention_period']);
        });
    }
};
