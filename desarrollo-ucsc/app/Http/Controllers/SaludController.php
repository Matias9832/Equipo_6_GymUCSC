<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salud;
use Illuminate\Support\Facades\Auth;

class SaludController extends Controller
{
    public function create()
    {
        // Solo mostrar si no ha registrado salud
        if (Auth::user()->salud) {
            return redirect()->route('home');
        }

        return view('salud.formulario');
    }

    public function store(Request $request)
    {
        $request->validate([
            'acepta_veracidad' => 'accepted'
        ]);

        Salud::create([
            'enfermo_cronico' => $request->has('enfermo_cronico'),
            'alergias' => $request->has('alergias'),
            'indicaciones_medicas' => $request->has('indicaciones_medicas'),
            'informacion_salud' => $request->input('informacion_salud'),
            'id_usuario' => Auth::id()
        ]);

        return redirect()->route('news.index')->with('success', 'Información de salud registrada correctamente.');
    }

    public function edit()
    {
        $salud = Auth::user()->salud;
        return view('salud.edit', compact('salud'));
    }

    public function update(Request $request)
    {
        $salud = Auth::user()->salud;

        $salud->update([
            'enfermo_cronico' => $request->has('enfermo_cronico'),
            'alergias' => $request->has('alergias'),
            'indicaciones_medicas' => $request->has('indicaciones_medicas'),
            'informacion_salud' => $request->input('informacion_salud'),
        ]);

        return redirect()->route('mi-perfil.edit')->with('success', 'Información de salud actualizada.');
    }
}