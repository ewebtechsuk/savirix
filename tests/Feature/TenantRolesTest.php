<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantProvisioner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class TenantRolesTest extends TestCase
{
    use RefreshDatabase;

    public function test_impersonation_provisions_agency_admin_role_in_tenant(): void
    {
        $tenantProvisioner = app(TenantProvisioner::class);
        $provisioned = $tenantProvisioner->provision([
            'subdomain' => 'agency-' . uniqid(),
            'name' => 'London Capital Investments',
        ]);

        /** @var Tenant $tenant */
        $tenant = $provisioned->tenant();
        $this->assertNotNull($tenant);

        $domain = $tenant->domains()->first()->domain;

        $agency = Agency::create([
            'name' => 'London Capital Investments',
            'slug' => 'londoncapitalinvestments',
            'email' => 'admin@londonci.com',
            'domain' => $domain,
        ]);

        $owner = User::factory()->create([
            'email' => 'owner@savarix.com',
            'password' => Hash::make('SavarixPass123!'),
            'role' => 'owner',
        ]);

        $agencyAdmin = User::factory()->create([
            'email' => 'admin@londonci.com',
            'password' => Hash::make('TempPass123!'),
            'role' => 'agency_admin',
            'agency_id' => $agency->id,
        ]);

        tenancy()->initialize($tenant);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Role::query()->delete();
        tenancy()->end();

        $response = $this->actingAs($owner)
            ->post(route('admin.agencies.impersonate', $agency));

        $response->assertRedirect('https://' . $domain . '/dashboard');

        tenancy()->initialize($tenant);
        $tenantUser = User::where('email', $agencyAdmin->email)->first();
        $this->assertNotNull($tenantUser);
        $this->assertTrue($tenantUser->hasRole('agency_admin'));
        tenancy()->end();

        $this->useTenantDomain($domain);

        $this->actingAs($tenantUser)
            ->get('http://' . $domain . route('properties.index', [], false))
            ->assertOk();

        $this->actingAs($tenantUser)
            ->get('http://' . $domain . route('properties.create', [], false))
            ->assertOk();
    }
}
