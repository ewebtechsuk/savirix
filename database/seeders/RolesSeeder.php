<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'Landlord', 'Agent', 'Tenant'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $viewTenants = Permission::firstOrCreate(['name' => 'view tenants']);

        foreach (['Admin', 'Landlord'] as $role) {
            Role::findByName($role)->givePermissionTo($viewTenants);
        }
    }
}
