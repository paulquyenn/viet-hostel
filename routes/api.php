<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomController;

Route::get('/admin', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'role:admin']);

Route::resource('building', BuildingController::class)->middleware('auth');
Route::resource('room', RoomController::class);

Route::middleware('auth')->prefix('api')->group(function () {
    Route::resource('user', UserController::class)->only('store', 'update', 'destroy');
    Route::resource('building', BuildingController::class)->only('store', 'update', 'destroy');
});
