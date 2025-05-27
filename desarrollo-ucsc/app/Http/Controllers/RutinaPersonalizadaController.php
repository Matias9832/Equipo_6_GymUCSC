<?php
namespace App\Http\Controllers;

use App\Models\Rutina;
use Illuminate\Support\Facades\Auth;

class RutinaPersonalizadaController extends Controller
{
    public function index()
    {
        $rutinas = Rutina::with([
                'ejercicios',
                'creador.alumno'
            ])
            ->where('user_id', Auth::user()->id_usuario)
            ->get();

        return view('usuarios.rutinas_personalizadas', compact('rutinas'));
    }
}