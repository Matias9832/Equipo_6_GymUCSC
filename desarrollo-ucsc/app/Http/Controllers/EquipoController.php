<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Deporte;
use App\Models\Usuario;
use App\Models\Torneo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EquipoController extends Controller
{
    public function index()
    {
        // Cargar equipos con sus deportes e integrantes
        $equipos = Equipo::with(['deporte', 'usuarios', 'capitan', 'torneos'])->get();

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
            'capitan_id' => 'required|exists:usuario,id_usuario',
            'torneos' => 'nullable|array',
            'torneos.*' => 'exists:torneos,id',
        ]);

        try {
            $equipo = Equipo::create($request->only(['nombre_equipo', 'id_deporte', 'capitan_id']));

            // Asignar torneos al equipo
            if ($request->has('torneos')) {
                $equipo->torneos()->attach($request->torneos);
            }

            // Registrar al capitán en la tabla equipo_usuario
            $equipo->usuarios()->attach($request->capitan_id);

            return redirect()->route('equipos.index')->with('success', 'Equipo creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear equipo: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al crear el equipo.']);
        }
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
            'nombre_equipo' => 'required|string|max:255',
            'usuarios' => 'nullable|array',
            'usuarios.*' => 'exists:usuario,id_usuario',
        ]);

        $deporte = $equipo->deporte;

        // Validar nombre único en los torneos del equipo
        $torneoIds = $equipo->torneos->pluck('id');
        $existe = Equipo::where('nombre_equipo', $request->nombre_equipo)
            ->whereHas('torneos', function($q) use ($torneoIds) {
                $q->whereIn('torneo_id', $torneoIds);
            })
            ->where('id', '!=', $equipo->id)
            ->exists();

        if ($existe) {
            return redirect()->back()->withInput()->withErrors([
                'nombre_equipo' => 'Ya existe un equipo con ese nombre en el torneo.',
            ]);
        }

        // Validar límite de integrantes
        if ($request->has('usuarios') && count($request->usuarios) > $deporte->jugadores_por_equipo) {
            return redirect()->back()->withInput()->withErrors([
                'usuarios' => "No se pueden seleccionar más de {$deporte->jugadores_por_equipo} jugadores para este deporte.",
            ]);
        }

        $equipo->update([
            'nombre_equipo' => $request->nombre_equipo,
        ]);

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

    public function buscar(Request $request)
    {
        $usuarios = Usuario::where('tipo_usuario', 'estudiante')
                           ->where(function ($query) use ($request) {
                               $query->where('rut', 'like', '%' . $request->q . '%')
                                     ->orWhere('nombre', 'like', '%' . $request->q . '%');
                           })
                           ->get()
                           ->map(function ($usuario) {
                               return ['id' => $usuario->id_usuario, 'text' => $usuario->rut . ' - ' . $usuario->nombre];
                           });

        return response()->json($usuarios);
    }

    public function torneosPorDeporte(Request $request)
    {
        $idDeporte = $request->input('id_deporte');
        $torneos = Torneo::where('id_deporte', $idDeporte)->get();

        return response()->json($torneos);
    }
}