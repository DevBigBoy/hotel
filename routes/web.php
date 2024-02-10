<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Profile\ProfileController;
use App\Http\Requests\Frontend\Profile\ProfileUpdateRequest;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('frontend.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.password');

    Route::get('mybookings', [ProfileController::class, 'booking'])->name('profile.booking');
});

require __DIR__ . '/auth.php';
