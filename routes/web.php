<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPostController;
use Illuminate\Support\Facades\Route;

// --- Dev 3 (Public Routes) ---
// 1. Homepage = List of Posts
Route::get('/', [PublicPostController::class, 'index'])->name('posts.index');
// 2. Single Post View
Route::get('/posts/{post:slug}', [PublicPostController::class, 'show'])->name('posts.show');

Route::get('/posts/{post}', [PublicPostController::class, 'show'])->name('posts.show');

// --- Authenticated Group ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Landing Page
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // Dev 2: Dashboard Posts (Manage My Posts)
    Route::resource('dashboard/posts', DashboardPostController::class)->names('dashboard.posts');
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Dev 4: Comment Routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
    // Dev 5: Like System
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
        ->name('posts.like');
    Route::get('/my-likes', [ProfileController::class, 'likedPosts'])->name('profile.likes');
});

require __DIR__ . '/auth.php';
