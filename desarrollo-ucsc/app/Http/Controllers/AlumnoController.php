<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\CarreraController;

//Manejo de excel
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumnoImport;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumno::query();

        if ($request->has('ocultar_inactivos') && $request->ocultar_inactivos == 'on') {
            $query->where('estado_alumno', 'Activo');
        }

        $alumnos = $query->orderBy('apellido_paterno')->paginate(20);

        return view('admin.mantenedores.alumnos.index', compact('alumnos'));
    }


    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with('error', 'Debes seleccionar un archivo válido para importar.');
        }

        try {
            DB::transaction(function () use ($request) {
                // 1. Desactivar a todos los alumnos
                Alumno::query()->update(['estado_alumno' => 'Inactivo']);

                // 2. Importar el archivo
                Excel::import(new AlumnoImport, $request->file('file'));

                // 3. Obtener RUTs de alumnos activos desde el archivo
                $alumnosActivos = Alumno::where('estado_alumno', 'Activo')->pluck('rut_alumno');

                // 4. Bloquear usuarios relacionados a alumnos que quedaron inactivos
                $alumnosInactivos = Alumno::where('estado_alumno', 'Inactivo')->pluck('rut_alumno');

                Usuario::whereIn('rut', $alumnosInactivos)
                    ->update(['bloqueado_usuario' => true]);

                Usuario::whereIn('rut', $alumnosActivos)
                    ->update(['bloqueado_usuario' => false]);
            });
        } catch (\Exception $e) {
            return redirect()->route('alumnos.index')
                ->with('warning', 'Error durante la importación: ' . $e->getMessage());
        }

        // Recuperar errores guardados durante la importación
        $errores_rut = session('import_errors_missing_rut', []);
        $errores_datos = session('import_errors_incomplete_data', []);

        if (count($errores_rut) > 0 || count($errores_datos) > 0) {
            return redirect()->route('alumnos.index')
                ->with('warning', 'Hubo problemas en algunos registros.')
                ->with('import_errors_missing_rut', $errores_rut)
                ->with('import_errors_incomplete_data', $errores_datos);
        }

        (new CarreraController)->actualizarCarrerasDesdeAlumnos();
        return redirect()->route('alumnos.index')->with('success', 'Alumnos importados exitosamente.');
    }

}