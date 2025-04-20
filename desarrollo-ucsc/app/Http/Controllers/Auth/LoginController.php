<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
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
            'correo_usuario' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['correo_usuario' => $credentials['correo_usuario'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->route('welcome'); // Redirigir al usuario autenticado
        }

        // Si la autenticación falla
        return back()->withErrors([
            'correo_usuario' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Sesión cerrada correctamente.');
    }
}