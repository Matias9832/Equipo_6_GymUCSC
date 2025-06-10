<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenants\TenantController;

use App\Http\Controllers\Tenants\Personalizacion\TemaController;
use App\Http\Controllers\Tenants\Personalizacion\ColorController;
use App\Http\Controllers\Tenants\Personalizacion\FuenteController;
use App\Http\Controllers\Tenants\Plan\PlanController;
use App\Http\Controllers\Tenants\Plan\BeneficioController;
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
    Route::resource('planes', PlanController::class);
    Route::resource('beneficios', BeneficioController::class);
    Route::resource('permisos', PermisoController::class);

    Route::delete('permisos/subgrupo/{subgrupo}', [PermisoController::class, 'destroySubgrupo'])->name('permisos.destroySubgrupo');
});

