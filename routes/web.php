<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomImageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!Auth::check()) {
        return view('welcome');
    }
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/motel', 'motel')->name('motel')->middleware('auth');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
});

Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('province', ProvinceController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('building', BuildingController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('room', RoomController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('image', ImageController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('room_image', RoomImageController::class)->only('index', 'create', 'edit', 'show');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
