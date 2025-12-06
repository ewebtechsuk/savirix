<?php

namespace Tests;

use App\Models\Property;
use App\Services\TenantProvisioner;
use Database\Seeders\RolePermissionConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_marketing_domain_does_not_expose_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertNotFound();
    }

    public function test_central_dashboard_redirects_without_initialising_tenancy(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect();

        $this->assertFalse(tenancy()->initialized);
    }

    public function test_tenant_user_can_view_dashboard_profile_and_property_show(): void
    {
        $tenantProvisioner = app(TenantProvisioner::class);

        $email = 'test-user@example.com';

        $provisioned = $tenantProvisioner->provision([
            'subdomain' => 'aktonz-' . Str::random(6),
            'name' => 'Aktonz',
            'user' => [
                'name' => 'Test User',
                'email' => $email,
                'password' => 'password',
            ],
        ]);

        $tenant = $provisioned->tenant();
        $this->assertNotNull($tenant, 'Tenant was not provisioned: ' . $provisioned->message());

        $domain = $tenant->domains()->first()->domain;

        [$user, $property] = $this->runInTenant($tenant, function () use ($email, $tenant) {
            $userModel = config('auth.providers.users.model');
            $user = $userModel::where('email', $email)->firstOrFail();

            $guard = RolePermissionConfig::guard();
            Role::query()->firstOrCreate(['name' => 'agency_admin', 'guard_name' => $guard]);
            $user->syncRoles(['agency_admin']);

            $property = Property::factory()->create(['tenant_id' => $tenant->getKey()]);

            return [$user, $property];
        });

        $this->useTenantDomain($domain);

        $response = $this->actingAs($user)->get('http://' . $domain . route('dashboard', [], false));
        $response->assertOk()
            ->assertSee('Dashboard');

        $profileResponse = $this->actingAs($user)->get('http://' . $domain . route('profile.edit', [], false));
        $profileResponse->assertOk();

        $propertyResponse = $this->actingAs($user)->get('http://' . $domain . route('properties.show', $property, false));
        $propertyResponse->assertOk();
    }

    private function runInTenant($tenant, callable $callback)
    {
        tenancy()->initialize($tenant);

        try {
            return $callback();
        } finally {
            tenancy()->end();
        }
    }
}
