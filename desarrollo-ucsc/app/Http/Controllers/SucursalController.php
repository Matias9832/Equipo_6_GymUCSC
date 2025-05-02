<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\Ciudad;
use App\Models\Marca;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::with(['ciudad', 'marca'])->get();
        return view('admin.sucursales.sucursal.index', compact('sucursales'));
    }

    public function create()
    {
        $ciudades = Ciudad::all();
        $marcas = Marca::all();
        return view('admin.sucursales.sucursal.create', compact('ciudades', 'marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ciudad' => 'required|exists:ciudad,id_ciudad',
            'id_marca' => 'required|exists:marca,id_marca',
            'nombre_suc' => 'required|string|max:100',
            'direccion_suc' => 'required|string|max:100',
        ]);

        Sucursal::create($request->all());

        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada correctamente.');
    }

    public function edit($id_suc)
    {
        $sucursal = Sucursal::findOrFail($id_suc);

        $ciudades = Ciudad::all();
        $marcas = Marca::all();

        return view('admin.sucursales.sucursal.edit', compact('sucursal', 'ciudades', 'marcas'));
    }

    public function update(Request $request, $id_suc)
    {
        $request->validate([
            'id_ciudad' => 'required|exists:ciudad,id_ciudad',
            'id_marca' => 'required|exists:marca,id_marca',
            'nombre_suc' => 'required|string|max:100',
            'direccion_suc' => 'required|string|max:100',
        ]);

        $sucursal = Sucursal::findOrFail($id_suc);
        $sucursal->update($request->all());

        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada correctamente.');
    }

    public function destroy($id_suc)
    {
        $sucursal = Sucursal::findOrFail($id_suc);
        $sucursal->delete();

        return redirect()->route('sucursales.index')->with('success', 'Sucursal eliminada correctamente.');
    }
}
