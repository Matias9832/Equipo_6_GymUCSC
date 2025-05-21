<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class ActividadController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function actividadUsuario()
    {
        $userId = Auth::id();

        $actividades = DB::table('ingreso as i')
            ->join('sala as s', 'i.id_sala', '=', 's.id_sala')
            ->where('i.id_usuario', $userId)
            ->select(
                'i.fecha_ingreso',
                'i.hora_ingreso', 
                'i.hora_salida', 
                DB::raw("TIMEDIFF(i.hora_salida, i.hora_ingreso) as tiempo_uso"), 
                's.nombre_sala')
            ->orderByDesc('i.fecha_ingreso')
            ->orderByDesc('i.hora_ingreso')
            ->get();

        return view('usuarios.mi_actividad', compact('actividades'));
    }

    public function eventosCalendario()
    {
        $userId = Auth::id();

        $actividades = DB::table('ingreso as i')
            ->join('sala as s', 'i.id_sala', '=', 's.id_sala')
            ->where('i.id_usuario', $userId)
            ->select(
                'i.fecha_ingreso',
                'i.hora_ingreso',
                'i.hora_salida',
                DB::raw('TIMESTAMPDIFF(MINUTE, i.hora_ingreso, i.hora_salida) as tiempo_uso'),
                's.nombre_sala'
            )
            ->get();

        $eventos = $actividades->map(function ($actividad) {
            return [
                'title' => $actividad->nombre_sala,
                'start' => $actividad->fecha_ingreso,
                'hora_ingreso' => $actividad->hora_ingreso,
                'tiempo_uso' => $actividad->tiempo_uso,
                'backgroundColor' => '#28a745',
                'borderColor' => '#28a745',
                'textColor' => '#fff',
                'display' => 'block'
            ];
        });

        return response()->json($eventos);
    }
   public function index()
    {
        $actividades = DB::table('ingreso as i') 
            ->select('i.nombre', 'i.fecha_ingreso', 'i.hora_ingreso', 'tiempo_uso')
            ->get();

        $eventos = $actividades->map(function ($actividad) {
            return [
                'title' => $actividad->nombre,
                'start' => Carbon::parse($actividad->fecha_ingreso)->toDateString(),
                'hora_ingreso' => Carbon::parse($actividad->hora_ingreso)->format('H:i'),
                'tiempo_uso' => $actividad->tiempo_uso
            ];
        });

        return response()->json($eventos);
    }

}
