<?php

namespace App\Http\Controllers;

use \App\Models\Administrador;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
   
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.mantenedores.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.mantenedores.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|string|unique:usuario,rut',
            'nombre_admin' => 'required|string|max:255',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario',
            'rol' => 'required|in:Docente,Coordinador', //Restricción para que solo pueda crear Docente y coordinador
        ]);

        //Crear contraseña aleatoria
        //Reemplazar con la función de generar contraseña aleatoria

        // Crear el usuario 
        $usuario = Usuario::create([
            'rut' => $request->rut,
            'correo_usuario' => $request->correo_usuario,
            'tipo_usuario' => 'admin',
            'bloqueado_usuario' => 0,
            'activado_usuario' => 1,
            'contrasenia_usuario' => '123456', // Shevi saca esto después y lo reemplaza por la función de generar contraseña aleatoria
        ]);
        $usuario->assignRole($request->rol);

            // Crear el administrador
            Administrador::create([
                'rut_admin' => $request->rut,
                'nombre_admin' => $request->nombre_admin,
                'fecha_creacion' => now(),
            ]);
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(Usuario $usuario)
    {
        return view('admin.mantenedores.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'rut' => 'required|string|unique:usuario,rut,' . $usuario->id_usuario . ',id_usuario',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario,' . $usuario->id_usuario . ',id_usuario',
            'tipo_usuario' => 'required|in:admin,normal,seleccionado',
            'contrasenia_usuario' => 'nullable|string|min:6', // Validación para la nueva contraseña
        ]);

        $data = $request->only(['rut', 'correo_usuario', 'tipo_usuario']); // Cambiado a 'rut'

        // Si se proporciona una nueva contraseña, encriptarla y agregarla a los datos
        if ($request->filled('contrasenia_usuario')) {
            $data['contrasenia_usuario'] = bcrypt($request->contrasenia_usuario);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        Administrador::where('rut_admin', $usuario->rut)->delete(); // Eliminar el administrador asociado
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}