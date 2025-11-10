<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Facades\Tenancy;

class DashboardController extends Controller
{
    public function index()
    {
        if (!tenant()) {
            abort(404, 'Company not found.');
        }
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('tenant.dashboard');
    }
}
