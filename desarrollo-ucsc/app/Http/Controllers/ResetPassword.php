<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Models\Usuario;
use App\Notifications\ForgotPassword;

class ResetPassword extends Controller
{
    use Notifiable;

    public function show()
    {
        return view('auth.reset-password');
    }

    public function routeNotificationForMail() {
        return request()->email;
    }

    public function send(Request $request)
    {
        $email = $request->validate([
            'email' => ['required', 'email']
        ]);
        $user = Usuario::where('correo_usuario', $email['email'])->first();

        if ($user) {
            try {
                $this->notify(new ForgotPassword($user->id_usuario));
            } catch (\Exception $e) {
                \Log::error('Error al enviar correo de recuperación: ' . $e->getMessage());
                return back()->withErrors(['error' => 'No se pudo enviar el correo. Intenta más tarde.']);
            }
            return back()->with('success', 'El correo fue enviado con éxito a ' . $request->email);
        } else {
            return back()->withErrors(['email' => 'Ingrese un correo válido'])->withInput();
        }
    }
}