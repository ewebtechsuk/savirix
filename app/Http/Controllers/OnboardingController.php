<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    public function showRegistrationForm()
    {
        return view('onboarding.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'company' => 'required|string|unique:tenants,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $tenantId = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $request->company));
        $domain = $tenantId . '.' . parse_url(config('app.url'), PHP_URL_HOST);

        // Create tenant and database
        $tenant = Tenant::create(['id' => $tenantId]);
        $tenant->domains()->create(['domain' => $domain]);
        $tenant->createDatabase();

        // Run tenant migrations
        tenancy()->initialize($tenant);
        \Artisan::call('tenants:migrate', ['--tenants' => [$tenant->id]]);

        // Create first user for tenant
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        tenancy()->end();

        // Redirect to tenant subdomain login
        return redirect('http://' . $domain . '/login')->with('success', 'Account created! Please log in.');
    }
}
