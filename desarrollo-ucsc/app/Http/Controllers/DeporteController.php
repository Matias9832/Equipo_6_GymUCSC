<?php

namespace App\Http\Controllers;

use App\Models\Deporte;
use Illuminate\Http\Request;

class DeporteController extends Controller
{
    public function index()
    {
        $deportes = Deporte::all();
        return view('admin.mantenedores.deportes.index', compact('deportes'));
    }

    public function create()
    {
        return view('admin.mantenedores.deportes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_deporte' => 'required|string|max:255',
            'jugadores_por_equipo' => 'nullable|integer|min:1',
            'descripcion' => 'nullable|string',
        ]);

        Deporte::create($request->all());
        return redirect()->route('deportes.index')->with('success', 'Deporte creado correctamente.');
    }

    public function edit(Deporte $deporte)
    {
        return view('admin.mantenedores.deportes.edit', compact('deporte'));
    }

    public function update(Request $request, Deporte $deporte)
    {
        $request->validate([
            'nombre_deporte' => 'required|string|max:255',
            'jugadores_por_equipo' => 'nullable|integer|min:1',
            'descripcion' => 'nullable|string',
        ]);

        $deporte->update($request->all());
        return redirect()->route('deportes.index')->with('success', 'Deporte actualizado correctamente.');
    }

    public function destroy(Deporte $deporte)
    {
        $deporte->delete();
        return redirect()->route('deportes.index')->with('success', 'Deporte eliminado correctamente.');
    }
}