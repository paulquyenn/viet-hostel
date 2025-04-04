<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/admin', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'role:admin']);

Route::resource('user', UserController::class);
