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

            'tiene_enfermedad' => 'required|in:si,no',
            'acepta_veracidad' => 'accepted',
            'cronicas' => 'nullable|array',
            'cronicas.*' => 'string',
            'detalle_alergias' => 'nullable|string',
            'detalle_indicaciones' => 'nullable|string',
        ]);
    
        // Validar que al menos un campo esté presente si tiene enfermedad
        if ($request->input('tiene_enfermedad') === 'si') {
            if (
                !(($request->has('cronicas') && count($request->cronicas) > 0) ||
                !empty($request->detalle_alergias) ||
                !empty($request->detalle_indicaciones))
            ) {
                return back()->withInput()->withErrors([
                    'tiene_enfermedad' => 'Debe especificar al menos una condición si indica que tiene enfermedades o condiciones médicas.'
                ]);
            }
        }

        Salud::create([
            'enfermo_cronico' =>  $request->has('cronicas') && count($request->cronicas) > 0,
            'alergias' => !empty($request->detalle_alergias),
            'indicaciones_medicas' => !empty($request->detalle_indicaciones),
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

        
        $nuevosDatos = [];

        if ($tieneEnfermedad) {
            if (
                !(($request->has('cronicas') && count($request->cronicas) > 0) ||
                !empty($request->detalle_alergias) ||
                !empty($request->detalle_indicaciones))
            ) {
                return back()->withInput()->withErrors([
                    'tiene_enfermedad' => 'Debe especificar al menos una condición si indica que tiene enfermedades o condiciones médicas.'
                ]);
            }

            $nuevosDatos = [
            'enfermo_cronico' => $request->has('cronicas') && count($request->input('cronicas')) > 0,
            'alergias' => !empty($request->input('detalle_alergias')),
            'indicaciones_medicas' => !empty($request->input('detalle_indicaciones')),
            'informacion_salud' => $request->input('informacion_salud'),
            'detalle_alergias' => $request->input('detalle_alergias'),
            'detalle_indicaciones' => $request->input('detalle_indicaciones'),
            'cronicas' => $request->input('cronicas') ?? [],
        ];
    } else {
        $nuevosDatos = [
            'enfermo_cronico' => false,
            'alergias' => false,
            'indicaciones_medicas' => false,
            'informacion_salud' => null,
            'detalle_alergias' => null,
            'detalle_indicaciones' => null,
            'cronicas' => [],
        ];
    }

    // Verificamos si hay cambios comparando los datos actuales con los nuevos
    $sinCambios = true;
        foreach ($nuevosDatos as $campo => $valorNuevo) {
            $valorActual = $salud->{$campo};

            // Comparación especial para arrays (cronicas)
            if (is_array($valorNuevo)) {
                if ($valorActual !== null && json_encode($valorActual) !== json_encode($valorNuevo)) {
                    $sinCambios = false;
                    break;
                } elseif ($valorActual === null && !empty($valorNuevo)) {
                    $sinCambios = false;
                    break;
                }
            } elseif ($valorActual != $valorNuevo) {
                $sinCambios = false;
                break;
            }
        }

        if ($sinCambios) {
            return redirect()->route('mi-perfil.edit')->with('info', 'No se han realizado cambios.');
        }

        // Guardar solo si hay cambios
        $salud->update($nuevosDatos);

        return redirect()->route('mi-perfil.edit')->with('success', 'Información de salud actualizada.');
    }
    
}