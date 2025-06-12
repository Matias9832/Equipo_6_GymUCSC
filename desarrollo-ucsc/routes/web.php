<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenants\TenantController;
use App\Http\Controllers\Tenants\EmpresaController;

use App\Http\Controllers\Tenants\Personalizacion\TemaController;
use App\Http\Controllers\Tenants\Personalizacion\ColorController;
use App\Http\Controllers\Tenants\Personalizacion\FuenteController;

Route::get('/inicio', function () {
    return view('tenants.inicio');
})->name('inicio');
Route::get('/paginas', function () {
    return view('tenants.paginas');
})->name('paginas');
Route::get('/beneficios', function () {
    return view('tenants.beneficios');
})->name('beneficios');
Route::get('/nosotros', function () {
    return view('tenants.nosotros');
})->name('nosotros');

Route::resource('tenants', TenantController::class);
Route::resource('empresas', EmpresaController::class);


Route::prefix('personalizacion')->name('personalizacion.')->group(function () {
    Route::resource('temas', TemaController::class);
    Route::resource('colores', ColorController::class);
    Route::resource('fuentes', FuenteController::class);
});

Route::fallback(function () {
    return redirect()->route('inicio');
});