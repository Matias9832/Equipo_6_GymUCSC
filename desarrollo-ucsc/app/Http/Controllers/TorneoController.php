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
            'fase_grupos' => 'nullable|in:0,1',
            'numero_grupos' => 'nullable|integer|min:1',
            'equipos_por_grupo' => 'nullable|integer|min:1',
            'partidos_ida_vuelta' => 'nullable|in:0,1',
            'tercer_lugar' => 'nullable|in:0,1',
        ]);
    
        // Validar que numero_grupos y equipos_por_grupo solo sean requeridos si fase_grupos es 1
        if ($request->fase_grupos == 1) {
            $request->validate([
                'numero_grupos' => 'required|integer|min:1',
                'equipos_por_grupo' => 'required|integer|min:1',
            ]);
        }
    
        try {
            Log::info('Validación exitosa');
    
            // Obtener la sucursal activa de la sesión
            $idSucursal = session('sucursal_activa');
    
            // Verificar si la sucursal está definida en la sesión
            if (!$idSucursal) {
                Log::error('No se encontró la sucursal activa en la sesión.');
                return redirect()->back()->withInput()->withErrors(['error' => 'No se ha seleccionado una sucursal activa.']);
            }
    
            $torneo = Torneo::create([
                'nombre_torneo' => $request->nombre_torneo,
                'id_sucursal' => $idSucursal,
                'id_deporte' => $request->id_deporte,
                'tipo_competencia' => $request->tipo_competencia,
                'max_equipos' => $request->max_equipos,
                'fase_grupos' => $request->fase_grupos ?? 0,
                'numero_grupos' => $request->numero_grupos ?? null,
                'equipos_por_grupo' => $request->equipos_por_grupo ?? null,
                'partidos_ida_vuelta' => $request->partidos_ida_vuelta ?? 0,
                'tercer_lugar' => $request->tercer_lugar ?? 0,
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
        $numEquipos = count($equipos);
    
        // Validar que haya al menos dos equipos
        if ($numEquipos < 2) {
            return redirect()->route('torneos.partidos', $torneo->id)->with('error', 'No hay suficientes equipos para iniciar el torneo.');
        }
    
        // Lógica para torneos tipo "copa"
        if ($torneo->tipo_competencia === 'copa') {
            $faseGrupos = $torneo->fase_grupos;
            $partidosIdaVuelta = $torneo->partidos_ida_vuelta;
            $tercerLugar = $torneo->tercer_lugar;
    
            if ($faseGrupos) {
                $numeroGrupos = $torneo->numero_grupos;
                $equiposPorGrupo = $torneo->equipos_por_grupo;
    
                // Validar que numero_grupos y equipos_por_grupo estén definidos
                if (!$numeroGrupos || !$equiposPorGrupo) {
                    return redirect()->route('torneos.partidos', $torneo->id)->with('error', 'Número de grupos y equipos por grupo deben estar definidos.');
                }
    
                // Distribuir equipos en grupos (aquí puedes implementar tu lógica de distribución)
                $grupos = array_chunk($equipos, $equiposPorGrupo);
    
                // Generar partidos dentro de cada grupo
                foreach ($grupos as $grupo) {
                    $numEquiposGrupo = count($grupo);
                    for ($i = 0; $i < $numEquiposGrupo; $i++) {
                        for ($j = $i + 1; $j < $numEquiposGrupo; $j++) {
                            $this->crearPartido($torneo->id, $grupo[$i], $grupo[$j]);
                            if ($partidosIdaVuelta) {
                                $this->crearPartido($torneo->id, $grupo[$j], $grupo[$i]);
                            }
                        }
                    }
                }
    
                // Lógica para calcular los equipos que clasifican por grupo y generar la siguiente fase
                // (Esto dependerá de cuántos equipos clasifican y cómo se organizan los cruces)
            } else {
                // Si no hay fase de grupos, generar cruces directos
                $this->generarCrucesDirectos($torneo->id, $equipos, $partidosIdaVuelta);
    
                // Si hay un número impar de equipos, agregar un equipo "fantasma"
                if ($numEquipos % 2 !== 0) {
                    // Puedes implementar aquí la lógica para manejar el equipo "fantasma"
                    // Por ejemplo, darle un "bye" automático a la siguiente ronda
                }
            }
    
            // Si se juega partido por el tercer lugar, generar el partido
            if ($tercerLugar) {
                // Aquí debes implementar la lógica para obtener los perdedores de las semifinales
                // y generar el partido por el tercer lugar
            }
        } elseif ($torneo->tipo_competencia === 'liga') {
            // Lógica para torneos tipo "liga" (todos contra todos)
            foreach ($equipos as $i => $equipo1) {
                for ($j = $i + 1; $j < $numEquipos; $j++) {
                    $equipo2 = $equipos[$j];
                    $this->crearPartido($torneo->id, $equipo1, $equipo2);
                }
            }
        }
    
        return redirect()->route('torneos.partidos', $torneo->id)->with('success', 'Partidos generados correctamente.');
    }
    
    // Función auxiliar para crear un partido
    private function crearPartido($torneoId, $equipoLocalId, $equipoVisitanteId)
    {
        Partido::create([
            'torneo_id' => $torneoId,
            'equipo_local_id' => $equipoLocalId,
            'equipo_visitante_id' => $equipoVisitanteId,
        ]);
    }
    
    // Función auxiliar para generar cruces directos
    private function generarCrucesDirectos($torneoId, $equipos, $partidosIdaVuelta)
    {
        shuffle($equipos); // Aleatorizar los equipos
        $numEquipos = count($equipos);
    
        for ($i = 0; $i < $numEquipos; $i += 2) {
            $equipo1 = $equipos[$i];
            $equipo2 = isset($equipos[$i + 1]) ? $equipos[$i + 1] : null;
    
            // Si hay un equipo "fantasma", darle un "bye"
            if (!$equipo2) {
                // Implementar aquí la lógica para el "bye"
                continue;
            }
    
            $this->crearPartido($torneoId, $equipo1, $equipo2);
            if ($partidosIdaVuelta) {
                $this->crearPartido($torneoId, $equipo2, $equipo1);
            }
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