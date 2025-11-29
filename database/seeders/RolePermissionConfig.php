<?php

namespace Database\Seeders;

class RolePermissionConfig
{
    /**
     * @return array<int, string>
     */
    public static function roles(): array
    {
        return ['Admin', 'Landlord', 'Agent', 'Tenant'];
    }

    /**
     * @return array<int, string>
     */
    public static function permissions(): array
    {
        return ['view tenants'];
    }

    /**
     * @return array<string, array<int, string>>
     */
    public static function rolePermissions(): array
    {
        return [
            'Admin' => ['view tenants'],
            'Landlord' => ['view tenants'],
        ];
    }

    public static function guard(): string
    {
        return config('permission.defaults.guard', 'web');
    }
}
