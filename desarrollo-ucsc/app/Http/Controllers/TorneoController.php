<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;
use App\Models\Deporte;
use App\Models\Equipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TorneoController extends Controller
{
    public function index()
    {
        $torneos = Torneo::with(['sucursal', 'deporte', 'equipos'])->get();
        return view('admin.mantenedores.torneos.index', compact('torneos'));
    }

    public function create()
    {
        $deportes = Deporte::all();
        return view('admin.mantenedores.torneos.create', compact('deportes'));
    }

    public function store(Request $request)
    {
        Log::info('Entrando al método store');

        $request->validate([
            'nombre_torneo' => 'required|string|max:255',
            'id_deporte' => 'required|exists:deportes,id_deporte',
            'tipo_competencia' => 'required|in:liga,copa,encuentro',
            'max_equipos' => 'required|integer|min:1',
        ]);

        try {
            Log::info('Validación exitosa');

            // Obtener la sucursal activa de la sesión
            $idSucursal = session('sucursal_activa');

            // Verificar si la sucursal está definida en la sesión
            if (!$idSucursal) {
                Log::error('No se encontró la sucursal activa en la sesión.');
                return redirect()->back()->withInput()->withErrors(['error' => 'No se ha seleccionado una sucursal activa.']);
            }

            Torneo::create([
                'nombre_torneo' => $request->nombre_torneo,
                'id_sucursal' => $idSucursal,
                'id_deporte' => $request->id_deporte,
                'tipo_competencia' => $request->tipo_competencia,
                'max_equipos' => $request->max_equipos,
            ]);

            Log::info('Torneo creado correctamente');

            return redirect()->route('torneos.index')->with('success', 'Torneo creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear el torneo: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Hubo un problema al crear el torneo.']);
        }
    }

    public function edit(Torneo $torneo)
    {
        $deportes = Deporte::all();
        $equipos = Equipo::where('id_deporte', $torneo->id_deporte)->get();
        return view('admin.mantenedores.torneos.edit', compact('torneo', 'equipos', 'deportes'));
    }

    public function update(Request $request, Torneo $torneo)
    {
        $request->validate([
            'nombre_torneo' => 'required|string|max:255',
            'id_deporte' => 'required|exists:deportes,id_deporte',
            'tipo_competencia' => 'required|in:liga,copa,encuentro',
            'max_equipos' => 'required|integer|min:1',
        ]);

        try {
            $torneo->update([
                'nombre_torneo' => $request->nombre_torneo,
                'id_deporte' => $request->id_deporte,
                'tipo_competencia' => $request->tipo_competencia,
                'max_equipos' => $request->max_equipos,
            ]);

            $equipos = $request->input('equipos', []);
            $torneo->equipos()->sync($equipos);

            return redirect()->route('torneos.index')->with('success', 'Torneo actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Hubo un problema al actualizar el torneo.']);
        }
    }

    public function destroy(Torneo $torneo)
    {
        try {
            $torneo->equipos()->detach();
            $torneo->delete();

            return redirect()->route('torneos.index')->with('success', 'Torneo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al eliminar el torneo.']);
        }
    }
}