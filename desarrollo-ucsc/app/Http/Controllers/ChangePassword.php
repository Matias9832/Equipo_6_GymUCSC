<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChangePassword extends Controller
{

    protected $user;

    public function __construct()
    {
       
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
            $user = User::find($id);

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
            'password' => ['required', 'min:5'],
            'confirm-password' => ['same:password']
        ]);

        $existingUser = User::where('email', $attributes['email'])->first();
        if ($existingUser) {
            $existingUser->update([
                'password' => $attributes['password']
            ]);
            return redirect('login');
        } else {
            return back()->with('error', 'Your email does not match the email who requested the password change');
        }
    }
}
