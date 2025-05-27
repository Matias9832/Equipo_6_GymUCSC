<?php
namespace App\Http\Controllers;

use App\Models\Rutina;
use Illuminate\Support\Facades\Auth;

class RutinaPersonalizadaController extends Controller
{
    public function index()
    {
        $rutinas = Rutina::with('ejercicios')
            ->where('user_id', Auth::id())
            ->get();

        return view('usuarios.rutinas_personalizadas', compact('rutinas'));
    }
}