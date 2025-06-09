<?php

namespace App\Http\Controllers\Tenants\Personalizacion;

use App\Http\Controllers\Controller;
use App\Models\Tenants\Tema;
use App\Models\Tenants\Color;
use App\Models\Tenants\Fuente;
use Illuminate\Http\Request;

class TemaController extends Controller
{
    public function index()
    {
        $temas = Tema::paginate(10);
        return view('tenants.personalizacion.temas.index', compact('temas'));
    }

    public function create()
    {
        $colores = Color::all();
        $fuentes = Fuente::all();
        return view('tenants.personalizacion.temas.create', compact('colores', 'fuentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_tema' => 'required|string|max:100',
            'id_fuente' => 'nullable|string',

            // Colores base
            'bs_primary' => 'required|string|size:7',
            'bs_success' => 'required|string|size:7',
            'bs_danger' => 'required|string|size:7',

            // Variantes de colores
            'primary_focus' => 'required|string|size:7',
            'border_primary_focus' => 'required|string|size:7',
            'primary_gradient' => 'required|string|size:7',

            'success_focus' => 'required|string|size:7',
            'border_success_focus' => 'required|string|size:7',
            'success_gradient' => 'required|string|size:7',

            'danger_focus' => 'required|string|size:7',
            'border_danger_focus' => 'required|string|size:7',
            'danger_gradient' => 'required|string|size:7',
        ]);

        $data = $request->only([
            'nombre_tema',
            'bs_primary',
            'bs_success',
            'bs_danger',

            'primary_focus',
            'border_primary_focus',
            'primary_gradient',

            'success_focus',
            'border_success_focus',
            'success_gradient',

            'danger_focus',
            'border_danger_focus',
            'danger_gradient',
        ]);

        if ($request->id_fuente === 'Sin Fuente') {
            $data['nombre_fuente'] = null;
            $data['familia_css'] = null;
            $data['url_fuente'] = null;
        } else {
            $fuente = Fuente::find($request->id_fuente);
            if ($fuente) {
                $data['nombre_fuente'] = $fuente->nombre_fuente;
                $data['familia_css'] = $fuente->familia_css;
                $data['url_fuente'] = $fuente->url_fuente;
            } else {
                return back()->withErrors(['id_fuente' => 'Fuente no encontrada.'])->withInput();
            }
        }

        Tema::create($data);

        return redirect()->route('personalizacion.temas.index')->with('success', 'Tema creado correctamente.');
    }


    public function edit(Tema $tema)
    {
        $colores = Color::all();
        $fuentes = Fuente::all();
        return view('tenants.personalizacion.temas.edit', compact('tema', 'colores', 'fuentes'));
    }
    public function update(Request $request, Tema $tema)
    {
        $request->validate([
            'nombre_tema' => 'required|string|max:100',
            'id_fuente' => 'nullable|string',

            // Colores
            'bs_primary' => 'required|string|size:7',
            'bs_success' => 'required|string|size:7',
            'bs_danger' => 'required|string|size:7',

            'primary_focus' => 'required|string|size:7',
            'border_primary_focus' => 'required|string|size:7',
            'primary_gradient' => 'required|string|size:7',

            'success_focus' => 'required|string|size:7',
            'border_success_focus' => 'required|string|size:7',
            'success_gradient' => 'required|string|size:7',

            'danger_focus' => 'required|string|size:7',
            'border_danger_focus' => 'required|string|size:7',
            'danger_gradient' => 'required|string|size:7',
        ]);

        $data = $request->only([
            'nombre_tema',
            'bs_primary',
            'bs_success',
            'bs_danger',

            'primary_focus',
            'border_primary_focus',
            'primary_gradient',

            'success_focus',
            'border_success_focus',
            'success_gradient',

            'danger_focus',
            'border_danger_focus',
            'danger_gradient',
        ]);

        // Lógica de fuente (idéntica a la de store)
        if ($request->id_fuente === 'Sin Fuente') {
            $data['nombre_fuente'] = null;
            $data['familia_css'] = null;
            $data['url_fuente'] = null;
        } else {
            $fuente = Fuente::find($request->id_fuente);
            if ($fuente) {
                $data['nombre_fuente'] = $fuente->nombre_fuente;
                $data['familia_css'] = $fuente->familia_css;
                $data['url_fuente'] = $fuente->url_fuente;
            } else {
                return back()->withErrors(['id_fuente' => 'Fuente no encontrada.'])->withInput();
            }
        }

        $tema->update($data);

        return redirect()->route('personalizacion.temas.index')->with('success', 'Tema actualizado correctamente.');
    }

    public function destroy(Tema $tema)
    {
        $tema->delete();
        return redirect()->route('temas.index')->with('success', 'Tema eliminado correctamente.');
    }
}
