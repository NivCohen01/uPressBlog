<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ExternalPostsController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');

Route::middleware(['auth'])->group(function () {
    // Create Post
    Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
    
    // Edit Post
    Route::get('/posts/{id}/edit', [PostsController::class, 'edit'])->name('posts.edit'); 
    Route::put('/posts/{id}', [PostsController::class, 'update'])->name('posts.update');

    // Delete Post
    Route::delete('/posts/{id}', [PostsController::class, 'destroy'])->name('posts.destroy');
});

Route::get('/posts/{id}', [PostsController::class, 'show'])->name('posts.show');


Route::get('/external-posts', [ExternalPostsController::class, 'index'])->name('external-posts.index');
Route::get('/external-posts/{id}', [ExternalPostsController::class, 'show'])->name('external-posts.show');