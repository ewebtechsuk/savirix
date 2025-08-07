<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class MagicLoginController extends Controller
{
    public function login($token): RedirectResponse
    {
        $user = User::where('login_token', $token)->first();
        if (!$user) {
            return redirect('/login')->withErrors(['Invalid or expired login link.']);
        }
        Auth::login($user);
        // Optionally, invalidate the token after use:
        $user->login_token = null;
        $user->save();
        return redirect('/dashboard');
    }
}
