<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use App\Models\Equipo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TorneoUsuarioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        // Mostrar todos los torneos donde el usuario participa en algún equipo
        $torneos = $usuario->equipos->flatMap(function ($equipo) {
            return $equipo->torneos;
        })->unique('id');

        return view('usuarios.torneos', compact('torneos'));
    }

    public function agregarMiembros(Torneo $torneo)
    {
        $usuario = Auth::user();

        // Buscar el equipo del usuario en este torneo
        $equipo = $usuario->equipos()
            ->whereHas('torneos', function ($query) use ($torneo) {
                $query->where('torneos.id', $torneo->id);
            })->first();

        if (!$equipo) {
            return redirect()->route('torneos.usuario.index')->withErrors(['error' => 'No perteneces a ningún equipo en este torneo.']);
        }

        $esCapitan = $equipo->capitan_id == $usuario->id_usuario;
        $deporte = $equipo->deporte;
        $integrantesActuales = $equipo->usuarios->count();
        $maxIntegrantes = $deporte->jugadores_por_equipo;

        // Para select2: pasar los usuarios actuales (para mostrar seleccionados)
        $usuariosActuales = $equipo->usuarios;

        return view('usuarios.ver_miembros', compact(
            'torneo', 'equipo', 'maxIntegrantes', 'integrantesActuales', 'esCapitan', 'usuariosActuales'
        ));
    }

    public function guardarMiembros(Request $request, Torneo $torneo)
    {
        $usuario = Auth::user();

        // Buscar el equipo del usuario en este torneo
        $equipo = $usuario->equipos()
            ->whereHas('torneos', function ($query) use ($torneo) {
                $query->where('torneos.id', $torneo->id);
            })->first();

        if (!$equipo || $equipo->capitan_id != $usuario->id_usuario) {
            return redirect()->route('torneos.usuario.index')->withErrors(['error' => 'No tienes permisos para modificar los integrantes.']);
        }

        $deporte = $equipo->deporte;
        $maxIntegrantes = $deporte->jugadores_por_equipo;

        $integrantes = $request->input('integrantes', []);

        // Asegurar que el capitán no se elimine a sí mismo
        if (!in_array($equipo->capitan_id, $integrantes)) {
            return redirect()->back()->withErrors(['error' => 'El capitán no puede eliminarse del equipo.']);
        }

        if (count($integrantes) > $maxIntegrantes) {
            return redirect()->back()->withErrors(['error' => "No puedes agregar más de {$maxIntegrantes} integrantes a tu equipo."]);
        }

        $equipo->usuarios()->sync($integrantes);

        return redirect()->route('torneos.usuario.index')->with('success', 'Integrantes actualizados correctamente.');
    }

    public function buscarUsuario(Request $request)
    {
        $usuarios = Usuario::where('tipo_usuario', 'estudiante')
            ->where(function ($query) use ($request) {
                $query->where('rut', 'like', '%' . $request->q . '%')
                    ->orWhere('nombre', 'like', '%' . $request->q . '%')
                    ->orWhere('apellido', 'like', '%' . $request->q . '%');
            })
            ->get()
            ->map(function ($usuario) {
                return [
                    'id' => $usuario->id_usuario,
                    'rut' => $usuario->rut,
                    'nombre' => $usuario->nombre,
                    'apellido' => $usuario->apellido,
                    'text' => $usuario->rut . ' - ' . $usuario->nombre . ' ' . ($usuario->apellido ?? ''),
                ];
            });
    
        return response()->json($usuarios);
    }
}