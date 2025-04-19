<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|unique:usuario,correo',
            'contraseña' => 'required|min:8|confirmed',
            'rut' => 'required|exists:alumno,rut',
        ]);

        // Verificar si el usuario ya está registrado
        if (Usuario::where('rut', $request->rut)->exists()) {
            return back()->withErrors(['rut' => 'Este RUT ya está registrado.']);
        }

        // Crear el usuario
        Usuario::create([
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->contraseña),
            'rut' => $request->rut,
            'bloqueado' => 0, // Por defecto, no bloqueado
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Por favor, inicia sesión.');
    }
    public function create()
    {
        return view('auth.register'); // Asegúrate de que esta vista exista
    }
}