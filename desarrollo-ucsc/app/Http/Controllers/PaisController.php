<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index()
    {
        $paises = Pais::all(); // Obtener todos los registros de la tabla 'pais'
        return view('admin.mantenedores.paises.index', compact('paises'));
    }

    public function create()
    {
        return view('admin.mantenedores.paises.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_pais' => 'required|string|max:255',
            'bandera_pais' => 'required|string|max:255',
        ]);

        Pais::create($request->all());

        return redirect()->route('paises.index')->with('success', 'País creado correctamente.');
    }

    public function edit($id_pais)
    {
        $pais = Pais::findOrFail($id_pais);
        return view('admin.mantenedores.paises.edit', compact('pais'));
    }

    public function update(Request $request, $id_pais)
    {
        $pais = Pais::findOrFail($id_pais);

        $request->validate([
            'nombre_pais' => 'required|string|max:255',
            'bandera_pais' => 'required|string|max:255',
        ]);

        $pais->update($request->all());

        return redirect()->route('paises.index')->with('success', 'País actualizado correctamente.');
    }

    public function destroy($id_pais)
    {
        $pais = Pais::findOrFail($id_pais);
        $pais->delete();

        return redirect()->route('paises.index')->with('success', 'País eliminado correctamente.');
    }
}