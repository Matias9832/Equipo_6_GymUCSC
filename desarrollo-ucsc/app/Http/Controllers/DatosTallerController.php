<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taller;
use App\Models\HorarioTaller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatosTallerController extends Controller
{
    public function index(Request $request)
    {
        $tallerId = $request->input('taller_id');
        $mes = $request->input('mes') ?? now()->format('m');
        $anio = $request->input('anio') ?? now()->format('Y');

        // Fechas de inicio y fin del mes seleccionado
        $inicio = Carbon::createFromDate($anio, $mes, 1)->startOfMonth();
        $fin = Carbon::createFromDate($anio, $mes, 1)->endOfMonth();

        // Consulta base: solo asistencias del taller y mes/año seleccionados
        $query = DB::table('taller_usuario')
            ->join('usuario', 'usuario.id_usuario', '=', 'taller_usuario.id_usuario')
            ->leftJoin('alumno', 'usuario.rut', '=', 'alumno.rut_alumno')
            ->whereBetween('fecha_asistencia', [$inicio->toDateString(), $fin->toDateString()]);

        if ($tallerId) {
            $query->where('id_taller', $tallerId);
        }

        $asistenciasFiltradas = $query->select(
            'taller_usuario.*',
            'usuario.rut',
            'alumno.nombre_alumno',
            'alumno.apellido_paterno',
            'alumno.apellido_materno',
            'alumno.carrera',
            'alumno.ua_carrera',
            'alumno.sexo_alumno'
        )->get();

        // Asistentes por mes (total)
        $asistentesMes = $asistenciasFiltradas->count();

        // Asistencias de la semana actual
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();
        $asistenciasSemana = $asistenciasFiltradas->filter(function ($a) use ($inicioSemana, $finSemana) {
            return Carbon::parse($a->fecha_asistencia)->between($inicioSemana, $finSemana);
        })->count();

        // Asistentes por género
        $femenino = $asistenciasFiltradas->where('sexo_alumno', 'F')->count();
        $masculino = $asistenciasFiltradas->where('sexo_alumno', 'M')->count();
        $totalGenero = $femenino + $masculino;
        $porcentajeF = $totalGenero ? round(($femenino / $totalGenero) * 100, 1) : 0;
        $porcentajeM = $totalGenero ? round(($masculino / $totalGenero) * 100, 1) : 0;

        // Asistentes por carrera
        $asistenciasPorCarrera = $asistenciasFiltradas
            ->filter(fn($a) => $a->carrera)
            ->groupBy(fn($a) => $a->ua_carrera . '|' . $a->carrera);

        $totalCarrera = $asistenciasPorCarrera->flatten()->count();

        $rankingCarreras = $asistenciasPorCarrera->map(function ($asistencias, $clave) use ($totalCarrera) {
            [$ua, $carrera] = explode('|', $clave);
            $cantidad = $asistencias->count();
            $porcentaje = $totalCarrera ? round(($cantidad / $totalCarrera) * 100, 2) : 0;

            return [
                'ua' => $ua,
                'carrera' => $carrera,
                'cantidad' => $cantidad,
                'porcentaje' => $porcentaje,
            ];
        })->sortByDesc('cantidad')->values();

        $rankingCarreras = $rankingCarreras->take(8);

        // Gráfico de curva: asistentes por día (solo días con horario de taller)
        $diasConHorario = [];
        if ($tallerId) {
            $diasConHorario = HorarioTaller::where('id_taller', $tallerId)
                ->pluck('dia_taller')
                ->map(fn($dia) => strtolower($dia))
                ->unique()
                ->toArray();
        }

        $diasMes = [];
        $curvaDatos = [];
        $diasNombres = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
        for ($date = $inicio->copy(); $date->lte($fin); $date->addDay()) {
            $nombreDia = strtolower($diasNombres[$date->dayOfWeek]);
            if (in_array($nombreDia, $diasConHorario)) {
                $diasMes[] = $date->format('Y-m-d');
            }
        }
        foreach ($diasMes as $dia) {
            $curvaDatos[] = [
                'fecha' => $dia,
                'cantidad' => $asistenciasFiltradas->where('fecha_asistencia', $dia)->count()
            ];
        }

        $talleres = Taller::all();

        // Años disponibles (desde el año más antiguo en la tabla hasta el actual)
        $anioMin = DB::table('taller_usuario')->min(DB::raw('YEAR(fecha_asistencia)')) ?? now()->year;
        $anioMax = now()->year;
        $anios = range($anioMax, $anioMin);

        return view('admin.datos.talleres.index', [
            'asistentesMes' => $asistentesMes,
            'asistenciasSemana' => $asistenciasSemana,
            'femenino' => $femenino,
            'masculino' => $masculino,
            'porcentajeF' => $porcentajeF,
            'porcentajeM' => $porcentajeM,
            'rankingCarreras' => $rankingCarreras,
            'talleres' => $talleres,
            'tallerId' => $tallerId,
            'mes' => $mes,
            'anio' => $anio,
            'anios' => $anios,
            'curvaDatos' => $curvaDatos,
        ]);
    }
}