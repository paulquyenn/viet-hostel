<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RejectBookingRequest;
use App\Models\Booking;
use App\Models\Contract;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Hiển thị danh sách đặt phòng cho admin/chủ trọ
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Admin xem tất cả booking
            $bookings = Booking::with(['room.building', 'user'])
                ->latest()
                ->paginate(10);
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ xem booking của các phòng thuộc sở hữu
            $bookings = Booking::with(['room.building', 'user'])
                ->whereHas('room.building', function ($query) use ($user) {
                    $query->where('user_id', $user->id); // Chủ trọ sở hữu building
                })
                ->latest()
                ->paginate(10);
        } else {
            // Các role khác không có quyền truy cập
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Hiển thị chi tiết đặt phòng
     */
    public function show(Booking $booking)
    {
        $user = Auth::user();

        // Kiểm tra quyền xem
        if ($user->hasRole('admin')) {
            // Admin có thể xem tất cả
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ có thể xem booking của phòng thuộc sở hữu
            if ($booking->room->building->user_id !== $user->id) {
                abort(403, 'Bạn không có quyền xem đặt phòng này.');
            }
        } else {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $booking->load(['room.building', 'user']);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Duyệt yêu cầu đặt phòng
     */
    public function approve(Booking $booking)
    {
        $user = Auth::user();

        // Kiểm tra quyền duyệt
        if ($user->hasRole('admin')) {
            // Admin có thể duyệt tất cả
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ có thể duyệt booking của phòng thuộc sở hữu
            if ($booking->room->building->user_id !== $user->id) {
                abort(403, 'Bạn không có quyền duyệt đặt phòng này.');
            }
        } else {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Chỉ có thể duyệt yêu cầu đang chờ xử lý.');
        }

        // Kiểm tra xem phòng còn chỗ trống không
        $room = Room::find($booking->room_id);
        if (!$room->has_available_space) {
            return redirect()->back()->with('error', 'Phòng này đã đầy, không thể duyệt đơn đặt phòng.');
        }

        $booking->status = 'approved';
        $booking->save();

        // Chuyển đến trang tạo hợp đồng
        return redirect()->route('admin.contracts.create', ['booking' => $booking->id])
            ->with('success', 'Đã duyệt yêu cầu đặt phòng. Vui lòng tạo hợp đồng.');
    }

    /**
     * Từ chối yêu cầu đặt phòng
     */
    public function reject(RejectBookingRequest $request, Booking $booking)
    {
        $user = Auth::user();

        // Kiểm tra quyền từ chối
        if ($user->hasRole('admin')) {
            // Admin có thể từ chối tất cả
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ có thể từ chối booking của phòng thuộc sở hữu
            if ($booking->room->building->user_id !== $user->id) {
                abort(403, 'Bạn không có quyền từ chối đặt phòng này.');
            }
        } else {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Chỉ có thể từ chối yêu cầu đang chờ xử lý.');
        }

        $validated = $request->validated();

        $booking->status = 'rejected';
        $booking->note = $booking->note . "\n\nLý do từ chối: " . $validated['reject_reason'];
        $booking->save();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Đã từ chối yêu cầu đặt phòng.');
    }
}
