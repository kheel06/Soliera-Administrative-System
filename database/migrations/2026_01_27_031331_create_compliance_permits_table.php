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
        Schema::create('compliance_permits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('issuing_authority');
            $table->string('reference_number')->nullable();
            $table->date('expiration_date');
            $table->string('status')->default('Valid'); // Valid, Expiring Soon, Expired, Renewal in Progress
            $table->integer('compliance_score')->default(100); // 0-100
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance_permits');
    }
};
