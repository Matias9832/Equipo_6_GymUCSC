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
        $request->validate([
            'nombre_academia' => 'required|string|max:255',
            'descripcion_academia' => 'required|string',
            'id_espacio' => 'required',
            'matricula'=> 'required|string',
            'mensualidad' => 'required|string',
            'horarios' => 'required|array',
            'horarios.*.dia' => 'required|string',
            'horarios.*.hora_inicio' => 'required',
            'horarios.*.hora_fin' => 'required',
        ]);

        $academia = Academia::create($request->only([
            'nombre_academia',
            'descripcion_academia',
            'id_espacio',
            'implementos',
            'matricula',
            'mensualidad'
        ]));

        foreach ($request->horarios as $horario) {
            $academia->horarios()->create($horario);
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
        $request->validate([
            'nombre_academia' => 'required|string|max:255',
            'descripcion_academia' => 'required|string',
            'id_espacio' => 'required',
            'mensualidad' => 'required|string',
            'implementos' => 'nullable|string',
            'matricula' => 'required|string',
            'horarios' => 'required|array',
            'horarios.*.dia' => 'required|string',
            'horarios.*.hora_inicio' => 'required',
            'horarios.*.hora_fin' => 'required',
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

        // Eliminar horarios existentes y volver a crear
        $academia->horarios()->delete();

        foreach ($request->horarios as $horario) {
            $academia->horarios()->create($horario);
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
