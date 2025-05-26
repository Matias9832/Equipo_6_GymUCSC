<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Region;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    public function index()
    {
        $ciudades = Ciudad::with('region.pais')->paginate(15);
        return view('admin.mantenedores.ciudades.index', compact('ciudades'));
    }

    public function create()
    {
        $regiones = Region::all();
        return view('admin.mantenedores.ciudades.create', compact('regiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_region' => 'required|exists:region,id_region',
            'nombre_ciudad' => 'required|string|max:255',
        ]);

        Ciudad::create($request->all());

        return redirect()->route('ciudades.index')->with('success', 'Ciudad creada correctamente.');
    }

    public function edit($id_ciudad)
    {
        $ciudad = Ciudad::findOrFail($id_ciudad);
        $regiones = Region::all(); // Obtener todas las regiones
        return view('admin.mantenedores.ciudades.edit', compact('ciudad', 'regiones'));
    }

    public function update(Request $request, $id_ciudad)
    {
        $ciudad = Ciudad::findOrFail($id_ciudad);

        $request->validate([
            'id_region' => 'required|exists:region,id_region',
            'nombre_ciudad' => 'required|string|max:255',
        ]);

        $ciudad->update($request->all());

        return redirect()->route('ciudades.index')->with('success', 'Ciudad actualizada correctamente.');
    }

    public function destroy($id_ciudad)
    {
        $ciudad = Ciudad::findOrFail($id_ciudad);
        $ciudad->delete();

        return redirect()->route('ciudades.index')->with('success', 'Ciudad eliminada correctamente.');
    }
}