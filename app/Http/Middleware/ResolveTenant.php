<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResolveTenant
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        $parts = explode('.', $host);

        $subdomain = count($parts) >= 3 ? $parts[0] : null;

        if ($subdomain && ! in_array($subdomain, ['www', 'app', 'api'])) {
            $tenant = cache()->remember("tenant:$subdomain", 60, fn () =>
                Tenant::where('slug', $subdomain)->first()
            );

            if (! $tenant) {
                throw new NotFoundHttpException('Tenant not found');
            }

            app()->instance('tenant', $tenant);
        }

        return $next($request);
    }
}
