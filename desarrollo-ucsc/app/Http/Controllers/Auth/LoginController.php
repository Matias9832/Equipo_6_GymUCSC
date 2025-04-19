<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required',
        ]);

        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['contraseña']])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard'); // Redirigir al dashboard
        }

        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }
    public function create()
    {
        return view('auth.login'); // Asegúrate de que esta vista exista
    }
}