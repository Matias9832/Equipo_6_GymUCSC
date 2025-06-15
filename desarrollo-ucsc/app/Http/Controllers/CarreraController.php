<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Carrera;

use Yajra\DataTables\Facades\DataTables;
class CarreraController extends Controller
{
    public function index(Request $request)
    {
        // Obtiene carreras con paginación de 20 por página
        $carreras = Carrera::where('cantidad_estudiantes', '>', 0)
            ->orderBy('nombre_carrera')
            ->paginate(20);

        return view('admin.mantenedores.carreras.index', compact('carreras'));
    }

    public function data(Request $request)
    {
        $query = Carrera::query();

        return DataTables::of($query)
            ->editColumn('UA', fn($row) => $row->UA ?? '-')
            ->make(true);
    }

    /**
     * Recorre las carreras de la tabla alumnos
     * y las actualiza o crea en la tabla carreras.
     */
    public function actualizarCarrerasDesdeAlumnos()
    {
        Carrera::query()->update(['cantidad_estudiantes' => 0]);

        $carreras = Alumno::select('carrera')
            ->whereNotNull('carrera')
            ->where('estado_alumno', 'Activo')
            ->groupBy('carrera')
            ->selectRaw('carrera, COUNT(*) as total')
            ->get();

        foreach ($carreras as $c) {
            Carrera::updateOrCreate(
                ['nombre_carrera' => $c->carrera],
                [
                    'UA' => null,
                    'cantidad_estudiantes' => $c->total
                ]
            );
        }

        $this->actualizarUACarreras();
    }
    public function actualizarUACarreras()
    {
        $carreras = Carrera::all();

        foreach ($carreras as $carrera) {
            // Obtener el UA más frecuente en alumnos activos para esa carrera
            $ua = Alumno::where('carrera', $carrera->nombre_carrera)
                ->where('estado_alumno', 'Activo')
                ->select('ua_carrera')
                ->groupBy('ua_carrera')
                ->orderByRaw('COUNT(*) DESC')
                ->value('ua_carrera');

            if ($ua) {
                $carrera->UA = $ua;
                $carrera->save();
            }
        }
    }

}
