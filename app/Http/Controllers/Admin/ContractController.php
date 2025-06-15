<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminContractRequest;
use App\Http\Requests\TerminateContractRequest;
use App\Http\Requests\UpdateAdminContractRequest;
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
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Admin xem tất cả hợp đồng
            $contracts = Contract::with(['room.building', 'tenant', 'landlord'])
                ->latest()
                ->paginate(10);
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ xem hợp đồng của các phòng thuộc sở hữu
            $contracts = Contract::with(['room.building', 'tenant', 'landlord'])
                ->whereHas('room.building', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return view('admin.contracts.index', compact('contracts'));
    }

    /**
     * Hiển thị form tạo hợp đồng
     */
    public function create(Booking $booking)
    {
        $user = Auth::user();

        // Kiểm tra quyền tạo hợp đồng
        if ($user->hasRole('admin')) {
            // Admin có thể tạo tất cả
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ có thể tạo hợp đồng cho phòng thuộc sở hữu
            if ($booking->room->building->user_id !== $user->id) {
                abort(403, 'Bạn không có quyền tạo hợp đồng cho đặt phòng này.');
            }
        } else {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }

        // Load các mối quan hệ cần thiết
        $booking->load(['room.building.province', 'room.building.district', 'room.building.ward', 'user']);
        $room = $booking->room;
        $tenant = $booking->user;

        // Lấy danh sách phòng có chỗ trống dựa trên role
        if ($user->hasRole('admin')) {
            $rooms = Room::whereRaw("status = 'available' OR (status = 'occupied' AND max_person > (
                SELECT COUNT(*) FROM contracts
                WHERE contracts.room_id = rooms.id
                AND contracts.status IN ('active', 'approved')
            ))")->with('building')->get();
        } else {
            // Landlord chỉ xem phòng của mình
            $rooms = Room::whereHas('building', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->whereRaw("status = 'available' OR (status = 'occupied' AND max_person > (
                    SELECT COUNT(*) FROM contracts
                    WHERE contracts.room_id = rooms.id
                    AND contracts.status IN ('active', 'approved')
                ))")
                ->with('building')
                ->get();
        }

        // Lấy danh sách người thuê tiềm năng
        $tenants = User::role('tenant')->get();

        // Lấy danh sách chủ trọ dựa trên role
        if ($user->hasRole('admin')) {
            $landlords = User::role('admin')->get();
        } else {
            // Landlord chỉ có thể đặt mình làm chủ trọ
            $landlords = collect([$user]);
        }

        // Chuẩn bị giá trị mặc định cho ngày bắt đầu và kết thúc hợp đồng
        $startDate = $booking->desired_move_date ? $booking->desired_move_date->format('Y-m-d') : now()->format('Y-m-d');
        $endDate = $booking->duration ? now()->addMonths($booking->duration)->format('Y-m-d') : now()->addYear()->format('Y-m-d');

        return view('admin.contracts.create', compact('booking', 'room', 'tenant', 'rooms', 'tenants', 'landlords', 'startDate', 'endDate'));
    }

    /**
     * Lưu hợp đồng mới
     */
    public function store(StoreAdminContractRequest $request)
    {
        $user = Auth::user();

        // Lấy dữ liệu đã validate
        $validated = $request->validated();

        // Kiểm tra quyền tạo hợp đồng cho phòng này
        $room = Room::find($validated['room_id']);
        if ($user->hasRole('landlord') && $room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền tạo hợp đồng cho phòng này.');
        }

        // Kiểm tra xem phòng có còn chỗ trống không
        if (!$room->has_available_space) {
            return redirect()->back()->with('error', 'Phòng này đã đầy, không thể tạo thêm hợp đồng.');
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

        // Cập nhật trạng thái phòng thành "occupied" nếu có người thuê
        $room = Room::find($validated['room_id']);
        if ($room->status === 'available') {
            $room->status = 'occupied';
            $room->save();
        }

        // Cập nhật booking nếu có
        if ($validated['booking_id']) {
            $booking = Booking::find($validated['booking_id']);
            if ($booking && $booking->status === 'approved') {
                // Đổi status sang 'completed' - giờ đã hợp lệ sau khi chạy migration
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

        // Lấy danh sách phòng có chỗ trống và phòng hiện tại
        $rooms = Room::where(function ($query) use ($contract) {
            // Phòng có chỗ trống
            $query->whereRaw("status = 'available' OR (status = 'occupied' AND max_person > (
                SELECT COUNT(*) FROM contracts
                WHERE contracts.room_id = rooms.id
                AND contracts.status IN ('active', 'approved')
            ))")
            // Hoặc phòng hiện tại (luôn cho phép)
            ->orWhere('id', $contract->room_id);
        })->with('building')->get();

        // Lấy danh sách người thuê và chủ trọ
        $tenants = User::role('tenant')->get();
        $landlords = User::role('admin')->get();

        return view('admin.contracts.edit', compact('contract', 'rooms', 'tenants', 'landlords'));
    }

    /**
     * Cập nhật hợp đồng
     */
    public function update(UpdateAdminContractRequest $request, Contract $contract)
    {
        $user = Auth::user();

        // Kiểm tra quyền chỉnh sửa hợp đồng
        if ($user->hasRole('admin')) {
            // Admin có thể chỉnh sửa tất cả
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ có thể chỉnh sửa hợp đồng của phòng thuộc sở hữu
            if ($contract->room->building->user_id !== $user->id) {
                abort(403, 'Bạn không có quyền chỉnh sửa hợp đồng này.');
            }
        } else {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }

        // Chỉ cho phép chỉnh sửa hợp đồng chưa ký
        if ($contract->isSigned()) {
            return redirect()->back()->with('error', 'Không thể chỉnh sửa hợp đồng đã được ký.');
        }

        // Lấy dữ liệu đã validate
        $validated = $request->validated();

        // Nếu thay đổi phòng, cần kiểm tra phòng mới có còn chỗ trống không
        if ($validated['room_id'] != $contract->room_id) {
            $room = Room::find($validated['room_id']);
            if (!$room->has_available_space) {
                return redirect()->back()->with('error', 'Phòng này đã đầy, không thể chuyển vào.');
            }

            // Cập nhật trạng thái phòng cũ nếu không còn ai thuê
            $oldRoom = Room::find($contract->room_id);
            if ($oldRoom->current_tenant_count <= 1) {
                $oldRoom->status = 'available';
                $oldRoom->save();
            }

            // Cập nhật trạng thái phòng mới thành "occupied" nếu chưa phải
            if ($room->status === 'available') {
                $room->status = 'occupied';
                $room->save();
            }
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
    /**
     * Chấm dứt hợp đồng
     */
    public function terminate(TerminateContractRequest $request, Contract $contract)
    {
        $user = Auth::user();

        // Kiểm tra quyền chấm dứt hợp đồng
        if ($user->hasRole('admin')) {
            // Admin có thể chấm dứt tất cả
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ có thể chấm dứt hợp đồng của phòng thuộc sở hữu
            if ($contract->room->building->user_id !== $user->id) {
                abort(403, 'Bạn không có quyền chấm dứt hợp đồng này.');
            }
        } else {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }

        // Kiểm tra xem hợp đồng có thể được chấm dứt không
        if (!$contract->canBeTerminated()) {
            return redirect()->back()->with('error', 'Không thể chấm dứt hợp đồng này.');
        }

        // Lấy dữ liệu đã validate
        $validated = $request->validated();

        // Sử dụng method mới từ model
        if ($contract->terminate($validated['termination_reason'])) {
            return redirect()->route('admin.contracts.index')
                ->with('success', 'Đã chấm dứt hợp đồng thành công.');
        }

        return redirect()->back()->with('error', 'Không thể chấm dứt hợp đồng này.');
    }

    /**
     * Download file hợp đồng
     */
    public function download(Contract $contract)
    {
        $user = Auth::user();

        // Kiểm tra quyền download hợp đồng
        if ($user->hasRole('admin')) {
            // Admin có thể download tất cả
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ có thể download hợp đồng của phòng thuộc sở hữu
            if ($contract->room->building->user_id !== $user->id) {
                abort(403, 'Bạn không có quyền tải xuống hợp đồng này.');
            }
        } else {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }

        if (!$contract->file_path) {
            return redirect()->back()->with('error', 'Không tìm thấy file hợp đồng.');
        }

        $path = Storage::disk('public')->path($contract->file_path);
        $originalName = pathinfo($contract->file_path, PATHINFO_BASENAME);
        $extension = pathinfo($contract->file_path, PATHINFO_EXTENSION);

        // Use the original file extension rather than forcing PDF extension
        $downloadName = $contract->contract_number . '.' . $extension;

        // Add explicit mime type based on extension
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        $mimeType = $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';

        // Check if file exists and is readable
        if (!file_exists($path) || !is_readable($path)) {
            return redirect()->back()->with('error', 'Không thể đọc file hợp đồng.');
        }

        // Use inline disposition for PDF files to view in browser
        if (strtolower($extension) === 'pdf') {
            return response()->file($path, ['Content-Type' => $mimeType]);
        }

        return response()->download($path, $downloadName, ['Content-Type' => $mimeType]);
    }
}
