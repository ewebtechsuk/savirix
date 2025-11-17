<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgencyUserController extends Controller
{
    public function index(Agency $agency): View
    {
        return view('admin.agencies.users', [
            'agency' => $agency,
            'users' => $agency->users,
        ]);
    }

    public function store(Request $request, Agency $agency): RedirectResponse
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role', 'agent'),
            'agency_id' => $agency->id,
        ]);

        return back();
    }

    public function destroy(Agency $agency, User $user): RedirectResponse
    {
        $user->delete();

        return back();
    }
}
