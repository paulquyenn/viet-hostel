<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomImageController;
use App\Models\District;

// Districts API endpoint (không yêu cầu xác thực)
Route::get('/districts', function (Request $request) {
    if ($request->has('province_id')) {
        // Cache danh sách quận/huyện theo tỉnh/thành phố để giảm thời gian truy vấn
        $districts = Cache::remember('api_districts_' . $request->province_id, 60 * 24, function () use ($request) {
            return District::where('province_id', $request->province_id)
                ->orderBy('name', 'asc')
                ->get();
        });
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
    Route::resource('review', ReviewController::class)->only('store', 'update', 'destroy');
    Route::get('/rooms/{room}/reviews', [ReviewController::class, 'getRoomReviews']);
});
