<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\Request;

class EspacioController extends Controller
{
    public function index()
    {
        $sucursalActiva = session('sucursal_activa');
        
        $espacios = Espacio::with(['tipo'])->where('id_suc', $sucursalActiva)->get();

        return view('admin.sucursales.espacios.index', compact('espacios'));
    }

    public function create()
    {
        $tipos = \App\Models\TipoEspacio::all();
        
        return view('admin.sucursales.espacios.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_espacio' => 'required|string|max:255',
            'tipo_espacio' => 'required|integer|exists:tipos_espacio,id',
        ]);

        $request->merge(['id_suc' => session('sucursal_activa')]);

        Espacio::create($request->all());

        return redirect()->route('espacios.index')->with('success', 'Espacio creado correctamente.');
    }

    public function edit($espacio)
    {
        $espacio = Espacio::findOrFail($espacio);
        $tipos = \App\Models\TipoEspacio::all();
        
        return view('admin.sucursales.espacios.edit', compact('espacio', 'tipos'));
    }

    public function update(Request $request, Espacio $espacio)
    {
        $request->validate([
            'nombre_espacio' => 'required|string|max:255',
            'tipo_espacio' => 'required',
        ]);

        $espacio->update($request->all());

        return redirect()->route('espacios.index')->with('success', 'Espacio actualizado correctamente.');
    }

    public function destroy(Espacio $espacio)
    {
        $espacio->delete();

        return redirect()->route('espacios.index')->with('success', 'Espacio eliminado correctamente.');
    }
}
