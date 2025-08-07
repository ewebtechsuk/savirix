<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Only allow admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }
        return view('admin.dashboard');
    }
}
