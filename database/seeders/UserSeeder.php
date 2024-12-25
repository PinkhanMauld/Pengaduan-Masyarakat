<?php

namespace Database\Seeders;

use App\Models\StaffProvinces;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\user;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        user::create([
            'email' => 'guest@gmail.com',
            'role' => 'guest',
            'password' => Hash::make('guest890')
        ]);

        user::create([
            'email' => 'staff@gmail.com',
            'role' => 'staff',
            'password' => Hash::make('staff456')
        ]);

        user::create([
            'email' => 'headstaff@gmail.com',
            'role' => 'head_staff',
            'password' => Hash::make('hs123')
        ]);

        $headStaff = User::create([
            // 'name' => 'headjabar',
            'email' => 'headjabar2@gmail.com',
            'password' => Hash::make('head'),
            'role' => 'HEAD_STAFF'
        ]);

        StaffProvinces::create([
            'user_id' => $headStaff->id,
            'province' => 'JAWA BARAT',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
