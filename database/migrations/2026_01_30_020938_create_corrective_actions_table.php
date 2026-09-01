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
        Schema::create('corrective_actions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('Open'); // Open, In Progress, Resolved, Closed
            $table->string('priority')->default('Medium'); // Low, Medium, High, Critical
            $table->unsignedBigInteger('assigned_to')->nullable(); // User ID
            $table->date('due_date')->nullable();
            $table->date('resolved_date')->nullable();

            // Linkages
            $table->unsignedBigInteger('related_permit_id')->nullable();
            $table->unsignedBigInteger('related_case_id')->nullable();

            $table->text('resolution_notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corrective_actions');
    }
};
