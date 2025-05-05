<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrador;
use App\Models\Usuario;
use App\Models\Rol;

class AdministradorController extends Controller
{
    /**
     * Muestra la lista de administradores.
     */
    public function index()
    {
        // Obtener los administradores con sus roles y usuarios relacionados
        $administradores = Administrador::with('rol')->get();
        // Obtener los usuarios relacionados con los administradores
        $usuarios = DB::table('usuario')
            ->join('administrador', 'usuario.rut', '=', 'administrador.rut_admin')
            ->select('usuario.*', 'administrador.nombre_admin')
            ->get();

        return view('admin.mantenedores.administradores.index', compact('administradores', 'usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo administrador.
     */
    public function create()
    {
        $roles = Rol::all();
        return view('admin.mantenedores.administradores.create', compact('roles'));
    }

    /**
     * Almacena un nuevo administrador en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rut_admin' => 'required|string|unique:administrador,rut_admin|unique:usuario,rut',
            'nombre_admin' => 'required|string|max:255',
            'id_rol' => 'required|exists:rol,id_rol',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario',
            'contrasenia_usuario' => 'required|string|min:6',
        ]);
    
        // Crear el usuario
        DB::table('usuario')->insert([
            'rut' => $request->rut_admin,
            'correo_usuario' => $request->correo_usuario,
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => bcrypt($request->contrasenia_usuario),
        ]);
    
        // Crear el administrador
        Administrador::create([
            'rut_admin' => $request->rut_admin,
            'nombre_admin' => $request->nombre_admin,
            'id_rol' => $request->id_rol,
            'fecha_creacion' => now(),
        ]);
    
        return redirect()->route('administradores.index')->with('success', 'Administrador creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un administrador existente.
     */
    public function edit(Administrador $administrador)
    {
        $usuario = DB::table('usuario')->where('rut', $administrador->rut_admin)->first();
        $roles = Rol::all();
        return view('admin.mantenedores.administradores.edit', compact('administrador', 'usuario'));
    }
    /**
     * Actualiza un administrador existente en la base de datos.
     */
    public function update(Request $request, Administrador $administrador)
    {
        $request->validate([
            'nombre_admin' => 'required|string|max:255',
            'id_rol' => 'required|exists:rol,id_rol',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario,' . $administrador->rut_admin . ',rut',
        ]);

        // Actualizar el usuario
        DB::table('usuario')->where('rut', $administrador->rut_admin)->update([
            'correo_usuario' => $request->correo_usuario,
        ]);

        // Actualizar el administrador
        $administrador->update([
            'nombre_admin' => $request->nombre_admin,
            'id_rol' => $request->id_rol,
        ]);

        return redirect()->route('administradores.index')->with('success', 'Administrador actualizado correctamente.');
    }

    public function editRol($id)
    {
        $administrador = Administrador::findOrFail($id);
        $roles = Rol::all(); // Obtener todos los roles disponibles
        return view('admin.mantenedores.administradores.rol', compact('administrador', 'roles'));
    }
    
    public function updateRol(Request $request, $id)
    {
        $request->validate([
            'id_rol' => 'required|exists:rol,id_rol',
        ]);

        $administrador = Administrador::findOrFail($id);
        $administrador->update([
            'id_rol' => $request->id_rol,
        ]);

        return redirect()->route('administradores.index')->with('success', 'Rol del administrador actualizado correctamente.');
    }

    public function destroy(Administrador $administrador)
    {
        // Eliminar el usuario asociado
        Usuario::where('rut', $administrador->rut_admin)->delete();

        // Eliminar el administrador
        $administrador->delete();

        return redirect()->route('administradores.index')->with('success', 'Administrador eliminado correctamente.');
    }
}