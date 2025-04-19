<?php
// filepath: c:\xampp\htdocs\Equipo_6_GymUCSC\example-app\app\Http\Controllers\UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Retorna la vista de la tabla de usuarios
        return view('users.index');
    }
}