<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dashboard\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123123'),
            'roles_name' => 'admin',
            'status' => '1',
        ]);

        Admin::create([
            'name' => 'Mohammed',
            'email' => 'mohammed@gmail.com',
            'password' => Hash::make('123123123'),
            'roles_name' => 'اضافة طلاب',
            'status' => '1',
        ]);
    }
}
