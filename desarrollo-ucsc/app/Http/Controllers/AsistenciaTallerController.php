<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Taller;
use App\Models\Usuario;

class AsistenciaTallerController extends Controller
{
    // Vista para usuarios: ver su asistencia
    public function verAsistenciaUsuario($id_usuario)
    {
        $asistencias = DB::table('taller_usuario')
            ->join('talleres', 'taller_usuario.id_taller', '=', 'talleres.id_taller')
            ->where('taller_usuario.id_usuario', $id_usuario)
            ->orderByDesc('fecha_asistencia')
            ->get();

        return view('asistencia.usuario', compact('asistencias'));
    }

    // Vista para administradores: ver asistencia por taller
    public function verAsistenciaTaller($id_taller)
    {
        $asistencias = DB::table('taller_usuario')
            ->join('usuario', 'taller_usuario.id_usuario', '=', 'usuario.id_usuario')
            ->where('taller_usuario.id_taller', $id_taller)
            ->orderByDesc('fecha_asistencia')
            ->get();

        return view('asistencia.admin', compact('asistencias'));
    }

    // Registrar asistencia
    public function registrarAsistencia(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'id_taller' => 'required|exists:talleres,id_taller',
            'fecha_asistencia' => 'required|date',
        ]);

        $existe = DB::table('taller_usuario')->where([
            ['id_usuario', '=', $request->id_usuario],
            ['id_taller', '=', $request->id_taller],
            ['fecha_asistencia', '=', $request->fecha_asistencia],
        ])->exists();

        if ($existe) {
            return back()->withErrors(['asistencia' => 'Ya se registró asistencia para este usuario en esta fecha.']);
        }

        DB::table('taller_usuario')->insert([
            'id_usuario' => $request->id_usuario,
            'id_taller' => $request->id_taller,
            'fecha_asistencia' => $request->fecha_asistencia,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Asistencia registrada correctamente.');
    }
}
