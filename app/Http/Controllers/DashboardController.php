<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get all tenants, handle if none exist
        try {
            $tenants = Tenant::all();
        } catch (\Exception $e) {
            $tenants = collect();
        }
        return view('dashboard.index', compact('tenants'));
    }

    public function store(Request $request)
    {
        // TODO: implement dashboard storage logic
    }

    public function destroy($id)
    {
        // TODO: implement dashboard deletion logic
    }

    public function impersonate($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        // Find the admin user for this tenant in the central users table
        $admin = \App\Models\User::where('tenant_id', $tenant->id)->where('is_admin', true)->first();
        if (!$admin) {
            return redirect()->route('dashboard.index')->with('error', 'No admin user found for this tenant.');
        }
        auth()->login($admin);
        tenancy()->initialize($tenant);
        return redirect()->to('/dashboard'); // Redirect to tenant dashboard
    }
}
