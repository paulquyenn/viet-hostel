<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $bookings = Booking::with(['room.building', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Hiển thị chi tiết đặt phòng
     */
    public function show(Booking $booking)
    {
        $booking->load(['room.building', 'user']);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Duyệt yêu cầu đặt phòng
     */
    public function approve(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Chỉ có thể duyệt yêu cầu đang chờ xử lý.');
        }

        // Kiểm tra xem phòng còn trống không
        $room = Room::find($booking->room_id);
        if ($room->status !== 'Còn trống') {
            return redirect()->back()->with('error', 'Phòng này đã có người thuê.');
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
    public function reject(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Chỉ có thể từ chối yêu cầu đang chờ xử lý.');
        }

        $request->validate([
            'reject_reason' => 'required|string|max:500',
        ]);

        $booking->status = 'rejected';
        $booking->note = $booking->note . "\n\nLý do từ chối: " . $request->reject_reason;
        $booking->save();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Đã từ chối yêu cầu đặt phòng.');
    }
}
