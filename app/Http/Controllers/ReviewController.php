<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reviews = Review::with(['user', 'room'])
            ->when($request->room_id, function ($query, $roomId) {
                return $query->where('room_id', $roomId);
            })
            ->when($request->user_id, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('review.index', [
            'reviews' => ReviewResource::collection($reviews)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $room = null;
        if ($request->has('room_id')) {
            $room = Room::findOrFail($request->room_id);
        }

        // Check if it's a tenant or admin request
        $viewTemplate = Auth::user()->role === 'admin' ? 'review.create' : 'review.tenant-create';

        return view($viewTemplate, [
            'room' => $room,
            'rooms' => Room::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $review = Review::create($data);

        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('room.show', $review->room_id)
                ->with('success', 'Đánh giá của bạn đã được gửi thành công!');
        } else {
            return redirect()->route('motel.detail', $review->room_id)
                ->with('success', 'Đánh giá của bạn đã được gửi thành công!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        // Load necessary relationships
        $review->load(['room.building', 'user']);

        // Check if it's an admin or tenant
        $viewTemplate = Auth::user()->role === 'admin' ? 'review.show' : 'review.tenant-show';

        return view($viewTemplate, [
            'review' => $review
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        // Chỉ cho phép chỉnh sửa đánh giá của chính mình
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa đánh giá này');
        }

        // Check if it's a tenant or admin request
        $viewTemplate = Auth::user()->role === 'admin' ? 'review.edit' : 'review.tenant-edit';

        return view($viewTemplate, [
            'review' => $review,
            'room' => $review->room
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('room.show', $review->room_id)
                ->with('success', 'Đánh giá đã được cập nhật thành công!');
        } else {
            return redirect()->route('motel.detail', $review->room_id)
                ->with('success', 'Đánh giá đã được cập nhật thành công!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Chỉ cho phép người dùng xóa đánh giá của chính họ hoặc admin
        if (Auth::id() !== $review->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa đánh giá này');
        }

        $roomId = $review->room_id;
        $review->delete();

        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('room.show', $roomId)
                ->with('success', 'Đánh giá đã được xóa thành công!');
        } else {
            return redirect()->route('motel.detail', $roomId)
                ->with('success', 'Đánh giá đã được xóa thành công!');
        }
    }

    /**
     * Lấy tất cả đánh giá của một phòng cụ thể (API endpoint)
     */
    public function getRoomReviews($roomId)
    {
        $room = Room::findOrFail($roomId);
        $reviews = Review::with('user')
            ->where('room_id', $roomId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return ReviewResource::collection($reviews)
            ->additional([
                'room' => [
                    'id' => $room->id,
                    'room_number' => $room->room_number,
                    'average_rating' => $room->average_rating,
                ]
            ]);
    }
}
