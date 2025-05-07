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

        return view('salud.formulario', ['salud' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'acepta_veracidad' => 'accepted',
            'cronicas' => 'nullable|array',
            'cronicas.*' => 'string',
        ]);

        Salud::create([
            'enfermo_cronico' => $request->has('enfermo_cronico'),
            'alergias' => $request->has('alergias'),
            'indicaciones_medicas' => $request->has('indicaciones_medicas'),
            'informacion_salud' => $request->informacion_salud,
            'cronicas' => $request->cronicas ?? [],
            'detalle_alergias' => $request->detalle_alergias,
            'detalle_indicaciones' => $request->detalle_indicaciones,
            'id_usuario' => Auth::id()
        ]);

        return redirect()->route('news.index')->with('success', 'Información de salud registrada correctamente.');
    }

    public function edit()
    {
        $salud = Auth::user()->salud;
        
        $tieneEnfermedad = 
        ($salud->cronicas && count($salud->cronicas) > 0) ||
        !empty($salud->detalle_alergias) || 
        !empty($salud->detalle_indicaciones);

         return view('salud.edit', compact('salud', 'tieneEnfermedad'));
    }

    public function update(Request $request)
{
    $salud = Auth::user()->salud;

    $request->validate([
        'tiene_enfermedad' => 'required|in:si,no',
        'informacion_salud' => 'nullable|string',
        'detalle_alergias' => 'nullable|string',
        'detalle_indicaciones' => 'nullable|string',
        'cronicas' => 'nullable|array',
        'cronicas.*' => 'string',
    ]);

    $tieneEnfermedad = $request->input('tiene_enfermedad') === 'si';

    if ($tieneEnfermedad) {
        $salud->update([
            'enfermo_cronico' => $request->has('cronicas') && count($request->input('cronicas')) > 0,
            'alergias' => !empty($request->input('detalle_alergias')),
            'indicaciones_medicas' => !empty($request->input('detalle_indicaciones')),
            'informacion_salud' => $request->input('informacion_salud'),
            'detalle_alergias' => $request->input('detalle_alergias'),
            'detalle_indicaciones' => $request->input('detalle_indicaciones'),
            'cronicas' => $request->input('cronicas') ?? [],
        ]);
    } else {
        $salud->update([
            'enfermo_cronico' => false,
            'alergias' => false,
            'indicaciones_medicas' => false,
            'informacion_salud' => null,
            'detalle_alergias' => null,
            'detalle_indicaciones' => null,
            'cronicas' => [],
        ]);
    }
    
        return redirect()->route('mi-perfil.edit')->with('success', 'Información de salud actualizada.');
    }
    
}