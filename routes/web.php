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

    Route::prefix('tenant')->name('tenant.')->group(function () {
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create/{room}', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings/{room}', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

        Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
        Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
        Route::get('/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');
        Route::post('/contracts/{contract}/sign', [ContractController::class, 'sign'])->name('contracts.sign');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking}/approve', [\App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('bookings.approve');
        Route::post('/bookings/{booking}/reject', [\App\Http\Controllers\Admin\BookingController::class, 'reject'])->name('bookings.reject');

        Route::get('/contracts', [\App\Http\Controllers\Admin\ContractController::class, 'index'])->name('contracts.index');
        Route::get('/contracts/create/{booking}', [\App\Http\Controllers\Admin\ContractController::class, 'create'])->name('contracts.create');
        Route::post('/contracts', [\App\Http\Controllers\Admin\ContractController::class, 'store'])->name('contracts.store');
        Route::get('/contracts/{contract}', [\App\Http\Controllers\Admin\ContractController::class, 'show'])->name('contracts.show');
        Route::get('/contracts/{contract}/download', [\App\Http\Controllers\Admin\ContractController::class, 'download'])->name('contracts.download');
        Route::get('/contracts/{contract}/edit', [\App\Http\Controllers\Admin\ContractController::class, 'edit'])->name('contracts.edit');
        Route::put('/contracts/{contract}', [\App\Http\Controllers\Admin\ContractController::class, 'update'])->name('contracts.update');
        Route::post('/contracts/{contract}/sign', [\App\Http\Controllers\Admin\ContractController::class, 'sign'])->name('contracts.sign');
        Route::post('/contracts/{contract}/terminate', [\App\Http\Controllers\Admin\ContractController::class, 'terminate'])->name('contracts.terminate');

        Route::get('/tenants', [\App\Http\Controllers\Admin\TenantController::class, 'index'])->name('tenants.index');
        Route::get('/tenants/{tenant}', [\App\Http\Controllers\Admin\TenantController::class, 'show'])->name('tenants.show');
        Route::get('/tenants-stats', [\App\Http\Controllers\Admin\TenantController::class, 'stats'])->name('tenants.stats');
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
