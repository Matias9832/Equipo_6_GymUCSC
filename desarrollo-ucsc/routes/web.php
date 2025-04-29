<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EspacioController;

// Página principal: Mostrar noticias públicas
Route::get('/', [NewsController::class, 'index'])->name('home');

// Grupo de rutas para mantenedores
// Rutas para el CRUD de alumnos (sin autenticación ni permisos de administrador, esto debe ser modificado)
Route::prefix('admin')->group(function () {
    
    Route::resource('alumnos', AlumnoController::class);
    Route::resource('espacios', EspacioController::class);
    
    // Ruta para importar el archivo Excel
    Route::post('alumnos/import', [AlumnoController::class, 'import'])->name('alumnos.import');
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
Route::get('/noticias/{news}', [NewsController::class, 'show'])->name('news.show');

// CRUD para administradores (solo para logueados y admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('news', NewsController::class)->except(['index', 'show']);
});

// CRUD para usuarios logueados (permitir ver detalles)
Route::middleware(['auth'])->group(function () {
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create')->middleware('admin');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit')->middleware('admin');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy')->middleware('admin');
});

//esto debemos unirlo con lo de arriba y editarlo para que solo entren administradores
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');


