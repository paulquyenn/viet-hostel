<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RoomImageController;

Route::get('/admin', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'role:admin']);

Route::middleware('auth')->prefix('api')->group(function () {
    Route::resource('user', UserController::class)->only('store', 'update', 'destroy');
    Route::resource('building', BuildingController::class)->only('store', 'update', 'destroy');
    Route::resource('room', RoomController::class)->only('store', 'update', 'destroy');
    Route::resource('image', ImageController::class)->only('store', 'update', 'destroy');
    Route::resource('room_image', RoomImageController::class)->only('store', 'update', 'destroy');
});
