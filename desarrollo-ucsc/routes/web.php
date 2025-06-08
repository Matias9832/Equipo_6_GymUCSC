<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenants\TenantController;

Route::resource('tenants', TenantController::class)->only(['index', 'store']);
