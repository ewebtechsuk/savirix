<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard.index', [
            'agencyCount' => Agency::count(),
            'activeAgencies' => Agency::where('status', 'active')->count(),
        ]);
    }
}
