<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Booking;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    use AuthorizesRequests;
    /**
     * Hiển thị danh sách hợp đồng của người thuê
     */
    public function index()
    {
        $contracts = Auth::user()->contracts()->with(['room.building', 'landlord'])->latest()->paginate(10);

        return view('tenant.contracts.index', compact('contracts'));
    }

    /**
     * Hiển thị chi tiết hợp đồng của người thuê
     */
    public function show(Contract $contract)
    {
        $this->authorize('view', $contract);

        $contract->load(['booking', 'room.building', 'landlord']);

        return view('tenant.contracts.show', compact('contract'));
    }

    /**
     * Download file hợp đồng
     */
    public function download(Contract $contract)
    {
        $this->authorize('view', $contract);

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
    /**
     * Hiển thị danh sách hợp đồng (Admin & Landlord)
     */
    public function adminIndex()
    {
        $user = Auth::user();

        // Kiểm tra quyền truy cập
        if (!$user || !$user->hasAnyRole(['admin', 'landlord'])) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        if ($user->hasRole('admin')) {
            // Admin xem tất cả hợp đồng
            $contracts = Contract::with(['tenant', 'landlord', 'room.building'])->latest()->paginate(10);
        } elseif ($user->hasRole('landlord')) {
            // Landlord chỉ xem hợp đồng của các phòng thuộc sở hữu
            $contracts = Contract::with(['tenant', 'landlord', 'room.building'])
                ->whereHas('room.building', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest()
                ->paginate(10);
        }

        return view('admin.contracts.index', compact('contracts'));
    }

    /**
     * Hiển thị chi tiết hợp đồng (Admin & Landlord)
     */
    public function adminShow(Contract $contract)
    {
        $user = Auth::user();

        // Kiểm tra quyền truy cập
        if (!$user || !$user->hasAnyRole(['admin', 'landlord'])) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Kiểm tra quyền xem hợp đồng cụ thể
        if ($user->hasRole('landlord') && $contract->room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền xem hợp đồng này.');
        }

        $contract->load(['tenant', 'landlord', 'room.building.ward.district.province', 'booking']);

        return view('admin.contracts.show', compact('contract'));
    }

    /**
     * Hiển thị form tạo hợp đồng (Admin & Landlord)
     */
    public function create(Booking $booking)
    {
        $user = Auth::user();

        // Kiểm tra quyền truy cập
        if (!$user || !$user->hasAnyRole(['admin', 'landlord'])) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Kiểm tra quyền tạo hợp đồng cho booking này
        if ($user->hasRole('landlord') && $booking->room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền tạo hợp đồng cho đặt phòng này.');
        }

        $this->authorize('create', Contract::class);

        // Chỉ tạo hợp đồng cho các booking đã được duyệt
        if ($booking->status !== 'approved') {
            return redirect()->back()->with('error', 'Chỉ có thể tạo hợp đồng cho các đặt phòng đã được duyệt.');
        }

        // Kiểm tra xem đã có hợp đồng cho booking này chưa
        if ($booking->contract) {
            return redirect()->route('admin.contracts.edit', $booking->contract->id)
                ->with('info', 'Hợp đồng cho đặt phòng này đã tồn tại.');
        }

        $startDate = Carbon::parse($booking->desired_move_date);
        $endDate = $startDate->copy()->addMonths($booking->duration);

        return view('admin.contracts.create', [
            'booking' => $booking,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d')
        ]);
    }

    /**
     * Lưu hợp đồng mới (Admin & Landlord)
     */
    public function store(StoreContractRequest $request)
    {
        $user = Auth::user();

        // Kiểm tra quyền truy cập
        if (!$user || !$user->hasAnyRole(['admin', 'landlord'])) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $this->authorize('create', Contract::class);

        $validated = $request->validated();

        $booking = Booking::findOrFail($validated['booking_id']);

        // Kiểm tra quyền tạo hợp đồng cho booking này
        if ($user->hasRole('landlord') && $booking->room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền tạo hợp đồng cho đặt phòng này.');
        }

        // Tạo mã hợp đồng ngẫu nhiên
        $contractNumber = 'HD' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $contract = new Contract([
            'contract_number' => $contractNumber,
            'booking_id' => $booking->id,
            'room_id' => $booking->room_id,
            'tenant_id' => $booking->user_id,
            'landlord_id' => $user->id, // Người tạo hợp đồng (admin/landlord)
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'monthly_rent' => $validated['monthly_rent'],
            'deposit_amount' => $validated['deposit_amount'],
            'terms_and_conditions' => $validated['terms_and_conditions'],
            'status' => 'pending'
        ]);

        // Upload file hợp đồng nếu có
        if ($request->hasFile('contract_file')) {
            $path = $request->file('contract_file')->store('contracts', 'public');
            $contract->file_path = $path;
        }

        $contract->save();

        return redirect()->route('admin.contracts.index')
            ->with('success', 'Đã tạo hợp đồng thành công. Hợp đồng đang chờ người thuê xác nhận.');
    }

    /**
     * Hiển thị form chỉnh sửa hợp đồng (Admin & Landlord)
     */
    public function edit(Contract $contract)
    {
        $user = Auth::user();

        // Kiểm tra quyền truy cập
        if (!$user || !$user->hasAnyRole(['admin', 'landlord'])) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Kiểm tra quyền chỉnh sửa hợp đồng cụ thể
        if ($user->hasRole('landlord') && $contract->room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền chỉnh sửa hợp đồng này.');
        }

        $this->authorize('update', $contract);

        $contract->load(['booking', 'room.building', 'tenant', 'landlord']);

        return view('admin.contracts.edit', compact('contract'));
    }

    /**
     * Cập nhật hợp đồng (Admin & Landlord)
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $user = Auth::user();

        // Kiểm tra quyền truy cập
        if (!$user || !$user->hasAnyRole(['admin', 'landlord'])) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Kiểm tra quyền cập nhật hợp đồng cụ thể
        if ($user->hasRole('landlord') && $contract->room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền cập nhật hợp đồng này.');
        }

        $this->authorize('update', $contract);

        $validated = $request->validated();

        $contract->start_date = $validated['start_date'];
        $contract->end_date = $validated['end_date'];
        $contract->monthly_rent = $validated['monthly_rent'];
        $contract->deposit_amount = $validated['deposit_amount'];
        $contract->terms_and_conditions = $validated['terms_and_conditions'];

        // Upload file hợp đồng mới nếu có
        if ($request->hasFile('contract_file')) {
            // Xóa file cũ nếu có
            if ($contract->file_path) {
                Storage::disk('public')->delete($contract->file_path);
            }

            $path = $request->file('contract_file')->store('contracts', 'public');
            $contract->file_path = $path;
        }

        $contract->save();

        return redirect()->route('admin.contracts.index')
            ->with('success', 'Đã cập nhật hợp đồng thành công.');
    }
    /**
     * Ký hợp đồng (Chỉ dành cho Tenant)
     */
    public function sign(Request $request, Contract $contract)
    {
        $this->authorize('sign', $contract);

        // Kiểm tra xem user hiện tại có phải là tenant của hợp đồng này không
        if (auth()->id() !== $contract->tenant_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền xác nhận hợp đồng này.');
        }

        // Sử dụng method mới từ model
        if ($contract->confirmByTenant()) {
            return redirect()->route('tenant.contracts.show', $contract)
                ->with('success', 'Hợp đồng đã được xác nhận thành công. Hợp đồng bây giờ đã có hiệu lực.');
        }

        return redirect()->back()->with('error', 'Không thể xác nhận hợp đồng này.');
    }
    /**
     * Chấm dứt hợp đồng (Admin & Landlord)
     */
    public function terminate(Contract $contract)
    {
        $user = Auth::user();

        // Kiểm tra quyền truy cập
        if (!$user || !$user->hasAnyRole(['admin', 'landlord'])) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Kiểm tra quyền chấm dứt hợp đồng cụ thể
        if ($user->hasRole('landlord') && $contract->room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền chấm dứt hợp đồng này.');
        }

        $this->authorize('terminate', $contract);

        $contract->status = 'terminated';
        $contract->save();

        // Cập nhật trạng thái phòng thành trống
        $room = $contract->room;
        $room->status = 0; // 0 = Còn trống
        $room->save();

        return redirect()->route('admin.contracts.index')
            ->with('success', 'Đã chấm dứt hợp đồng thành công.');
    }

    /**
     * Download file hợp đồng (Admin & Landlord)
     */
    public function adminDownload(Contract $contract)
    {
        $user = Auth::user();

        // Kiểm tra quyền truy cập
        if (!$user || !$user->hasAnyRole(['admin', 'landlord'])) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Kiểm tra quyền download hợp đồng cụ thể
        if ($user->hasRole('landlord') && $contract->room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền tải xuống hợp đồng này.');
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
