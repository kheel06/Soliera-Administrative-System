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
        Schema::create('legal_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('contract_number')->unique()->nullable();
            $table->string('counterparty_name');
            $table->string('type')->default('Service Agreement'); // NDA, SLA, Lease, etc.
            $table->string('status')->default('Draft'); // Draft, Pending Signature, Active, Expired, Terminated
            $table->date('effective_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->decimal('contract_value', 15, 2)->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Owner
            $table->string('department')->nullable();
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); // Link to stored document
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_contracts');
    }
};
