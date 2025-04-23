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
            'correo' => [
                'required',
                'email',
                'unique:usuario,correo_usuario',
                function ($attribute, $value, $fail) {
                    if (\DB::table('usuario')->where('correo_usuario', $value)->exists()) {
                        $fail('El correo ingresado ya está registrado.');
                    }
                },
            ],
            'contraseña' => 'required|confirmed|min:6',
            'rut' => [
                'required',
                'unique:usuario,rut_alumno',
                function ($attribute, $value, $fail) {
                    if (!\DB::table('alumno')->where('rut_alumno', $value)->exists()) {
                        $fail('El RUT ingresado no está registrado en la tabla de alumnos.');
                    }
                },
            ],
        ], [
            'correo.required' => 'El campo correo es obligatorio.',
            'correo.email' => 'El correo debe tener un formato válido.',
            'correo.unique' => 'El correo ingresado ya está registrado.',
            'contraseña.required' => 'El campo contraseña es obligatorio.',
            'contraseña.confirmed' => 'Las contraseñas no coinciden.',
            'contraseña.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'rut.required' => 'El campo RUT es obligatorio.',
            'rut.unique' => 'El RUT ingresado ya está registrado en la tabla de usuarios.',
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

            // Redirigir al usuario con un mensaje de éxito
            return redirect()->route('register')->with('success', 'El usuario fue registrado exitosamente.');
        } catch (\Exception $e) {
            // Registrar el error en los logs para depuración
            Log::error('Error al registrar usuario: ' . $e->getMessage());

            // Manejar errores y redirigir con un mensaje de error
            return back()->withErrors(['error' => 'Ocurrió un error al registrar el usuario. Inténtalo nuevamente.']);
        }
    }
}