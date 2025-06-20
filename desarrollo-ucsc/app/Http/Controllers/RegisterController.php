<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\VerificacionUsuario;
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
        $request->validate([
            'contraseña' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'rut' => [
                'required',
                'unique:usuario,rut',
                function ($attribute, $value, $fail) {
                    // Verifica que el rut exista en la tabla alumno
                    if (!\DB::table('alumno')->where('rut_alumno', $value)->exists()) {
                        $fail('Ingrese un RUT válido.');
                    }
                },
            ],
        ], [
            'contraseña.required' => 'El campo contraseña es obligatorio.',
            'contraseña.confirmed' => 'Las contraseñas no coinciden.',
            'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'contraseña.regex' => 'La contraseña debe incluir al menos una mayúscula y un número.',
            'rut.required' => 'El campo RUT es obligatorio.',
            'rut.unique' => 'El RUT ingresado ya está registrado.',
        ]);

        try {
            // Buscar correo en la tabla alumno
            $alumno = \DB::table('alumno')->where('rut_alumno', $request->rut)->first();
            if (!$alumno || empty($alumno->correo_alumno)) {
                return back()->withErrors(['rut' => 'No se encontró correo asociado a este RUT.']);
            }
            $correo = $alumno->correo_alumno;

            $codigoVerificacion = rand(100000, 999999);

            $usuario = Usuario::create([
                'correo_usuario' => $correo,
                'contrasenia_usuario' => \Hash::make($request->contraseña),
                'rut' => $request->rut,
                'bloqueado_usuario' => 0,
                'activado_usuario' => 0,
                'tipo_usuario' => 'estudiante',
            ]);

            VerificacionUsuario::create([
                'id_usuario' => $usuario->id_usuario,
                'codigo_verificacion' => $codigoVerificacion,
                'intentos' => 0,
            ]);

            session(['verificacion_id_usuario' => $usuario->id_usuario]);

            try {
                \Mail::to($correo)->send(new \App\Mail\VerificacionUsuarioMail($usuario->rut, $codigoVerificacion));
            } catch (\Exception $e) {
                $usuario->delete();
                VerificacionUsuario::where('id_usuario', $usuario->id_usuario)->delete();
                \Log::error('Error al enviar correo de verificación: ' . $e->getMessage());
                return back()->withErrors(['error' => 'No se pudo enviar el correo de verificación. Intenta nuevamente.']);
            }

            return redirect()->route('verificar.vista')->with('success', 'Se ha enviado un código de verificación a tu correo institucional.');
        } catch (\Exception $e) {
            \Log::error('Error al registrar usuario: ' . $e->getMessage());
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
            'rut' => session('verificacion_id_usuario') ? 'nullable' : 'required'
        ], [
            'codigo.required' => 'El campo código de verificación es obligatorio.',
            'codigo.numeric' => 'El código de verificación debe ser un número.',
            'rut.required' => 'El campo RUT es obligatorio.',
        ]);

        try {
            // Buscar usuario por sesión o por RUT
            if (session('verificacion_id_usuario')) {
                $idUsuario = session('verificacion_id_usuario');
            } else {
                $usuario = Usuario::where('rut', $request->rut)->first();
                if (!$usuario) {
                    return back()->with('info', 'No se encontró el usuario para verificar.');
                }
                $idUsuario = $usuario->id_usuario;
            }

            $verificacion = VerificacionUsuario::where('id_usuario', $idUsuario)->first();
            $usuario = Usuario::find($idUsuario);

            if (!$verificacion || !$usuario) {
                return back()->with('info', 'El código es inválido.');
            }

            if ($verificacion->codigo_verificacion != $request->codigo) {
                $verificacion->intentos += 1;

                if ($verificacion->intentos >= 5) {
                    // Generar nuevo código y reiniciar intentos
                    $nuevoCodigo = rand(100000, 999999);
                    $verificacion->codigo_verificacion = $nuevoCodigo;
                    $verificacion->intentos = 0; // Reiniciar a 0
                    $verificacion->save();

                    // Reenviar correo
                    Mail::to($usuario->correo_usuario)->send(new \App\Mail\VerificacionUsuarioMail($usuario->rut, $nuevoCodigo));

                    return back()->with('info', 'Se ha enviado un nuevo código de verificación a tu correo.');
                } else {
                    $intentosRestantes = 5 - $verificacion->intentos;
                    $verificacion->save();
                    return back()->with('info', "Código incorrecto. Te quedan {$intentosRestantes} intentos.");
                }
            }

            // Código correcto
            $usuario->update([
                'activado_usuario' => 1,
            ]);
            $verificacion->delete();
            session()->forget('verificacion_id_usuario');
            session()->forget('rut_verificacion'); // <-- Limpiar el rut de la sesión

            return redirect()->route('login')->with('success', 'Cuenta verificada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al verificar código: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error inesperado al verificar el código. Intenta nuevamente.']);
        }
    }

    /**
     * Reenvía el código de verificación al correo del usuario.
     */
    public function reenviarCodigo(Request $request)
    {
        $idUsuario = session('verificacion_id_usuario');
        $rut = session('rut_verificacion');

        if (!$idUsuario && !$rut) {
            return redirect()->route('login')->with('error', 'No se encontró usuario para reenviar el código.');
        }

        if ($idUsuario) {
            $usuario = Usuario::find($idUsuario);
        } else {
            $usuario = Usuario::where('rut', $rut)->first();
        }

        if (!$usuario) {
            return redirect()->route('login')->with('error', 'No se encontró usuario para reenviar el código.');
        }

        $verificacion = VerificacionUsuario::where('id_usuario', $usuario->id_usuario)->first();

        if (!$verificacion) {
            return redirect()->route('login')->with('error', 'No se encontró código de verificación para reenviar.');
        }

        $nuevoCodigo = rand(100000, 999999);
        $verificacion->codigo_verificacion = $nuevoCodigo;
        $verificacion->intentos = 0;
        $verificacion->save();

        try {
            \Mail::to($usuario->correo_usuario)->send(new \App\Mail\VerificacionUsuarioMail($usuario->rut, $nuevoCodigo));
        } catch (\Exception $e) {
            \Log::error('Error al reenviar código: ' . $e->getMessage());
            return back()->withErrors(['error' => 'No se pudo reenviar el código. Intenta más tarde.']);
        }

        return back()->with('success', 'Se ha reenviado el código de verificación a tu correo.');
    }
}