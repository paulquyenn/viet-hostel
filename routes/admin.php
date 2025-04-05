<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;

Route::get('/admin', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'role:admin']);

Route::resource('user', UserController::class);
Route::resource('building', BuildingController::class);
