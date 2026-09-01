<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('legal_docs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file_path')->unique(); // important: para di madoble
            $table->string('status')->default('draft'); // draft/pending/approved/archived
            $table->string('department')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('legal_docs');
    }
};

