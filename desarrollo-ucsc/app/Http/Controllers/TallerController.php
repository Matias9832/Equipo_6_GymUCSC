<?php

namespace App\Http\Controllers;
use App\Models\Administrador;
use App\Models\Taller;
use App\Models\Espacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Asegúrate de que esta línea esté presente

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
        $rules = [
            'nombre_taller' => 'required|string|max:100',
            'descripcion_taller' => 'required|string',
            'cupos_taller' => 'required|integer|min:1',
            'id_admin' => 'nullable|exists:administrador,id_admin',
            'id_espacio' => 'nullable|exists:espacio,id_espacio',
            'activo_taller' => 'boolean',
            'horarios' => 'nullable|array', // CAMBIO: Horarios ahora es nullable y solo array
            // No se pone required aquí para los subcampos, se validarán condicionalmente
        ];

        $messages = [
            'horarios.*.hora_termino.after' => 'La hora término debe ser posterior a la hora inicio.',
            'horarios.*.dia.required' => 'El día es obligatorio para todos los horarios ingresados.',
            'horarios.*.hora_inicio.required' => 'La hora de inicio es obligatoria para todos los horarios ingresados.',
            'horarios.*.hora_termino.required' => 'La hora de término es obligatoria para todos los horarios ingresados.',
            'horarios.*.dia.in' => 'El día seleccionado no es válido.',
            'horarios.*.hora_inicio.date_format' => 'El formato de la hora de inicio debe ser HH:mm.',
            'horarios.*.hora_termino.date_format' => 'El formato de la hora de término debe ser HH:mm.',
        ];

        $request->validate($rules, $messages);

        $horariosValidos = collect($request->horarios)
            ->filter(function($h) {
                // Filtramos solo los horarios que tienen al menos un campo lleno,
                // para evitar procesar filas completamente vacías añadidas por error o eliminación
                return !empty($h['dia']) || !empty($h['hora_inicio']) || !empty($h['hora_termino']);
            })
            ->values()
            ->all();

        // Validar cada horario individualmente si existen horarios para validar
        if (!empty($horariosValidos)) {
            foreach ($horariosValidos as $i => $h) {
                // Asegurarse de que si se ingresa un horario, esté completo y sea válido
                Validator::make($h, [
                    'dia' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
                    'hora_inicio' => 'required|date_format:H:i',
                    'hora_termino' => 'required|date_format:H:i|after:hora_inicio',
                ], [
                    'dia.required' => "El día para el horario #:position es obligatorio.",
                    'hora_inicio.required' => "La hora de inicio para el horario #:position es obligatoria.",
                    'hora_termino.required' => "La hora de término para el horario #:position es obligatoria.",
                    'hora_termino.after' => "La hora de término para el horario #:position debe ser posterior a la hora de inicio.",
                ], [
                    'dia' => 'día',
                    'hora_inicio' => 'hora inicio',
                    'hora_termino' => 'hora término'
                ])->validate(); // Esto detendrá la ejecución si falla la validación
            }
        }


        // Crear Taller
        $taller = Taller::create([
            'nombre_taller' => $request->nombre_taller,
            'descripcion_taller' => $request->descripcion_taller,
            'cupos_taller' => $request->cupos_taller,
            'activo_taller' => $request->activo_taller,
            'id_admin' => $request->id_admin,
            'id_espacio' => $request->id_espacio,
        ]);

        // Crear horarios solo si hay horarios válidos
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
        $espacios = Espacio::all();
        return view('admin.talleres.edit', compact('taller', 'admins','espacios'));
    }
    public function update(Request $request, Taller $taller)
    {
        $rules = [
            'nombre_taller' => 'required|string|max:100',
            'descripcion_taller' => 'required|string',
            'cupos_taller' => 'required|integer|min:1',
            'id_admin' => 'nullable|exists:administrador,id_admin',
            'id_espacio' => 'nullable|exists:espacio,id_espacio',
            'activo_taller' => 'boolean',
            'horarios' => 'nullable|array', // CAMBIO: Horarios ahora es nullable y solo array
        ];

        $messages = [
            'horarios.*.hora_termino.after' => 'La hora término debe ser posterior a la hora inicio.',
            'horarios.*.dia.required' => 'El día es obligatorio para todos los horarios ingresados.',
            'horarios.*.hora_inicio.required' => 'La hora de inicio es obligatoria para todos los horarios ingresados.',
            'horarios.*.hora_termino.required' => 'La hora de término es obligatoria para todos los horarios ingresados.',
            'horarios.*.dia.in' => 'El día seleccionado no es válido.',
            'horarios.*.hora_inicio.date_format' => 'El formato de la hora de inicio debe ser HH:mm.',
            'horarios.*.hora_termino.date_format' => 'El formato de la hora de término debe ser HH:mm.',
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

        // Validar cada horario individualmente si existen horarios para validar
        if (!empty($horariosEnviados)) {
            foreach ($horariosEnviados as $i => $h) {
                // Asegurarse de que si se ingresa un horario, esté completo y sea válido
                Validator::make($h, [
                    'dia' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
                    'hora_inicio' => 'required|date_format:H:i',
                    'hora_termino' => 'required|date_format:H:i|after:hora_inicio',
                ], [
                    'dia.required' => "El día para el horario #:position es obligatorio.",
                    'hora_inicio.required' => "La hora de inicio para el horario #:position es obligatoria.",
                    'hora_termino.required' => "La hora de término para el horario #:position es obligatoria.",
                    'hora_termino.after' => "La hora de término para el horario #:position debe ser posterior a la hora de inicio.",
                ], [
                    'dia' => 'día',
                    'hora_inicio' => 'hora inicio',
                    'hora_termino' => 'hora término'
                ])->validate(); // Esto detendrá la ejecución si falla la validación
            }
        }
        
        // Actualizar taller
        $taller->update([
            'nombre_taller' => $request->nombre_taller,
            'descripcion_taller' => $request->descripcion_taller,
            'cupos_taller' => $request->cupos_taller,
            'activo_taller' => $request->activo_taller,
            'id_admin' => $request->id_admin,
            'id_espacio' => $request->id_espacio,
        ]);

        // Sincronizar horarios: Eliminar los que no se enviaron, actualizar los existentes, crear los nuevos
        $currentHorarios = $taller->horarios->keyBy('id'); // Get current horarios as a collection keyed by ID
        $submittedHorarios = collect($horariosEnviados)->keyBy('id'); // Key submitted horarios by ID

        // Horarios a eliminar (existen en la base de datos pero no se enviaron)
        $horariosToDelete = $currentHorarios->diffKeys($submittedHorarios);
        foreach ($horariosToDelete as $horario) {
            $horario->delete();
        }

        // Crear o actualizar horarios
        foreach ($horariosEnviados as $h) {
            if (isset($h['id']) && $currentHorarios->has($h['id'])) {
                // Update existing
                $horario = $currentHorarios->get($h['id']);
                $horario->update([
                    'dia_taller' => $h['dia'],
                    'hora_inicio' => $h['hora_inicio'],
                    'hora_termino' => $h['hora_termino'],
                ]);
            } else {
                // Create new
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