<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('admin.mantenedores.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.mantenedores.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_rol' => 'required|string|max:255|unique:rol,nombre_rol',
        ]);

        Rol::create($request->all());

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function edit(Rol $rol)
    {
        return view('admin.mantenedores.roles.edit', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'nombre_rol' => 'required|string|max:255|unique:rol,nombre_rol,' . $rol->id_rol . ',id_rol',
        ]);

        $rol->update($request->all());

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}