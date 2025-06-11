<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenants\TenantController;
use App\Http\Controllers\Tenants\EmpresaController;

use App\Http\Controllers\Tenants\Personalizacion\TemaController;
use App\Http\Controllers\Tenants\Personalizacion\ColorController;
use App\Http\Controllers\Tenants\Personalizacion\FuenteController;

Route::get('/inicio', function () {
    return view('inicio');
})->name('inicio');
Route::resource('tenants', TenantController::class)->only(['index', 'store']);
Route::resource('empresas', EmpresaController::class);


Route::prefix('personalizacion')->name('personalizacion.')->group(function () {
    Route::resource('temas', TemaController::class);
    Route::resource('colores', ColorController::class);
    Route::resource('fuentes', FuenteController::class);
});

