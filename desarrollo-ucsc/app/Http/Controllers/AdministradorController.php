<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrador;
use App\Models\Usuario;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // Importar la clase Log
use Yajra\DataTables\Facades\DataTables;

class AdministradorController extends Controller
{
    public function index()
    {
        // Paginar administradores (20 por página), manteniendo relación con sucursales activas
        $administradores = Administrador::with([
            'sucursales' => function ($query) {
                $query->wherePivot('activa', true);
            }
        ])->paginate(20);

        $usuarios = Usuario::with('roles')->get();

        return view('admin.mantenedores.administradores.index', compact('administradores', 'usuarios'));
    }

    public function data(Request $request)
    {
        $query = DB::table('administrador')
            ->join('usuario', 'administrador.rut_admin', '=', 'usuario.rut')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('usuario.id_usuario', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', Usuario::class);
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->leftJoin('admin_sucursal', function ($join) {
                $join->on('administrador.id_admin', '=', 'admin_sucursal.id_admin')
                    ->where('admin_sucursal.activa', 1);
            })
            ->leftJoin('sucursal', 'admin_sucursal.id_suc', '=', 'sucursal.id_suc')
            ->select(
                'administrador.id_admin',
                'administrador.rut_admin',
                'administrador.nombre_admin',
                'usuario.correo_usuario as correo_usuario',
                'roles.name as rol_name',
                'sucursal.nombre_suc as nombre_suc'
            );

        return DataTables::of($query)
            ->editColumn('correo_usuario', fn($admin) => $admin->correo_usuario ?? '-')
            ->editColumn('rol_name', function ($admin) {
                $rolText = $admin->rol_name ?? 'Sin rol';
                return '<span class="badge badge-sm bg-gradient-info" style="width: 150px !important;">' . e($rolText) . '</span>';
            })
            ->editColumn('nombre_suc', fn($admin) => $admin->nombre_suc ?? 'Sin sucursal')
            ->addColumn('acciones', function ($admin) {
                $editUrl = route('administradores.edit', $admin->id_admin);
                $deleteUrl = route('administradores.destroy', $admin->id_admin);

                return '
        <td class="align-middle text-center">
            <a href="' . $editUrl . '" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                <i class="fas fa-pen-to-square text-info"></i>
            </a>
            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar este administrador?\')">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" title="Eliminar">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </td>';
            })
            ->rawColumns(['rol_name', 'acciones'])
            ->toJson();
    }

    public function create()
    {
        // Obtener todas las sucursales
        $sucursales = Sucursal::all();
        return view('admin.mantenedores.administradores.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut_admin' => 'required|string|unique:administrador,rut_admin|unique:usuario,rut',
            'nombre_admin' => 'required|string|max:255',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario',
            'rol' => 'required|in:Director,Docente,Coordinador,Visor QR',
        ]);

        try {
            // Generar una contraseña aleatoria de 6 caracteres
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);

            // Crear el usuario
            $usuario = Usuario::create([
                'rut' => $request->rut_admin,
                'correo_usuario' => $request->correo_usuario,
                'tipo_usuario' => 'admin',
                'bloqueado_usuario' => 0,
                'activado_usuario' => 1,
                'contrasenia_usuario' => Hash::make($password),
            ]);

            // Asignar el rol
            $usuario->assignRole($request->rol);

            // Manejar la foto de perfil si se proporciona
            $fotoPath = null;
            if ($request->hasFile('foto_perfil')) {
                $foto = $request->file('foto_perfil');
                $fotoNombre = uniqid() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('img/perfiles'), $fotoNombre);
                $fotoPath = 'img/perfiles/' . $fotoNombre;
}
            // Crear el administrador
            $administrador = Administrador::create([
                'rut_admin' => $request->rut_admin,
                'nombre_admin' => $request->nombre_admin,
                'fecha_creacion' => now(),
                'foto_perfil' => 'default.png',
            ]);

            // Asignar la sucursal al administrador
            DB::table('admin_sucursal')->insert([
                'id_admin' => $administrador->id_admin,
                'id_suc' => $request->sucursal_id,
                'activa' => true,
            ]);

            // Enviar el correo con la contraseña
            Mail::to($usuario->correo_usuario)->send(new \App\Mail\AdministradorPasswordMail($request->nombre_admin, $password));

            return redirect()->route('administradores.index')->with('success', 'Administrador creado correctamente y se ha enviado la contraseña por correo.');
        } catch (\Exception $e) {
            // Manejar errores
            Log::error('Error al crear administrador: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error al crear el administrador. Inténtalo nuevamente.']);
        }
    }

    /**
     * Muestra el formulario para editar un administrador existente.
     */
    public function edit($id)
    {
        $administrador = Administrador::findOrFail($id);
        $usuario = Usuario::where('rut', $administrador->rut_admin)->firstOrFail();
        $sucursales = Sucursal::all();
        $sucursalSeleccionada = DB::table('admin_sucursal')
            ->where('id_admin', $id)
            ->where('activa', true)
            ->first();
        return view('admin.mantenedores.administradores.edit', compact('administrador', 'usuario', 'sucursales', 'sucursalSeleccionada'));
    }
    /**
     * Actualiza un administrador existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $administrador = Administrador::findOrFail($id);

        $request->validate([
            'nombre_admin' => 'required|string|max:255',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario,' . $administrador->rut_admin . ',rut',
            'rol' => 'required|in:Director,Docente,Coordinador,Visor QR',
        ]);

        // Actualizar el administrador
        $administrador = Administrador::findOrFail($id);
        $administrador->update([
            'nombre_admin' => $request->nombre_admin,
        ]);

        // Actualizar el usuario
        $usuario = Usuario::where('rut', $administrador->rut_admin)->first();
        $usuario->update([
            'correo_usuario' => $request->correo_usuario,
        ]);
        $usuario->syncRoles([$request->rol]); // Cambiar rol

        // Actualizar la sucursal
        DB::table('admin_sucursal')
            ->where('id_admin', $administrador->id_admin)
            ->delete();

        DB::table('admin_sucursal')->insert([
            'id_admin' => $administrador->id_admin,
            'id_suc' => $request->sucursal_id,
            'activa' => true,
        ]);
        return redirect()->route('administradores.index')->with('success', 'Administrador actualizado correctamente.');
    }


    public function destroy(Administrador $administrador)
    {
        // Eliminar el administrador
        $administrador->delete();
        // Eliminar el usuario asociado
        Usuario::where('rut', $administrador->rut_admin)->delete();

        return redirect()->route('administradores.index')->with('success', 'Administrador eliminado correctamente.');
    }
}