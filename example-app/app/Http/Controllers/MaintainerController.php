<?php

namespace App\Http\Controllers;

use App\Models\User;

class MaintainerController extends Controller
{
    public function index()
    {
        return view('maintainers.index'); // Vista principal de mantenedores
    }

    public function users()
    {
        $users = User::all(); // Obtiene todos los usuarios
        return view('maintainers.users', compact('users')); // Retorna la vista de usuarios
    }
}