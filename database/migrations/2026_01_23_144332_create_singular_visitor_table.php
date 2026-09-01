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
        // Drop both versions to start completely fresh
        Schema::dropIfExists('visitors');
        Schema::dropIfExists('visitor');

        Schema::create('visitor', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('purpose')->nullable();
            $table->string('department')->nullable();
            $table->string('host_employee')->nullable();
            $table->unsignedBigInteger('facility_id')->nullable();
            $table->unsignedBigInteger('facility_reservation_id')->nullable();
            $table->unsignedBigInteger('bulk_session_id')->nullable();

            $table->dateTime('time_in')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->dateTime('expected_time_out')->nullable();
            $table->date('expected_date_out')->nullable();
            $table->date('arrival_date')->nullable();
            $table->time('arrival_time')->nullable();

            $table->string('status')->default('pending'); // active, completed, pending, etc.
            $table->string('approval_status')->default('pending');

            $table->string('pass_type')->nullable();
            $table->string('pass_id')->nullable();
            $table->string('access_level')->nullable();
            $table->dateTime('pass_valid_from')->nullable();
            $table->dateTime('pass_valid_until')->nullable();
            $table->json('pass_data')->nullable();
            $table->string('access_code')->nullable();

            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();
            $table->string('id_document_path')->nullable();
            $table->string('vehicle_plate')->nullable();

            $table->boolean('pending_exit')->default(false);
            $table->dateTime('pending_exit_at')->nullable();

            $table->date('scheduled_date')->nullable();
            $table->time('scheduled_time')->nullable();
            $table->integer('expected_duration')->nullable();

            $table->string('profile_photo_url')->nullable();
            $table->integer('rating')->nullable();
            $table->text('rating_comment')->nullable();

            $table->boolean('id_verified')->default(false);
            $table->dateTime('id_verified_at')->nullable();
            $table->unsignedBigInteger('id_verified_by')->nullable();
            $table->text('id_verification_notes')->nullable();
            $table->string('id_verification_method')->nullable();
            $table->json('id_scanned_data')->nullable();
            $table->string('supporting_document')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor');
    }
};
