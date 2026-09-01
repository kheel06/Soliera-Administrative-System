<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $roles = [
            ['code' => 'OWNER', 'name' => 'Owner'],
            ['code' => 'ADMIN_MANAGER', 'name' => 'Admin Manager'],
            ['code' => 'LEGAL', 'name' => 'Legal Officer'],
            ['code' => 'COMPLIANCE', 'name' => 'Compliance Lead'],
            ['code' => 'SECURITY', 'name' => 'Security Supervisor'],
            ['code' => 'FRONT_OFFICE', 'name' => 'Front Office Manager'],
        ];

        // Get current role codes
        $currentRoleCodes = array_column($roles, 'code');

        // Delete roles that are not in the new list
        DB::table('rbac_roles')->whereNotIn('code', $currentRoleCodes)->delete();

        foreach ($roles as $role) {
            $exists = DB::table('rbac_roles')->where('code', $role['code'])->exists();
            if (!$exists) {
                DB::table('rbac_roles')->insert([
                    'code' => $role['code'],
                    'name' => $role['name'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('rbac_roles')->where('code', $role['code'])->update([
                    'name' => $role['name'],
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
