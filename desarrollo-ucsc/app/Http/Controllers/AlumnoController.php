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