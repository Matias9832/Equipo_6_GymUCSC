<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;
use App\Models\Deporte;
use App\Models\Equipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Partido;

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

    public function partidos(Torneo $torneo)
    {
        $partidos = \App\Models\Partido::where('torneo_id', $torneo->id)
            ->with(['local', 'visitante'])
            ->get();
    
        return view('admin.mantenedores.torneos.partidos', compact('torneo', 'partidos'));
    }

    public function actualizarPartido(Request $request, Partido $partido)
    {
        $request->validate([
            'goles_local' => 'required|integer|min:0',
            'goles_visitante' => 'required|integer|min:0',
        ]);
        $partido->update([
            'goles_local' => $request->goles_local,
            'goles_visitante' => $request->goles_visitante,
        ]);
        return back()->with('success', 'Resultado actualizado.');
    }

    public function tabla(Torneo $torneo)
    {
        // Cargar los equipos asociados al torneo utilizando la relación
        $equipos = $torneo->equipos()->get();
        $partidos = Partido::where('torneo_id', $torneo->id)->get();
    
        $tabla = [];
        foreach ($equipos as $equipo) {
            $tabla[$equipo->id] = [
                'equipo' => $equipo,
                'pj' => 0, 'pg' => 0, 'pe' => 0, 'pp' => 0, 'gf' => 0, 'gc' => 0, 'pts' => 0
            ];
        }
        foreach ($partidos as $p) {
            if ($p->goles_local !== null && $p->goles_visitante !== null) {
                $tabla[$p->equipo_local_id]['pj']++;
                $tabla[$p->equipo_visitante_id]['pj']++;
                $tabla[$p->equipo_local_id]['gf'] += $p->goles_local;
                $tabla[$p->equipo_local_id]['gc'] += $p->goles_visitante;
                $tabla[$p->equipo_visitante_id]['gf'] += $p->goles_visitante;
                $tabla[$p->equipo_visitante_id]['gc'] += $p->goles_local;
                if ($p->goles_local > $p->goles_visitante) {
                    $tabla[$p->equipo_local_id]['pg']++;
                    $tabla[$p->equipo_local_id]['pts'] += 3;
                    $tabla[$p->equipo_visitante_id]['pp']++;
                } elseif ($p->goles_local < $p->goles_visitante) {
                    $tabla[$p->equipo_visitante_id]['pg']++;
                    $tabla[$p->equipo_visitante_id]['pts'] += 3;
                    $tabla[$p->equipo_local_id]['pp']++;
                } else {
                    $tabla[$p->equipo_local_id]['pe']++;
                    $tabla[$p->equipo_local_id]['pts'] += 1;
                    $tabla[$p->equipo_visitante_id]['pe']++;
                    $tabla[$p->equipo_visitante_id]['pts'] += 1;
                }
            }
        }
        // Ordenar por puntos, diferencia de gol, goles a favor
        $tabla = collect($tabla)->sortByDesc(fn($e) => [$e['pts'], $e['gf'] - $e['gc'], $e['gf']])->values();
    
        return view('admin.mantenedores.torneos.tabla', compact('torneo', 'tabla'));
    }

    public function copa(Torneo $torneo)
    {
        $partidos = \App\Models\Partido::where('torneo_id', $torneo->id)->with(['local', 'visitante'])->get();

        // Armar los equipos y resultados para el bracket
        $equipos = [];
        $resultados = [];
        foreach ($partidos as $partido) {
            $equipos[] = [
                $partido->local ? $partido->local->nombre_equipo : 'TBD',
                $partido->visitante ? $partido->visitante->nombre_equipo : 'TBD'
            ];
            $resultados[] = [
                $partido->goles_local ?? null,
                $partido->goles_visitante ?? null
            ];
        }

        return view('admin.mantenedores.torneos.copa', compact('torneo', 'equipos', 'resultados'));
    }
    public function iniciar(Torneo $torneo)
    {
        // Evitar duplicar partidos
        if (Partido::where('torneo_id', $torneo->id)->exists()) {
            return redirect()->route('torneos.partidos', $torneo->id)->with('info', 'El torneo ya fue iniciado.');
        }

        $equipos = $torneo->equipos()->pluck('equipos.id')->toArray();

        // Verificar si hay suficientes equipos para generar los partidos
        if (count($equipos) < 2) {
            return redirect()->route('torneos.partidos', $torneo->id)->with('error', 'No hay suficientes equipos para generar los partidos.');
        }

        if ($torneo->tipo_competencia === 'liga') {
            // Todos contra todos
            foreach ($equipos as $i => $equipo1) {
                for ($j = $i + 1; $j < count($equipos); $j++) {
                    $equipo2 = $equipos[$j];
                    Partido::create([
                        'torneo_id' => $torneo->id,
                        'equipo_local_id' => $equipo1,
                        'equipo_visitante_id' => $equipo2,
                    ]);
                }
            }
        } elseif ($torneo->tipo_competencia === 'copa') {
            // Copa: cruces aleatorios (eliminación directa)
            shuffle($equipos);
            // Asegurarse de que haya un número par de equipos
            if (count($equipos) % 2 !== 0) {
                // Si hay un número impar de equipos, agregar un equipo "fantasma"
                $equipos[] = null;
            }
            for ($i = 0; $i < count($equipos); $i += 2) {
                $equipo1 = $equipos[$i];
                $equipo2 = $equipos[$i + 1] ?? null; // Usar null si no hay un segundo equipo

                // No crear partido si alguno de los equipos es null
                if ($equipo1 && $equipo2) {
                    Partido::create([
                        'torneo_id' => $torneo->id,
                        'equipo_local_id' => $equipo1,
                        'equipo_visitante_id' => $equipo2,
                    ]);
                }
            }
        }

        return redirect()->route('torneos.partidos', $torneo->id)->with('success', 'Partidos generados correctamente.');
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