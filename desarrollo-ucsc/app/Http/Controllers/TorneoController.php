<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;
use App\Models\Sucursal;
use App\Models\Deporte;
use App\Models\Equipo;

class TorneoController extends Controller
{
    public function index()
    {
        $torneos = Torneo::with(['equipos', 'sucursal', 'deporte'])->get(); // Cargar relaciones necesarias
        return view('admin.mantenedores.torneos.index', compact('torneos'));
    }

    public function create()
    {
        $sucursales = Sucursal::all(); // Cargar todas las sucursales disponibles
        $deportes = Deporte::all(); // Cargar todos los deportes disponibles
        return view('admin.mantenedores.torneos.create', compact('sucursales', 'deportes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_torneo' => 'required|string|max:255',
            'id_sucursal' => 'required|exists:sucursal,id_suc',
            'id_deporte' => 'required|exists:deportes,id_deporte',
            'max_equipos' => 'required|integer|min:1',
        ]);

        Torneo::create([
            'nombre_torneo' => $request->nombre_torneo,
            'id_sucursal' => $request->id_sucursal,
            'id_deporte' => $request->id_deporte,
            'max_equipos' => $request->max_equipos,
        ]);

        return redirect()->route('torneos.index')->with('success', 'Torneo creado correctamente.');
    }

    public function edit(Torneo $torneo)
    {
        $equipos = Equipo::where('id_deporte', $torneo->id_deporte)->get(); // Cargar equipos del mismo deporte
        $sucursales = Sucursal::all(); // Cargar todas las sucursales disponibles
        return view('admin.mantenedores.torneos.edit', compact('torneo', 'equipos', 'sucursales'));
    }
    
    public function update(Request $request, Torneo $torneo)
    {
        // Validar los datos enviados desde el formulario
        $request->validate([
            'nombre_torneo' => 'required|string|max:255',
            'equipos' => 'nullable|array', // Validar que sea un array
            'equipos.*' => 'exists:equipos,id', // Validar que los equipos existan
        ]);
    
        // Actualizar el nombre del torneo
        $torneo->update([
            'nombre_torneo' => $request->nombre_torneo,
        ]);
    
        // Sincronizar los equipos seleccionados
        if ($request->has('equipos')) {
            $torneo->equipos()->sync($request->equipos);
        } else {
            $torneo->equipos()->detach(); // Si no se seleccionaron equipos, eliminar todos
        }
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('torneos.index')->with('success', 'Torneo actualizado correctamente.');
    }

    public function destroy(Torneo $torneo)
    {
        $torneo->equipos()->detach(); // Eliminar relaciones en la tabla pivote
        $torneo->delete(); // Eliminar el torneo

        return redirect()->route('torneos.index')->with('success', 'Torneo eliminado correctamente.');
    }
}