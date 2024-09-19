<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/toggle-dark-mode', function (Request $request) {
        $user = $request->user();

        // Toggle dark mode state
        $user->dark_mode = $user->dark_mode === 'on' ? 'off' : 'on';
        $user->save();

        return response()->json(['dark_mode' => $user->dark_mode]);
    });

    Route::post('/get-dark-mode', function (Request $request) {
        $user = $request->user();
        return response()->json(['dark_mode' => $user->dark_mode ?? 'off']);
    });
});


Route::middleware(['auth:sanctum', 'role:sales'])->group(function () {});


Route::middleware(['auth:sanctum', 'role:user'])->group(function () {});