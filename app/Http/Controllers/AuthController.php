<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $tenant = app('tenant');

        if (! $tenant) {
            $subdomain = $request->header('X-Tenant') ?? $request->input('tenant');

            if ($subdomain) {
                $tenant = Tenant::where('slug', $subdomain)->first();
            }
        }

        if (! $tenant) {
            return response()->json(['message' => 'Tenant not resolved'], 422);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $authAttempt = Auth::attempt(array_merge($credentials, ['tenant_id' => $tenant->id]));

        if ($authAttempt) {
            $request->session()->regenerate();

            return response()->json(['ok' => true]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
