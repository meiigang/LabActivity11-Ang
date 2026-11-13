<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/posts');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/my-posts', [PostController::class, 'mine'])
    ->middleware('auth')
    ->name('posts.mine');
Route::get('/posts/create', [PostController::class, 'create'])
    ->middleware('auth')
    ->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])
    ->middleware('auth')
    ->name('posts.store');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
