<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPostController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// --- Dev 3 (Public Routes) ---
// This makes the homepage the post list
Route::get('/', [PublicPostController::class, 'index'])
    ->name('home');

// This opens a single post.
// Note: We use {post} to allow Route Model Binding
Route::get('/posts/{post}', [PublicPostController::class, 'show'])
    ->name('posts.show');

require __DIR__ . '/auth.php';
