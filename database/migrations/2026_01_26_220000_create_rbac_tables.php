<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('rbac_roles')) {
            Schema::create('rbac_roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code', 50)->unique();
                $table->string('name', 100);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('rbac_permissions')) {
            Schema::create('rbac_permissions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code', 100)->unique();
                $table->string('name', 150);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('rbac_role_permissions')) {
            Schema::create('rbac_role_permissions', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id');
                $table->unsignedBigInteger('permission_id');
                $table->primary(['role_id', 'permission_id']);
                $table->index('permission_id', 'idx_rp_permission');
            });
        }

        if (!Schema::hasTable('rbac_user_roles')) {
            Schema::create('rbac_user_roles', function (Blueprint $table) {
                // account_id references department_accounts primary key (Dept_no)
                $table->unsignedBigInteger('account_id');
                $table->unsignedBigInteger('role_id');
                $table->primary(['account_id', 'role_id']);
                $table->index('role_id', 'idx_ur_role');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rbac_user_roles');
        Schema::dropIfExists('rbac_role_permissions');
        Schema::dropIfExists('rbac_permissions');
        Schema::dropIfExists('rbac_roles');
    }
};
