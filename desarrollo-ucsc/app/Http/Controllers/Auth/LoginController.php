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
            'rut' => 'required', // Cambiado a 'rut'
            'password' => 'required',
        ], [
            'rut.required' => 'El campo RUT es obligatorio.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        // Verificar si el RUT existe en la base de datos
        $usuario = Usuario::where('rut', $credentials['rut'])->first(); // Cambiado a 'rut'
        if (!$usuario) {
            return back()->withErrors([
                'rut' => 'El RUT ingresado no está asociado a ningún usuario registrado.',
            ]);
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
}