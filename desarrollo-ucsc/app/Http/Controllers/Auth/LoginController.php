<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
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
            'rut_alumno' => 'required',
            'password' => 'required',
        ], [
            'rut_alumno.required' => 'El campo RUT es obligatorio.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        // Verificar si el RUT existe en la base de datos
        $usuario = Usuario::where('rut_alumno', $credentials['rut_alumno'])->first();
        if (!$usuario) {
            return back()->withErrors([
                'rut_alumno' => 'El RUT ingresado no está asociado a ningún usuario registrado.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo);
        }
        
        // Verificar si la contraseña es correcta
        if (!Hash::check($credentials['password'], $usuario->contrasenia_usuario)) {
            return back()->withErrors([
                'password' => 'La contraseña ingresada no corresponde al RUT ingresado.',
            ]);
        }

        // Autenticar al usuario
        Auth::login($usuario);
        $request->session()->regenerate();

        // Redirigir al usuario autenticado (sin modificar la redirección existente)
        $news = News::all(); // Obtener todas las noticias para mostrarlas en la vista de inicio
        return view('welcome', compact('news')); // Redirigir al usuario autenticado
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $news = News::all(); 
        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}
