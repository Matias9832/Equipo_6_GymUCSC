<?php

namespace App\Http\Controllers;
use App\Models\Administrador;
use App\Models\Taller;
use App\Models\Espacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Asegúrate de que esta línea esté presente
use Illuminate\Validation\Rule;
class TallerController extends Controller
{
    public function index()
    {
        $talleres = Taller::with('horarios')->get();
        return view('admin.talleres.index', compact('talleres'));
    }

    public function create()
    {
        $admins = Administrador::all();
        $espacios = Espacio::all();
        return view('admin.talleres.create', compact('admins', 'espacios'));
    }

    public function store(Request $request)
    {
        // Filtrar horarios vacíos ANTES de la validación
        $horariosValidos = collect($request->input('horarios'))
            ->filter(function ($horario) {
                return !empty(array_filter($horario, 'strlen')); // Elimina horarios completamente vacíos
            })->toArray();

        // Reemplaza los horarios del request con solo los válidos
        $request->merge(['horarios' => $horariosValidos]);
        
        $rules = [
            'nombre_taller' => 'required|string|max:100',
            'descripcion_taller' => 'required|string',
            'cupos_taller' => 'required|integer|min:1',
            'id_admin' => 'nullable|exists:administrador,id_admin',
            'id_espacio' => 'nullable|exists:espacio,id_espacio',
            'activo_taller' => 'boolean',
            'horarios' => ['nullable', 'array'], // Permitir que el array de horarios sea opcional
            'horarios.*.dia' => ['required', 'string', Rule::in(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])],
            'horarios.*.hora_inicio' => ['required', 'date_format:H:i'],
            'horarios.*.hora_termino' => ['required', 'date_format:H:i', 'after:horarios.*.hora_inicio'],
        ];

        $messages = [
            'horarios.*.dia.required' => 'El día del horario es obligatorio.',
            'horarios.*.dia.in' => 'El día del horario no es válido.',
            'horarios.*.hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'horarios.*.hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'horarios.*.hora_termino.required' => 'La hora de término es obligatoria.',
            'horarios.*.hora_termino.date_format' => 'La hora de término debe tener el formato HH:MM.',
            'horarios.*.hora_termino.after' => 'La hora de término del horario debe ser posterior a la hora de inicio.',
        ];

        $request->validate($rules, $messages);

        $horariosValidos = collect($request->horarios)
            ->filter(function($h) {
                return !empty($h['dia']) || !empty($h['hora_inicio']) || !empty($h['hora_termino']);
            })
            ->values()
            ->all();

        // Crear Taller
        $taller = Taller::create($request->except('horarios')); // Guardar el taller sin los horarios
    
        // Guardar los horarios asociados
        foreach ($request->horarios as $horarioData) {
            // Asegúrate de que los IDs existan si estás editando y deseas actualizar
            // En create, no habrá ID, solo se crea
            $taller->horarios()->create([
                'dia_taller' => $horarioData['dia'],
                'hora_inicio' => $horarioData['hora_inicio'],
                'hora_termino' => $horarioData['hora_termino'],
            ]);
        }

        return redirect()->route('talleres.index')->with('success', 'Taller creado correctamente');
    }

    public function edit(Taller $taller)
    {
        $taller->load('horarios');
        $admins = Administrador::all();
        $espacios = Espacio::all();
        return view('admin.talleres.edit', compact('taller', 'admins','espacios'));
    }
    public function update(Request $request, Taller $taller)
{
    $horariosValidos = collect($request->input('horarios'))
        ->filter(function ($horario) {
            return !empty(array_filter($horario, 'strlen'));
        })->toArray();
    
    $request->merge(['horarios' => $horariosValidos]);

    $rules = [
        'nombre_taller' => 'required|string|max:100',
        'descripcion_taller' => 'required|string',
        'cupos_taller' => 'required|integer|min:1',
        'id_admin' => 'nullable|exists:administrador,id_admin',
        'id_espacio' => 'nullable|exists:espacio,id_espacio',
        'activo_taller' => 'boolean',
        'horarios' => ['nullable', 'array'],
        // LA LÍNEA MODIFICADA AQUÍ:
        'horarios.*.id' => ['nullable', 'exists:horarios_talleres,id'], // Cambiado 'horarios' a 'horarios_talleres'
        'horarios.*.dia' => ['required', 'string', Rule::in(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])],
        'horarios.*.hora_inicio' => ['required', 'date_format:H:i'],
        'horarios.*.hora_termino' => ['required', 'date_format:H:i', 'after:horarios.*.hora_inicio'],
    ];

    $messages = [
        'horarios.*.dia.required' => 'El día del horario es obligatorio.',
        'horarios.*.dia.in' => 'El día del horario no es válido.',
        'horarios.*.hora_inicio.required' => 'La hora de inicio es obligatoria.',
        'horarios.*.hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
        'horarios.*.hora_termino.required' => 'La hora de término es obligatoria.',
        'horarios.*.hora_termino.date_format' => 'La hora de término debe tener el formato HH:MM.',
        'horarios.*.hora_termino.after' => 'La hora de término del horario debe ser posterior a la hora de inicio.',
    ];

    $request->validate($rules, $messages);
    
    $horariosEnviados = collect($request->horarios)
            ->filter(function($h) {
                // Filtramos solo los horarios que tienen al menos un campo lleno
                return !empty($h['dia']) || !empty($h['hora_inicio']) || !empty($h['hora_termino']);
            })
            ->map(function ($h) {
                // Normalizar formatos de hora si existen
                $h['hora_inicio'] = isset($h['hora_inicio']) ? date('H:i', strtotime($h['hora_inicio'])) : null;
                $h['hora_termino'] = isset($h['hora_termino']) ? date('H:i', strtotime($h['hora_termino'])) : null;
                return $h;
            })
            ->values()
            ->all();

    $taller->update($request->except('horarios', '_method'));

    $idsExistenteHorarios = [];
    foreach ($request->horarios as $horarioData) {
        if (isset($horarioData['id']) && !empty($horarioData['id'])) {
            $taller->horarios()->where('id', $horarioData['id'])->update([
                'dia_taller' => $horarioData['dia'],
                'hora_inicio' => $horarioData['hora_inicio'],
                'hora_termino' => $horarioData['hora_termino'],
            ]);
            $idsExistenteHorarios[] = $horarioData['id'];
        } else {
            $horario = $taller->horarios()->create([
                'dia_taller' => $horarioData['dia'],
                'hora_inicio' => $horarioData['hora_inicio'],
                'hora_termino' => $horarioData['hora_termino'],
            ]);
            $idsExistenteHorarios[] = $horario->id;
        }
    }

    $taller->horarios()->whereNotIn('id', $idsExistenteHorarios)->delete();

    return redirect()->route('talleres.index')->with('success', 'Taller actualizado exitosamente.');
}

    public function destroy(Taller $taller)
    {
        $taller->delete();
        return redirect()->route('talleres.index')->with('success', 'Taller eliminado correctamente.');
    }
}