<?php

namespace App\Http\Controllers\Tenants\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Tenants\UsuarioTenant;

class LoginTenantController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('tenant_id')) {
            return redirect()->route('inicio');
        }
        return view('tenants.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'gmail' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $usuario = UsuarioTenant::where('gmail_usuario', $request->gmail)->first();

        if (!$usuario) {
            return back()->withErrors(['gmail' => 'Usuario no encontrado.'])->withInput();
        }

        if (!Hash::check($request->password, $usuario->password)) {
            return back()->withErrors(['password' => 'Contraseña incorrecta.'])->withInput();
        }

        session([
            'tenant_id' => $usuario->id_usuario_tenant,
            'tenant_nombre' => $usuario->nombre_usuario,
            'tenant_tipo' => $usuario->tipo_usuario_tenant,
        ]);

        return redirect()->route('tenants.index');
    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect()->route('inicio');
    }
}
