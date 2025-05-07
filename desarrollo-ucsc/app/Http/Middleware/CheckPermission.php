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
        if (!auth()->user()->hasPermissionTo($permiso)) {
            return redirect()->route('admin.index')->with('error', 'No tienes permiso para acceder a esta sección.');
        }
    
        return $next($request);
    }
}