<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            'contraseña' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/', // Al menos una letra mayúscula
                'regex:/[0-9]/', // Al menos un número
            ],
            'rut' => [
                'required',
                'unique:usuario,rut',
                function ($attribute, $value, $fail) {
                    if (!\DB::table('alumno')->where('rut_alumno', $value)->exists()) {
                        $fail('Ingrese un rut valido RUT valido.');
                    }
                },
            ],
        ], [
            'correo.required' => 'El campo correo es obligatorio.',
            'correo.email' => 'El correo debe tener un formato válido.',
            'correo.unique' => 'El correo ingresado ya está registrado.',
            'contraseña.required' => 'El campo contraseña es obligatorio.',
            'contraseña.confirmed' => 'Las contraseñas no coinciden.',
            'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'contraseña.regex' => 'La contraseña debe incluir al menos una mayúscula y un número.',
            'rut.required' => 'El campo RUT es obligatorio.',
            'rut.unique' => 'El RUT ingresado ya está registrado.',
        ]);

        try {
            // Generar un código de verificación
            $codigoVerificacion = rand(100000, 999999);

            // Crear el usuario
            $usuario = Usuario::create([
                'correo_usuario' => $request->correo,
                'contrasenia_usuario' => Hash::make($request->contraseña),
                'rut' => $request->rut,
                'bloqueado_usuario' => 0,
                'activado_usuario' => 0,
                'tipo_usuario' => 'estudiante',
                'codigo_verificacion' => $codigoVerificacion, // Guardar el código
            ]);

            // Enviar el código de verificación por correo
            Mail::to($usuario->correo_usuario)->send(new \App\Mail\VerificacionUsuarioMail($usuario->rut, $codigoVerificacion));

            // Redirigir al usuario con un mensaje de éxito
            return redirect()->route('verificar.vista')->with('success', 'Se ha enviado un código de verificación a tu correo.');
        } catch (\Exception $e) {
            // Registrar el error en los logs para depuración
            Log::error('Error al registrar usuario: ' . $e->getMessage());

            // Manejar errores y redirigir con un mensaje de error
            return back()->withErrors(['error' => 'Ocurrió un error al registrar el usuario. Inténtalo nuevamente.']);
        }
    }

    /**
     * Muestra la vista para verificar el código.
     */
    public function verificarVista()
    {
        return view('auth.verificar');
    }

    /**
     * Verifica el código ingresado por el usuario.
     */
    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required|numeric',
        ]);

        $usuario = Usuario::where('codigo_verificacion', $request->codigo)->first();

        if (!$usuario) {
            return back()->withErrors(['codigo' => 'El código es inválido.']);
        }

        $usuario->update([
            'activado_usuario' => 1,
            'codigo_verificacion' => null, // Eliminar el código después de usarlo
        ]);

        return redirect()->route('login')->with('success', 'Cuenta verificada correctamente.');
    }
}