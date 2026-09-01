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
        Schema::create('visitor_incidents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('severity')->default('Low'); // Low, Medium, High, Critical
            $table->string('status')->default('Open'); // Open, Investigating, Resolved, Closed
            $table->string('location')->nullable();
            $table->dateTime('incident_date');

            $table->unsignedBigInteger('reported_by')->nullable(); // User ID
            $table->unsignedBigInteger('visitor_id')->nullable(); // Related Visitor ID

            $table->text('resolution_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_incidents');
    }
};
