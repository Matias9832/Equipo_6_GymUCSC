<?php

namespace App\Http\Controllers;
use App\Models\Administrador;
use App\Models\Taller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TallerController extends Controller
{
    public function index()
    {
        $talleres = Taller::with('horarios')->get();
        return view('admin.mantenedores.talleres.index', compact('talleres'));
    }

    public function create()
    {
        $admins = Administrador::all();
        return view('admin.mantenedores.talleres.create', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_taller' => 'required|string|max:100',
            'descripcion_taller' => 'required|string',
            'cupos_taller' => 'required|integer|min:1',
            'id_admin' => 'nullable|exists:administrador,id_admin',
            'activo_taller' => 'boolean',
            'horarios' => 'required|array|min:1',
            'horarios.*.dia' => 'nullable|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'horarios.*.hora_inicio' => 'nullable|date_format:H:i',
            'horarios.*.hora_termino' => 'nullable|date_format:H:i|after:horarios.*.hora_inicio',
        ]);

        $horariosValidos = collect($request->horarios)
            ->filter(fn($h) => !empty($h['dia']) && !empty($h['hora_inicio']) && !empty($h['hora_termino']))
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
            'activo_taller' => $request->activo_taller,
            'id_admin' => $request->id_admin,
        ]);

        // Crear horarios
        foreach ($horariosValidos as $h) {
            $taller->horarios()->create([
                'dia_taller' => $h['dia'],
                'hora_inicio' => $h['hora_inicio'],
                'hora_termino' => $h['hora_termino'],
            ]);
        }

        return redirect()->route('talleres.index')->with('success', 'Taller creado correctamente');
    }


    public function edit(Taller $taller)
    {
        $taller->load('horarios');
        $admins = Administrador::all();
        return view('admin.mantenedores.talleres.edit', compact('taller', 'admins'));
    }

    public function update(Request $request, Taller $taller)
    {
        $request->validate([
            'nombre_taller' => 'required|string|max:100',
            'descripcion_taller' => 'required|string',
            'cupos_taller' => 'required|integer|min:1',
            'id_admin' => 'nullable|exists:administrador,id_admin',
            'activo_taller' => 'boolean',
            'horarios' => 'required|array|min:1',
        ]);

        // Normalizar formatos de hora (en caso de que vengan con segundos u otro formato)
        $horariosEnviados = collect($request->horarios)->map(function ($h) {
            $h['hora_inicio'] = isset($h['hora_inicio']) ? date('H:i', strtotime($h['hora_inicio'])) : null;
            $h['hora_termino'] = isset($h['hora_termino']) ? date('H:i', strtotime($h['hora_termino'])) : null;
            return $h;
        });

        // Validar cada horario manualmente
        foreach ($horariosEnviados as $i => $h) {
            if (!empty($h['dia']) || !empty($h['hora_inicio']) || !empty($h['hora_termino'])) {
                Validator::make($h, [
                    'dia' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
                    'hora_inicio' => 'required|date_format:H:i',
                    'hora_termino' => 'required|date_format:H:i|after:hora_inicio',
                ], [], [
                    "dia" => "día",
                    "hora_inicio" => "hora inicio",
                    "hora_termino" => "hora término"
                ])->validate();
            }
        }

        // Actualizar taller
        $taller->update([
            'nombre_taller' => $request->nombre_taller,
            'descripcion_taller' => $request->descripcion_taller,
            'cupos_taller' => $request->cupos_taller,
            'activo_taller' => $request->activo_taller,
            'id_admin' => $request->id_admin,
        ]);

        // Cargar horarios actuales
        $taller->load('horarios');

        $idsEnviados = $horariosEnviados->pluck('id')->filter()->all();
        $idsActuales = $taller->horarios->pluck('id')->all();

        // Eliminar horarios eliminados
        $idsParaEliminar = array_diff($idsActuales, $idsEnviados);
        if (count($idsParaEliminar)) {
            $taller->horarios()->whereIn('id', $idsParaEliminar)->delete();
        }

        // Crear o actualizar horarios
        foreach ($horariosEnviados as $h) {
            if (!empty($h['id'])) {
                $horario = $taller->horarios->firstWhere('id', $h['id']);
                if ($horario) {
                    $horario->update([
                        'dia_taller' => $h['dia'],
                        'hora_inicio' => $h['hora_inicio'],
                        'hora_termino' => $h['hora_termino'],
                    ]);
                }
            } else {
                $taller->horarios()->create([
                    'dia_taller' => $h['dia'],
                    'hora_inicio' => $h['hora_inicio'],
                    'hora_termino' => $h['hora_termino'],
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
