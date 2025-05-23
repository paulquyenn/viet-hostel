<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contract;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    /**
     * Hiển thị danh sách hợp đồng
     */
    public function index()
    {
        $contracts = Contract::with(['room.building', 'tenant', 'landlord'])
            ->latest()
            ->paginate(10);

        return view('admin.contracts.index', compact('contracts'));
    }

    /**
     * Hiển thị form tạo hợp đồng
     */
    public function create(Request $request)
    {
        $booking = null;
        $room = null;
        $tenant = null;

        // Nếu có booking_id, lấy thông tin từ booking
        if ($request->has('booking') && $request->booking) {
            $booking = Booking::with(['room.building', 'user'])->findOrFail($request->booking);
            $room = $booking->room;
            $tenant = $booking->user;
        }

        // Nếu có room_id, lấy thông tin phòng
        if ($request->has('room') && $request->room) {
            $room = Room::with('building')->findOrFail($request->room);
        }

        // Lấy danh sách phòng trống (nếu không chọn phòng từ booking)
        $rooms = Room::where('status', 'available')->with('building')->get();

        // Lấy danh sách người thuê tiềm năng (nếu không chọn người thuê từ booking)
        $tenants = User::role('tenant')->get();

        // Lấy danh sách chủ trọ
        $landlords = User::role('admin')->get();

        return view('admin.contracts.create', compact('booking', 'room', 'tenant', 'rooms', 'tenants', 'landlords'));
    }

    /**
     * Lưu hợp đồng mới
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:users,id',
            'landlord_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'terms_and_conditions' => 'required|string',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // Kiểm tra xem phòng có trạng thái "available" không
        $room = Room::find($validated['room_id']);
        if ($room->status !== 'available') {
            return redirect()->back()->with('error', 'Phòng này đã có người thuê.');
        }

        // Tạo mã hợp đồng
        $contractNumber = 'HD' . date('Ymd') . '-' . Str::random(5);

        // Lưu file hợp đồng nếu có
        $filePath = null;
        if ($request->hasFile('contract_file')) {
            $file = $request->file('contract_file');
            $filePath = $file->storeAs('contracts', $contractNumber . '.' . $file->getClientOriginalExtension(), 'public');
        }

        // Tạo hợp đồng mới
        $contract = new Contract();
        $contract->contract_number = $contractNumber;
        $contract->booking_id = $validated['booking_id'] ?? null;
        $contract->room_id = $validated['room_id'];
        $contract->tenant_id = $validated['tenant_id'];
        $contract->landlord_id = $validated['landlord_id'];
        $contract->start_date = $validated['start_date'];
        $contract->end_date = $validated['end_date'];
        $contract->monthly_rent = $validated['monthly_rent'];
        $contract->deposit_amount = $validated['deposit_amount'];
        $contract->terms_and_conditions = $validated['terms_and_conditions'];
        $contract->status = 'pending';
        $contract->file_path = $filePath;
        $contract->save();

        // Cập nhật trạng thái phòng thành "occupied"
        $room = Room::find($validated['room_id']);
        $room->status = 'occupied';
        $room->save();

        // Cập nhật booking nếu có
        if ($validated['booking_id']) {
            $booking = Booking::find($validated['booking_id']);
            if ($booking && $booking->status === 'approved') {
                $booking->status = 'completed';
                $booking->save();
            }
        }

        return redirect()->route('admin.contracts.index')
            ->with('success', 'Đã tạo hợp đồng thành công.');
    }

    /**
     * Hiển thị chi tiết hợp đồng
     */
    public function show(Contract $contract)
    {
        $contract->load(['booking', 'room.building', 'tenant', 'landlord']);

        return view('admin.contracts.show', compact('contract'));
    }

    /**
     * Hiển thị form chỉnh sửa hợp đồng
     */
    public function edit(Contract $contract)
    {
        // Chỉ cho phép chỉnh sửa hợp đồng chưa ký
        if ($contract->isSigned()) {
            return redirect()->back()->with('error', 'Không thể chỉnh sửa hợp đồng đã được ký.');
        }

        $contract->load(['booking', 'room.building', 'tenant', 'landlord']);

        // Lấy danh sách phòng trống và phòng hiện tại
        $rooms = Room::where(function ($query) use ($contract) {
            $query->where('status', 'available') // Phòng trống
                ->orWhere('id', $contract->room_id); // Hoặc phòng hiện tại
        })->with('building')->get();

        // Lấy danh sách người thuê và chủ trọ
        $tenants = User::role('tenant')->get();
        $landlords = User::role('admin')->get();

        return view('admin.contracts.edit', compact('contract', 'rooms', 'tenants', 'landlords'));
    }

    /**
     * Cập nhật hợp đồng
     */
    public function update(Request $request, Contract $contract)
    {
        // Chỉ cho phép chỉnh sửa hợp đồng chưa ký
        if ($contract->isSigned()) {
            return redirect()->back()->with('error', 'Không thể chỉnh sửa hợp đồng đã được ký.');
        }

        // Validate dữ liệu
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:users,id',
            'landlord_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'terms_and_conditions' => 'required|string',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // Nếu thay đổi phòng, cần kiểm tra trạng thái phòng mới
        if ($validated['room_id'] != $contract->room_id) {
            $room = Room::find($validated['room_id']);
            if ($room->status !== 'available') {
                return redirect()->back()->with('error', 'Phòng này đã có người thuê.');
            }

            // Cập nhật trạng thái phòng cũ thành "available"
            $oldRoom = Room::find($contract->room_id);
            $oldRoom->status = 'available';
            $oldRoom->save();

            // Cập nhật trạng thái phòng mới thành "occupied"
            $room->status = 'occupied';
            $room->save();
        }

        // Lưu file hợp đồng mới nếu có
        if ($request->hasFile('contract_file')) {
            // Xóa file cũ nếu có
            if ($contract->file_path) {
                Storage::disk('public')->delete($contract->file_path);
            }

            $file = $request->file('contract_file');
            $filePath = $file->storeAs('contracts', $contract->contract_number . '.' . $file->getClientOriginalExtension(), 'public');
            $contract->file_path = $filePath;
        }

        // Cập nhật hợp đồng
        $contract->room_id = $validated['room_id'];
        $contract->tenant_id = $validated['tenant_id'];
        $contract->landlord_id = $validated['landlord_id'];
        $contract->start_date = $validated['start_date'];
        $contract->end_date = $validated['end_date'];
        $contract->monthly_rent = $validated['monthly_rent'];
        $contract->deposit_amount = $validated['deposit_amount'];
        $contract->terms_and_conditions = $validated['terms_and_conditions'];
        $contract->save();

        return redirect()->route('admin.contracts.show', $contract)
            ->with('success', 'Đã cập nhật hợp đồng thành công.');
    }

    /**
     * Xác nhận hợp đồng
     */
    public function sign(Request $request, Contract $contract)
    {
        // Chỉ cho phép xác nhận hợp đồng chưa ký
        if ($contract->isSigned()) {
            return redirect()->back()->with('error', 'Hợp đồng này đã được xác nhận.');
        }

        $contract->signed_at = now();
        $contract->status = 'active';
        $contract->save();

        return redirect()->route('admin.contracts.show', $contract)
            ->with('success', 'Đã xác nhận hợp đồng thành công.');
    }

    /**
     * Chấm dứt hợp đồng
     */
    public function terminate(Request $request, Contract $contract)
    {
        // Chỉ cho phép chấm dứt hợp đồng đã ký và đang hiệu lực
        if (!$contract->isSigned() || $contract->status !== 'active') {
            return redirect()->back()->with('error', 'Không thể chấm dứt hợp đồng này.');
        }

        $request->validate([
            'termination_reason' => 'required|string|max:500',
        ]);

        $contract->status = 'terminated';
        $contract->terms_and_conditions .= "\n\nLý do chấm dứt: " . $request->termination_reason;
        $contract->save();

        // Cập nhật trạng thái phòng thành "Còn trống"
        $room = Room::find($contract->room_id);
        $room->status = 0; // Còn trống
        $room->save();

        return redirect()->route('admin.contracts.index')
            ->with('success', 'Đã chấm dứt hợp đồng thành công.');
    }
}
