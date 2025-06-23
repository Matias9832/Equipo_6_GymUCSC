<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academia;
use App\Models\AcademyNews;
use App\Models\HorarioAcademia;
use App\Models\Espacio;
use App\Models\AcademySetting;



class AcademiaController extends Controller
{
    public function index()
    {
        $academias = Academia::with('horarios')->get();
        $featuredNews = AcademyNews::with('images', 'administrador')
            ->where('is_featured', true)
            ->where(function ($query) {
                $query->whereNull('featured_until')
                    ->orWhere('featured_until', '>=', now());
            })
            ->orderBy('fecha_noticia', 'desc')
            ->take(5)
            ->get();
        $news = AcademyNews::with('images', 'administrador')
        ->orderBy('fecha_noticia', 'desc')
        ->paginate(4);

        $banner = \App\Models\AcademySetting::first();

        return view('academynews.index', compact('academias', 'featuredNews', 'banner', 'news'));
    }

    public function create()
    {
        $espacios = Espacio::all();
        return view('academias.create', compact('espacios'));
    }

    public function store(Request $request)
    {
        // Filtrar horarios vacíos antes de validar
        $horariosValidos = collect($request->input('horarios'))
            ->filter(function ($horario) {
                return !empty(array_filter($horario, 'strlen'));
            })->toArray();
        $request->merge(['horarios' => $horariosValidos]);

        $request->validate([
            'nombre_academia' => 'required|string|max:255',
            'descripcion_academia' => 'required|string',
            'id_espacio' => 'required',
            'matricula'=> 'required|string',
            'mensualidad' => 'required|string',
            'horarios' => 'nullable|array',
            'horarios.*.dia' => 'nullable|string',
            'horarios.*.hora_inicio' => 'nullable|date_format:H:i',
            'horarios.*.hora_fin' => 'nullable|date_format:H:i|after:horarios.*.hora_inicio',
        ], [
            'horarios.*.hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'horarios.*.hora_fin.date_format' => 'La hora de término debe tener el formato HH:MM.',
            'horarios.*.hora_fin.after' => 'La hora de término debe ser posterior a la hora de inicio.',
        ]);

        $academia = Academia::create($request->only([
            'nombre_academia',
            'descripcion_academia',
            'id_espacio',
            'implementos',
            'matricula',
            'mensualidad'
        ]));

        if (!empty($request->horarios)) {
            foreach ($request->horarios as $horario) {
                if (
                    !empty($horario['dia']) &&
                    !empty($horario['hora_inicio']) &&
                    !empty($horario['hora_fin'])
                ) {
                    $academia->horarios()->create([
                        'dia_semana' => $horario['dia'],
                        'hora_inicio' => $horario['hora_inicio'],
                        'hora_fin' => $horario['hora_fin'],
                    ]);
                }
            }
        }

        return redirect()->route('academias.index')->with('success', 'Academia creada correctamente.');
    }
    public function edit($id)
    {
        $academia = Academia::with('horarios')->findOrFail($id);
        $espacios = Espacio::all();
        return view('academias.edit', compact('academia', 'espacios'));
    }

    public function update(Request $request, $id)
    {
        // Filtrar horarios vacíos antes de validar
        $horariosValidos = collect($request->input('horarios'))
            ->filter(function ($horario) {
                return !empty(array_filter($horario, 'strlen'));
            })->toArray();
        $request->merge(['horarios' => $horariosValidos]);

        $request->validate([
            'nombre_academia' => 'required|string|max:255',
            'descripcion_academia' => 'required|string',
            'id_espacio' => 'required',
            'matricula'=> 'required|string',
            'mensualidad' => 'required|string',
            'horarios' => 'nullable|array',
            'horarios.*.dia' => 'nullable|string',
            'horarios.*.hora_inicio' => 'nullable|date_format:H:i',
            'horarios.*.hora_fin' => 'nullable|date_format:H:i|after:horarios.*.hora_inicio',
        ], [
            'horarios.*.hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'horarios.*.hora_fin.date_format' => 'La hora de término debe tener el formato HH:MM.',
            'horarios.*.hora_fin.after' => 'La hora de término debe ser posterior a la hora de inicio.',
        ]);

        $academia = Academia::findOrFail($id);
        $academia->update($request->only([
            'nombre_academia',
            'descripcion_academia',
            'id_espacio',
            'implementos',
            'matricula',
            'mensualidad'
        ]));

        // Elimina los horarios antiguos
        $academia->horarios()->delete();

        // Agrega los nuevos horarios si existen
        if (!empty($request->horarios)) {
            foreach ($request->horarios as $horario) {
                if (
                    !empty($horario['dia']) &&
                    !empty($horario['hora_inicio']) &&
                    !empty($horario['hora_fin'])
                ) {
                    $academia->horarios()->create([
                        'dia_semana' => $horario['dia'],
                        'hora_inicio' => $horario['hora_inicio'],
                        'hora_fin' => $horario['hora_fin'],
                    ]);
                }
            }
        }

        return redirect()->route('academias.index')->with('success', 'Academia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $academia = Academia::findOrFail($id);
        $academia->delete();

        return redirect()->route('academias.index')->with('success', 'Academia eliminada.');
    }
}
