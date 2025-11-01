<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'abdulkhalidmasood66@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $superAdmin->assignRole('super_admin');

        $this->command->info('Super Admin created successfully!');
        $this->command->info('Email: abdulkhalidmasood66@gmail.com');
        $this->command->info('Password: password');
    }
}
