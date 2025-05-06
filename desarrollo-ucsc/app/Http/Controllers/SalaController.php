<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    public function index()
    {
        $sucursalActiva = session('sucursal_activa');

        $salas = Sala::where('id_suc', $sucursalActiva)->get();

        return view('admin.sucursales.sala.index', compact('salas'));
    }

    public function create()
    {
        return view('admin.sucursales.sala.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_sala' => 'required|string|max:255',
            'aforo_sala' => 'required|integer|min:1',
            'horario_apertura' => 'required|date_format:H:i',
            'horario_cierre' => 'required|date_format:H:i|after:horario_apertura',
        ]);

        $data = $request->all();
        $data['id_suc'] = session('sucursal_activa');
        $data['activo'] = false;

        Sala::create($data);

        return redirect()->route('salas.index')->with('success', 'Sala creada correctamente.');
    }

    public function edit($id)
    {
        $sala = Sala::findOrFail($id);

        return view('admin.sucursales.sala.edit', compact('sala'));
    }

    public function update(Request $request, Sala $sala)
    {
        $request->validate([
            'nombre_sala' => 'required|string|max:255',
            'aforo_sala' => 'required|integer|min:1',
        ]);

        $sala->update($request->all());

        return redirect()->route('salas.index')->with('success', 'Sala actualizada correctamente.');
    }

    public function destroy(Sala $sala)
    {
        $sala->delete();

        return redirect()->route('salas.index')->with('success', 'Sala eliminada correctamente.');
    }
}
