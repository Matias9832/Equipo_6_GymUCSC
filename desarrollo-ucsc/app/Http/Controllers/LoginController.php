<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Administrador;
use App\Models\Alumno;
use App\Models\News;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    protected $redirectTo = '/';

    public function create()
    {
        return view('auth.login'); // Asegúrate de tener esta vista en resources/views/auth/login.blade.php
    }

    /**
     * Procesa el inicio de sesión.
     */
    public function authenticate(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'rut' => 'required',
            'password' => 'required',
        ], [
            'rut.required' => 'El campo RUT es obligatorio.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        // Buscar al usuario
        $usuario = Usuario::where('rut', $credentials['rut'])->first();

        if (!$usuario) {
            return back()->withErrors([
                'rut' => 'Rut o contraseña ingresada incorrecta.',
            ]);
        }

        // Verificar si el usuario está bloqueado
        if ($usuario->bloqueado_usuario == 1) {
            return back()->withErrors([
                'bloqueado' => 'Tu cuenta está bloqueada. Contacta al administrador.',
            ]);
        }

        // Verificar si la cuenta está activa
        if ($usuario->activado_usuario == 0) {
            session(['rut_verificacion' => $usuario->rut]); // <-- Agregado para pasar el rut a la verificación
            return redirect()->route('verificar.vista')->withErrors([
                'activado' => 'Tu cuenta no está activa. Verifica tu correo para activarla.',
            ]);
        }

        // Validar la contraseña
        if (!Hash::check($credentials['password'], $usuario->contrasenia_usuario)) {
            return back()->withErrors([
                'password' => 'Rut o contraseña ingresada incorrecta.',
            ]);
        }

        // Autenticar
        Auth::login($usuario);
        $request->session()->regenerate();

        // Si es administrador tiene una sucursal asociada
        if ($usuario->tipo_usuario === 'admin') {
            // Obtener el administrador vinculado al usuario logueado
            $admin = Administrador::where('rut_admin', $usuario->rut)->first();

            if ($admin) {
                $sucursal = \DB::table('admin_sucursal')
                    ->join('sucursal', 'admin_sucursal.id_suc', '=', 'sucursal.id_suc')
                    ->where('admin_sucursal.id_admin', $admin->id_admin)
                    ->where('admin_sucursal.activa', true)
                    ->select('sucursal.id_suc', 'sucursal.nombre_suc')
                    ->first();

                if ($sucursal) {
                    session()->put('sucursal_activa', $sucursal->id_suc);
                    session()->put('nombre_sucursal', $sucursal->nombre_suc);
                } else {
                    \Log::warning('No se encontró sucursal activa para admin ID: ' . $admin->id_admin);
                }
            } else {
                \Log::warning('No se encontró administrador para el rut: ' . $usuario->rut);
            }
        }

        return redirect()->intended($this->redirectTo);
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }

    public function editProfile()
    {
        $usuario = \Auth::user();

        if ($usuario->is_admin) {
            $profile = \App\Models\Administrador::where('rut_admin', $usuario->rut)->first();
        } else {
            $profile = \App\Models\Alumno::where('rut_alumno', $usuario->rut)->first();
        }

        if (!$profile) {
            return back()->withErrors(['error' => 'No se encontró el perfil asociado al usuario.']);
        }

        return view('auth.edit', compact('usuario', 'profile'));
    }


    public function updateProfile(Request $request)
    {
        $usuario = Auth::user();

        $request->validate([
            'contrasenia_usuario' => 'nullable|min:6|confirmed',
            'correo_usuario' => 'nullable|email|max:255',
        ]);

        if ($usuario->is_admin) {
            $profile = Administrador::where('rut_admin', $usuario->rut)->first();
        } else {
            $profile = Alumno::where('rut_alumno', $usuario->rut)->first();
        }

        $cambios = false;

        // Verificar si el correo cambió
        if ($request->filled('correo_usuario') && $request->correo_usuario !== $usuario->correo_usuario) {
            $usuario->correo_usuario = $request->correo_usuario;
            $cambios = true;
        }

        // Verificar si la contraseña es nueva y diferente (comparando con la actual)
        if ($request->filled('contrasenia_usuario')) {
            // Solo marcar como cambio si la nueva contraseña NO coincide con la actual
            if (!Hash::check($request->contrasenia_usuario, $usuario->contrasenia_usuario)) {
                $usuario->contrasenia_usuario = Hash::make($request->contrasenia_usuario);
                $cambios = true;
            }
        }

        if (!$cambios) {
            return back()->with('info', 'No se realizaron cambios.');
        }

        $usuario->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }


    public function index()
    {
        if (!Auth::user()->salud) {
            return redirect()->route('salud.create');
        }

        return view('news.index');
    }
}