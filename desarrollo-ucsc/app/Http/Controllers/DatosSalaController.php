<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Ingreso;
use App\Models\Alumno;

class DatosSalaController extends Controller
{

    public function index()
    {

        //Metricas Por fecha
        $hoy = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        $ingresosMes = Ingreso::whereDate('fecha_ingreso', '>=', $inicioMes)
            ->whereNotNull('hora_salida')
            ->count();

        $ingresosDia = Ingreso::whereDate('fecha_ingreso', $hoy)
            ->whereNotNull('hora_salida')
            ->count();

        // Metricas por genero
        $ingresos = Ingreso::whereBetween('fecha_ingreso', [$inicioMes, $finMes])
            ->with('usuario')
            ->get();

        $femenino = $ingresos->filter(function ($ingreso) {
            return optional($ingreso->usuario->alumno)->sexo_alumno === 'F';
        })->count();

        $masculino = $ingresos->filter(function ($ingreso) {
            return optional($ingreso->usuario->alumno)->sexo_alumno === 'M';
        })->count();

        $total = $femenino + $masculino;

        $porcentajeF = $total ? round(($femenino / $total) * 100, 1) : 0;
        $porcentajeM = $total ? round(($masculino / $total) * 100, 1) : 0;

        // Metricas por carrera
        $ingresosPorCarrera = Ingreso::whereBetween('fecha_ingreso', [$inicioMes, $finMes])
            ->whereNotNull('hora_salida')
            ->with('usuario.alumno')
            ->get()
            ->filter(fn($ingreso) => $ingreso->usuario && $ingreso->usuario->alumno)
            ->groupBy(fn($ingreso) => $ingreso->usuario->alumno->ua_carrera . '|' . $ingreso->usuario->alumno->carrera);

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

        return view('admin.datos.salas.index', [
            'ingresosMes' => $ingresosMes,
            'ingresosDia' => $ingresosDia,
            'femenino' => $femenino,
            'masculino' => $masculino,
            'porcentajeF' => $porcentajeF,
            'porcentajeM' => $porcentajeM,
            'rankingCarreras' => $rankingCarreras,
        ]);
    }

}
