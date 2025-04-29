<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

//Manejo de excel
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumnoImport;

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

    public function import(Request $request)
    {
        // Validar el archivo
        $request->validate([
            'file' => 'required|mimes:xlsx,csv' // Acepta solo archivos Excel o CSV
        ]);

        // Importar el archivo con la clase AlumnoImport
        Excel::import(new AlumnoImport, $request->file('file'));

        // Redirigir con un mensaje de éxito
        return redirect()->route('alumnos.index')->with('success', 'Alumnos importados exitosamente.');
    }
}