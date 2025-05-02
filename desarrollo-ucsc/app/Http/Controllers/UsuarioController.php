<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.mantenedores.usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('admin.mantenedores.usuarios.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rut_alumno' => 'required|string|unique:usuario,rut_alumno',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario',
            'contrasenia_usuario' => 'required|string|min:6',
            'tipo_usuario' => 'required|in:admin,normal,seleccionado',
        ]);

        Usuario::create([
            'rut_alumno' => $request->rut_alumno,
            'correo_usuario' => $request->correo_usuario,
            'contrasenia_usuario' => bcrypt($request->contrasenia_usuario),
            'tipo_usuario' => $request->tipo_usuario,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(Usuario $usuario)
    {
        return view('admin.mantenedores.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'rut_alumno' => 'required|string|unique:usuario,rut_alumno,' . $usuario->id_usuario . ',id_usuario',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario,' . $usuario->id_usuario . ',id_usuario',
            'tipo_usuario' => 'required|in:admin,normal,seleccionado',
            'contrasenia_usuario' => 'nullable|string|min:6', // Validación para la nueva contraseña
        ]);

        $data = $request->only(['rut_alumno', 'correo_usuario', 'tipo_usuario']);

        // Si se proporciona una nueva contraseña, encriptarla y agregarla a los datos
        if ($request->filled('contrasenia_usuario')) {
            $data['contrasenia_usuario'] = bcrypt($request->contrasenia_usuario);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}