<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $lawyer = Role::create(['name' => 'lawyer']);
        $client = Role::create(['name' => 'client']);
        $user = Role::create(['name' => 'user']);

        // Create permissions
        $permissions = [
            'manage_users',
            'manage_lawyers',
            'manage_clients',
            'manage_cases',
            'manage_blog',
            'view_dashboard',
            'view_reports',
            'manage_settings'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to super_admin
        $superAdmin->givePermissionTo(Permission::all());

        // Assign specific permissions to lawyer
        $lawyer->givePermissionTo([
            'view_dashboard',
            'manage_blog'
        ]);
    }
}
