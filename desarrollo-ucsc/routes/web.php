<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
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
Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::resource('alumnos', AlumnoController::class);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Tipos de Espacios'])->group(function () {
        Route::resource('tipos_espacio', TipoEspacioController::class)->parameters(['tipos_espacio' => 'tipoEspacio']);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Tipos de Sanción'])->group(function () {
        Route::resource('tipos_sancion', TipoSancionController::class)->parameters(['tipos_sancion' => 'tipoSancion']);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Marcas'])->group(function () {
        Route::resource('marcas', MarcasController::class);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Máquinas'])->group(function () {
        Route::resource('maquinas', MaquinaController::class);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Deportes'])->group(function () {
        Route::resource('deportes', DeporteController::class);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Usuarios'])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Países'])->group(function () {
        Route::resource('paises', PaisController::class);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Regiones'])->group(function () {
        Route::resource('regiones', RegionController::class);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Ciudades'])->group(function () {
        Route::resource('ciudades', CiudadController::class);
    });

    Route::middleware(['permission:Acceso al Mantenedor de Sucursales'])->group(function () {
        Route::resource('sucursales', SucursalController::class);
    });
    Route::middleware(['permission:Acceso al Mantenedor de Espacios'])->group(function () {
        Route::resource('espacios', EspacioController::class);
    });
    Route::middleware(['permission:Acceso al Mantenedor de Salas'])->group(function () {
        Route::resource('salas', SalaController::class);
    });
    

    Route::resource('equipos', EquipoController::class);
    Route::resource('torneos', TorneoController::class);


    Route::delete('/news/image/{id}', [App\Http\Controllers\NewsImageController::class, 'destroy'])->name('news.image.destroy');

    // CRUD para administradores
    Route::middleware(['auth', 'admin','permission:Acceso al Mantenedor de Administradores'])->group(function () {
        Route::resource('news', NewsController::class)->except(['index', 'show']);
        // Ruta para el panel de administración
        Route::get('/admin', function () {
            return view('admin.index');
        })->name('admin.index');
        Route::resource('administradores', AdministradorController::class)->parameters([
            'administradores' => 'administrador',
        ]);
    });

    // Ruta para importar el archivo Excel
    Route::post('alumnos/import', [AlumnoController::class, 'import'])->name('alumnos.import');

    // Ruta para la gestión de QR
    Route::get('/control-salas/seleccionar', [ControlSalasController::class, 'seleccionarSala'])->name('control-salas.seleccionar');
    Route::post('/control-salas/generar-qr', [ControlSalasController::class, 'generarQR'])->name('control-salas.generarQR');
    Route::get('control-salas/ver-qr', [ControlSalasController::class, 'verQR'])->name('control-salas.verQR');
    Route::post('/control-salas/cambiar-aforo', [ControlSalasController::class, 'cambiarAforo'])->name('control_salas.cambiar_aforo');
    Route::post('admin/control-salas/cerrar-sala', [ControlSalasController::class, 'cerrarSala'])
    ->name('admin.control_salas.cerrar_sala')
    ->middleware('auth');

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
    Route::put('/salud', [SaludController::class, 'update'])->name('salud.update');

});



// Rutas de autenticación
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

