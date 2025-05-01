<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\TipoEspacioController;
use App\Http\Controllers\TipoSancionController;
use App\Http\Controllers\MaquinaController;

// Página principal: Mostrar noticias públicas
Route::get('/', [NewsController::class, 'index'])->name('home');

// Grupo de rutas para mantenedores
Route::prefix('admin')->group(function () {
    Route::resource('alumnos', AlumnoController::class);
    Route::resource('espacios', EspacioController::class);
    Route::resource('tipos_espacio', TipoEspacioController::class)->parameters(['tipos_espacio' => 'tipoEspacio']);
    Route::resource('tipos_sancion', TipoSancionController::class)->parameters(['tipos_sancion' => 'tipoSancion']);
    Route::resource('maquinas', MaquinaController::class);
});

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Página de bienvenida
Route::get('/bienvenido', function () {
    return redirect()->route('home');
})->name('bienvenido');

// Ruta para la página de bienvenida
Route::get('/welcome', function () {
    $news = News::all();
    return view('welcome', compact('news'));
})->name('welcome');

// Noticias públicas
Route::get('/noticias', [NewsController::class, 'index'])->name('noticias'); // Cambiado el nombre de la ruta
Route::get('/noticias/{news}', [NewsController::class, 'show'])->name('news.show');

// CRUD para administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('news', NewsController::class)->except(['index', 'show']);
});

// Ruta para el panel de administración
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');