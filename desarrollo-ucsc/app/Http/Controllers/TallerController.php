<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use Illuminate\Http\Request;

class TallerController extends Controller
{
    public function index()
    {
        $talleres = Taller::with('horarios')->get();
        return view('admin.mantenedores.talleres.index', compact('talleres'));
    }

    public function create()
    {
        return view('admin.mantenedores.talleres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_taller' => 'required|string|max:100',
            'descripcion_taller' => 'required|string',
            'cupos_taller' => 'required|integer|min:1',
            'duracion_taller' => 'required|string|max:50',
            'activo_taller' => 'boolean',
            'horarios' => 'required|array|min:1',
            'horarios.*.dia' => 'nullable|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'horarios.*.hora' => 'nullable|date_format:H:i',
        ]);

        // Filtrar horarios válidos (con día y hora)
        $horariosValidos = collect($request->horarios)
            ->filter(fn($h) => !empty($h['dia']) && !empty($h['hora']))
            ->values()
            ->all();

        if (count($horariosValidos) === 0) {
            return back()
                ->withErrors(['horarios' => 'Debes ingresar al menos un horario con día y hora'])
                ->withInput();
        }

        // Crear Taller
        $taller = Taller::create([
            'nombre_taller' => $request->nombre_taller,
            'descripcion_taller' => $request->descripcion_taller,
            'cupos_taller' => $request->cupos_taller,
            'duracion_taller' => $request->duracion_taller,
            'activo_taller' => $request->activo_taller,
        ]);

        // Crear horarios
        foreach ($horariosValidos as $h) {
            $taller->horarios()->create([
                'dia_taller' => $h['dia'],
                'hora_taller' => $h['hora'],
            ]);
        }

        return redirect()->route('talleres.index')->with('success', 'Taller creado correctamente');
    }


    public function edit(Taller $taller)
    {
        $taller->load('horarios');
        return view('admin.mantenedores.talleres.edit', compact('taller'));
    }

    public function update(Request $request, Taller $taller)
    {
        $request->validate([
            'nombre_taller' => 'required|string|max:100',
            'descripcion_taller' => 'required|string',
            'cupos_taller' => 'required|integer|min:1',
            'duracion_taller' => 'required|string|max:50',
            'activo_taller' => 'boolean',
            'horarios' => 'required|array|min:1',
            'horarios.*.id' => 'nullable|integer|exists:horarios_talleres,id',
            'horarios.*.dia' => 'nullable|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'horarios.*.hora' => 'nullable|date_format:H:i',
        ]);

        $taller->update([
            'nombre_taller' => $request->nombre_taller,
            'descripcion_taller' => $request->descripcion_taller,
            'cupos_taller' => $request->cupos_taller,
            'duracion_taller' => $request->duracion_taller,
            'activo_taller' => $request->activo_taller,
        ]);

        $horariosEnviados = collect($request->horarios)
            ->filter(fn($h) => !empty($h['dia']) && !empty($h['hora']))
            ->values();

        if ($horariosEnviados->count() === 0) {
            return back()
                ->withErrors(['horarios' => 'Debes ingresar al menos un horario con día y hora'])
                ->withInput();
        }

        // Actualizar, crear o eliminar horarios
        $idsEnviados = $horariosEnviados->pluck('id')->filter()->all(); // ids existentes enviados
        $idsActuales = $taller->horarios()->pluck('id')->all();

        // Borrar horarios que no se enviaron
        $idsParaEliminar = array_diff($idsActuales, $idsEnviados);
        if (count($idsParaEliminar)) {
            $taller->horarios()->whereIn('id', $idsParaEliminar)->delete();
        }

        foreach ($horariosEnviados as $h) {
            if (!empty($h['id'])) {
                // Actualizar horario existente
                $horario = $taller->horarios()->find($h['id']);
                if ($horario) {
                    $horario->update([
                        'dia_taller' => $h['dia'],
                        'hora_taller' => $h['hora'],
                    ]);
                }
            } else {
                // Crear nuevo horario
                $taller->horarios()->create([
                    'dia_taller' => $h['dia'],
                    'hora_taller' => $h['hora'],
                ]);
            }
        }

        return redirect()->route('talleres.index')->with('success', 'Taller actualizado correctamente');
    }


    public function destroy(Taller $taller)
    {
        $taller->delete();
        return redirect()->route('talleres.index')->with('success', 'Taller eliminado correctamente.');
    }
}
