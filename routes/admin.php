<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Backend\DashboardContoller;
use App\Http\Controllers\Backend\Room\RoomController;
use App\Http\Controllers\Backend\Team\TeamController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Admin\ProfileController;
use App\Http\Controllers\Backend\Room\MultiImageController;
use App\Http\Controllers\Backend\BookArea\BookAreaController;
use App\Http\Controllers\Backend\facility\FacilityController;
use App\Http\Controllers\Backend\RoomNumber\RoomNumberController;
use App\Http\Controllers\Backend\RoomType\RoomTypeController;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'login'])
        ->name('login');

    Route::post('login', [LoginController::class, 'store'])
        ->name('login.store');
});


Route::middleware(['auth', 'roles:admin'])->group(function () {

    Route::get('/dashboard', [DashboardContoller::class, 'index'])->name('dashboard');


    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {

        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');

        Route::get('psssword/edit', [ProfileController::class, 'password'])->name('password.edit');
        Route::patch('psssword/update', [PasswordController::class, 'update'])->name('password.update');

        Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
    });



    Route::resource('room-types', RoomTypeController::class)->except(['show']);

    Route::resource('facilities', FacilityController::class)->except(['show']);

    Route::resource('rooms', RoomController::class)->except(['show']);

    Route::post('multi-images/{room}', [MultiImageController::class, 'store'])->name('multi-images.store');
    Route::delete('multi-images/{room}/{multiImage}', [MultiImageController::class, 'destroy'])->name('multi-images.destroy');

    Route::resource('room-numbers', RoomNumberController::class)->except('show');

    /**
     *
     * Frontend
     */

    Route::resource('teams', TeamController::class);

    Route::resource('bookarea', BookAreaController::class);
});