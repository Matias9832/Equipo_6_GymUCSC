<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaintainerController;
/*
Todavía tengo que administrar los cargos de admin
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    // Ruta para la tabla de usuarios
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

//Rutas para los mantenedores
Route::middleware('auth')->group(function () {
    Route::get('/maintainers', [MaintainerController::class, 'index'])->name('maintainers.index');
    Route::get('/maintainers/users', [MaintainerController::class, 'users'])->name('maintainers.users');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // returns the home page with all posts
    Route::get('/crud', PostController::class . '@index')->name('posts.index');
    // returns the form for adding a post
    Route::get('/posts/create', PostController::class . '@create')->name('posts.create');
    // adds a post to the database
    Route::post('/posts', PostController::class . '@store')->name('posts.store');
    // returns a page that shows a full post
    Route::get('/posts/{post}', PostController::class . '@show')->name('posts.show');
    // returns the form for editing a post
    Route::get('/posts/{post}/edit', PostController::class . '@edit')->name('posts.edit');
    // updates a post
    Route::put('/posts/{post}', PostController::class . '@update')->name('posts.update');
    // deletes a post
    Route::delete('/posts/{post}', PostController::class . '@destroy')->name('posts.destroy');

});

require __DIR__ . '/auth.php';
