<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ControlSalasController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\TipoEspacioController;
use App\Http\Controllers\TipoSancionController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\DeporteController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SaludController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\TorneoController;

// Página principal: Mostrar noticias públicas
Route::get('/', function () {
    return redirect()->route('news.index');
})->name('welcome');

// Noticias públicas
Route::get('/noticias', [NewsController::class, 'index'])->name('news.index');
Route::get('/noticias/{news}', [NewsController::class, 'show'])->name('news.show');

// Ruta para la página de administradores
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin');

// Grupo de rutas para mantenedores
Route::prefix('admin')->group(function () {
    Route::resource('alumnos', AlumnoController::class);

    Route::resource('tipos_espacio', TipoEspacioController::class)->parameters(['tipos_espacio' => 'tipoEspacio']);
    Route::resource('tipos_sancion', TipoSancionController::class)->parameters(['tipos_sancion' => 'tipoSancion']);
    Route::resource('marcas', MarcasController::class);

    Route::resource('maquinas', MaquinaController::class);
    Route::resource('deportes', DeporteController::class);
    Route::resource('usuarios', UsuarioController::class);
    

    Route::resource('paises', PaisController::class);
    Route::resource('regiones', RegionController::class);
    Route::resource('ciudades', CiudadController::class);

    Route::resource('sucursales', SucursalController::class);
    Route::resource('espacios', EspacioController::class);
    Route::resource('salas', SalaController::class);

    Route::resource('equipos', EquipoController::class);
    Route::resource('torneos', TorneoController::class);


    Route::delete('/news/image/{id}', [App\Http\Controllers\NewsImageController::class, 'destroy'])->name('news.image.destroy');


    // Ruta para importar el archivo Excel
    Route::post('alumnos/import', [AlumnoController::class, 'import'])->name('alumnos.import');
    Route::get('/control-salas/seleccionar', [ControlSalasController::class, 'seleccionarSala'])->name('control-salas.seleccionar');
    Route::post('/control-salas/generar-qr', [ControlSalasController::class, 'generarQR'])->name('control-salas.generarQR');

    //Asignación de roles a administradores
    Route::resource('roles', RolController::class)->parameters([
        'roles' => 'rol',
    ]);
    Route::get('administradores/{id}/edit-rol', [AdministradorController::class, 'editRol'])->name('administradores.rol');
    Route::post('administradores/{id}/update-rol', [AdministradorController::class, 'updateRol'])->name('administradores.updateRol');
});

Route::middleware(['auth'])->group(function () {
    // Ruta para la vista del registro, accesible solo para usuarios alumnos logueados
    Route::get('/ingreso/registro', [ControlSalasController::class, 'registroDesdeQR'])->name('sala.registro');
    Route::post('/sala/salida', [ControlSalasController::class, 'registrarSalida'])->name('sala.registrarSalida');
    Route::match(['get', 'post'], '/ingreso/actual', [ControlSalasController::class, 'mostrarIngreso'])
        ->name('ingreso.mostrar')
        ->middleware('auth');
        
    Route::get('/mi-perfil', [LoginController::class, 'editProfile'])->middleware('auth')->name('mi-perfil.edit');
    Route::post('/mi-perfil', [LoginController::class, 'updateProfile'])->middleware('auth')->name('mi-perfil.update');

    // Ruta para el formulario de salud
    Route::get('/salud', [SaludController::class, 'create'])->name('salud.create');
    Route::post('/salud', [SaludController::class, 'store'])->name('salud.store');
    Route::get('/salud/edit', [SaludController::class, 'edit'])->name('salud.edit');
    Route::post('/salud/edit', [SaludController::class, 'update'])->name('salud.update');
});

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// Rutas para la verificación de usuario
Route::get('/verificar', [RegisterController::class, 'verificarVista'])->name('verificar.vista');
Route::post('/verificar', [RegisterController::class, 'verificarCodigo'])->name('verificar.codigo');

// CRUD para administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('news', NewsController::class)->except(['index', 'show']);
    // Ruta para el panel de administración
    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');
    Route::resource('administradores', AdministradorController::class)->parameters([
        'administradores' => 'administrador',
    ]);
});
