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

        try {
            // Importar el archivo con la clase AlumnoImport
            Excel::import(new AlumnoImport, $request->file('file'));
        } catch (\Exception $e) {
            return redirect()->route('alumnos.index')
                ->with('warning', 'Error en los encabezados del archivo: ' . $e->getMessage());
        }

        // Recuperar errores que se guardaron en la sesión durante la importación
        $errores_rut = session('import_errors_missing_rut', []);
        $errores_datos = session('import_errors_incomplete_data', []);

        // Si hay errores, redireccionar con advertencias
        if (count($errores_rut) > 0 || count($errores_datos) > 0) {
            return redirect()->route('alumnos.index')
                ->with('warning', 'Hubo problemas en algunos registros.')
                ->with('import_errors_missing_rut', $errores_rut)
                ->with('import_errors_incomplete_data', $errores_datos);
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('alumnos.index')->with('success', 'Alumnos importados exitosamente.');
    }
}