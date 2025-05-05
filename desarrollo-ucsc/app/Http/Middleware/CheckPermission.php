<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Manejar una solicitud entrante.
     */
    public function handle(Request $request, Closure $next, $permiso)
    {
        $administrador = Auth::user()->administrador; // Obtener el administrador autenticado

        // Verificar si el administrador tiene el permiso
        if (!$administrador || !$administrador->permisos()->where('nombre_permiso', $permiso)->exists()) {
            return redirect()->route('home')->with('error', 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}