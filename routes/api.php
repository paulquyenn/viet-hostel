<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomImageController;
use App\Http\Controllers\BookingController;
use App\Models\District;

// Districts API endpoint (không yêu cầu xác thực)
Route::get('/districts', function (Request $request) {
    if ($request->has('province_id')) {
        $districts = District::where('province_id', $request->province_id)
            ->orderBy('name', 'asc')
            ->get();
        return response()->json($districts);
    }
    return response()->json([]);
});

Route::get('/admin', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'role:admin']);

Route::middleware('auth')->prefix('api')->group(function () {
    Route::resource('user', UserController::class)->only('store', 'update', 'destroy');
    Route::resource('building', BuildingController::class)->only('store', 'update', 'destroy');
    Route::resource('room', RoomController::class)->only('store', 'update', 'destroy');
    Route::resource('image', ImageController::class)->only('store', 'update', 'destroy');
    Route::resource('room_image', RoomImageController::class)->only('store', 'update', 'destroy');
    Route::resource('review', ReviewController::class)->only('store', 'update', 'destroy')->names([
        'store' => 'api.review.store',
        'update' => 'api.review.update',
        'destroy' => 'api.review.destroy'
    ]);
    Route::get('/rooms/{room}/reviews', [ReviewController::class, 'getRoomReviews']);
    Route::get('/check-booking-status', [BookingController::class, 'checkStatus']);
});
