<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::all(); // Obtén todos los alumnos
        return view('admin.mantenedores.alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        return view('admin.mantenedores.alumnos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut_alumno' => 'required|unique:alumno,rut_alumno',
            'nombre_alumno' => 'required',
            'carrera' => 'required',
            'estado_alumno' => 'required',
        ]);

        Alumno::create($request->all());

        return redirect()->route('alumnos.index')->with('success', 'Alumno creado correctamente.');
    }

    public function edit($rut_alumno)
    {
        $alumno = Alumno::findOrFail($rut_alumno);
        return view('admin.mantenedores.alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, $rut_alumno)
    {
        $alumno = Alumno::findOrFail($rut_alumno);

        $request->validate([
            'rut_alumno' => 'required|unique:alumno,rut_alumno,' . $rut_alumno . ',rut_alumno',
            'nombre_alumno' => 'required',
            'carrera' => 'required',
            'estado_alumno' => 'required',
        ]);

        $alumno->update($request->all());

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy($rut_alumno)
    {
        $alumno = Alumno::findOrFail($rut_alumno);
        $alumno->delete();

        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}