<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;

class CompanyOnboardingController extends Controller
{
    public function personal()
    {
        return view('admin.companies.onboarding.personal');
    }

    public function company(Request $request)
    {
        // Validate and store personal info in session
        $request->validate([
            'first_name' => 'required',
            'surname' => 'required',
            'mobile' => 'required',
        ]);
        session(['onboarding.personal' => $request->only(['first_name', 'surname', 'mobile'])]);
        return view('admin.companies.onboarding.company');
    }

    public function users(Request $request)
    {
        // Validate and store company info in session
        $request->validate([
            'company_name' => 'required',
            'website' => 'nullable',
            'company_email' => 'required|email',
            'company_phone' => 'required',
        ]);
        session(['onboarding.company' => $request->only(['company_name', 'website', 'company_email', 'company_phone'])]);
        return view('admin.companies.onboarding.users');
    }

    public function billing(Request $request)
    {
        // Validate and store user info in session
        $request->validate([
            'user_name' => 'required',
            'user_email' => 'required|email',
            'user_password' => 'required|min:6',
        ]);
        session(['onboarding.users' => $request->only(['user_name', 'user_email', 'user_password'])]);
        return view('admin.companies.onboarding.billing');
    }

    public function store(Request $request)
    {
        // Validate and store billing info, then create company
        $request->validate([
            'card_token' => 'required',
        ]);
        $personal = session('onboarding.personal');
        $company = session('onboarding.company');
        $users = session('onboarding.users');
        // Generate a unique 4-6 digit company_id
        $company_id = '468173';
        // Create tenant
        $tenant = Tenant::create([
            'id' => strtolower(preg_replace('/\s+/', '', $company['company_name'])),
            'data' => array_merge($personal, $company, ['card_token' => $request->card_token, 'company_id' => $company_id]),
        ]);
        // Create user, billing, etc. as needed
        // ...
        // Clear session
        session()->forget(['onboarding.personal', 'onboarding.company', 'onboarding.users']);
        return redirect()->route('admin.companies.show', $tenant->id)->with('success', 'Company onboarded successfully.');
    }
}
