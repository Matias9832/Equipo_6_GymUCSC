<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Taller;
use App\Models\Usuario;
use Carbon\Carbon;

class AsistenciaTallerController extends Controller
{
    // Ver lista de asistencias para un taller en una fecha específica
    public function ver(Request $request, Taller $taller)
    {
        $fecha = $request->input('fecha', now()->toDateString());

        $asistencias = DB::table('taller_usuario')
            ->join('usuario', 'usuario.id_usuario', '=', 'taller_usuario.id_usuario')
            ->where('id_taller', $taller->id_taller)
            ->whereDate('fecha_asistencia', $fecha)
            ->select('usuario.rut', 'usuario.correo_usuario', 'usuario.nombre_usuario as nombre', 'fecha_asistencia') // Debo agregar carrera y genero
            ->get();

        return view('admin.talleres.asistencia.ver', compact('taller', 'asistencias', 'fecha'));
    }

    // Mostrar formulario para registrar asistencia manual
    public function registrar(Request $request, Taller $taller)
    {
        $usuarios = Usuario::all();
        return view('admin.talleres.asistencia.registrar', compact('taller', 'usuarios'));
    }

    // Procesar registro de asistencia
    public function guardarRegistro(Request $request, Taller $taller)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'fecha_asistencia' => 'required|date',
        ], [
            'id_usuario.required' => 'Debes seleccionar un usuario.',
            'fecha_asistencia.required' => 'La fecha de asistencia es obligatoria.',
        ]);

        // Validar que la fecha coincide con un día válido del taller
        $dia = Carbon::parse($request->fecha_asistencia)->locale('es')->isoFormat('dddd');

        $esValido = $taller->horarios->contains(function ($horario) use ($dia) {
            return strtolower($horario->dia_taller) === strtolower($dia);
        });

        if (! $esValido) {
            return back()->withErrors(['fecha_asistencia' => 'La fecha seleccionada no corresponde a un día de taller.']);
        }

        // Insertar o actualizar registro
        DB::table('taller_usuario')->updateOrInsert([
            'id_usuario' => $request->id_usuario,
            'id_taller' => $taller->id_taller,
            'fecha_asistencia' => $request->fecha_asistencia,
        ]);

        return redirect()->route('talleres.index', $taller)->with('success', 'Asistencia registrada correctamente.');
    }
}
