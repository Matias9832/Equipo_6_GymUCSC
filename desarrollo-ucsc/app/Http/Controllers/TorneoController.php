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
            'max_equipos' => 'required|integer|min:2',
        ]);

        if ($request->tipo_competencia === 'copa') {
            $faseGrupos = $request->fase_grupos ?? 0;

            if ($faseGrupos == 1) {
                $request->validate([
                    'numero_grupos' => 'required|integer|min:1',
                    'clasifican_por_grupo' => 'required|integer|min:1',
                ]);

                // Calcular equipos por grupo
                if ($request->max_equipos % $request->numero_grupos !== 0) {
                    return back()->withInput()->withErrors([
                        'numero_grupos' => 'El número de grupos debe dividir exactamente el máximo de equipos.'
                    ]);
                }
                $equiposPorGrupo = $request->max_equipos / $request->numero_grupos;

                // Validar clasificados por grupo
                if ($request->clasifican_por_grupo > $equiposPorGrupo) {
                    return back()->withInput()->withErrors([
                        'clasifican_por_grupo' => 'No pueden clasificar más equipos de los que hay en el grupo.'
                    ]);
                }
                if ($request->clasifican_por_grupo == $equiposPorGrupo) {
                    return back()->withInput()->withErrors([
                        'clasifican_por_grupo' => 'No tiene sentido que clasifiquen todos los equipos del grupo.'
                    ]);
                }
                if ($request->numero_grupos == 1) {
                    return back()->withInput()->withErrors([
                        'numero_grupos' => 'Si solo hay un grupo, considera usar el formato "liga".'
                    ]);
                }
            } else {
                if (!in_array($request->max_equipos, [2,4,8,16,32,64])) {
                    return back()->withInput()->withErrors([
                        'max_equipos' => 'Para copa sin grupos, la cantidad de equipos debe ser potencia de 2 (2, 4, 8, 16, ...).'
                    ]);
                }
            }
        }

        try {
            Log::info('Validación exitosa');

            $idSucursal = session('sucursal_activa');
            if (!$idSucursal) {
                Log::error('No se encontró la sucursal activa en la sesión.');
                return redirect()->back()->withInput()->withErrors(['error' => 'No se ha seleccionado una sucursal activa.']);
            }

            // Calcular equipos_por_grupo solo si hay fase de grupos
            $equiposPorGrupo = null;
            if ($request->tipo_competencia === 'copa' && ($request->fase_grupos ?? 0) == 1) {
                $equiposPorGrupo = $request->max_equipos / $request->numero_grupos;
            }

            $torneo = Torneo::create([
                'nombre_torneo' => $request->nombre_torneo,
                'id_sucursal' => $idSucursal,
                'id_deporte' => $request->id_deporte,
                'tipo_competencia' => $request->tipo_competencia,
                'max_equipos' => $request->max_equipos,
                'fase_grupos' => $request->fase_grupos ?? 0,
                'numero_grupos' => $request->numero_grupos ?? null,
                'equipos_por_grupo' => $equiposPorGrupo,
                'clasifican_por_grupo' => $request->clasifican_por_grupo ?? null,
                'partidos_ida_vuelta' => $request->partidos_ida_vuelta ?? 0,
                'tercer_lugar' => $request->tercer_lugar ?? 0,
            ]);

            if (!$torneo) {
                Log::error('No se pudo crear el torneo en la base de datos.');
                return redirect()->back()->withInput()->withErrors(['error' => 'Hubo un error al crear el torneo. Intenta nuevamente.']);
            }

            Log::info('Torneo creado correctamente');

            return redirect()->route('torneos.index')->with('success', 'Torneo creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear el torneo: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Hubo un error al crear el torneo. Intenta nuevamente.']);
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
            ->orderBy('ronda')
            ->get();

        // Agrupar partidos por ronda
        $partidosPorRonda = $partidos->groupBy('ronda');
        $fechas = $partidosPorRonda->keys()->sort()->values();
        $totalFechas = $fechas->count();

        // Determinar ronda actual (la menor ronda con partidos sin resultado)
        $rondaActual = null;
        foreach ($partidosPorRonda as $ronda => $partidosDeRonda) {
            $incompletos = $partidosDeRonda->filter(function($p) {
                return $p->resultado_local === null || $p->resultado_visitante === null;
            });
            if ($incompletos->count() > 0) {
                $rondaActual = $ronda;
                break;
            }
        }

        // Determinar ronda seleccionada
        $rondaSeleccionada = request('ronda');
        if (!$rondaSeleccionada) {
            $rondaSeleccionada = $rondaActual ?? ($fechas->first() ?? 1);
        }
        $rondaSeleccionada = intval($rondaSeleccionada);

        $indiceActual = $fechas->search($rondaSeleccionada);
        $rondaAnterior = $indiceActual > 0 ? $fechas[$indiceActual - 1] : null;
        $rondaSiguiente = $indiceActual !== false && $indiceActual < $fechas->count() - 1 ? $fechas[$indiceActual + 1] : null;

        $finalizada = isset($partidosPorRonda[$rondaSeleccionada]) && $partidosPorRonda[$rondaSeleccionada]->first()->finalizada;

        // Determinar etapa
        $etapa = '';
        if ($torneo->fase_grupos) {
            $totalFechasGrupos = $torneo->equipos_por_grupo - 1;
            if ($rondaSeleccionada <= $totalFechasGrupos) {
                $etapa = 'Fase de Grupos';
            } else {
                $etapa = 'Eliminatoria';
            }
        } else {
            $etapa = 'Liga';
        }

        // Mostrar vista según tipo de usuario
        if (Auth::user()->hasRole('admin')) {
            return view('admin.mantenedores.torneos.partidos', compact(
                'torneo', 'partidos', 'partidosPorRonda', 'fechas', 'rondaSeleccionada', 'rondaAnterior', 'rondaSiguiente', 'finalizada', 'etapa'
            ));
        } else {
            return view('usuarios.torneos.usuario_partidos', compact(
                'torneo', 'partidosPorRonda', 'fechas', 'rondaSeleccionada', 'rondaAnterior', 'rondaSiguiente', 'etapa'
            ));
        }
    }

    public function actualizarPartido(Request $request, Partido $partido)
    {
        $request->validate([
            'resultado_local' => 'nullable|string|max:255',
            'resultado_visitante' => 'nullable|string|max:255',
        ]);
        $partido->update([
            'resultado_local' => $request->resultado_local,
            'resultado_visitante' => $request->resultado_visitante,
        ]);
        return back()->with('success', 'Resultado actualizado.');
    }

    public function tabla(Torneo $torneo)
    {
        $equipos = $torneo->equipos()->get();
        $partidos = \App\Models\Partido::where('torneo_id', $torneo->id)->get();

        $tabla = [];
        foreach ($equipos as $equipo) {
            $tabla[$equipo->id] = [
                'equipo' => $equipo,
                'pj' => 0, 'pg' => 0, 'pe' => 0, 'pp' => 0,
                'gf' => 0, 'gc' => 0, 'pts' => 0,
            ];
        }
        foreach ($partidos as $p) {
            if (is_numeric($p->resultado_local) && is_numeric($p->resultado_visitante)) {
                $tabla[$p->equipo_local_id]['pj']++;
                $tabla[$p->equipo_visitante_id]['pj']++;
                $tabla[$p->equipo_local_id]['gf'] += $p->resultado_local;
                $tabla[$p->equipo_local_id]['gc'] += $p->resultado_visitante;
                $tabla[$p->equipo_visitante_id]['gf'] += $p->resultado_visitante;
                $tabla[$p->equipo_visitante_id]['gc'] += $p->resultado_local;

                if ($p->resultado_local > $p->resultado_visitante) {
                    $tabla[$p->equipo_local_id]['pg']++;
                    $tabla[$p->equipo_local_id]['pts'] += 3;
                    $tabla[$p->equipo_visitante_id]['pp']++;
                } elseif ($p->resultado_local < $p->resultado_visitante) {
                    $tabla[$p->equipo_visitante_id]['pg']++;
                    $tabla[$p->equipo_visitante_id]['pts'] += 3;
                    $tabla[$p->equipo_local_id]['pp']++;
                } else {
                    $tabla[$p->equipo_local_id]['pe']++;
                    $tabla[$p->equipo_local_id]['pts']++;
                    $tabla[$p->equipo_visitante_id]['pe']++;
                    $tabla[$p->equipo_visitante_id]['pts']++;
                }
            }
        }
        $tabla = collect($tabla)->sortByDesc(fn($e) => [$e['pts'], $e['gf'] - $e['gc'], $e['gf']])->values();

        if (Auth::user()->hasRole('admin')) {
            return view('admin.mantenedores.torneos.tabla', compact('torneo', 'tabla'));
        } else {
            return view('usuarios.torneos.usuario_tabla', compact('torneo', 'tabla'));
        }
    }

    public function copa(Torneo $torneo)
    {
        $partidos = \App\Models\Partido::where('torneo_id', $torneo->id)
            ->where('etapa', 'eliminatoria')
            ->orderBy('ronda')
            ->get()
            ->groupBy('ronda')
            ->sortKeys();

        $primerRonda = $partidos->keys()->first();
        $teams   = [];
        $results = [];

        foreach ($partidos as $ronda => $matches) {
            if ($ronda == $primerRonda) {
                foreach ($matches as $m) {
                    $teams[] = [
                        $m->local ? $m->local->nombre_equipo : 'Sin equipo',
                        $m->visitante ? $m->visitante->nombre_equipo : 'Sin equipo'
                    ];
                }
            }
            $row = [];
            foreach ($matches as $m) {
                $row[] = [
                    is_numeric($m->resultado_local) ? (int)$m->resultado_local : null,
                    is_numeric($m->resultado_visitante) ? (int)$m->resultado_visitante : null
                ];
            }
            $results[] = $row;
        }

        // Mostrar vista según tipo de usuario
        if (Auth::user()->hasRole('admin')) {
            return view('admin.mantenedores.torneos.copa', compact('torneo','teams','results'));
        } else {
            return view('usuarios.torneos.usuario_copa', compact('torneo','teams','results'));
        }
    }



    public function iniciar(Torneo $torneo)
    {
        // Evitar duplicar partidos
        if (Partido::where('torneo_id', $torneo->id)->exists()) {
            return redirect()->route('torneos.partidos', $torneo->id)->with('info', 'El torneo ya fue iniciado.');
        }

        $equipos = $torneo->equipos()->pluck('equipos.id')->toArray();
        $numEquipos = count($equipos);

        if ($numEquipos < 2) {
            return redirect()->route('torneos.partidos', $torneo->id)->with('error', 'No hay suficientes equipos para iniciar el torneo.');
        }

        if ($torneo->tipo_competencia === 'copa') {
            if ($torneo->fase_grupos) {
                // Fase de grupos: round robin por grupo
                $numeroGrupos = $torneo->numero_grupos;
                $equiposPorGrupo = $torneo->equipos_por_grupo;
                $grupos = array_chunk($equipos, $equiposPorGrupo);

                foreach ($grupos as $grupoIdx => $grupo) {
                    $this->generarRoundRobin($torneo->id, $grupo, $grupoIdx, 'fase_grupos');
                }
            } else {
                // Eliminatoria directa desde el inicio
                if (!$this->esPotenciaDe2($numEquipos)) {
                    return redirect()->route('torneos.partidos', $torneo->id)->with('error', 'La cantidad de equipos debe ser potencia de 2 para copa sin grupos.');
                }
                $this->generarCrucesDirectos($torneo->id, $equipos, $torneo->partidos_ida_vuelta, 'eliminatoria');
            }
        } elseif ($torneo->tipo_competencia === 'liga') {
            $this->generarRoundRobin($torneo->id, $equipos, 0, 'liga');
        }

        return redirect()->route('torneos.partidos', $torneo->id)->with('success', 'Partidos generados correctamente.');
    }


        private function esPotenciaDe2($n)
    {
        return $n > 0 && ($n & ($n - 1)) === 0;
    }
    
    // Algoritmo round robin para un grupo
    private function generarRoundRobin($torneoId, $grupo, $grupoIdx = 0, $etapa = 'liga')
    {
        $n = count($grupo);
        $equipos = array_values($grupo);

        if ($n % 2 !== 0) {
            $equipos[] = null;
            $n++;
        }

        $rondas = $n - 1;
        $mitad = $n / 2;

        for ($ronda = 1; $ronda <= $rondas; $ronda++) {
            for ($i = 0; $i < $mitad; $i++) {
                $local = $equipos[$i];
                $visitante = $equipos[$n - 1 - $i];
                if ($local !== null && $visitante !== null) {
                    // PASA $etapa aquí
                    $this->crearPartido($torneoId, $local, $visitante, $ronda, $etapa);
                }
            }
            // Rotar equipos (excepto el primero)
            $primer = array_shift($equipos);
            $ultimo = array_pop($equipos);
            array_unshift($equipos, $primer);
            array_splice($equipos, 1, 0, [$ultimo]);
        }
    }
    
    // Función auxiliar para crear un partido
    private function crearPartido($torneoId, $equipoLocalId, $equipoVisitanteId, $ronda = null, $etapa = 'liga')
    {
        if (!$equipoLocalId || !$equipoVisitanteId) return;

        $existe = \App\Models\Partido::where('torneo_id', $torneoId)
            ->where('equipo_local_id', $equipoLocalId)
            ->where('equipo_visitante_id', $equipoVisitanteId)
            ->where('ronda', $ronda)
            ->where('etapa', $etapa)
            ->exists();

        if (!$existe) {
            \App\Models\Partido::create([
                'torneo_id' => $torneoId,
                'equipo_local_id' => $equipoLocalId,
                'equipo_visitante_id' => $equipoVisitanteId,
                'ronda' => $ronda,
                'etapa' => $etapa,
            ]);
        }
    }

    // Crea partido por el tercer lugar si corresponde
    private function crearPartidoTercerLugar($torneoId, $equipo1, $equipo2, $ronda, $etapa)
    {
        // El partido de tercer lugar se marca con ronda igual a la final y etapa 'eliminatoria'
        $this->crearPartido($torneoId, $equipo1, $equipo2, $ronda, $etapa);
    }

    // Función auxiliar para generar cruces directos
    private function generarCrucesDirectos($torneoId, $equipos, $partidosIdaVuelta, $etapa = 'eliminatoria')
    {
        shuffle($equipos);
        $numEquipos = count($equipos);

        for ($i = 0; $i < $numEquipos; $i += 2) {
            $equipo1 = $equipos[$i];
            $equipo2 = isset($equipos[$i + 1]) ? $equipos[$i + 1] : null;
            if (!$equipo2) {
                continue;
            }
            $this->crearPartido($torneoId, $equipo1, $equipo2, 1, $etapa);
            if ($partidosIdaVuelta) {
                $this->crearPartido($torneoId, $equipo2, $equipo1, 1, $etapa);
            }
        }
    }

    public function faseGrupos(Torneo $torneo)
    {
        // Obtener los equipos y agruparlos
        $equipos = $torneo->equipos()->pluck('equipos.id')->toArray();
        $equiposPorGrupo = $torneo->equipos_por_grupo;
        $grupos = array_chunk($equipos, $equiposPorGrupo);

        // Obtener los modelos de equipos por grupo
        $equiposPorGrupoModel = [];
        foreach ($grupos as $grupo) {
            $equiposPorGrupoModel[] = \App\Models\Equipo::whereIn('id', $grupo)->get();
        }

        // Obtener los partidos y agruparlos por grupo
        $partidos = \App\Models\Partido::where('torneo_id', $torneo->id)->get();
        $partidosPorGrupo = [];
        foreach ($grupos as $idx => $grupo) {
            $partidosPorGrupo[$idx] = $partidos->filter(function ($p) use ($grupo) {
                return in_array($p->equipo_local_id, $grupo) && in_array($p->equipo_visitante_id, $grupo);
            });
        }

        // Calcular tabla de posiciones por grupo
        $tablas = [];
        foreach ($equiposPorGrupoModel as $idx => $equiposGrupo) {
            $tabla = [];
            foreach ($equiposGrupo as $equipo) {
                $tabla[$equipo->id] = [
                    'equipo' => $equipo,
                    'pj' => 0, 'pg' => 0, 'pe' => 0, 'pp' => 0,
                    'gf' => 0, 'gc' => 0, 'pts' => 0,
                ];
            }
            foreach ($partidosPorGrupo[$idx] as $p) {
                if (is_numeric($p->resultado_local) && is_numeric($p->resultado_visitante)) {
                    $tabla[$p->equipo_local_id]['pj']++;
                    $tabla[$p->equipo_visitante_id]['pj']++;
                    $tabla[$p->equipo_local_id]['gf'] += $p->resultado_local;
                    $tabla[$p->equipo_local_id]['gc'] += $p->resultado_visitante;
                    $tabla[$p->equipo_visitante_id]['gf'] += $p->resultado_visitante;
                    $tabla[$p->equipo_visitante_id]['gc'] += $p->resultado_local;

                    if ($p->resultado_local > $p->resultado_visitante) {
                        $tabla[$p->equipo_local_id]['pg']++;
                        $tabla[$p->equipo_local_id]['pts'] += 3;
                        $tabla[$p->equipo_visitante_id]['pp']++;
                    } elseif ($p->resultado_local < $p->resultado_visitante) {
                        $tabla[$p->equipo_visitante_id]['pg']++;
                        $tabla[$p->equipo_visitante_id]['pts'] += 3;
                        $tabla[$p->equipo_local_id]['pp']++;
                    } else {
                        $tabla[$p->equipo_local_id]['pe']++;
                        $tabla[$p->equipo_local_id]['pts']++;
                        $tabla[$p->equipo_visitante_id]['pe']++;
                        $tabla[$p->equipo_visitante_id]['pts']++;
                    }
                }
            }
            // Ordenar por puntos, diferencia de goles, goles a favor
            $tablas[$idx] = collect($tabla)->sortByDesc(fn($e) => [$e['pts'], $e['gf'] - $e['gc'], $e['gf']])->values();
        }

        if (Auth::user()->hasRole('admin')) {
            return view('admin.mantenedores.torneos.fase_grupos', compact('torneo', 'tablas'));
        } else {
            return view('usuarios.torneos.usuario_fase_grupos', compact('torneo', 'tablas'));
        }
    }

    // Finaliza una fecha/ronda del torneo
    public function finalizarFecha(Request $request, Torneo $torneo)
    {
        $ronda = $request->input('ronda');
        // Marcar la fecha como finalizada
        \App\Models\Partido::where('torneo_id', $torneo->id)
            ->where('ronda', $ronda)
            ->update(['finalizada' => true]);

        // Si es fase de grupos, verifica si es la última fecha
        if ($torneo->tipo_competencia === 'copa' && $torneo->fase_grupos) {
            $totalFechas = $torneo->equipos_por_grupo - 1;
            if ($ronda == $totalFechas) {
                $this->generarEliminacionDirecta($torneo);
                $torneo->fase_grupos_finalizada = true;
                $torneo->save();
            }
        }

        // --- Generar siguiente ronda de eliminatoria ---
        $partidosEliminatoria = \App\Models\Partido::where('torneo_id', $torneo->id)
            ->where('etapa', 'eliminatoria')
            ->where('ronda', $ronda)
            ->get();

        if ($partidosEliminatoria->count() > 0) {
            $todosConResultado = $partidosEliminatoria->every(function($p) {
                return is_numeric($p->resultado_local) && is_numeric($p->resultado_visitante);
            });

            if ($todosConResultado) {
                $ganadores = [];
                $perdedores = [];
                foreach ($partidosEliminatoria as $p) {
                    if ($p->resultado_local > $p->resultado_visitante) {
                        $ganadores[] = $p->equipo_local_id;
                        $perdedores[] = $p->equipo_visitante_id;
                    } elseif ($p->resultado_local < $p->resultado_visitante) {
                        $ganadores[] = $p->equipo_visitante_id;
                        $perdedores[] = $p->equipo_local_id;
                    }
                    // Si hay empate, no se permite (debe ingresar resultado definitivo)
                }

                $nextRonda = $ronda + 1;
                // Si quedan 2 ganadores, es la final
                if (count($ganadores) == 2) {
                    $this->crearPartido($torneo->id, $ganadores[0], $ganadores[1], $nextRonda, 'eliminatoria');
                    // Tercer lugar
                    if ($torneo->tercer_lugar && count($perdedores) == 2) {
                        $this->crearPartidoTercerLugar($torneo->id, $perdedores[0], $perdedores[1], $nextRonda, 'eliminatoria');
                    }
                } elseif (count($ganadores) > 2) {
                    // Siguiente ronda normal
                    for ($i = 0; $i < count($ganadores); $i += 2) {
                        if (isset($ganadores[$i + 1])) {
                            $this->crearPartido($torneo->id, $ganadores[$i], $ganadores[$i + 1], $nextRonda, 'eliminatoria');
                        }
                    }
                }
                // Si solo hay 1 ganador, torneo terminó
            }
        }

        return back()->with('success', "Fecha $ronda finalizada.");
    }

    // Genera los partidos de eliminación directa según los clasificados
    private function generarEliminacionDirecta(Torneo $torneo)
    {
        $clasificados = [];
        $equipos = $torneo->equipos()->pluck('equipos.id')->toArray();
        $equiposPorGrupo = $torneo->equipos_por_grupo;
        $numeroGrupos = $torneo->numero_grupos;
        $clasificanPorGrupo = $torneo->clasifican_por_grupo;

        // Obtener los grupos
        $grupos = array_chunk($equipos, $equiposPorGrupo);

        // Para cada grupo, obtener los mejores N equipos
        foreach ($grupos as $idx => $grupo) {
            // Calcular tabla de posiciones para este grupo
            $tabla = [];
            foreach ($grupo as $equipoId) {
                $tabla[$equipoId] = [
                    'equipo_id' => $equipoId,
                    'pts' => 0, 'gf' => 0, 'gc' => 0, 'dif' => 0
                ];
            }
            $partidos = \App\Models\Partido::where('torneo_id', $torneo->id)
                ->where('ronda', '<=', $torneo->equipos_por_grupo - 1)
                ->whereIn('equipo_local_id', $grupo)
                ->whereIn('equipo_visitante_id', $grupo)
                ->get();

            foreach ($partidos as $p) {
                if (is_numeric($p->resultado_local) && is_numeric($p->resultado_visitante)) {
                    $tabla[$p->equipo_local_id]['gf'] += $p->resultado_local;
                    $tabla[$p->equipo_local_id]['gc'] += $p->resultado_visitante;
                    $tabla[$p->equipo_local_id]['dif'] = $tabla[$p->equipo_local_id]['gf'] - $tabla[$p->equipo_local_id]['gc'];
                    $tabla[$p->equipo_visitante_id]['gf'] += $p->resultado_visitante;
                    $tabla[$p->equipo_visitante_id]['gc'] += $p->resultado_local;
                    $tabla[$p->equipo_visitante_id]['dif'] = $tabla[$p->equipo_visitante_id]['gf'] - $tabla[$p->equipo_visitante_id]['gc'];
                    if ($p->resultado_local > $p->resultado_visitante) {
                        $tabla[$p->equipo_local_id]['pts'] += 3;
                    } elseif ($p->resultado_local < $p->resultado_visitante) {
                        $tabla[$p->equipo_visitante_id]['pts'] += 3;
                    } else {
                        $tabla[$p->equipo_local_id]['pts'] += 1;
                        $tabla[$p->equipo_visitante_id]['pts'] += 1;
                    }
                }
            }
            // Ordenar por puntos, diferencia, goles a favor
            $tabla = collect($tabla)->sortByDesc(fn($e) => [$e['pts'], $e['dif'], $e['gf']])->values();
            // Tomar los N primeros
            $clasificados = array_merge($clasificados, $tabla->take($clasificanPorGrupo)->pluck('equipo_id')->toArray());
        }

        // Emparejamiento: 1° grupo A vs 2° grupo B, 1° grupo B vs 2° grupo A, etc.
        // Por defecto, empareja en orden
        $totalClasificados = count($clasificados);
        $ronda = $torneo->equipos_por_grupo; // primera ronda eliminatoria después de grupos
        for ($i = 0; $i < $totalClasificados; $i += 2) {
            if (isset($clasificados[$i + 1])) {
                $this->crearPartido(
                    $torneo->id,
                    $clasificados[$i],
                    $clasificados[$i + 1],
                    $ronda,
                    'eliminatoria'
                );
            }
        }
    }

    public function reiniciar(Torneo $torneo)
    {
        // Borra todos los partidos del torneo
        Partido::where('torneo_id', $torneo->id)->delete();

        // Si tienes campos de estado en el torneo, puedes reiniciarlos aquí
        $torneo->fase_grupos_finalizada = false;
        $torneo->save();

        return redirect()->route('torneos.partidos', $torneo->id)->with('success', 'Torneo reiniciado correctamente. Ahora puedes iniciarlo de nuevo.');
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