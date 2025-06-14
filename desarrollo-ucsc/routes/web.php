<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenants\TenantController;
use App\Http\Controllers\Tenants\EmpresaController;

use App\Http\Controllers\Tenants\Personalizacion\TemaController;
use App\Http\Controllers\Tenants\Personalizacion\ColorController;
use App\Http\Controllers\Tenants\Personalizacion\FuenteController;
use App\Http\Controllers\Tenants\InicioController;
use App\Http\Controllers\Tenants\Auth\LoginTenantController;

Route::middleware(['web', 'preventTenant'])->group(function () {

Route::get('tenant-login', [LoginTenantController::class, 'showLoginForm'])->name('tenant-login');
Route::post('tenant-login', [LoginTenantController::class, 'login']);
Route::post('tenant-logout', [LoginTenantController::class, 'logout'])->name('tenant-logout');


Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
Route::fallback(function () {
    return redirect()->route('inicio');
});

Route::middleware(['checkTenantSession'])->group(function () {
    Route::resource('tenants', TenantController::class);
    Route::resource('empresas', EmpresaController::class);

    Route::prefix('personalizacion')->name('personalizacion.')->group(function () {
        Route::resource('temas', TemaController::class);
        Route::resource('colores', ColorController::class);
        Route::resource('fuentes', FuenteController::class);
    });
});
    
});