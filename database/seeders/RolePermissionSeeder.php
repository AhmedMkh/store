<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dashboard\Role;
use App\Models\Dashboard\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $tableName = 'role_has_permissions';
        $permissions = Permission::all();
        $role = Role::where('name', 'admin')->first();
        foreach ($permissions as $permission) {
            DB::table($tableName)->insert([
                'permission_id' => $permission->id,
                'role_id' => $role->id
            ]);
        }
    }
}
