<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RentalRequestController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractStatusController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
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
    Route::get('/motel', 'motel')->name('motel'); // Removed auth middleware
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

    // Routes cho yêu cầu thuê phòng
    Route::resource('rental-requests', RentalRequestController::class);
    Route::get('/landlord/rental-requests', [RentalRequestController::class, 'landlordRequests'])
        ->name('landlord.rental-requests');

    // Routes cho hợp đồng thuê phòng
    Route::resource('contracts', ContractController::class);
    Route::post('/contracts/{contract}/terminate', [ContractController::class, 'terminate'])
        ->name('contracts.terminate');

    // Route cho việc cập nhật hợp đồng hết hạn
    Route::get('/admin/update-expired-contracts', [ContractStatusController::class, 'updateExpiredContracts'])
        ->middleware(['auth', 'role:admin'])
        ->name('contracts.update-expired');

    // Routes cho trang quản lý admin
    Route::get('/admin/contract-management', [AdminController::class, 'contractManagement'])
        ->middleware(['auth', 'role:admin'])
        ->name('admin.contract-management');

    // Routes cho thanh toán
    Route::resource('payments', PaymentController::class);
    Route::post('/payments/{payment}/mark-as-paid', [PaymentController::class, 'markAsPaid'])
        ->name('payments.mark-as-paid');
    Route::post('/contracts/{contract}/generate-monthly-payment', [PaymentController::class, 'generateMonthlyPayment'])
        ->name('contracts.generate-monthly-payment');

    // Routes cho thông báo
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
