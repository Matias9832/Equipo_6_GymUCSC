<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Desactivar a todos los alumnos
                Alumno::query()->update(['estado_alumno' => 'Inactivo']);

                // 2. Importar el archivo
                Excel::import(new AlumnoImport, $request->file('file'));

                // 3. Bloquear usuarios relacionados a alumnos que no quedaron activos
                $alumnosInactivos = Alumno::where('estado_alumno', '!=', 'activo')->pluck('rut_alumno');

                Usuario::whereIn('rut', $alumnosInactivos)
                    ->update(['bloqueado_usuario' => true]);

                // Desbloquear usuarios relacionados a alumnos activos
                $alumnosActivos = Alumno::where('estado_alumno', 'activo')->pluck('rut_alumno');

                Usuario::whereIn('rut', $alumnosActivos)
                    ->update(['bloqueado_usuario' => false]);
            });
        } catch (\Exception $e) {
            return redirect()->route('alumnos.index')
                ->with('warning', 'Error durante la importación: ' . $e->getMessage());
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