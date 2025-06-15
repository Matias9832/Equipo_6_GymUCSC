<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;

// Controladores adicionales
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
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\RutinaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\AsistenciaTallerController;
use App\Http\Controllers\RutinaPersonalizadaController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\TorneoUsuarioController;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/


use App\Models\Tenant;

Route::get('/', function () {
    $host = request()->getHost();

    $tenant = Tenant::whereHas('domains', function ($query) use ($host) {
        $query->where('domain', $host);
    })->first();

    if ($tenant) {
        tenancy()->initialize($tenant);
        return redirect()->route('news.index');
    }

    return redirect()->route('inicio');
});

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/docentes/perfil/{id}', [DocenteController::class, 'showPerfil'])->name('docentes.perfilAjax');
    Route::get('/administradores/perfil/{id}', [AdministradorController::class, 'showPerfil'])->name('administradores.perfil');

    Route::get('/', function () {
        return redirect()->route('news.index');
    })->name('welcome');

    Route::fallback(function () {
        return redirect()->route('news.index');
    });

    // Rutas para verificación de usuario
    Route::get('/verificar', [RegisterController::class, 'verificarVista'])->name('verificar.vista');
    Route::post('/verificar', [RegisterController::class, 'verificarCodigo'])->name('verificar.codigo');
    Route::get('/reenviar-codigo', [RegisterController::class, 'reenviarCodigo'])->name('reenviar.codigo');

    // Rutas de autenticación
    Route::get('/dashboard', function () {
        return redirect('/dashboard');
    })->middleware('auth');

    Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
    Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest')->name('login.perform');
    Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
    Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
    Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
    Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'admin']);

    // Noticias públicas
    Route::get('/noticias', [NewsController::class, 'index'])->name('news.index');
    Route::get('/noticias/{news}', [NewsController::class, 'show'])->name('news.show');

    // Grupo de rutas protegidas por auth
    Route::group(['middleware' => 'auth'], function () {
        // Salud
        Route::get('/salud', [SaludController::class, 'create'])->name('salud.create');
        Route::post('/salud', [SaludController::class, 'store'])->name('salud.store');
        Route::get('/salud/edit', [SaludController::class, 'edit'])->name('salud.edit');
        Route::put('/salud', [SaludController::class, 'update'])->name('salud.update');

        // Actividades
        Route::get('/mi-actividad', [ActividadController::class, 'actividadUsuario'])->name('actividad.usuario');
        Route::get('/actividades', [ActividadController::class, 'eventosCalendario'])->name('actividad.eventos');

        // Control de salas
        Route::get('/ingreso/registro', [ControlSalasController::class, 'registroDesdeQR'])->name('sala.registro');
        Route::post('/sala/salida', [ControlSalasController::class, 'registrarSalida'])->name('sala.registrarSalida');
        Route::match(['get', 'post'], '/ingreso/actual', [ControlSalasController::class, 'mostrarIngreso'])->name('ingreso.mostrar');

        // Perfil usuario
        Route::get('/edit-perfil', [LoginController::class, 'editProfile'])->name('edit-perfil.edit');
        Route::post('/edit-perfil', [LoginController::class, 'updateProfile'])->name('edit-perfil.update');

        Route::get('/mis-rutinas', [RutinaPersonalizadaController::class, 'index'])->name('rutinas.personalizadas.index');

        Route::get('/mis-torneos', [TorneoUsuarioController::class, 'index'])->name('torneos.usuario.index');
        Route::get('/torneos/{torneo}/ver-miembros', [TorneoUsuarioController::class, 'verMiembros'])->name('torneos.ver.miembros');

        Route::get('/torneos/{torneo}/tabla', [TorneoController::class, 'tabla'])->name('usuario.torneos.tabla');
        Route::get('/torneos/{torneo}/partidos', [TorneoController::class, 'partidos'])->name('usuario.torneos.partidos');
        Route::get('/torneos/{torneo}/fase-grupos', [TorneoController::class, 'faseGrupos'])->name('usuario.torneos.fase-grupos');
        Route::get('/torneos/{torneo}/copa', [TorneoController::class, 'copa'])->name('usuario.torneos.copa');



        // Buscar alumno por RUT (para el formulario de rutinas)
        Route::get('/buscar-alumno-por-rut/{rut}', [App\Http\Controllers\RutinaController::class, 'buscarPorRut'])->name('buscar.alumno.rut');

        // Ejercicios por grupo muscular (para el formulario de rutinas)
        Route::get('/ejercicios-por-grupo/{grupo}', [EjercicioController::class, 'porGrupo'])->name('ejercicios.por.grupo');

        // Rutas originales
        // Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
        // Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
        Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
        Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
        Route::get('/{page}', [PageController::class, 'index'])->name('page');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });

    // Grupo de rutas administrativas bajo /admin
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', function () {
            return view('admin.index');
        })->name('admin.index');

        // Recursos protegidos por permisos
        Route::middleware(['permission:Acceso al Mantenedor de Alumnos'])->group(function () {
            Route::resource('alumnos', AlumnoController::class);
        });
        Route::middleware(['permission:Acceso al Mantenedor de Tipos de Espacios'])->group(function () {
            Route::resource('tipos_espacio', TipoEspacioController::class)->parameters(['tipos_espacio' => 'tipoEspacio']);
        });
        Route::middleware(['permission:Acceso al Mantenedor de Tipos de Sanción'])->group(function () {
            Route::resource('tipos_sancion', TipoSancionController::class)->parameters(['tipos_sancion' => 'tipoSancion']);
        });
        Route::middleware(['permission:Acceso al Mantenedor de Máquinas'])->group(function () {
            Route::resource('maquinas', MaquinaController::class);
        });
        Route::middleware(['permission:Acceso al Mantenedor de Deportes'])->group(function () {
            Route::resource('deportes', DeporteController::class);
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
            Route::get('/exportar-ingresos', [SalaController::class, 'exportIngresos'])->name('salas.exportar');
        });
        Route::middleware(['permission:Acceso al Mantenedor de Equipos'])->group(function () {
            Route::resource('equipos', EquipoController::class);
        });
        Route::middleware(['permission:Acceso al Mantenedor de Torneos'])->group(function () {
            Route::resource('torneos', TorneoController::class);
        });
        Route::get('/torneos-por-deporte', [EquipoController::class, 'torneosPorDeporte'])->name('torneos.porDeporte');

        Route::middleware(['permission:Acceso al Mantenedor de Torneos'])->group(function () {
            Route::resource('torneos', TorneoController::class);
            Route::get('torneos/{torneo}/iniciar', [TorneoController::class, 'iniciar'])->name('torneos.iniciar');
            Route::get('torneos/{torneo}/partidos', [TorneoController::class, 'partidos'])->name('torneos.partidos');
            Route::get('torneos/{torneo}/tabla', [TorneoController::class, 'tabla'])->name('torneos.tabla');
            Route::put('partidos/{partido}', [TorneoController::class, 'actualizarPartido'])->name('partidos.update');
            Route::get('torneos/{torneo}/copa', [TorneoController::class, 'copa'])->name('torneos.copa');
            Route::get('torneos/{torneo}/fase-grupos', [TorneoController::class, 'faseGrupos'])->name('torneos.fase-grupos');
            Route::put('torneos/{torneo}/finalizar-fecha', [TorneoController::class, 'finalizarFecha'])->name('torneos.finalizar-fecha');
            Route::post('admin/torneos/{torneo}/reiniciar', [TorneoController::class, 'reiniciar'])->name('torneos.reiniciar');
        });

        Route::middleware(['permission:Acceso al Mantenedor de Talleres'])->group(function () {
            Route::resource('talleres', TallerController::class)->parameters([
                'talleres' => 'taller'
            ]);
        });
        Route::middleware(['permission:Acceso al Mantenedor de Ejercicios'])->group(function () {
            Route::resource('ejercicios', EjercicioController::class)->parameters([
                'ejercicios' => 'ejercicio',
            ]);
        });
        Route::middleware(['permission:Acceso al Mantenedor de Rutinas'])->group(function () {
            Route::resource('rutinas', RutinaController::class)->parameters([
                'rutinas' => 'rutina',
            ]);
        });

        Route::middleware(['permission:Acceso al Mantenedor de Talleres'])->group(function () {
            Route::get('admin/talleres/{taller}/asistencia/registrar', [AsistenciaTallerController::class, 'registrar'])
                ->name('asistencia.registrar');
            Route::post('admin/talleres/{taller}/asistencia/registrar', [AsistenciaTallerController::class, 'guardarRegistro'])
                ->name('asistencia.guardar');
            Route::get('admin/talleres/{taller}/asistencia/ver', [AsistenciaTallerController::class, 'ver'])
                ->name('asistencia.ver');
            Route::delete('/asistencia/{taller}/eliminar/{usuario}/{fecha}', [AsistenciaTallerController::class, 'destroy'])
                ->name('asistencia.destroy');
        });

        // Usuarios
        Route::middleware(['permission:Ver Usuarios'])->group(function () {
            Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        });
        Route::middleware(['permission:Crear Usuarios'])->group(function () {
            Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
            Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        });
        Route::middleware(['permission:Editar Usuarios'])->group(function () {
            Route::get('usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
            Route::put('usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
            Route::patch('usuarios/{usuario}', [UsuarioController::class, 'update']);
        });
        Route::middleware(['permission:Eliminar Usuarios'])->group(function () {
            Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        });

        // Rutas para el mantenedor de Docentes
        Route::middleware(['permission:Ver Docentes'])->group(function () {
            Route::get('docentes', [DocenteController::class, 'index'])->name('docentes.index');
            Route::get('/mi-perfil', [DocenteController::class, 'indexPerfil'])->name('docentes.perfil');
            Route::put('/docentes/mi-perfil/foto', [DocenteController::class, 'updateFoto'])->name('docentes.foto.update');
            Route::get('/mi-perfil/edit-contacto', [DocenteController::class, 'editContacto'])->name('docentes.contacto.edit');
            Route::put('/mi-perfil/edit-contacto', [DocenteController::class, 'updateInformacionContacto'])->name('docentes.contacto.update');
        });    
        Route::middleware(['permission:Crear Docentes'])->group(function () {
            Route::get('docentes/create', [DocenteController::class, 'create'])->name('docentes.create');
            Route::post('docentes', [DocenteController::class, 'store'])->name('docentes.store');
        });
        Route::middleware(['permission:Editar Docentes'])->group(function () {
            Route::get('docentes/{docente}/edit', [DocenteController::class, 'edit'])->name('docentes.edit');
            Route::put('docentes/{docente}', [DocenteController::class, 'update'])->name('docentes.update');
        });
        Route::middleware(['permission:Eliminar Docentes'])->group(function () {
            Route::delete('docentes/{docente}', [DocenteController::class, 'destroy'])->name('docentes.destroy');
        });
        Route::get('/docentes/data', [DocenteController::class, 'data'])->name('docentes.data');


        // Busqueda de usuarios para Select2  
        Route::get('/usuarios/buscar', [UsuarioController::class, 'buscar'])->name('usuarios.buscar');


        // CRUD para administradores
        Route::middleware(['permission:Acceso al Mantenedor de Administradores'])->group(function () {
            Route::get('/administradores/data', [AdministradorController::class, 'data'])->name('administradores.data');

            Route::resource('administradores', AdministradorController::class)->parameters([
                'administradores' => 'administrador',
            ]);

        });
        Route::middleware(['permission:Crear Noticias'])->group(function () {
            Route::resource('news', NewsController::class)->except(['index', 'show']);
        });

        // Importar alumnos
        Route::post('alumnos/import', [AlumnoController::class, 'import'])->name('alumnos.import');

        Route::middleware(['permission:Acceso al Mantenedor de Carreras'])->group(function () {
            Route::resource('carreras', CarreraController::class)->only(['index']);
            Route::get('/carreras/data', [CarreraController::class, 'data'])->name('carreras.data');
        });
        // Gestión de QR
        Route::middleware(['permission:Acceso a Gestión de QR'])->group(function () {
            Route::get('/control-salas/seleccionar', [ControlSalasController::class, 'seleccionarSala'])->name('control-salas.seleccionar');
            Route::post('/control-salas/generar-qr', [ControlSalasController::class, 'generarQR'])->name('control-salas.generarQR');
            Route::get('control-salas/ver-qr', [ControlSalasController::class, 'verQR'])->name('control-salas.verQR');
            Route::post('/control-salas/registro-manual', [ControlSalasController::class, 'registroManual'])->name('registro.manual');
            Route::post('/salida-manual', [ControlSalasController::class, 'salidaManual'])->name('salida.manual');
            Route::post('/control-salas/cambiar-aforo', [ControlSalasController::class, 'cambiarAforo'])->name('control-salas.cambiar_aforo');
            Route::post('control-salas/cerrar-sala', [ControlSalasController::class, 'cerrarSala'])->name('admin.control-salas.cerrar_sala');
            Route::post('/control-salas/sacar-usuario', [ControlSalasController::class, 'sacarUsuario'])->name('admin.control-salas.sacar_usuario');
            Route::get('control-salas/ver-usuarios/{id_sala}', [ControlSalasController::class, 'verUsuarios'])->name('admin.control-salas.ver_usuarios');
            Route::get('/estado-usuario', [SalaController::class, 'estadoUsuario'])->middleware('auth');

        });

        // Eliminar imagen de noticia
        Route::delete('/news/image/{id}', [App\Http\Controllers\NewsImageController::class, 'destroy'])->name('news.image.destroy');
    });
});
