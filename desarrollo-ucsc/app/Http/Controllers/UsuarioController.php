<?php

namespace App\Http\Controllers;

use \App\Models\Administrador;
use App\Models\Usuario;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
                ->leftJoin('administrador', 'usuario.rut', '=', 'administrador.rut_admin')
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
                    $eliminar = auth()->user()->can('Eliminar Usuarios')
                        ? '<form action="' . route('usuarios.destroy', $usuario->id_usuario) . '" method="POST" class="d-inline">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm(\'¿Estás seguro de que quieres eliminar este usuario?\')" title="Eliminar">'
                        . '<i class="fas fa-trash-alt"></i></button></form>'
                        : '';

                    return $eliminar;
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
        $administrador = Administrador::where('rut_admin', $usuario->rut)->firstorfail();
        return view('admin.mantenedores.usuarios.edit', compact('usuario', 'administrador'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $rules = [
            'rut' => 'required|string|unique:usuario,rut,' . $usuario->id_usuario . ',id_usuario',
            'nombre_admin' => 'required|string|max:255',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario,' . $usuario->id_usuario . ',id_usuario',
        ];
        // Si el usuario NO es admin, entonces validamos tipo_usuario
        if ($usuario->tipo_usuario !== 'admin') {
            $rules['tipo_usuario'] = 'required|in:estudiante,seleccionado';
        } else {
            $rules['rol'] = 'required|in:Docente,Coordinador,Visor QR'; // Si es admin, validamos el rol
        }

        $request->validate($rules);



        if ($request->correo_usuario !== $request->correo_antiguo) {
            // Si el correo ha cambiado, se envía un nuevo correo con la contraseña
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
            $data = [
                'nombre_admin' => $request->nombre_admin,
                'correo_usuario' => $request->correo_usuario,
                'contrasenia_usuario' => Hash::make($password),
            ];

            Mail::to($usuario->correo_usuario)->send(new \App\Mail\AdministradorPasswordMail($request->nombre_admin, $password));

        } else {
            // Si el correo no ha cambiado, no se actualiza el campo correo_usuario
            $data = [
                'nombre_admin' => $request->nombre_admin,
            ];
        }

        // Solo actualiza tipo_usuario si no es admin
        if ($usuario->tipo_usuario !== 'admin') {
            $data['tipo_usuario'] = $request->tipo_usuario;
            $usuario->syncRoles([]); // Asegúrate de quitar cualquier rol si ya no es admin
        }

        $usuario->update($data);

        $administrador = Administrador::where('rut_admin', $request->rut)->firstorfail();
        $administrador->update([
            'nombre_admin' => $request->nombre_admin,
        ]);

        // Si es admin, sincroniza el rol
        if ($usuario->tipo_usuario === 'admin' && $request->has('rol')) {
            $usuario->syncRoles([$request->rol]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function buscar(Request $request)
    {
        $query = $request->get('q', '');

        $usuarios = Usuario::with('alumno')
            ->where('rut', 'like', "%$query%")
            ->orWhereHas('alumno', function ($queryBuilder) use ($query) {
                $queryBuilder->where('nombre_alumno', 'like', "%$query%")
                    ->orWhere('apellido_paterno', 'like', "%$query%")
                    ->orWhere('apellido_materno', 'like', "%$query%");
            })
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
        Administrador::where('rut_admin', $usuario->rut)->delete(); // Eliminar el administrador asociado
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}