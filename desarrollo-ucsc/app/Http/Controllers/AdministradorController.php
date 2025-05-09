<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrador;
use App\Models\Usuario;
use App\Models\Sucursal;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = Administrador::with(['sucursales' => function ($query) {
            $query->wherePivot('activa', true);
        }])->get();

        $usuarios = Usuario::with('roles')->get();

        return view('admin.mantenedores.administradores.index', compact('administradores', 'usuarios'));
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
            'rol' => 'required|in:Director,Docente,Coordinador',
        ]);
    
        //Crear contraseña aleatoria
        //Reemplazar con la función de generar contraseña aleatoria

        // Crear el usuario 
        $usuario = Usuario::create([
            'rut' => $request->rut_admin,
            'correo_usuario' => $request->correo_usuario,
            'tipo_usuario' => 'admin',
            'bloqueado_usuario' => 0,
            'activado_usuario' => 1,
            'contrasenia_usuario' => '123456', // Shevi saca esto después y lo reemplaza por la función de generar contraseña aleatoria
        ]);
        // Asignar rol Docente
        $usuario->assignRole($request->rol);

        // Crear el administrador
        $administrador = Administrador::create([
            'rut_admin' => $request->rut_admin,
            'nombre_admin' => $request->nombre_admin,
            'fecha_creacion' => now(),
        ]);
        // Asignar la sucursal al administrador
        DB::table('admin_sucursal')->insert([
            'id_admin' => $administrador->id_admin,
            'id_suc' => $request->sucursal_id,
            'activa' => true,
        ]);

        return redirect()->route('administradores.index')->with('success', 'Administrador creado correctamente con rol de Docente.');
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
            'rol' => 'required|in:Director,Docente,Coordinador',
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