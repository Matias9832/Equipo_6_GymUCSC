<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Taller;
use App\Models\Usuario;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class AsistenciaTallerController extends Controller
{
    public function ver(Request $request, Taller $taller)
    {
        if ($request->ajax()) {
            $asistencias = DB::table('taller_usuario')
                ->join('usuario', 'usuario.id_usuario', '=', 'taller_usuario.id_usuario')
                ->leftJoin('alumno', 'usuario.rut', '=', 'alumno.rut_alumno')
                ->select(
                    'taller_usuario.id_usuario',
                    'usuario.rut',
                    DB::raw("CONCAT_WS(' ', alumno.nombre_alumno, alumno.apellido_paterno, alumno.apellido_materno) as nombre"),
                    'alumno.carrera',
                    'alumno.sexo_alumno',
                    'taller_usuario.fecha_asistencia'
                )
                ->where('taller_usuario.id_taller', $taller->id_taller);

            return DataTables::of($asistencias)
                ->filterColumn('nombre', function ($query, $keyword) {
                    $query->whereRaw("LOWER(CONCAT_WS(' ', alumno.nombre_alumno, alumno.apellido_paterno, alumno.apellido_materno)) LIKE ?", ["%".strtolower($keyword)."%"]);
                })
                ->addColumn('nombre_html', function ($row) {
                    return '<p class="text-xs font-weight-bold mb-0">' . e($row->nombre) . '</p>';
                })
                ->addColumn('sexo_html', function ($row) {
                    $color = $row->sexo_alumno === 'M' ? 'bg-gradient-blue' : 'bg-gradient-pink';
                    return '<span class="badge badge-sm border ' . $color . '" style="width: 35px;">' . $row->sexo_alumno . '</span>';
                })
                ->addColumn('fecha_html', function ($row) {
                    return '<span class="text-sm">' . e(Carbon::parse($row->fecha_asistencia)->format('d-m-Y')) . '</span>';
                })
                ->addColumn('acciones', function ($row) use ($taller) {
                    $fecha = Carbon::parse($row->fecha_asistencia)->format('Y-m-d');
                    $url = route('asistencia.destroy', [
                        'taller' => $taller->id_taller,
                        'usuario' => $row->id_usuario,
                        'fecha' => $fecha,
                    ]);

                    return '
                        <form action="' . $url . '" method="POST" class="d-inline-block eliminar-asistencia-form" data-id="' . $row->id_usuario . '" data-fecha="' . $fecha . '">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" title="Eliminar asistencia" onclick="return confirm(\'¿Eliminar asistencia?\')">
                                <i class="ni ni-fat-remove"></i>
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['nombre_html', 'sexo_html', 'fecha_html','acciones'])
                ->make(true);
        }

        return view('admin.talleres.asistencia.ver', compact('taller'));
    }

    public function verMiAsistencia($tallerId)
    {
        $userId = auth()->id();
        $taller = Taller::findOrFail($tallerId);

        $asistencias = DB::table('taller_usuario')
            ->where('id_taller', $tallerId)
            ->where('id_usuario', $userId)
            ->orderBy('fecha_asistencia', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->fecha_asistencia)->format('Y-m');
            });

        return view('usuarios.mis_asistencias', compact('taller', 'asistencias'));
    }


    // Mostrar formulario para registrar asistencia manual
    public function registrar(Request $request, Taller $taller)
    {
        $usuarios = Usuario::where('tipo_usuario', '!=', 'admin')
            ->with('alumno')
            ->get();

        $diasValidos = $taller->horarios
            ->pluck('dia_taller')
            ->map(fn($dia) => strtolower($dia))
            ->unique()
            ->values()
            ->toArray();

        // Toma la fecha del request si existe, si no usa old(), si no null
        $fechaSeleccionada = $request->input('fecha', old('fecha_asistencia'));

        return view('admin.talleres.asistencia.registrar', compact('taller', 'usuarios', 'diasValidos', 'fechaSeleccionada'));
    }

    // Procesar registro de asistencia
    public function guardarRegistro(Request $request, Taller $taller)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'fecha_asistencia' => 'required|date',
        ], [
            'id_usuario.required' => 'Debes seleccionar un usuario.',
            'fecha_asistencia.required' => 'La fecha de asistencia es obligatoria.',
        ]);

        // Validar que la fecha coincide con un día válido del taller
        $dia = Carbon::parse($request->fecha_asistencia)->locale('es')->isoFormat('dddd');

        $esValido = $taller->horarios->contains(function ($horario) use ($dia) {
            return strtolower($horario->dia_taller) === strtolower($dia);
        });

        if (! $esValido) {
            return back()->withErrors(['fecha_asistencia' => 'La fecha seleccionada no corresponde a un día de taller.']);
        }

        // Insertar o actualizar registro
        DB::table('taller_usuario')->updateOrInsert([
            'id_usuario' => $request->id_usuario,
            'id_taller' => $taller->id_taller,
            'fecha_asistencia' => $request->fecha_asistencia,
        ]);

        return redirect()
            ->route('asistencia.registrar', [
                'taller' => $taller->id_taller,
                'fecha' => $request->fecha_asistencia // <-- pasa la fecha como parámetro
            ])
            ->with('success', 'Asistencia registrada correctamente.');
    }

    // Eliminar asistencia
    public function destroy(Taller $taller, $id_usuario, $fecha)
    {
        DB::table('taller_usuario')
            ->where('id_taller', $taller->id_taller)
            ->where('id_usuario', $id_usuario)
            ->where('fecha_asistencia', $fecha)
            ->delete();

        return redirect()
            ->route('asistencia.ver', ['taller' => $taller->id_taller])
            ->with('success', 'Asistencia eliminada correctamente.');
    }
}
