<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;
use Database\Seeders\RolePermissionConfig;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AgencyTenantRoleProvisioner
{
    public function __construct(private readonly TenantRoleSynchronizer $tenantRoleSynchronizer)
    {
    }

    public function ensureTenantAdminRoles(Tenant $tenant, User $user): void
    {
        tenancy()->initialize($tenant);

        try {
            $this->tenantRoleSynchronizer->syncInCurrentTenant();

            $tenantUser = $this->resolveTenantUser($user);
            $guard = RolePermissionConfig::guard();

            $adminRole = Role::query()->firstOrCreate([
                'name' => 'agency_admin',
                'guard_name' => $guard,
            ]);

            if (! $tenantUser->hasRole($adminRole->name)) {
                $tenantUser->assignRole($adminRole);
            }

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            Log::info('Tenant roles ensured for impersonation', [
                'tenant_id' => $tenant->getKey(),
                'agency_id' => $user->agency_id,
                'user_id' => $user->getKey(),
                'roles' => $tenantUser->getRoleNames()->all(),
            ]);
        } finally {
            tenancy()->end();
        }
    }

    protected function resolveTenantUser(User $user): User
    {
        $userModel = config('auth.providers.users.model');

        if (! is_string($userModel) || $userModel === '') {
            throw new \RuntimeException('User model is not configured for tenant context.');
        }

        $password = $user->getAuthPassword();

        if (Hash::needsRehash($password)) {
            $password = Hash::make($password);
        }

        /** @var User $tenantUser */
        $tenantUser = $userModel::query()->firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'password' => $password,
                'agency_id' => $user->agency_id,
                'role' => $user->role,
            ],
        );

        return $tenantUser;
    }
}
