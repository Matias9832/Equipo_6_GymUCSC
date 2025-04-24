<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Auth;

// Página principal: Mostrar noticias públicas
Route::get('/', [NewsController::class, 'index'])->name('home');

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'create'])->name('login'); // Formulario de inicio de sesión
Route::post('/login', [LoginController::class, 'authenticate']);        // Procesa el inicio de sesión

Route::get('/register', [RegisterController::class, 'create'])->name('register'); // Formulario de registro
Route::post('/register', [RegisterController::class, 'store']);                  // Procesa el registro

Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // Cerrar sesión

// Página de bienvenida (redirige a noticias)
Route::get('/bienvenido', function () {
    return redirect()->route('home');
})->name('bienvenido');

// Noticias públicas
Route::get('/news', [NewsController::class, 'index'])->name('home');
Route::get('/noticias/{news}', [NewsController::class, 'show'])->name('home');

// CRUD para administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('news', NewsController::class)->except(['index', 'show']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create')->middleware('admin');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit')->middleware('admin');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy')->middleware('admin');
});
