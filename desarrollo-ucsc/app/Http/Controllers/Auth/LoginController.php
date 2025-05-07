<?php

namespace App\Http\Controllers\Auth;

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
                'rut' => 'El RUT ingresado no está asociado a ningún usuario registrado.',
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
            return redirect()->route('verificar.vista')->withErrors([
                'activado' => 'Tu cuenta no está activa. Verifica tu correo para activarla.',
            ]);
        }
    
        // Validar la contraseña
        if (!Hash::check($credentials['password'], $usuario->contrasenia_usuario)) {
            return back()->withErrors([
                'password' => 'La contraseña ingresada no corresponde al RUT ingresado.',
            ]);
        }
    
        // Autenticar
        Auth::login($usuario);
        $request->session()->regenerate();
    
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
        $usuario = Auth::user(); // Obtener el usuario autenticado
    
        if ($usuario->is_admin) {
            // Si el usuario es administrador, obtenemos los datos de la tabla 'administradores'
            $profile = Administrador::where('rut_admin', $usuario->rut)->first();
        } else {
            // Si el usuario es alumno, obtenemos los datos de la tabla 'alumnos'
            $profile = Alumno::where('rut_alumno', $usuario->rut)->first();
        }
    
        return view('auth.edit', compact('usuario', 'profile')); 
        } 


        public function updateProfile(Request $request)
        {
            $usuario = Auth::user();

            $validated = $request->validate([
                'contrasenia_usuario' => 'nullable|min:6|confirmed',
                'correo_usuario' => 'nullable|email|max:255',
            ]);

            if ($usuario->is_admin) {
                $profile = Administrador::where('rut_admin', $usuario->rut)->first();
            } else {
                $profile = Alumno::where('rut_alumno', $usuario->rut)->first();
            }

            // Solo actualiza contraseña si se envía
            if ($request->filled('contrasenia_usuario')) {
                $usuario->contrasenia_usuario = Hash::make($request->contrasenia_usuario);
            }

            // Actualiza correo si se envía
            if ($request->filled('correo_usuario')) {
                $usuario->correo_usuario = $request->correo_usuario;
            }

            $usuario->save(); // Guarda cambios del usuario

            return redirect()->route('news.index')->with('success', 'Perfil actualizado correctamente');
        }

        public function index()
        {
            if (!Auth::user()->salud) {
                return redirect()->route('salud.create');
            }

            return view('news.index');
        }



}