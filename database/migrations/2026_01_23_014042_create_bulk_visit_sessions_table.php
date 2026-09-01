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
        Schema::create('bulk_visit_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');
            $table->string('host_name')->nullable();
            $table->string('department')->nullable();
            $table->string('purpose')->nullable();
            $table->dateTime('visit_date');
            $table->integer('expected_headcount')->default(1);
            $table->string('qr_code_token')->unique();
            $table->string('status')->default('pending'); // pending, processed, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_visit_sessions');
    }
};
