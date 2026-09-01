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
        Schema::create('contract_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('requester_id'); // User ID
            $table->string('department');
            $table->text('description');
            $table->string('counterparty_name')->nullable();
            $table->string('priority')->default('Medium'); // Low, Medium, High, Critical
            $table->string('status')->default('Pending Approval'); // Pending Approval, Approved, In Drafting, Completed, Rejected
            $table->date('desired_date')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_requests');
    }
};
