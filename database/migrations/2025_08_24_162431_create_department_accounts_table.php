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
        if (!Schema::hasTable('department_accounts')) {
            Schema::create('department_accounts', function (Blueprint $table) {
                $table->unsignedBigInteger('Dept_no')->primary();
                $table->string('Dept_id')->nullable();
                $table->string('dept_name')->nullable();
                $table->string('employee_name');
                $table->string('employee_id')->nullable();
                $table->string('role')->nullable();
                $table->string('email')->nullable();
                $table->string('status')->default('active');
                $table->string('password');
                $table->rememberToken();
            });
        } else {
            // Table exists, add missing columns if needed
            Schema::table('department_accounts', function (Blueprint $table) {
                if (!Schema::hasColumn('department_accounts', 'Dept_no')) {
                    $table->unsignedBigInteger('Dept_no')->primary()->first();
                }
                if (!Schema::hasColumn('department_accounts', 'Dept_id')) {
                    $table->string('Dept_id')->nullable()->after('Dept_no');
                }
                if (!Schema::hasColumn('department_accounts', 'dept_name')) {
                    $table->string('dept_name')->nullable()->after('Dept_id');
                }
                if (!Schema::hasColumn('department_accounts', 'employee_name')) {
                    $table->string('employee_name')->after('dept_name');
                }
                if (!Schema::hasColumn('department_accounts', 'employee_id')) {
                    $table->string('employee_id')->nullable()->after('employee_name');
                }
                if (!Schema::hasColumn('department_accounts', 'role')) {
                    $table->string('role')->nullable()->after('employee_id');
                }
                if (!Schema::hasColumn('department_accounts', 'email')) {
                    $table->string('email')->nullable()->after('role');
                }
                if (!Schema::hasColumn('department_accounts', 'status')) {
                    $table->string('status')->default('active')->after('email');
                }
                if (!Schema::hasColumn('department_accounts', 'password')) {
                    $table->string('password')->after('status');
                }
                if (!Schema::hasColumn('department_accounts', 'remember_token')) {
                    $table->rememberToken()->after('password');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_accounts');
    }
};
