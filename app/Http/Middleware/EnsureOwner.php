<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EnsureOwner
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isOwner()) {
            throw new HttpException(403, 'Unauthorized');
        }

        return $next($request);
    }
}
