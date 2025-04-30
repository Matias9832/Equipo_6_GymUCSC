<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CiudadController;

use App\Http\Controllers\MaquinaController;

// Página principal: Mostrar noticias públicas
Route::get('/', [NewsController::class, 'index'])->name('home');

// Grupo de rutas para mantenedores
Route::prefix('admin')->group(function () {
    // Rutas para el CRUD de alumnos
    Route::resource('alumnos', AlumnoController::class);
    Route::post('alumnos/import', [AlumnoController::class, 'import'])->name('alumnos.import');

    // Rutas para el CRUD de máquinas
    Route::resource('maquinas', MaquinaController::class);
});

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

// Ruta para la página de bienvenida (welcome.blade.php)
Route::get('/welcome', function () {
    $news = News::all(); // Obtén todas las noticias desde la base de datos
    return view('welcome', compact('news')); // Pasa la variable $news a la vista
})->name('welcome');

// Noticias públicas
Route::get('/noticias', [NewsController::class, 'index'])->name('home');
Route::get('/noticias/{news}', [NewsController::class, 'show'])->name('home');

// CRUD para administradores
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('news', NewsController::class)->except(['index', 'show']);
});

// Página principal del panel de administración
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');

// Rutas para el CRUD de ciudades, países y regiones (solo para administradores)
Route::prefix('admin')->group(function () {
    Route::resource('ciudades', CiudadController::class);
    Route::resource('paises', PaisController::class);
    Route::resource('regiones', RegionController::class);
});