<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Registra un nuevo usuario.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'correo' => 'required|email|unique:usuario,correo_usuario',
            'contraseña' => 'required|confirmed|min:6',
            'rut' => 'required|unique:usuario,rut_alumno',
        ]);

        try {
            // Crear el usuario
            $usuario = Usuario::create([
                'correo_usuario' => $request->correo,
                'contrasenia_usuario' => Hash::make($request->contraseña),
                'rut_alumno' => $request->rut,
                'bloqueado_usuario' => 0,
                'activado_usuario' => 1,
                'tipo_usuario' => 'estudiante',
            ]);

            // Iniciar sesión automáticamente
            Auth::login($usuario);

            // Redirigir al usuario a la página de bienvenida con un mensaje de éxito
            return redirect()->route('welcome')->with('success', 'Usuario registrado e iniciado sesión correctamente.');
        } catch (\Exception $e) {
            // Registrar el error en los logs para depuración
            Log::error('Error al registrar usuario: ' . $e->getMessage());

            // Manejar errores y redirigir con un mensaje de error
            return back()->withErrors(['error' => 'Ocurrió un error al registrar el usuario. Inténtalo nuevamente.']);
        }
    }
}