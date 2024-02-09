<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Profile\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('frontend.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/logout', [ProfileController::class, 'logout'])->name('profile.logout');

    Route::get('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});

require __DIR__ . '/auth.php';


/**
 * Admin Group
 */

Route::middleware('guest')->prefix('admin')->as('admin.')->group(function () {
    Route::get('login', [AdminController::class, 'login'])
        ->name('login');
});


Route::middleware(['auth', 'roles:admin'])->prefix('admin')->as('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'destroy'])->name('logout');

    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
});