<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPostController;
use Illuminate\Support\Facades\Route;

<<<<<<< HEAD
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::controller(DashboardPostController::class)
        ->prefix('dashboard/posts')
        ->name('dashboard.posts.')
        ->group(function () {

            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{post}/view', 'show')->name('view');
            Route::get('/{post}/edit', 'edit')->name('edit');
            Route::put('/{post}', 'update')->name('update');
            Route::delete('/{post}', 'destroy')->name('destroy');
        });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('account', function () {
        return view();
    });
=======
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
>>>>>>> 9a7192196431b1d4ab1963a655c88ecb7e5cce87
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
