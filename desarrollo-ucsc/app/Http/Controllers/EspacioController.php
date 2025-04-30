<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\Request;

class EspacioController extends Controller
{
    public function index()
    {
        $espacios = Espacio::with(['tipo'])->get();
        return view('admin.mantenedores.espacios.index', compact('espacios'));
    }

    public function create()
    {
        $tipos = \App\Models\TipoEspacio::all();
        return view('admin.mantenedores.espacios.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_espacio' => 'required|string|max:255',
            'tipo_espacio' => 'required|integer|exists:tipos_espacio,id',
            'id_suc' => 'required|integer',
        ]);

        Espacio::create($request->all());

        return redirect()->route('espacios.index')->with('success', 'Espacio creado correctamente.');
    }

    public function edit($espacio)
    {
        $espacio = Espacio::findOrFail($espacio);
        return view('admin.mantenedores.espacios.edit', compact('espacio'));
    }

    public function update(Request $request, Espacio $espacio)
    {
        

        $request->validate([
            'nombre_espacio' => 'required|string|max:255',
            'tipo_espacio' => 'required',
            'id_suc' => 'required|integer',
        ]);

        $espacio->update($request->all());

        return redirect()->route('espacios.index')->with('success', 'Espacio actualizado correctamente.');
    }

    public function destroy( Espacio $espacio)
    {
        $espacio->delete();

        return redirect()->route('espacios.index')->with('success', 'Espacio eliminado correctamente.');
    }
}