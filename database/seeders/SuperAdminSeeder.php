<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@pantau.com',
            'password' => Hash::make('password'),
            'role' => 'admin', // Or whatever role you use, but is_super_admin is key
            'is_super_admin' => true,
        ]);
    }
}
