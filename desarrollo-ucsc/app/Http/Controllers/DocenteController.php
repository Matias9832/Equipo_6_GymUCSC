<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Administrador;
use App\Models\Usuario;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use App\View\Components\CardDocente;

class DocenteController extends Controller
{
    public function index()
    {
        Administrador::whereHas('sucursales', function ($query) {
            $query->where('admin_sucursal.activa', true)
                ->where('admin_sucursal.id_suc', session('sucursal_activa'));
        })->with([
            'sucursales' => function ($query) {
                $query->wherePivot('activa', true);
            }
        ])->paginate(20);
        return view('admin.mantenedores.docentes.index');
    }

    public function indexPerfil()
    {
        $admin = auth()->user();

        $administrador = Administrador::where('rut_admin', $admin->rut)
            ->with([
                'sucursales' => function ($query) {
                    $query->wherePivot('activa', true);
                }
            ])->first();
        $talleres = $administrador->talleres;
        $rol = $admin->roles->pluck('name')->first(); // Solo un rol
        $sucursal = $administrador->sucursales->first();

        return view('admin.mantenedores.docentes.mi-perfil.index', compact('administrador', 'admin', 'rol', 'sucursal','talleres'));
    }

    public function data(Request $request)
    {
        $sucursalId = session('sucursal_activa');

        $query = DB::table('administrador')
            ->join('usuario', 'administrador.rut_admin', '=', 'usuario.rut')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('usuario.id_usuario', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', Usuario::class);
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->leftJoin('admin_sucursal', function ($join) {
                $join->on('administrador.id_admin', '=', 'admin_sucursal.id_admin')
                    ->where('admin_sucursal.activa', true);
            })
            ->whereIn('roles.name', ['Docente', 'Coordinador'])
            ->where('admin_sucursal.id_suc', $sucursalId)
            ->select(
                'administrador.id_admin',
                'administrador.rut_admin',
                'administrador.nombre_admin',
                'usuario.correo_usuario as correo_usuario',
                'roles.name as rol_name'
            );

        return DataTables::of($query)
                ->editColumn('correo_usuario', fn($admin) => $admin->correo_usuario ?? '-')
                ->editColumn('nombre_admin', function ($admin) {
                    return '<span class="nombre-docente" data-id="' . $admin->id_admin . '" style="cursor:pointer;">' . e($admin->nombre_admin) . '</span>';
                })
                ->editColumn('rol_name', function ($admin) {
                    $rolText = $admin->rol_name ?? 'Sin rol';
                    return '<span class="badge badge-sm bg-gradient-info" style="width: 150px !important;">' . e($rolText) . '</span>';
                })
                ->addColumn('acciones', function ($admin) {
                    if (!auth()->user()->hasRole(['Director', 'Super Admin'])) {
                        return ''; // No muestra acciones
                    }

                    $editUrl = route('docentes.edit', $admin->id_admin);
                    $deleteUrl = route('docentes.destroy', $admin->id_admin);

                    return '
                        <td class="align-middle text-center">
                            <a href="' . $editUrl . '" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                                <i class="fas fa-pen-to-square text-primary"></i>
                            </a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar este docente?\')">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>';
                })
                ->rawColumns(['rol_name', 'acciones', 'nombre_admin'])
                ->filter(function ($query) use ($request) {
                if ($request->has('search') && $search = $request->search['value']) {
                    $query->where(function ($q) use ($search) {
                        $q->where('administrador.rut_admin', 'like', "%{$search}%")
                        ->orWhere('administrador.nombre_admin', 'like', "%{$search}%");
                    });
                }
            })
            ->toJson();
        }

    public function showPerfil($id)
    {
        try {
            Log::info('Entrando a showPerfil con ID: ' . $id);

            $administrador = Administrador::with(['talleres', 'sucursales', 'usuario'])->find($id);

            if (!$administrador) {
                Log::warning("Administrador con ID $id no encontrado.");
                return response()->json(['success' => false]);
            }

            $sucursal = $administrador->sucursales->first();
            $admin = $administrador->usuario;
            $rol = $admin?->roles->pluck('name')->first() ?? 'Sin rol';

            // Usamos el componente como clase correctamente
            $card = new \App\View\Components\CardDocente(
                nombre: $administrador->nombre_admin,
                foto: $administrador->foto_perfil,
                cargo: $administrador->descripcion_cargo ?? $rol,
                sucursal: $sucursal?->nombre_suc,
                ubicacion: $administrador->descripcion_ubicacion,
                correo: $admin?->correo_usuario,
                telefono: $administrador->numero_contacto,
                sobreMi: $administrador->sobre_mi,
                talleres: $administrador->talleres?->pluck('nombre_taller')->toArray()
            );

            $html = view($card->render()->getName(), $card->data())->render();

            return response()->json(['html' => $html]);

        } catch (\Exception $e) {
            Log::error("Error al mostrar perfil del docente: " . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto_perfil' => 'required|image|max:2048', // 2MB
        ]);

        $admin = auth()->user();
        $administrador = Administrador::where('rut_admin', $admin->rut)->first();

        // Procesar y guardar la nueva imagen
        if ($request->hasFile('foto_perfil')) {
            $foto = $request->file('foto_perfil');
            $nombreArchivo = uniqid() . '.' . $foto->getClientOriginalExtension();
            $rutaDestino = public_path('img/perfiles');

            // Mover la nueva foto
            $foto->move($rutaDestino, $nombreArchivo);

            // Eliminar foto anterior si no es default y existe físicamente
            if ($administrador->foto_perfil && $administrador->foto_perfil !== 'default.png') {
                $rutaAnterior = $rutaDestino . '/' . $administrador->foto_perfil;
                if (File::exists($rutaAnterior)) { // Usar File::exists
                    File::delete($rutaAnterior); // Usar File::delete
                }
            }

            // Actualizar el nombre de la foto en la base de datos y guardar
            $administrador->foto_perfil = $nombreArchivo;
            $administrador->save();
        }

        return redirect()->back()->with('success', 'Foto de perfil actualizada correctamente.');
    }

    public function editContacto()
    {
       $admin = auth()->user();

        $administrador = Administrador::where('rut_admin', $admin->rut)
            ->with([
                'sucursales' => function ($query) {
                    $query->wherePivot('activa', true);
                }
            ])->first();
        $talleres = $administrador->talleres;
        $rol = $admin->roles->pluck('name')->first(); // Solo un rol
        $sucursal = $administrador->sucursales->first();

        return view('admin.mantenedores.docentes.mi-perfil.edit', compact('administrador', 'admin', 'rol', 'sucursal','talleres'));
    }

    public function updateInformacionContacto(Request $request)
    {
        $request->validate([
            'numero_contacto' => 'nullable|string|max:20',
            'descripcion_ubicacion' => 'nullable|string|max:255',
            'sobre_mi' => 'nullable|string|max:1000',
        ]);

        $admin = auth()->user()->administrador;
        $admin->numero_contacto = $request->numero_contacto;
        $admin->descripcion_ubicacion = $request->descripcion_ubicacion;
        $admin->sobre_mi = $request->sobre_mi;
        $admin->save();

        return redirect()->route('docentes.perfil')->with('success', 'Información actualizada correctamente.');
    }

    public function create()
    {
        return view('admin.mantenedores.docentes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|string|unique:usuario,rut',
            'nombre_admin' => 'required|string|max:255',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario',
            'rol' => 'required|in:Docente,Coordinador,Visor QR',
            'descripcion_cargo' => 'nullable|string|max:255',
        ]);

        try {
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);

            $usuario = Usuario::create([
                'rut' => $request->rut,
                'correo_usuario' => $request->correo_usuario,
                'tipo_usuario' => 'admin',
                'bloqueado_usuario' => 0,
                'activado_usuario' => 1,
                'contrasenia_usuario' => Hash::make($password),
            ]);
            $usuario->assignRole($request->rol);

            $administrador = Administrador::create([
                'rut_admin' => $request->rut,
                'nombre_admin' => $request->nombre_admin,
                'fecha_creacion' => now(),
                'descripcion_cargo' => $request->descripcion_cargo,
            ]);

            DB::table('admin_sucursal')->insert([
                'id_admin' => $administrador->id_admin,
                'id_suc' => session('sucursal_activa'),
                'activa' => true,
            ]);

            Mail::to($usuario->correo_usuario)->send(new \App\Mail\AdministradorPasswordMail($request->nombre_admin, $password));

            return redirect()->route('docentes.index')->with('success', 'Docente creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear docente: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error al crear el docente.'])->withInput();
        }
    }

    public function edit($id)
    {
        $administrador = Administrador::findOrFail($id);
        $usuario = Usuario::where('rut', $administrador->rut_admin)->firstOrFail();

        return view('admin.mantenedores.docentes.edit', compact('administrador', 'usuario'));
    }

    public function update(Request $request, $id)
    {
        $administrador = Administrador::findOrFail($id);

        $request->validate([
            'nombre_admin' => 'required|string|max:255',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario,' . $administrador->rut_admin . ',rut',
            'rol' => 'required|in:Docente,Coordinador,Visor QR',
            'descripcion_cargo' => 'nullable|string|max:255',
        ]);

        // Actualizar el administrador
        $administrador->update([
            'nombre_admin' => $request->nombre_admin,
            'descripcion_cargo' => $request->descripcion_cargo,
        ]);

        // Actualizar el usuario asociado
        $usuario = Usuario::where('rut', $administrador->rut_admin)->first();
        $usuario->update([
            'correo_usuario' => $request->correo_usuario,
        ]);
        $usuario->syncRoles([$request->rol]);

        DB::table('admin_sucursal')
            ->where('id_admin', $administrador->id_admin)
            ->delete();

        DB::table('admin_sucursal')->insert([
            'id_admin' => $administrador->id_admin,
            'id_suc' => session('sucursal_activa'),
            'activa' => true,
        ]);

        return redirect()->route('docentes.index')->with('success', 'Docente actualizado correctamente.');
    }

    public function destroy(Administrador $administrador)
    {
        $administrador->delete();
        Usuario::where('rut', $administrador->rut_admin)->delete();
        
        return redirect()->route('docentes.index')->with('success', 'Docente eliminado correctamente.');
    }
}
