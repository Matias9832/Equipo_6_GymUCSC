<?php

namespace App\Http\Controllers;

use \App\Models\Administrador;
use App\Models\Usuario;
use App\Models\Alumno;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::query();

        if ($request->has('solo_admins') && $request->solo_admins === 'on') {
            $query->where('tipo_usuario', '!=', 'admin');
        }

        $usuarios = $query->paginate(20);
        $administradores = Administrador::all();
        $alumnos = Alumno::all();

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
            'contrasenia_usuario' => '123456',
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
        $rules = [
            'rut' => 'required|string|unique:usuario,rut,' . $usuario->id_usuario . ',id_usuario',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario,' . $usuario->id_usuario . ',id_usuario',
        ];
        // Si el usuario NO es admin, entonces validamos tipo_usuario
        if ($usuario->tipo_usuario !== 'admin') {
            $rules['tipo_usuario'] = 'required|in:estudiante,seleccionado';
        } else {
            $rules['rol'] = 'required|in:Docente,Coordinador'; // Si es admin, validamos el rol
        }

        $request->validate($rules);

        // Datos base para actualizar
        $data = [
            'rut' => $request->rut,
            'correo_usuario' => $request->correo_usuario,
        ];

        // Solo actualiza tipo_usuario si no es admin
        if ($usuario->tipo_usuario !== 'admin') {
            $data['tipo_usuario'] = $request->tipo_usuario;
            $usuario->syncRoles([]); // Asegúrate de quitar cualquier rol si ya no es admin
        }

        $usuario->update($data);

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