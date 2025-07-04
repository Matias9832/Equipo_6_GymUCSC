<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarSalud
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (tenancy()->initialized && Auth::check()) {
            $usuario = Auth::user();
            if (!$usuario->salud && !$request->is('salud*')) {
                return redirect()->route('salud.create');
            }
        }

        return $next($request);
    }
}
