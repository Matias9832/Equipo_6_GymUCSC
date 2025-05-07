<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Deporte;
use App\Models\Usuario;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        // Cargar equipos con sus deportes e integrantes
        $equipos = Equipo::with(['deporte', 'usuarios'])->get();

        return view('admin.mantenedores.equipos.index', compact('equipos'));
    }

    public function create()
    {
        $deportes = Deporte::all();
        return view('admin.mantenedores.equipos.create', compact('deportes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_equipo' => 'required|string|max:255',
            'id_deporte' => 'required|exists:deportes,id_deporte',
        ]);

        Equipo::create($request->only(['nombre_equipo', 'id_deporte']));

        return redirect()->route('equipos.index')->with('success', 'Equipo creado correctamente.');
    }

    public function edit(Equipo $equipo)
    {
        $deporte = $equipo->deporte;
        $usuarios = Usuario::all(); // Cargar todos los usuarios disponibles
        return view('admin.mantenedores.equipos.edit', compact('equipo', 'deporte', 'usuarios'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'usuarios' => 'nullable|array',
            'usuarios.*' => 'exists:usuario,id_usuario', // Cambiar a la tabla y clave primaria correctas
        ]);

        $deporte = $equipo->deporte;

        // Validar que no se seleccionen más usuarios que el límite permitido por el deporte
        if ($request->has('usuarios') && count($request->usuarios) > $deporte->jugadores_por_equipo) {
            return redirect()->back()->withErrors([
                'usuarios' => "No se pueden seleccionar más de {$deporte->jugadores_por_equipo} jugadores para este deporte.",
            ]);
        }

        // Sincronizar los usuarios seleccionados con el equipo
        if ($request->has('usuarios')) {
            $equipo->usuarios()->sync($request->usuarios);
        } else {
            $equipo->usuarios()->detach();
        }

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado correctamente.');
    }
    public function destroy(Equipo $equipo)
    {
        // Eliminar las relaciones del equipo con los usuarios
        $equipo->usuarios()->detach();

        // Eliminar el equipo
        $equipo->delete();

        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado correctamente.');
    }
}