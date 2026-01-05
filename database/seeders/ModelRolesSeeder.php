<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dashboard\Admin;
use App\Models\Dashboard\Role;
use Illuminate\Support\Facades\DB;

class ModelRolesSeeder extends Seeder
{
    public function run()
    {
        $tableName = 'model_has_roles';

        $admin = Admin::where('name', 'Admin')->first();
        $role = Role::where('name', 'admin')->first();
        DB::table($tableName)->insert([
            'role_id' => $role->id,
            'model_type' => Admin::class,
            'model_id' => $admin->id
        ]);
    }


}
