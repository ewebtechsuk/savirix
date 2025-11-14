<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AktonzTenantLoginTest extends TestCase
{
    public function test_aktonz_admin_can_log_in_via_tenant_domain(): void
    {
        $tenant = Tenant::factory()->create([
            'id' => 'aktonz',
            'name' => 'Aktonz Estate Agents',
            'data' => [
                'slug' => 'aktonz',
                'company_name' => 'Aktonz Estate Agents',
                'company_email' => 'info@aktonz.com',
                'company_id' => '468173',
                'domains' => ['aktonz.savarix.com'],
            ],
        ]);

        $tenant->domains()->create(['domain' => 'aktonz.savarix.com']);

        $user = User::factory()->create([
            'email' => 'info@aktonz.com',
            'password' => Hash::make('AktonzTempPass123!'),
            'is_admin' => true,
        ]);

        $session = $this->app['session'];
        $session->start();
        $token = $session->token();

        $response = $this->withServerVariables([
            'HTTP_HOST' => 'aktonz.savarix.com',
        ])->withSession(['_token' => $token])
            ->from('https://aktonz.savarix.com/login')
            ->post('https://aktonz.savarix.com/login', [
                '_token' => $token,
                'email' => 'info@aktonz.com',
                'password' => 'AktonzTempPass123!',
            ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user, 'web');
    }
}
