<?php

namespace Database\Seeders\Tenancy;

use Database\Seeders\RolePermissionConfig;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TenantRolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = RolePermissionConfig::guard();

        foreach (RolePermissionConfig::permissions() as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard,
            ]);
        }

        foreach (RolePermissionConfig::roles() as $roleName) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $guard,
            ]);

            $role->syncPermissions(RolePermissionConfig::rolePermissions()[$roleName] ?? []);
        }
    }
}
