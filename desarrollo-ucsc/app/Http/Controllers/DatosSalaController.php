<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Sala;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class DatosSalaController extends Controller
{
    public function index(Request $request)
    {
        $salaId = $request->input('sala_id');
        $desde = $request->input('desde') ?? Carbon::now()->startOfMonth()->toDateString();
        $hasta = $request->input('hasta') ?? Carbon::now()->endOfMonth()->toDateString();

        $inicio = Carbon::parse($desde)->startOfDay();
        $fin = Carbon::parse($hasta)->endOfDay();

        // Consulta base
        $query = Ingreso::whereBetween('fecha_ingreso', [$inicio, $fin])
            ->whereNotNull('hora_salida');

        if ($salaId) {
            $query->where('id_sala', $salaId);
        }

        $ingresosFiltrados = $query->with('usuario.alumno')->get();

        // Métricas por fecha
        $ingresosMes = $ingresosFiltrados->count();
        $ingresosDia = $ingresosFiltrados->where('fecha_ingreso', Carbon::today()->toDateString())->count();

        // Métricas por género
        $femenino = $ingresosFiltrados->filter(fn($i) => optional($i->usuario->alumno)->sexo_alumno === 'F')->count();
        $masculino = $ingresosFiltrados->filter(fn($i) => optional($i->usuario->alumno)->sexo_alumno === 'M')->count();

        $total = $femenino + $masculino;
        $porcentajeF = $total ? round(($femenino / $total) * 100, 1) : 0;
        $porcentajeM = $total ? round(($masculino / $total) * 100, 1) : 0;

        // Métricas por carrera
        $ingresosPorCarrera = $ingresosFiltrados
            ->filter(fn($i) => $i->usuario && $i->usuario->alumno)
            ->groupBy(fn($i) => $i->usuario->alumno->ua_carrera . '|' . $i->usuario->alumno->carrera);

        $totalIngresosCarrera = $ingresosPorCarrera->flatten()->count();

        $rankingCarreras = $ingresosPorCarrera->map(function ($ingresos, $clave) use ($totalIngresosCarrera) {
            [$ua, $carrera] = explode('|', $clave);
            $cantidad = $ingresos->count();
            $porcentaje = $totalIngresosCarrera ? round(($cantidad / $totalIngresosCarrera) * 100, 2) : 0;

            return [
                'ua' => $ua,
                'carrera' => $carrera,
                'cantidad' => $cantidad,
                'porcentaje' => $porcentaje,
            ];
        })->sortByDesc('cantidad')->values();

        $rankingCarreras = $rankingCarreras->take(8);

        $salas = Sala::all(); // Para el select en la vista

        // Gráfico de curva: ingresos por día del mes seleccionado
        $curvaDatos = [];
        $periodo = \Carbon\CarbonPeriod::create($inicio, $fin);
        foreach ($periodo as $dia) {
            $fecha = $dia->format('Y-m-d');
            $curvaDatos[] = [
                'fecha' => $fecha,
                'cantidad' => $ingresosFiltrados->where('fecha_ingreso', $fecha)->count()
            ];
        }
        return view('admin.datos.salas.index', [
            'ingresosMes' => $ingresosMes,
            'ingresosDia' => $ingresosDia,
            'femenino' => $femenino,
            'masculino' => $masculino,
            'porcentajeF' => $porcentajeF,
            'porcentajeM' => $porcentajeM,
            'rankingCarreras' => $rankingCarreras,
            'salas' => $salas,
            'curvaDatos' => $curvaDatos,
            'salaId' => $salaId,
            'desde' => $desde,
            'hasta' => $hasta,
        ]);
    }

    public function exportarExcel(Request $request)
    {
        $salaId = $request->input('sala_id');
        $desde = $request->input('desde') ?? Carbon::now()->startOfMonth()->toDateString();
        $hasta = $request->input('hasta') ?? Carbon::now()->endOfMonth()->toDateString();

        $inicio = Carbon::parse($desde)->startOfDay();
        $fin = Carbon::parse($hasta)->endOfDay();

        $query = Ingreso::whereBetween('fecha_ingreso', [$inicio, $fin])
            ->whereNotNull('hora_salida');

        if ($salaId) {
            $query->where('id_sala', $salaId);
        }

        $ingresos = $query->with('usuario.alumno')->get();

        $exportData = $ingresos->map(function ($ingreso) {
            $alumno = $ingreso->usuario->alumno ?? null;

            return [
                'Sala' => $ingreso->sala->nombre_sala ?? 'N/A',
                'Fecha Ingreso' => Carbon::parse($ingreso->fecha_ingreso)->format('d-m-Y'),
                'Hora Ingreso' => $ingreso->hora_ingreso,
                'Hora Salida' => $ingreso->hora_salida,
                'Tiempo de Uso (minutos)' => $ingreso->tiempo_uso,
                'Rut' => $ingreso->usuario->rut ?? '',
                'Nombre Completo' => $alumno ? trim("{$alumno->nombre_alumno} {$alumno->apellido_paterno} {$alumno->apellido_materno}") : '',
                'Carrera' => $alumno->carrera ?? '',
                'Sexo' => $alumno->sexo_alumno ?? '',
            ];
        });

        return Excel::download(new class ($exportData) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return collect($this->data);
            }

            public function headings(): array
            {
                return [
                    'Sala',
                    'Fecha Ingreso',
                    'Hora Ingreso',
                    'Hora Salida',
                    'Tiempo de Uso (minutos)',
                    'Rut',
                    'Nombre Completo',
                    'Carrera',
                    'Sexo',
                ];
            }
        }, 'ingresos_salas_' . $desde . '_a_' . $hasta . '.xlsx');
    }

}
