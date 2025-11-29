<?php

namespace Tests\Unit;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasRoles;
use Tests\TestCase;

class UserAuthorizationTest extends TestCase
{
    public function test_user_uses_has_roles_trait(): void
    {
        $this->assertContains(HasRoles::class, class_uses_recursive(User::class));
    }

    public function test_user_can_be_given_permissions(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $user = User::factory()->create();

        $guardName = config('auth.defaults.guard');

        Permission::findOrCreate('test-permission', $guardName);

        $user->givePermissionTo('test-permission');

        $this->assertTrue($user->hasPermissionTo('test-permission'));
    }
}
