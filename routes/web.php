<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPostController;
use Illuminate\Support\Facades\Route;

// 1. Homepage = List of Posts
Route::get('/', [PublicPostController::class, 'index'])
    ->name('posts.index');
// 2. Single Post View
Route::get('/posts/{post:slug}', [PublicPostController::class, 'show'])
    ->name('posts.show')->middleware(['user']);

// --- Authenticated Group ---
Route::middleware(['auth', 'verified','user'])->group(function () {

    // Dashboard Landing Page
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('dashboard/posts', DashboardPostController::class)
        ->names('dashboard.posts');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
        ->name('posts.like');

    Route::get('/my-likes', [ProfileController::class, 'likedPosts'])
        ->name('profile.likes');
});

require __DIR__ . '/auth.php';