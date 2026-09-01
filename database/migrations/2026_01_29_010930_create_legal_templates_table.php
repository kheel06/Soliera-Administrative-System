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
        Schema::create('legal_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // e.g., NDA-2026, SLA-001
            $table->string('category'); // supplier_agreement, employment, nda, moa, service_contract, incident_report
            $table->text('description')->nullable();
            $table->longText('content'); // The template content/body
            $table->string('version')->default('1.0');
            $table->enum('status', ['draft', 'pending_review', 'approved', 'obsolete'])->default('draft');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->json('tags')->nullable(); // ['mandatory', 'ph-compliant', 'data-privacy']
            $table->integer('usage_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_templates');
    }
};
