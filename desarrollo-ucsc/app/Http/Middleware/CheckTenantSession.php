<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckTenantSession
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('tenant_id')) {
            return redirect()->route('tenant-login');
        }

        return $next($request);
    }
}
