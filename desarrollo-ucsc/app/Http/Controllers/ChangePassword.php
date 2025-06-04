<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class ChangePassword extends Controller
{

    protected $user;

    public function __construct()
    {
        Auth::logout();

        if (tenancy()->tenant) {
            $id = intval(request()->id);
            $this->user = Usuario::find($id);
        }
    }
    public function show(Request $request)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            return redirect('home');
        }

        // Si no está autenticado, continúa con el flujo normal
        {
            Auth::logout(); // Ahora está aquí
            $id = intval($request->id);
            $user = Usuario::find($id);

            if (!$user) {
                return abort(404, 'Usuario no encontrado');
            }

            return view('auth.change-password', ['user' => $user]);
        }
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required'],
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/', // Al menos una letra mayúscula
                'regex:/[0-9]/', // Al menos un número
            ],
            'password_confirmation' => ['required'],
        ], [
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe incluir al menos una mayúscula y un número.',
        ]);

        $existingUser = Usuario::where('correo_usuario', $attributes['email'])->first();
        if ($existingUser) {
            $existingUser->update([
                'contrasenia_usuario' => Hash::make($attributes['password'])
            ]);
            return redirect('login')->with('success', 'Contraseña cambiada correctamente. Ahora puedes iniciar sesión.');
        } else {
            return back()->with('error', 'Tu correo no coinice con el que se solicitó el cambio de contraseña');
        }
    }
}