<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Hiển thị danh sách đặt phòng của người dùng hiện tại
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->with(['room.building'])->latest()->paginate(10);

        return view('tenant.bookings.index', compact('bookings'));
    }

    /**
     * Hiển thị form đặt phòng
     */
    public function create(Room $room)
    {
        // Kiểm tra xem người dùng đã có hợp đồng active hay chưa
        if (Auth::user()->hasActiveContract()) {
            $activeContract = Auth::user()->getActiveContract();
            return redirect()->back()->with('error',
                'Bạn đang có hợp đồng thuê phòng tại ' .
                $activeContract->room->building->name . ' - ' . $activeContract->room->room_number .
                ' (đến ngày ' . $activeContract->end_date->format('d/m/Y') . '). ' .
                'Không thể đăng ký phòng mới khi đang có hợp đồng hiệu lực.');
        }

        // Kiểm tra xem người dùng có đơn đặt phòng đang chờ xử lý không
        if (Auth::user()->hasPendingBooking()) {
            $pendingBooking = Auth::user()->getPendingBooking();
            return redirect()->back()->with('error',
                'Bạn đang có đơn đặt phòng chờ xử lý tại ' .
                $pendingBooking->room->building->name . ' - ' . $pendingBooking->room->room_number .
                ' (ngày đặt: ' . $pendingBooking->created_at->format('d/m/Y') . '). ' .
                'Vui lòng chờ xử lý hoặc hủy đơn cũ trước khi đặt phòng mới.');
        }

        // Kiểm tra xem phòng có còn chỗ trống hay không
        if (!$room->has_available_space) {
            return redirect()->back()->with('error', 'Phòng này đã đầy, không thể đặt thêm.');
        }

        return view('tenant.bookings.create', compact('room'));
    }

    /**
     * Lưu đơn đặt phòng mới
     */
    public function store(Request $request, Room $room)
    {
        // Kiểm tra xem người dùng đã có hợp đồng active hay chưa
        if (Auth::user()->hasActiveContract()) {
            $activeContract = Auth::user()->getActiveContract();
            return redirect()->back()->with('error',
                'Bạn đang có hợp đồng thuê phòng tại ' .
                $activeContract->room->building->name . ' - ' . $activeContract->room->room_number .
                ' (đến ngày ' . $activeContract->end_date->format('d/m/Y') . '). ' .
                'Không thể đăng ký phòng mới khi đang có hợp đồng hiệu lực.');
        }

        // Kiểm tra xem người dùng có đơn đặt phòng đang chờ xử lý không
        if (Auth::user()->hasPendingBooking()) {
            $pendingBooking = Auth::user()->getPendingBooking();
            return redirect()->back()->with('error',
                'Bạn đang có đơn đặt phòng chờ xử lý tại ' .
                $pendingBooking->room->building->name . ' - ' . $pendingBooking->room->room_number .
                ' (ngày đặt: ' . $pendingBooking->created_at->format('d/m/Y') . '). ' .
                'Vui lòng chờ xử lý hoặc hủy đơn cũ trước khi đặt phòng mới.');
        }

        // Kiểm tra xem phòng có còn chỗ trống hay không
        if (!$room->has_available_space) {
            return redirect()->back()->with('error', 'Phòng này đã đầy, không thể đặt thêm.');
        }

        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'desired_move_date' => 'required|date|after:today',
            'duration' => 'required|integer|min:1|max:36',
            'note' => 'nullable|string|max:500',
        ]);

        // Tạo booking mới
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->room_id = $room->id;
        $booking->desired_move_date = $validated['desired_move_date'];
        $booking->duration = $validated['duration'];
        $booking->note = $validated['note'];
        $booking->status = 'pending';
        $booking->save();

        return redirect()->route('tenant.bookings.index')
            ->with('success', 'Đã gửi yêu cầu đặt phòng thành công. Vui lòng đợi chủ trọ xác nhận.');
    }

    /**
     * Hiển thị chi tiết đặt phòng
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        $booking->load(['room.building', 'user']);

        return view('tenant.bookings.show', compact('booking'));
    }
    /**
     *
     * Hủy đặt phòng
     */
    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        // Chỉ có thể hủy nếu trạng thái là 'pending'
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Không thể hủy yêu cầu đặt phòng này.');
        }

        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('tenant.bookings.index')
            ->with('success', 'Đã hủy yêu cầu đặt phòng thành công.');
    }

    /**
     * Hiển thị tất cả các đặt phòng (Admin)
     */
    public function adminIndex()
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
        }

        // Chỉ admin mới có quyền xem tất cả các booking
        $bookings = Booking::with(['user', 'room.building'])->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Hiển thị chi tiết đặt phòng (Admin)
     */
    public function adminShow(Booking $booking)
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
        }

        $booking->load(['room.building', 'user', 'contract']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Duyệt đặt phòng (Admin)
     */
    public function approve(Booking $booking)
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
        }

        $this->authorize('approve', $booking);

        // Chỉ có thể duyệt nếu trạng thái là 'pending'
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Không thể duyệt yêu cầu đặt phòng này.');
        }

        // Kiểm tra xem phòng có còn chỗ trống không
        $room = $booking->room;
        if (!$room->has_available_space) {
            return redirect()->back()->with('error', 'Phòng này đã đầy, không thể duyệt đơn đặt phòng.');
        }

        $booking->status = 'approved';
        $booking->save();

        // Cập nhật trạng thái phòng
        // Nếu phòng đang trống, đổi status thành 'occupied'
        if ($room->status === 'available') {
            $room->status = 'occupied';
            $room->save();
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Đã duyệt yêu cầu đặt phòng thành công.');
    }

    /**
     * Từ chối đặt phòng (Admin)
     */
    public function reject(Booking $booking)
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
        }

        $this->authorize('reject', $booking);

        // Chỉ có thể từ chối nếu trạng thái là 'pending'
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Không thể từ chối yêu cầu đặt phòng này.');
        }

        $booking->status = 'rejected';
        $booking->save();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Đã từ chối yêu cầu đặt phòng.');
    }

    public function checkStatus()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => 'not_authenticated'], 401);
        }

        // Check for active contract
        if ($user->hasActiveContract()) {
            $contract = $user->getActiveContract();
            $room = $contract->room;
            $building = $room->building;
            return response()->json([
                'status' => 'has_active_contract',
                'message' => "Bạn đang có hợp đồng thuê phòng tại {$building->name} - {$room->name} (đến ngày " . $contract->end_date->format('d/m/Y') . "). Không thể đăng ký phòng mới khi đang có hợp đồng hiệu lực.",
                'room' => $room->name,
                'building' => $building->name,
                'end_date' => $contract->end_date->format('d/m/Y')
            ]);
        }

        // Check for pending booking
        if ($user->hasPendingBooking()) {
            $booking = $user->getPendingBooking();
            $room = $booking->room;
            $building = $room->building;
            return response()->json([
                'status' => 'has_pending_booking',
                'message' => "Bạn đang có đơn đặt phòng chờ xử lý tại {$building->name} - {$room->name}. Vui lòng chờ xử lý hoặc hủy đơn cũ trước khi đặt phòng mới.",
                'room' => $room->name,
                'building' => $building->name
            ]);
        }

        return response()->json(['status' => 'available']);
    }
}
