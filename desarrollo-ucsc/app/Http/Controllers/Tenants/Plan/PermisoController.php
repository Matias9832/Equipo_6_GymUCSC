<?php

namespace App\Http\Controllers\Tenants\Plan;

use App\Http\Controllers\Controller;
use App\Models\Tenants\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    /**
     * Mostrar listado de permisos.
     */
    public function index()
    {
        $permisos = Permiso::orderBy('nombre_permiso')->paginate(10);

        return view('tenants.plan.permisos.index', compact('permisos'));
    }

    /**
     * Mostrar formulario para crear nuevo permiso.
     */
    public function create()
    {
        return view('tenants.plan.permisos.create');
    }

    /**
     * Almacenar nuevo permiso.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_permiso' => 'required|string|max:100|unique:permiso,nombre_permiso',
        ]);

        Permiso::create([
            'nombre_permiso' => $request->nombre_permiso,
        ]);

        return redirect()->route('plan.permisos.index')->with('success', 'Permiso creado correctamente.');
    }
}
