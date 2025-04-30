<?php

namespace App\Http\Controllers;
use App\Models\TipoEspacio;

use Illuminate\Http\Request;

class TipoEspacioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoEspacio::all();
        return view('tipos_espacio.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipos_espacio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_tipo' => 'required|string|max:255',
        ]);
    
        TipoEspacio::create($request->all());
    
        return redirect()->route('tipos_espacio.index')->with('success', 'Tipo de espacio creado.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoEspacio $tipoEspacio)
    {
        return view('tipos_espacio.edit', ['tipo' => $tipoEspacio]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoEspacio $tipoEspacio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipoEspacio->update($request->only('nombre_espacio'));

        return redirect()->route('tipos_espacio.index')->with('success', 'Tipo de espacio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoEspacio $tipoEspacio)
    {
        $tipoEspacio->delete();

        return redirect()->route('tipos_espacio.index')->with('success', 'Tipo de espacio eliminado correctamente.');
    }
}
