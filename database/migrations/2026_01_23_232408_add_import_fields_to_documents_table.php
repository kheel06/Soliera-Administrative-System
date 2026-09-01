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
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'external_reference_id')) {
                $table->string('external_reference_id')->nullable()->index()->after('file_path');
            }
            if (!Schema::hasColumn('documents', 'import_source')) {
                $table->string('import_source', 100)->nullable()->after('external_reference_id');
            }
            if (!Schema::hasColumn('documents', 'metadata')) {
                $table->json('metadata')->nullable()->after('import_source');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['external_reference_id', 'import_source', 'metadata']);
        });
    }
};
