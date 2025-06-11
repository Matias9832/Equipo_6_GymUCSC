<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenants\TenantController;

use App\Http\Controllers\Tenants\Personalizacion\TemaController;
use App\Http\Controllers\Tenants\Personalizacion\ColorController;
use App\Http\Controllers\Tenants\Personalizacion\FuenteController;
use App\Http\Controllers\Tenants\Plan\PlanController;
use App\Http\Controllers\Tenants\Plan\CuentaController;
use App\Http\Controllers\Tenants\Plan\PermisoController;

Route::get('/start', function () {
    return view('start');
})->name('start');
Route::resource('tenants', TenantController::class)->only(['index', 'store']);
Route::resource('empresas', TenantController::class)->only(['index', 'store']);


Route::prefix('personalizacion')->name('personalizacion.')->group(function () {
    Route::resource('temas', TemaController::class);
    Route::resource('colores', ColorController::class);
    Route::resource('fuentes', FuenteController::class);
});

Route::prefix('plan')->name('plan.')->group(function () {
    Route::get('planes', [PlanController::class, 'index'])->name('planes.index');
    Route::get('cuentas', [CuentaController::class, 'index'])->name('cuentas.index');
    Route::get('permisos', [PermisoController::class, 'index'])->name('permisos.index');
});

