<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
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
        $curvaDatos = [];
        $diasNombres = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];

        if ($tallerId) {
            // Solo días con horario de ese taller
            $diasConHorario = HorarioTaller::where('id_taller', $tallerId)
                ->pluck('dia_taller')
                ->map(fn($dia) => strtolower($dia))
                ->unique()
                ->toArray();

            $diasMes = [];
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
        } else {
            // TODOS los talleres: muestra todos los días del mes donde hubo al menos una asistencia
            $diasConAsistencia = $asistenciasFiltradas->pluck('fecha_asistencia')->unique()->sort()->values();
            foreach ($diasConAsistencia as $dia) {
                $curvaDatos[] = [
                    'fecha' => $dia,
                    'cantidad' => $asistenciasFiltradas->where('fecha_asistencia', $dia)->count()
                ];
            }
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
    public function exportarExcel(Request $request)
    {
        $tallerId = $request->input('taller_id');
        $mes = $request->input('mes') ?? now()->format('m');
        $anio = $request->input('anio') ?? now()->format('Y');

        // Reutiliza la lógica de index para obtener los datos filtrados
        $inicio = Carbon::createFromDate($anio, $mes, 1)->startOfMonth();
        $fin = Carbon::createFromDate($anio, $mes, 1)->endOfMonth();

        $query = DB::table('taller_usuario')
            ->join('usuario', 'usuario.id_usuario', '=', 'taller_usuario.id_usuario')
            ->leftJoin('alumno', 'usuario.rut', '=', 'alumno.rut_alumno')
            ->join('talleres', 'talleres.id_taller', '=', 'taller_usuario.id_taller')
            ->where('taller_usuario.id_taller', $tallerId)
            ->whereBetween('fecha_asistencia', [$inicio->toDateString(), $fin->toDateString()]);

        if ($tallerId) {
            $query->where('taller_usuario.id_taller', $tallerId);
        }

        $asistencias = $query->select(
            'taller_usuario.id_usuario',
            'usuario.rut',
            DB::raw("CONCAT_WS(' ', alumno.nombre_alumno, alumno.apellido_paterno, alumno.apellido_materno) as nombre"),
            'alumno.carrera',
            'alumno.sexo_alumno',
            'taller_usuario.fecha_asistencia',
            'talleres.nombre_taller as taller'
        )->get();

        // Formatea los datos para el Excel
        $exportData = $asistencias->map(function ($a) use ($tallerId) {
            $row = [
                'RUT' => $a->rut,
                'Nombre' => $a->nombre,
                'Carrera' => $a->carrera,
                'Sexo' => $a->sexo_alumno,
                'Fecha Asistencia' => \Carbon\Carbon::parse($a->fecha_asistencia)->format('d-m-Y'),
            ];
            if (!$tallerId) {
                $row['Taller'] = $a->taller; // Solo si es "Todos"
            }
            return $row;
        });

        $nombreMes = ucfirst(\Carbon\Carbon::create()->month($mes)->locale('es')->monthName);

        if ($tallerId) {
            // Busca el nombre del taller
            $taller = \App\Models\Taller::find($tallerId);
            $nombreTaller = $taller ? $taller->nombre_taller : 'Taller';
            $fileName = 'Asistencia_' . str_replace(' ', '_', $nombreTaller) . "_{$nombreMes}_{$anio}.xlsx";
        } else {
            $fileName = "Asistencia_total_Talleres_{$nombreMes}_{$anio}.xlsx";
        }

        // Luego en el return:
        return Excel::download(
            new class($exportData, $tallerId) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
                private $data, $tallerId;
                public function __construct($data, $tallerId) { $this->data = $data; $this->tallerId = $tallerId; }
                public function collection() { return collect($this->data); }
                public function headings(): array {
                    $headings = ['RUT', 'Nombre', 'Carrera', 'Sexo', 'Fecha Asistencia'];
                    if (!$this->tallerId) {
                        $headings[] = 'Taller';
                    }
                    return $headings;
                }
            },
            $fileName // <-- aquí va el nombre personalizado
        );
    }
}