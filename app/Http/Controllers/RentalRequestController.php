<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RentalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Kiểm tra vai trò người dùng để hiển thị danh sách yêu cầu phù hợp
        $user = Auth::user();

        if ($user->role == 'admin') {
            // Admin xem tất cả các yêu cầu
            $rentalRequests = RentalRequest::with(['user', 'room'])->latest()->paginate(10);
        } elseif ($user->role == 'landlord') {
            // Chủ trọ xem các yêu cầu liên quan đến phòng của họ
            $buildingIds = $user->buildings()->pluck('id');
            $roomIds = Room::whereIn('building_id', $buildingIds)->pluck('id');
            $rentalRequests = RentalRequest::whereIn('room_id', $roomIds)
                ->with(['user', 'room'])
                ->latest()
                ->paginate(10);
        } else {
            // Người thuê xem các yêu cầu của mình
            $rentalRequests = $user->rentalRequests()
                ->with(['room'])
                ->latest()
                ->paginate(10);
        }

        return view('rental-requests.index', compact('rentalRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomId = request('room_id');
        $room = Room::findOrFail($roomId);

        // Kiểm tra xem phòng đã được thuê chưa
        if ($room->isRented()) {
            return redirect()->back()
                ->with('error', 'Phòng này đã được thuê.');
        }

        return view('rental-requests.create', compact('room'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'requested_from_date' => 'required|date|after_or_equal:today',
            'requested_to_date' => 'nullable|date|after:requested_from_date',
            'message' => 'nullable|string|max:500',
        ]);

        $room = Room::findOrFail($request->room_id);

        // Kiểm tra xem phòng đã được thuê chưa
        if ($room->isRented()) {
            return redirect()->back()
                ->with('error', 'Phòng này đã được thuê.');
        }

        // Kiểm tra xem người dùng đã gửi yêu cầu thuê phòng này chưa
        $existingRequest = RentalRequest::where('user_id', Auth::id())
            ->where('room_id', $request->room_id)
            ->where('status', 'pending')
            ->exists();

        if ($existingRequest) {
            return redirect()->back()
                ->with('error', 'Bạn đã gửi yêu cầu thuê phòng này rồi.');
        }

        // Tạo yêu cầu thuê mới
        $rentalRequest = new RentalRequest();
        $rentalRequest->user_id = Auth::id();
        $rentalRequest->room_id = $request->room_id;
        $rentalRequest->requested_from_date = $request->requested_from_date;
        $rentalRequest->requested_to_date = $request->requested_to_date;
        $rentalRequest->message = $request->message;
        $rentalRequest->status = 'pending';
        $rentalRequest->save();

        return redirect()->route('rental-requests.index')
            ->with('success', 'Yêu cầu thuê phòng đã được gửi thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rentalRequest = RentalRequest::with(['user', 'room', 'room.building'])->findOrFail($id);

        // Kiểm tra quyền truy cập
        $user = Auth::user();
        $canView = false;

        if ($user->role == 'admin') {
            $canView = true;
        } elseif ($user->role == 'landlord') {
            // Chỉ chủ trọ của phòng mới có thể xem
            $canView = $rentalRequest->room->building->user_id === $user->id;
        } elseif ($user->id === $rentalRequest->user_id) {
            // Người gửi yêu cầu có thể xem
            $canView = true;
        }

        if (!$canView) {
            abort(403, 'Bạn không có quyền xem yêu cầu thuê này.');
        }

        return view('rental-requests.show', compact('rentalRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Không cần chức năng edit, vì yêu cầu thuê không được sửa sau khi đã gửi
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ]);

        $rentalRequest = RentalRequest::findOrFail($id);

        // Kiểm tra quyền xử lý yêu cầu
        $user = Auth::user();
        $canProcess = false;

        if ($user->role == 'admin') {
            $canProcess = true;
        } elseif ($user->role == 'landlord') {
            // Chỉ chủ trọ của phòng mới có thể xử lý
            $canProcess = $rentalRequest->room->building->user_id === $user->id;
        }

        if (!$canProcess) {
            return redirect()->back()
                ->with('error', 'Bạn không có quyền xử lý yêu cầu thuê này.');
        }

        // Kiểm tra xem phòng đã được thuê chưa
        if ($rentalRequest->room->isRented() && $request->status === 'approved') {
            return redirect()->back()
                ->with('error', 'Không thể chấp nhận yêu cầu vì phòng này đã được thuê.');
        }

        // Cập nhật trạng thái yêu cầu
        $rentalRequest->status = $request->status;
        if ($request->status === 'rejected') {
            $rentalRequest->rejection_reason = $request->rejection_reason;
        }
        $rentalRequest->save();

        if ($request->status === 'approved') {
            // Chuyển hướng đến trang tạo hợp đồng
            return redirect()->route('contracts.create', ['rental_request_id' => $rentalRequest->id])
                ->with('success', 'Yêu cầu thuê đã được chấp nhận. Hãy tạo hợp đồng.');
        }

        return redirect()->route('rental-requests.index')
            ->with('success', 'Yêu cầu thuê đã được xử lý thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rentalRequest = RentalRequest::findOrFail($id);

        // Chỉ cho phép người thuê hủy yêu cầu của chính họ và chỉ khi yêu cầu đang ở trạng thái "pending"
        if (Auth::id() !== $rentalRequest->user_id || !$rentalRequest->isPending()) {
            return redirect()->back()
                ->with('error', 'Bạn không thể hủy yêu cầu thuê này.');
        }

        // Cập nhật trạng thái thành "cancelled" thay vì xóa
        $rentalRequest->status = 'cancelled';
        $rentalRequest->save();

        return redirect()->route('rental-requests.index')
            ->with('success', 'Yêu cầu thuê đã được hủy thành công.');
    }

    /**
     * Hiển thị danh sách yêu cầu thuê cho chủ trọ xử lý
     */
    public function landlordRequests()
    {
        $user = Auth::user();

        if (!$user->role == 'landlord' && !$user->role == 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        if ($user->role == 'admin') {
            // Admin xem tất cả các yêu cầu đang chờ xử lý
            $pendingRequests = RentalRequest::where('status', 'pending')
                ->with(['user', 'room', 'room.building'])
                ->latest()
                ->paginate(10);
        } else {
            // Chủ trọ xem các yêu cầu liên quan đến phòng của họ
            $buildingIds = $user->buildings()->pluck('id');
            $roomIds = Room::whereIn('building_id', $buildingIds)->pluck('id');
            $pendingRequests = RentalRequest::whereIn('room_id', $roomIds)
                ->where('status', 'pending')
                ->with(['user', 'room', 'room.building'])
                ->latest()
                ->paginate(10);
        }

        return view('rental-requests.landlord', compact('pendingRequests'));
    }
}
