<?php

use App\Http\Controllers\Frontend\CheckAvailabilityContorller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Post\PostController;
use App\Http\Controllers\Frontend\Profile\ProfileController;
use App\Http\Controllers\Frontend\Room\RoomsController;


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


/** Rooms */
Route::get('rooms', [RoomsController::class, 'index'])->name('rooms.index');
Route::get('rooms/{room}', [RoomsController::class, 'show'])->name('rooms.show');

Route::get('check-room-availability', [CheckAvailabilityContorller::class, 'checkAvailability'])->name('checkAvailability');

/** Posts */
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{slug}', [PostController::class, 'show'])->name('posts.show');


require __DIR__ . '/auth.php';
