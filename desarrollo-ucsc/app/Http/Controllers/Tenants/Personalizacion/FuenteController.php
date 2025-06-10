<?php

namespace App\Http\Controllers\Tenants\Personalizacion;

use App\Http\Controllers\Controller;
use App\Models\Tenants\Fuente;
use Illuminate\Http\Request;

class FuenteController extends Controller
{
    public function index()
    {
        $fuentes = Fuente::paginate(5);
        return view('tenants.personalizacion.fuentes.index', compact('fuentes'));
    }

    public function create()
    {
        return view('tenants.personalizacion.fuentes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_fuente' => 'required|string|max:100',
            'familia_css' => 'required|string|max:100',
            'url_fuente' => 'nullable|url',
        ]);

        Fuente::create($request->only(['nombre_fuente', 'familia_css', 'url_fuente']));

        return redirect()->route('personalizacion.fuentes.index')->with('success', 'Fuente creada correctamente.');
    }

    public function edit(Fuente $fuente)
    {
        return view('tenants.personalizacion.fuentes.edit', compact('fuente'));
    }

    public function update(Request $request, Fuente $fuente)
    {
        $request->validate([
            'nombre_fuente' => 'required|string|max:100',
            'familia_css' => 'required|string|max:100',
            'url_fuente' => 'nullable|url',
        ]);

        $fuente->update($request->only(['nombre_fuente', 'familia_css', 'url_fuente']));

        return redirect()->route('personalizacion.fuentes.index')->with('success', 'Fuente actualizada correctamente.');
    }

    public function destroy(Fuente $fuente)
    {
        $fuente->delete();
        return redirect()->route('personalizacion.fuentes.index')->with('success', 'Fuente eliminada.');
    }
}
