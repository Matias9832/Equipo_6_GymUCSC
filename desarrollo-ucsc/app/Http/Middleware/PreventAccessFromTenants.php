<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PreventAccessFromTenants
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        // Si el host NO es el central (ej: ugym.cl) => asumimos que es un tenant
        if ($host !== 'ugym.cl' && Str::contains($host, 'ugym.cl')) {
            // \Log::info('🌐 Redirigiendo porque es tenant: ' . $host);
            return redirect()->route('news.index');
        }

        return $next($request);
    }
}
