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
        // Mostrar todos los torneos disponibles
        $torneos = Torneo::with('deporte')->get();

        return view('usuarios.torneos.torneos', compact('torneos'));
    }

    public function verMiembros(Torneo $torneo)
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

        // Solo datos para mostrar, sin lógica de edición
        return view('usuarios.torneos.ver_miembros', compact('torneo', 'equipo'));
    }

}