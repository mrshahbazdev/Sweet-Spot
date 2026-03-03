<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'view_dashboard', 'group' => 'Dashboard', 'description' => 'Can view the main metrics dashboard'],
            ['name' => 'manage_customers', 'group' => 'Customers', 'description' => 'Can add, edit, and delete customers'],
            ['name' => 'view_customers', 'group' => 'Customers', 'description' => 'Can view the raw customer table'],
            ['name' => 'manage_settings', 'group' => 'System', 'description' => 'Can alter system weight settings'],
            ['name' => 'manage_roles', 'group' => 'Team', 'description' => 'Can manage roles and permissions'],
            ['name' => 'manage_team', 'group' => 'Team', 'description' => 'Can invite or remove team members'],
        ];

        foreach ($permissions as $perm) {
            \App\Models\Permission::firstOrCreate(['name' => $perm['name']], $perm);
        }

        $adminRole = \App\Models\Role::firstOrCreate(['name' => 'Admin', 'description' => 'Full system access']);
        $adminRole->permissions()->sync(\App\Models\Permission::all());

        $viewerRole = \App\Models\Role::firstOrCreate(['name' => 'Viewer', 'description' => 'Read-only access']);
        $viewerRole->permissions()->sync(\App\Models\Permission::whereIn('name', ['view_dashboard', 'view_customers'])->get());
    }
}
