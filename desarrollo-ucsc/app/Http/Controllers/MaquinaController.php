<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maquina;

class MaquinaController extends Controller
{
    public function index()
    {
        $maquinas = Maquina::all();
        return view('admin.mantenedores.maquinas.index', compact('maquinas'));
    }

    public function create()
    {
        return view('admin.mantenedores.maquinas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_maq' => 'required|string|max:255',
            'estado_maq' => 'required|boolean',
        ]);

        Maquina::create($request->all());

        return redirect()->route('maquinas.index')->with('success', 'Máquina creada exitosamente.');
    }

    public function edit($id)
    {
        $maquina = Maquina::findOrFail($id);
        return view('admin.mantenedores.maquinas.edit', compact('maquina'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_maq' => 'required|string|max:255',
            'estado_maq' => 'required|boolean',
        ]);

        $maquina = Maquina::findOrFail($id);
        $maquina->update($request->all());

        return redirect()->route('maquinas.index')->with('success', 'Máquina actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $maquina = Maquina::findOrFail($id);
        $maquina->delete();

        return redirect()->route('maquinas.index')->with('success', 'Máquina eliminada exitosamente.');
    }
}