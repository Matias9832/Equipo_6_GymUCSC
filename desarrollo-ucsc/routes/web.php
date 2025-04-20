<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'create'])->name('login'); // Ruta para mostrar el formulario de inicio de sesión
Route::post('/login', [LoginController::class, 'authenticate']); // Ruta para procesar el inicio de sesión

Route::get('/register', [RegisterController::class, 'create'])->name('register'); // Ruta para mostrar el formulario de registro
Route::post('/register', [RegisterController::class, 'store']); // Ruta para procesar el registro

Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // Ruta para cerrar sesión

// Página de bienvenida después de iniciar sesión
Route::get('/bienvenido', function () {
    return view('bienvenido');
})->name('bienvenido');