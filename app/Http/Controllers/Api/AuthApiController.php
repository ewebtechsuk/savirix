<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        $token = $user?->createToken('api-token')->plainTextToken;

        if (! $token) {
            return response()->json(['message' => 'Unable to generate API token'], 500);
        }

        return response()->json(['token' => $token]);
    }
}
