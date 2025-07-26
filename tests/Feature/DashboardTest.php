<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginPageLoads()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testDashboardRequiresAuthentication()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function testAuthenticatedUserCanSeeDashboard()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }
}
