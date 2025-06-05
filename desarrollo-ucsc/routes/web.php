<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landlord\TenantController;

Route::get('/landlord', [TenantController::class, 'index'])->name('landlord.home');
Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');