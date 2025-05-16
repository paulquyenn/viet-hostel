<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReviewController;
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

// Test route for middleware debugging
Route::get('/role-test', function () {
    return "You have successfully accessed the role test route!";
})->middleware(['auth', 'admin.role'])->name('role.test');

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
    Route::get('/motel/{room}', 'motelDetail')->name('motel.detail')->middleware('auth');
    Route::get('/my-reviews', 'myReviews')->name('my.reviews')->middleware('auth');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
});

Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('building', BuildingController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('room', RoomController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('image', ImageController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('room_image', RoomImageController::class)->only('index', 'create', 'edit', 'show');
    Route::resource('review', ReviewController::class);

    // Routes for tenant booking management
    Route::prefix('tenant')->name('tenant.')->group(function () {
        // Booking routes
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create/{room}', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings/{room}', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

        // Contract routes
        Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
        Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
        Route::get('/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');
        Route::post('/contracts/{contract}/sign', [ContractController::class, 'sign'])->name('contracts.sign');
    });

    // Routes for admin booking & contract management
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        // Admin booking routes - direct control in controller
        Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('bookings.index');
        Route::get('/bookings/{booking}', [BookingController::class, 'adminShow'])->name('bookings.show');
        Route::post('/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
        Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

        // Admin contract routes
        Route::get('/contracts', [ContractController::class, 'adminIndex'])->name('contracts.index');
        Route::get('/contracts/create/{booking}', [ContractController::class, 'create'])->name('contracts.create');
        Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
        Route::get('/contracts/{contract}', [ContractController::class, 'adminShow'])->name('contracts.show');
        Route::get('/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');
        Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
        Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
        Route::post('/contracts/{contract}/sign', [ContractController::class, 'sign'])->name('contracts.sign');
        Route::post('/contracts/{contract}/terminate', [ContractController::class, 'terminate'])->name('contracts.terminate');
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
