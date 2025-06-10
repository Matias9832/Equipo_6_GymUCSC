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
        $permisos = Permiso::orderBy('subpermisos')
            ->orderBy('nombre_permiso')
            ->paginate(5);

        return view('tenants.plan.permisos.index', compact('permisos'));
    }

    /**
     * Mostrar formulario para crear nuevo permiso.
     */
    public function create()
    {
        $subpermisos = Permiso::select('subpermisos')->distinct()->orderBy('subpermisos')->pluck('subpermisos');
        return view('tenants.plan.permisos.create', compact('subpermisos'));
    }

    /**
     * Almacenar nuevo permiso.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_permiso' => 'required|string|max:100',
            'subpermisos' => 'nullable|string|max:100',
            'nuevo_subpermisos' => 'nullable|string|max:100',
        ]);

        $subgrupo = $request->nuevo_subpermisos ?: $request->subpermisos;

        Permiso::create([
            'nombre_permiso' => $request->nombre_permiso,
            'subpermisos' => $subgrupo,
        ]);

        return redirect()->route('plan.permisos.index')->with('success', 'Permiso creado correctamente.');
    }

    public function destroy($id)
    {
        $permiso = Permiso::findOrFail($id);
        $permiso->delete();

        return redirect()->route('plan.permisos.index')->with('success', 'Permiso eliminado correctamente.');
    }

    public function destroySubgrupo($subgrupo)
    {
        Permiso::where('subpermisos', $subgrupo)->delete();

        return redirect()->route('plan.permisos.index')->with('success', 'Grupo de permisos eliminado correctamente.');
    }

}
