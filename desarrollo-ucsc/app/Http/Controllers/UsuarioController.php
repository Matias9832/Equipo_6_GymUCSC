<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Usuario::query()
                ->whereIn('usuario.tipo_usuario', ['estudiante', 'seleccionado']); // 👈 Solo estudiantes y seleccionados

            $query->leftJoin('model_has_roles', function ($join) {
                $join->on('usuario.id_usuario', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', '=', Usuario::class);
            })
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->leftJoin('alumno', 'usuario.rut', '=', 'alumno.rut_alumno')
                ->select([
                    'usuario.id_usuario',
                    'usuario.rut',
                    'usuario.tipo_usuario',
                    'usuario.correo_usuario',
                    'roles.name as rol_name',
                    \DB::raw("CONCAT(alumno.nombre_alumno, ' ', alumno.apellido_paterno, ' ', alumno.apellido_materno) as nombre_usuario"),
                    \DB::raw("CASE 
                        WHEN usuario.tipo_usuario = 'estudiante' THEN 'Estudiante'
                        ELSE 'Seleccionado'
                    END as rol_visible")
                ]);

            return DataTables::of($query)
                ->editColumn('rol_visible', function ($usuario) {
                    $label = $usuario->rol_visible;
                    $class = $usuario->tipo_usuario === 'estudiante' ? 'bg-gradient-success' : 'bg-gradient-warning';
                    return '<span class="badge badge-sm ' . $class . '" style="width:150px;">' . $label . '</span>';
                })
                ->addColumn('acciones', function ($usuario) {
                    $editar = '<a href="' . route('usuarios.edit', $usuario->id_usuario) . '" class="btn btn-link text-primary p-0 m-0 align-baseline" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>';
                    $eliminar = auth()->user()->can('Eliminar Usuarios')
                        ? '<form action="' . route('usuarios.destroy', $usuario->id_usuario) . '" method="POST" class="d-inline">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm(\'¿Estás seguro de que quieres eliminar este usuario?\')" title="Eliminar">'
                        . '<i class="fas fa-trash-alt"></i></button></form>'
                        : '';

                    return $editar .' '. $eliminar;
                })
                ->rawColumns(['rol_visible', 'acciones'])
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $search = $request->search['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->where('usuario.rut', 'like', "%{$search}%")
                                ->orWhere('usuario.correo_usuario', 'like', "%{$search}%")
                                ->orWhere(\DB::raw("CONCAT(alumno.nombre_alumno, ' ', alumno.apellido_paterno, ' ', alumno.apellido_materno)"), 'like', "%{$search}%");
                        });
                    }
                })
                ->make(true);
        }

        return view('admin.mantenedores.usuarios.index');
    }

    public function edit(Usuario $usuario)
    {
        return view('admin.mantenedores.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        // Solo permitir actualizar si es estudiante o seleccionado
        if (!in_array($usuario->tipo_usuario, ['estudiante', 'seleccionado'])) {
            abort(403, 'Solo se puede editar tipo_usuario de estudiantes o seleccionados.');
        }

        $request->validate([
            'tipo_usuario' => 'required|in:estudiante,seleccionado',
        ]);

        $usuario->update([
            'tipo_usuario' => $request->tipo_usuario,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Tipo de usuario actualizado correctamente.');
    }

    public function buscar(Request $request)
    {
        $query = $request->get('q', '');

        $usuarios = Usuario::with('alumno')
            ->whereIn('tipo_usuario', ['estudiante', 'seleccionado']) // Solo estudiantes y seleccionados
            ->where(function ($q) use ($query) {
                $q->where('rut', 'like', "%$query%")
                ->orWhereHas('alumno', function ($q2) use ($query) {
                    $q2->whereRaw("CONCAT(nombre_alumno, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", ["%$query%"]);
                });
            })
            ->whereHas('alumno') // Solo usuarios que tengan alumno relacionado
            ->limit(10)
            ->get();

        return response()->json($usuarios->map(function ($usuario) {
            $nombreCompleto = $usuario->alumno
                ? "{$usuario->alumno->nombre_alumno} {$usuario->alumno->apellido_paterno} {$usuario->alumno->apellido_materno}"
                : 'Nombre no disponible';

            return [
                'id' => $usuario->id_usuario,
                'text' => "{$usuario->rut} - {$nombreCompleto}",
            ];
        }));
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}