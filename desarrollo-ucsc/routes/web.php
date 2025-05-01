<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ControlSalasController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\TipoEspacioController;
use App\Http\Controllers\TipoSancionController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CiudadController;

// Página principal: Mostrar noticias públicas
Route::get('/', function () {
    $news = News::all();
    return view('welcome', compact('news'));
})->name('welcome');

// Ruta para la página de administradores
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin');

// Grupo de rutas para mantenedores
Route::prefix('admin')->group(function () {
    Route::resource('alumnos', AlumnoController::class);
    Route::resource('espacios', EspacioController::class);
    Route::resource('tipos_espacio', TipoEspacioController::class)->parameters(['tipos_espacio' => 'tipoEspacio']);
    Route::resource('tipos_sancion', TipoSancionController::class)->parameters(['tipos_sancion' => 'tipoSancion']);
    Route::resource('marcas', MarcasController::class);
    
    Route::resource('paises', PaisController::class);
    Route::resource('regiones', RegionController::class);
    Route::resource('ciudades', CiudadController::class);
    
    // Ruta para importar el archivo Excel
    Route::post('alumnos/import', [AlumnoController::class, 'import'])->name('alumnos.import');
    Route::get('/gestion-qr', [ControlSalasController::class, 'mostrarQR'])->name('control_salas.gestion_qr');

    // Rutas para el CRUD de máquinas
    Route::resource('maquinas', MaquinaController::class);
});

Route::middleware(['auth'])->group(function () {
    // Ruta para la vista del registro, accesible solo para usuarios logueados
    Route::get('/registro-sala', [ControlSalasController::class, 'registroDesdeQR'])->name('sala.registro');
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
//Route::get('/noticias', [NewsController::class, 'index'])->name('home');
//Route::get('/noticias/{news}', [NewsController::class, 'show'])->name('news.show');

// CRUD para administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('news', NewsController::class)->except(['index', 'show']);
});

// Ruta para el panel de administración
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');