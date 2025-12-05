<?php

namespace Tests\Feature\Tenancy;

use App\Models\Contact;
use App\Models\Tenant;
use Tests\TestCase;

class ContactIsolationTest extends TestCase
{
    public function test_contacts_are_isolated_per_tenant(): void
    {
        $aktonz = Tenant::factory()->create(['slug' => 'aktonz']);
        $lci = Tenant::factory()->create(['slug' => 'lci']);

        tenancy()->initialize($aktonz);
        $aktonzContact = Contact::factory()->create(['name' => 'Aktonz Contact']);
        tenancy()->end();

        tenancy()->initialize($lci);
        $lciContact = Contact::factory()->create(['name' => 'LCI Contact']);
        tenancy()->end();

        tenancy()->initialize($aktonz);
        $this->assertSame($aktonz->id, tenant()->id);
        $this->assertNotNull(Contact::find($aktonzContact->id));
        $this->assertNull(Contact::find($lciContact->id), 'LCI contact should not be visible in AKTONZ context.');
        $this->assertSame(['Aktonz Contact'], Contact::pluck('name')->all());
        tenancy()->end();

        tenancy()->initialize($lci);
        $this->assertSame($lci->id, tenant()->id);
        $this->assertNotNull(Contact::find($lciContact->id));
        $this->assertNull(Contact::find($aktonzContact->id), 'AKTONZ contact should not be visible in LCI context.');
        $this->assertSame(['LCI Contact'], Contact::pluck('name')->all());
        tenancy()->end();
    }
}
