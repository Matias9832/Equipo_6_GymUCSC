<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NoticiasController;
use Illuminate\Support\Facades\Auth;

// Página de bienvenida
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('news.index');
    }
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

//Noticias modo publico
Route::get('/noticias', [NoticiasController::class, 'index'])->name('news.index');
Route::get('/noticias/{news}', [NoticiasController::class, 'show'])->name('news.show');

//CRUD ADMIIN
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('news', App\Http\Controllers\NoticiasController::class)->except(['index', 'show']);
});

