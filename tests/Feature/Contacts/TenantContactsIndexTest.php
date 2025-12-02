<?php

namespace Tests\Feature\Contacts;

use App\Models\Tenant;
use Tests\TestCase;

class TenantContactsIndexTest extends TestCase
{
    public function test_tenant_initialization_with_domain(): void
    {
        $tenant = Tenant::factory()->create([
            'slug' => 'aktonz',
            'data' => ['company_id' => '468173'],
        ]);

        $domain = $tenant->domains()->firstOrCreate([
            'domain' => 'aktonz.savarix.com',
        ]);

        tenancy()->initialize($tenant);

        $this->assertSame($tenant->id, tenant()->id);
        $this->assertSame('aktonz.savarix.com', $domain->domain);
    }
}
