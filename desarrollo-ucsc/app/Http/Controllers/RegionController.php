<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Pais;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regiones = Region::with('pais')->get(); // Obtener regiones con su país asociado
        return view('admin.mantenedores.regiones.index', compact('regiones'));
    }

    public function create()
    {
        $paises = Pais::all(); // Obtener todos los países
        return view('admin.mantenedores.regiones.create', compact('paises'));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_pais' => 'required|exists:pais,id_pais',
        'nombre_region' => 'required|string|max:255',
    ]);

    Region::create($request->all());

    return redirect()->route('regiones.index')->with('success', 'Región creada correctamente.');
}

    public function edit($id_region)
    {
        $region = Region::findOrFail($id_region);
        $paises = Pais::all(); // Obtener todos los países
        return view('admin.mantenedores.regiones.edit', compact('region', 'paises'));
    }

    public function update(Request $request, $id_region)
    {
        $region = Region::findOrFail($id_region);

        $request->validate([
            'id_pais' => 'required|exists:pais,id_pais',
            'nombre_region' => 'required|string|max:255',
        ]);

        $region->update($request->all());

        return redirect()->route('regiones.index')->with('success', 'Región actualizada correctamente.');
    }

    public function destroy($id_region)
    {
        $region = Region::findOrFail($id_region);
        $region->delete();

        return redirect()->route('regiones.index')->with('success', 'Región eliminada correctamente.');
    }
}