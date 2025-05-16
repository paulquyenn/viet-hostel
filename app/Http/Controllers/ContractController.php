<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Contract;
use App\Models\RentalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Bắt đầu query dựa trên vai trò người dùng
        if ($user->role == 'admin') {
            // Admin xem tất cả các hợp đồng
            $query = Contract::with(['room', 'tenant', 'landlord']);
        } elseif ($user->role == 'landlord') {
            // Chủ trọ xem các hợp đồng của họ
            $query = $user->landlordContracts()->with(['room', 'tenant']);
        } else {
            // Người thuê xem các hợp đồng của họ
            $query = $user->tenantContracts()->with(['room', 'landlord']);
        }

        // Áp dụng các bộ lọc
        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo khoảng thời gian
        if ($request->filled('date_range')) {
            $today = now();

            switch ($request->date_range) {
                case 'active':
                    $query->where('start_date', '<=', $today)
                        ->where('end_date', '>=', $today);
                    break;

                case 'expired':
                    $query->where('end_date', '<', $today);
                    break;

                case 'expiring_soon':
                    $query->where('end_date', '>=', $today)
                        ->where('end_date', '<=', $today->copy()->addDays(30));
                    break;

                case 'created_this_month':
                    $query->whereMonth('created_at', $today->month)
                        ->whereYear('created_at', $today->year);
                    break;
            }
        }

        // Lọc theo người thuê (chỉ cho admin và chủ trọ)
        if (($user->role == 'admin' || $user->role == 'landlord') && $request->filled('tenant')) {
            $query->whereHas('tenant', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->tenant}%");
            });
        }

        // Lọc theo chủ trọ (chỉ cho admin)
        if ($user->role == 'admin' && $request->filled('landlord')) {
            $query->whereHas('landlord', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->landlord}%");
            });
        }

        // Lấy kết quả và phân trang
        $contracts = $query->latest()->paginate(10)->withQueryString();

        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Chỉ cho phép chủ trọ hoặc admin tạo hợp đồng
        if (!Auth::user()->role == 'landlord' && !Auth::user()->role == 'admin') {
            abort(403, 'Bạn không có quyền tạo hợp đồng.');
        }

        $rentalRequestId = request('rental_request_id');

        if ($rentalRequestId) {
            $rentalRequest = RentalRequest::with(['user', 'room'])->findOrFail($rentalRequestId);

            // Kiểm tra xem người dùng có quyền tạo hợp đồng cho phòng này không
            if (!Auth::user()->role == 'admin' && $rentalRequest->room->building->user_id !== Auth::id()) {
                abort(403, 'Bạn không có quyền tạo hợp đồng cho phòng này.');
            }

            // Kiểm tra trạng thái yêu cầu
            if ($rentalRequest->status !== 'approved') {
                return redirect()->back()
                    ->with('error', 'Chỉ có thể tạo hợp đồng cho yêu cầu thuê đã được chấp nhận.');
            }

            // Kiểm tra xem phòng đã được thuê chưa
            if ($rentalRequest->room->isRented()) {
                return redirect()->back()
                    ->with('error', 'Không thể tạo hợp đồng vì phòng này đã được thuê.');
            }

            $room = $rentalRequest->room;
            $tenant = $rentalRequest->user;
            $landlord = $room->building->user;

            return view('contracts.create', compact('rentalRequest', 'room', 'tenant', 'landlord'));
        } else {
            // Tạo hợp đồng trực tiếp không qua yêu cầu thuê
            $user = Auth::user();

            if ($user->role == 'admin') {
                $rooms = Room::where('status', 0)->get(); // Lấy các phòng còn trống
                $tenants = User::role('tenant')->get();
                $landlords = User::role('landlord')->get();
            } else {
                // Chủ trọ chỉ có thể tạo hợp đồng cho phòng của họ
                $buildings = $user->buildings()->pluck('id');
                $rooms = Room::whereIn('building_id', $buildings)
                    ->where('status', 0)
                    ->get();
                $tenants = User::role('tenant')->get();
                $landlords = User::where('id', $user->id)->get();
            }

            return view('contracts.create_direct', compact('rooms', 'tenants', 'landlords'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Chỉ cho phép chủ trọ hoặc admin tạo hợp đồng
        if (!Auth::user()->role == 'landlord' && !Auth::user()->role == 'admin') {
            abort(403, 'Bạn không có quyền tạo hợp đồng.');
        }

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:users,id',
            'landlord_id' => 'required|exists:users,id',
            'rental_request_id' => 'nullable|exists:rental_requests,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'payment_day' => 'required|integer|min:1|max:31',
            'terms_and_conditions' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $room = Room::findOrFail($request->room_id);

        // Kiểm tra quyền tạo hợp đồng cho phòng này
        $user = Auth::user();
        if (!$user->role == 'admin' && $room->building->user_id !== $user->id) {
            return redirect()->back()
                ->with('error', 'Bạn không có quyền tạo hợp đồng cho phòng này.');
        }

        // Kiểm tra xem phòng đã được thuê chưa
        if ($room->isRented()) {
            return redirect()->back()
                ->with('error', 'Không thể tạo hợp đồng vì phòng này đã được thuê.');
        }

        // Tạo số hợp đồng
        $contractNumber = 'HD' . date('Ymd') . '-' . Str::upper(Str::random(6));

        // Upload tài liệu hợp đồng nếu có
        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('contracts', 'public');
        }

        // Tạo hợp đồng mới
        $contract = new Contract();
        $contract->contract_number = $contractNumber;
        $contract->room_id = $request->room_id;
        $contract->tenant_id = $request->tenant_id;
        $contract->landlord_id = $request->landlord_id;
        $contract->rental_request_id = $request->rental_request_id;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
        $contract->monthly_rent = $request->monthly_rent;
        $contract->deposit = $request->deposit;
        $contract->payment_day = $request->payment_day;
        $contract->terms_and_conditions = $request->terms_and_conditions;
        $contract->status = 'pending';
        $contract->document_path = $documentPath;

        // Chủ trọ tạo hợp đồng đã ký sẵn
        $contract->landlord_signed = true;
        $contract->landlord_signed_at = now();

        $contract->save();

        // Cập nhật trạng thái phòng
        $room->status = 1; // Đã thuê
        $room->save();

        return redirect()->route('contracts.show', $contract->id)
            ->with('success', 'Hợp đồng đã được tạo thành công. Vui lòng thông báo cho người thuê ký hợp đồng.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contract = Contract::with(['room', 'room.building', 'tenant', 'landlord', 'rentalRequest'])->findOrFail($id);

        // Kiểm tra quyền xem hợp đồng
        $user = Auth::user();
        $canView = false;

        if ($user->role == 'admin') {
            $canView = true;
        } elseif ($user->id === $contract->landlord_id) {
            // Chủ trọ có thể xem hợp đồng của mình
            $canView = true;
        } elseif ($user->id === $contract->tenant_id) {
            // Người thuê có thể xem hợp đồng của mình
            $canView = true;
        }

        if (!$canView) {
            abort(403, 'Bạn không có quyền xem hợp đồng này.');
        }

        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contract = Contract::findOrFail($id);

        // Chỉ cho phép chỉnh sửa hợp đồng nếu hợp đồng chưa được ký bởi cả hai bên
        if ($contract->isFullySigned()) {
            return redirect()->back()
                ->with('error', 'Không thể chỉnh sửa hợp đồng đã được ký bởi cả hai bên.');
        }

        // Kiểm tra quyền chỉnh sửa hợp đồng
        $user = Auth::user();
        $canEdit = false;

        if ($user->role == 'admin') {
            $canEdit = true;
        } elseif ($user->id === $contract->landlord_id) {
            // Chủ trọ có thể chỉnh sửa hợp đồng của mình nếu người thuê chưa ký
            $canEdit = !$contract->tenant_signed;
        }

        if (!$canEdit) {
            abort(403, 'Bạn không có quyền chỉnh sửa hợp đồng này.');
        }

        return view('contracts.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contract = Contract::findOrFail($id);

        // Xác định loại cập nhật (chỉnh sửa chi tiết hoặc ký hợp đồng)
        $action = $request->input('action', 'edit');

        if ($action === 'sign') {
            // Ký hợp đồng
            $user = Auth::user();

            if ($user->id === $contract->tenant_id && !$contract->tenant_signed) {
                // Người thuê ký hợp đồng
                $contract->tenant_signed = true;
                $contract->tenant_signed_at = now();

                // Nếu cả hai bên đã ký, cập nhật trạng thái
                if ($contract->landlord_signed) {
                    $contract->status = 'active';

                    // Cập nhật trạng thái phòng thành "Đã thuê"
                    $room = $contract->room;
                    $room->status = 1; // Đã thuê
                    $room->save();
                }

                $contract->save();

                return redirect()->route('contracts.show', $contract->id)
                    ->with('success', 'Bạn đã ký hợp đồng thành công.');
            } elseif ($user->id === $contract->landlord_id && !$contract->landlord_signed) {
                // Chủ trọ ký hợp đồng
                $contract->landlord_signed = true;
                $contract->landlord_signed_at = now();

                // Nếu cả hai bên đã ký, cập nhật trạng thái
                if ($contract->tenant_signed) {
                    $contract->status = 'active';

                    // Cập nhật trạng thái phòng thành "Đã thuê"
                    $room = $contract->room;
                    $room->status = 1; // Đã thuê
                    $room->save();
                }

                $contract->save();

                return redirect()->route('contracts.show', $contract->id)
                    ->with('success', 'Bạn đã ký hợp đồng thành công.');
            } else {
                return redirect()->back()
                    ->with('error', 'Bạn không thể ký hợp đồng này hoặc đã ký trước đó.');
            }
        } else {
            // Chỉnh sửa chi tiết hợp đồng

            // Chỉ cho phép chỉnh sửa hợp đồng nếu hợp đồng chưa được ký bởi cả hai bên
            if ($contract->isFullySigned()) {
                return redirect()->back()
                    ->with('error', 'Không thể chỉnh sửa hợp đồng đã được ký bởi cả hai bên.');
            }

            // Kiểm tra quyền chỉnh sửa hợp đồng
            $user = Auth::user();
            $canEdit = false;

            if ($user->role == 'admin') {
                $canEdit = true;
            } elseif ($user->id === $contract->landlord_id) {
                // Chủ trọ có thể chỉnh sửa hợp đồng của mình nếu người thuê chưa ký
                $canEdit = !$contract->tenant_signed;
            }

            if (!$canEdit) {
                return redirect()->back()
                    ->with('error', 'Bạn không có quyền chỉnh sửa hợp đồng này.');
            }

            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'monthly_rent' => 'required|numeric|min:0',
                'deposit' => 'required|numeric|min:0',
                'payment_day' => 'required|integer|min:1|max:31',
                'terms_and_conditions' => 'nullable|string',
                'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);

            // Upload tài liệu hợp đồng mới nếu có
            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('contracts', 'public');
                $contract->document_path = $documentPath;
            }

            // Cập nhật thông tin hợp đồng
            $contract->start_date = $request->start_date;
            $contract->end_date = $request->end_date;
            $contract->monthly_rent = $request->monthly_rent;
            $contract->deposit = $request->deposit;
            $contract->payment_day = $request->payment_day;
            $contract->terms_and_conditions = $request->terms_and_conditions;

            // Nếu chủ trọ chỉnh sửa, cũng cập nhật trạng thái chữ ký
            if ($user->id === $contract->landlord_id) {
                $contract->landlord_signed = true;
                $contract->landlord_signed_at = now();
            }

            $contract->save();

            return redirect()->route('contracts.show', $contract->id)
                ->with('success', 'Hợp đồng đã được cập nhật thành công.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contract = Contract::findOrFail($id);

        // Chỉ cho phép xóa hợp đồng nếu hợp đồng chưa được ký bởi cả hai bên
        if ($contract->isFullySigned()) {
            return redirect()->back()
                ->with('error', 'Không thể xóa hợp đồng đã được ký bởi cả hai bên.');
        }

        // Kiểm tra quyền xóa hợp đồng
        $user = Auth::user();
        $canDelete = false;

        if ($user->role == 'admin') {
            $canDelete = true;
        } elseif ($user->id === $contract->landlord_id) {
            // Chủ trọ có thể xóa hợp đồng của mình nếu người thuê chưa ký
            $canDelete = !$contract->tenant_signed;
        }

        if (!$canDelete) {
            return redirect()->back()
                ->with('error', 'Bạn không có quyền xóa hợp đồng này.');
        }

        // Cập nhật trạng thái phòng
        $room = $contract->room;
        $room->status = 0; // Còn trống
        $room->save();

        // Xóa hợp đồng
        $contract->delete();

        return redirect()->route('contracts.index')
            ->with('success', 'Hợp đồng đã được xóa thành công.');
    }

    /**
     * Chấm dứt hợp đồng
     */
    public function terminate(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        // Chỉ cho phép chấm dứt hợp đồng nếu hợp đồng đang hoạt động
        if (!$contract->isActive()) {
            return redirect()->back()
                ->with('error', 'Chỉ có thể chấm dứt hợp đồng đang hoạt động.');
        }

        // Kiểm tra quyền chấm dứt hợp đồng
        $user = Auth::user();
        $canTerminate = false;

        if ($user->role == 'admin') {
            $canTerminate = true;
        } elseif ($user->id === $contract->landlord_id || $user->id === $contract->tenant_id) {
            // Cả chủ trọ và người thuê đều có thể chấm dứt hợp đồng
            $canTerminate = true;
        }

        if (!$canTerminate) {
            return redirect()->back()
                ->with('error', 'Bạn không có quyền chấm dứt hợp đồng này.');
        }

        $request->validate([
            'termination_reason' => 'required|string|max:500',
        ]);

        // Cập nhật trạng thái hợp đồng
        $contract->status = 'terminated';
        $contract->termination_reason = $request->termination_reason;
        $contract->save();

        // Cập nhật trạng thái phòng
        $room = $contract->room;
        $room->status = 0; // Còn trống
        $room->save();

        return redirect()->route('contracts.show', $contract->id)
            ->with('success', 'Hợp đồng đã được chấm dứt thành công.');
    }
}
