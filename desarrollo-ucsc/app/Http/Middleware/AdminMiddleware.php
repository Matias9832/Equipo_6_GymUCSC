<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->tipo_usuario === 'admin') {
            return $next($request);
        }

        // Redirigir si no es administrador
        return redirect('/')->with('error', 'No tienes acceso a esta sección.');
    }
}