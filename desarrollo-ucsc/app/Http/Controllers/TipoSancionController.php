<?php
namespace App\Http\Controllers;

use App\Models\TipoSancion;
use Illuminate\Http\Request;

class TipoSancionController extends Controller
{
    public function index()
    {
        $tipos = TipoSancion::all();
        return view('admin.mantenedores.tipos_sancion.index', compact('tipos'));
    }

    public function create()
    {
        return view('admin.mantenedores.tipos_sancion.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'nombre_tipo_sancion' => 'required|string|max:255',
            'descripcion_tipo_sancion' => 'required|string|max:255',
        ]);
        
        TipoSancion::create($request->only('nombre_tipo_sancion', 'descripcion_tipo_sancion'));

        return redirect()->route('tipos_sancion.index')->with('success', 'Tipo de sanción creado correctamente.');
    }

    public function edit(TipoSancion $tipoSancion)
    {
        return view('admin.mantenedores.tipos_sancion.edit', ['tipo' =>$tipoSancion]);
    }

    public function update(Request $request, TipoSancion $tipoSancion)
    {
        $request->validate([
            'nombre_tipo_sancion' => 'required|string|max:255',
            'descripcion_tipo_sancion' => 'required|string|max:255',
        ]);

        $tipoSancion->update($request->only('nombre_tipo_sancion', 'descripcion_tipo_sancion'));

        return redirect()->route('tipos_sancion.index')->with('success', 'Tipo de sanción actualizado correctamente.');
    }

    public function destroy(TipoSancion $tipoSancion)
    {
        $tipoSancion->delete();

        return redirect()->route('tipos_sancion.index')->with('success', 'Tipo de sanción eliminado correctamente.');
    }
}
