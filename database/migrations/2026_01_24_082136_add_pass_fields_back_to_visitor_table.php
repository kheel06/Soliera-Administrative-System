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
        Schema::table('visitor', function (Blueprint $table) {
            if (!Schema::hasColumn('visitor', 'pass_validity')) {
                $table->string('pass_validity')->nullable()->after('pass_type');
            }

            if (!Schema::hasColumn('visitor', 'pass_valid_from')) {
                $table->dateTime('pass_valid_from')->nullable()->after('pass_validity');
            } else {
                // ensure ordering remains sensible if column already exists
                $table->dateTime('pass_valid_from')->nullable()->change();
            }

            if (!Schema::hasColumn('visitor', 'pass_valid_until')) {
                $table->dateTime('pass_valid_until')->nullable()->after('pass_valid_from');
            } else {
                $table->dateTime('pass_valid_until')->nullable()->change();
            }

            if (!Schema::hasColumn('visitor', 'access_level')) {
                $table->string('access_level')->nullable()->after('pass_valid_until');
            }

            if (!Schema::hasColumn('visitor', 'escort_required')) {
                $table->string('escort_required')->default('no')->after('access_level');
            }

            if (!Schema::hasColumn('visitor', 'special_instructions')) {
                $table->text('special_instructions')->nullable()->after('escort_required');
            }

            if (!Schema::hasColumn('visitor', 'generate_digital_pass')) {
                $table->boolean('generate_digital_pass')->default(false)->after('special_instructions');
            }

            // pass_id already exists but make sure it's nullable and reasonably sized
            $table->string('pass_id')->nullable()->change();

            // pass_data already exists, leave as is
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor', function (Blueprint $table) {
            if (Schema::hasColumn('visitor', 'generate_digital_pass')) {
                $table->dropColumn('generate_digital_pass');
            }
            if (Schema::hasColumn('visitor', 'special_instructions')) {
                $table->dropColumn('special_instructions');
            }
            if (Schema::hasColumn('visitor', 'escort_required')) {
                $table->dropColumn('escort_required');
            }
            if (Schema::hasColumn('visitor', 'access_level')) {
                $table->dropColumn('access_level');
            }
            if (Schema::hasColumn('visitor', 'pass_valid_until')) {
                $table->dropColumn('pass_valid_until');
            }
            if (Schema::hasColumn('visitor', 'pass_valid_from')) {
                $table->dropColumn('pass_valid_from');
            }
            if (Schema::hasColumn('visitor', 'pass_validity')) {
                $table->dropColumn('pass_validity');
            }
        });
    }
};
