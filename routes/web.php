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

/*
|--------------------------------------------------------------------------
| Public Routes - Không yêu cầu đăng nhập
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (!Auth::check()) {
        return view('welcome');
    }
    return redirect()->route('dashboard');
});

// Các trang công khai
Route::controller(HomeController::class)->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes - Yêu cầu đăng nhập
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes - Tất cả user đã đăng nhập
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Shared routes - Tất cả user đã đăng nhập có thể truy cập
    Route::controller(HomeController::class)->group(function () {
        Route::get('/motel', 'motel')->name('motel');
        Route::get('/motel/{room}', 'motelDetail')->name('motel.detail');
        Route::get('/my-reviews', 'myReviews')->name('my.reviews');
    });

    // Review routes - Tất cả user có thể tạo và quản lý review
    Route::resource('review', ReviewController::class);

    /*
    |--------------------------------------------------------------------------
    | Tenant Routes - Dành cho người thuê trọ
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:tenant')->prefix('tenant')->name('tenant.')->group(function () {

        // Booking management
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('index');
            Route::get('/create/{room}', [BookingController::class, 'create'])->name('create');
            Route::post('/{room}', [BookingController::class, 'store'])->name('store');
            Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
            Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
        });

        // Contract management for tenants
        Route::prefix('contracts')->name('contracts.')->group(function () {
            Route::get('/', [ContractController::class, 'index'])->name('index');
            Route::get('/{contract}', [ContractController::class, 'show'])->name('show');
            Route::get('/{contract}/download', [ContractController::class, 'download'])->name('download');
            Route::post('/{contract}/sign', [ContractController::class, 'sign'])->name('sign');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Landlord Routes - Dành cho chủ trọ
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:landlord')->prefix('landlord')->name('landlord.')->group(function () {

        // Building management
        Route::resource('buildings', BuildingController::class)->except(['destroy']);

        // Room management
        Route::resource('rooms', RoomController::class)->except(['destroy']);

        // Image management
        Route::resource('images', ImageController::class)->except(['destroy']);
        Route::resource('room_image', RoomImageController::class)->except(['destroy']);

        // Booking management for landlord's properties
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('index');
            Route::get('/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('show');
            Route::post('/{booking}/approve', [\App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('approve');
            Route::post('/{booking}/reject', [\App\Http\Controllers\Admin\BookingController::class, 'reject'])->name('reject');
        });

        // Contract management for landlord's properties
        Route::prefix('contracts')->name('contracts.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ContractController::class, 'index'])->name('index');
            Route::get('/create/{booking}', [\App\Http\Controllers\Admin\ContractController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\ContractController::class, 'store'])->name('store');
            Route::get('/{contract}', [\App\Http\Controllers\Admin\ContractController::class, 'show'])->name('show');
            Route::get('/{contract}/download', [\App\Http\Controllers\Admin\ContractController::class, 'download'])->name('download');
            Route::get('/{contract}/edit', [\App\Http\Controllers\Admin\ContractController::class, 'edit'])->name('edit');
            Route::put('/{contract}', [\App\Http\Controllers\Admin\ContractController::class, 'update'])->name('update');
            Route::post('/{contract}/sign', [\App\Http\Controllers\Admin\ContractController::class, 'sign'])->name('sign');
            Route::post('/{contract}/terminate', [\App\Http\Controllers\Admin\ContractController::class, 'terminate'])->name('terminate');
        });

        // View tenants in landlord's properties
        Route::prefix('tenants')->name('tenants.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\TenantController::class, 'index'])->name('index');
            Route::get('/{tenant}', [\App\Http\Controllers\Admin\TenantController::class, 'show'])->name('show');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes - Dành cho quản trị viên
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        // User management
        Route::resource('users', UserController::class);

        // Building management (full control)
        Route::resource('buildings', BuildingController::class);

        // Room management (full control)
        Route::resource('rooms', RoomController::class);

        // Image management (full control)
        Route::resource('images', ImageController::class);
        Route::resource('room_image', RoomImageController::class);

        // Booking management
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('index');
            Route::get('/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('show');
            Route::post('/{booking}/approve', [\App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('approve');
            Route::post('/{booking}/reject', [\App\Http\Controllers\Admin\BookingController::class, 'reject'])->name('reject');
        });

        // Contract management
        Route::prefix('contracts')->name('contracts.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ContractController::class, 'index'])->name('index');
            Route::get('/create/{booking}', [\App\Http\Controllers\Admin\ContractController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\ContractController::class, 'store'])->name('store');
            Route::get('/{contract}', [\App\Http\Controllers\Admin\ContractController::class, 'show'])->name('show');
            Route::get('/{contract}/download', [\App\Http\Controllers\Admin\ContractController::class, 'download'])->name('download');
            Route::get('/{contract}/edit', [\App\Http\Controllers\Admin\ContractController::class, 'edit'])->name('edit');
            Route::put('/{contract}', [\App\Http\Controllers\Admin\ContractController::class, 'update'])->name('update');
            Route::post('/{contract}/sign', [\App\Http\Controllers\Admin\ContractController::class, 'sign'])->name('sign');
            Route::post('/{contract}/terminate', [\App\Http\Controllers\Admin\ContractController::class, 'terminate'])->name('terminate');
        });

        // Tenant management
        Route::prefix('tenants')->name('tenants.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\TenantController::class, 'index'])->name('index');
            Route::get('/{tenant}', [\App\Http\Controllers\Admin\TenantController::class, 'show'])->name('show');
            Route::get('/stats', [\App\Http\Controllers\Admin\TenantController::class, 'stats'])->name('stats');
        });
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
