<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dashboard\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create([
            'name' => 'الطلاب',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'اضافة طالب',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'تعديل طالب',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'حذف طالب',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'الصلاحيات',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'فريق النظام',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
