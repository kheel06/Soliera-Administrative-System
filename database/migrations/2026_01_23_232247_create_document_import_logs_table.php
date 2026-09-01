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
        Schema::create('document_import_logs', function (Blueprint $table) {
            $table->id();
            $table->string('source_system', 100)->index(); // e.g., 'HR1', 'FINANCIAL', 'CORE 1'
            $table->string('external_reference_id')->index(); // Idempotency key
            $table->unsignedBigInteger('document_id')->nullable()->index();
            $table->enum('import_status', ['processing', 'success', 'failed'])->default('processing');
            $table->text('payload')->nullable(); // Original request payload
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->float('processing_time_ms')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('set null');

            // Unique constraint for idempotency
            $table->unique(['source_system', 'external_reference_id'], 'unique_import');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_import_logs');
    }
};
