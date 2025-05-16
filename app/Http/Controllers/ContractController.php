<?php

namespace App\Http\Controllers;

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
     * Hiển thị danh sách hợp đồng (Admin)
     */
    public function adminIndex()
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
        }

        $contracts = Contract::with(['tenant', 'landlord', 'room.building'])->latest()->paginate(10);

        return view('admin.contracts.index', compact('contracts'));
    }

    /**
     * Hiển thị chi tiết hợp đồng (Admin)
     */
    public function adminShow(Contract $contract)
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
        }

        $contract->load(['tenant', 'landlord', 'room.building.ward.district.province', 'booking']);

        return view('admin.contracts.show', compact('contract'));
    }

    /**
     * Hiển thị form tạo hợp đồng (Admin)
     */
    public function create(Booking $booking)
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
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
     * Lưu hợp đồng mới (Admin)
     */
    public function store(Request $request)
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
        }

        $this->authorize('create', Contract::class);

        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'terms_and_conditions' => 'required|string',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        // Tạo mã hợp đồng ngẫu nhiên
        $contractNumber = 'HD' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $contract = new Contract([
            'contract_number' => $contractNumber,
            'booking_id' => $booking->id,
            'room_id' => $booking->room_id,
            'tenant_id' => $booking->user_id,
            'landlord_id' => Auth::id(), // Hiện tại là admin/chủ trọ tạo hợp đồng
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
     * Hiển thị form chỉnh sửa hợp đồng (Admin)
     */
    public function edit(Contract $contract)
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
        }

        $this->authorize('update', $contract);

        $contract->load(['booking', 'room.building', 'tenant', 'landlord']);

        return view('admin.contracts.edit', compact('contract'));
    }

    /**
     * Cập nhật hợp đồng (Admin)
     */
    public function update(Request $request, Contract $contract)
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
        }

        $this->authorize('update', $contract);

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'terms_and_conditions' => 'required|string',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

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
     * Ký hợp đồng (Tenant & Admin)
     */
    public function sign(Request $request, Contract $contract)
    {
        $this->authorize('sign', $contract);

        // Log user and contract information for debugging
        \Log::info('Contract signing attempt', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->getRoleNames()->first() ?? 'no role',
            'contract_id' => $contract->id,
            'has_signature_data' => $request->has('signature_data'),
        ]);

        // Validate signature data if provided
        if ($request->has('signature_data')) {
            $request->validate([
                'signature_data' => 'required|string',
            ]);

            // Save signature as image
            if ($request->signature_data) {
                $signatureImage = $request->signature_data;
                $signatureImage = str_replace('data:image/png;base64,', '', $signatureImage);
                $signatureImage = str_replace(' ', '+', $signatureImage);

                // Create directory if it doesn't exist
                $dirPath = 'contracts/signatures';
                if (!Storage::disk('public')->exists($dirPath)) {
                    Storage::disk('public')->makeDirectory($dirPath);
                }

                $imageName = 'signature_' . $contract->id . '_' . time() . '.png';
                $path = $dirPath . '/' . $imageName;

                try {
                    $success = Storage::disk('public')->put($path, base64_decode($signatureImage));
                    \Log::info('Signature save result', ['success' => $success, 'path' => $path]);

                    if ($success) {
                        // Save signature file path to contract
                        $contract->signature_path = $path;
                    } else {
                        return redirect()->back()->with('error', 'Không thể lưu chữ ký, vui lòng thử lại.');
                    }
                } catch (\Exception $e) {
                    \Log::error('Error saving signature', ['error' => $e->getMessage()]);
                    return redirect()->back()->with('error', 'Lỗi khi lưu chữ ký: ' . $e->getMessage());
                }
            }
        }

        $contract->signed_at = now();
        $contract->status = 'active';
        $contract->save();

        // Log successful signing
        \Log::info('Contract signed successfully', [
            'user_id' => auth()->id(),
            'contract_id' => $contract->id,
        ]);

        // Update room status to rented if not already
        if ($contract->room && $contract->room->getRawOriginal('status') == 0) {
            $room = $contract->room;
            $room->status = 1; // 1 = Đã thuê
            $room->save();
        }

        // Determine the appropriate redirect route based on user role
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.contracts.show', $contract)
                ->with('success', 'Hợp đồng đã được ký thành công.');
        } else {
            return redirect()->route('tenant.contracts.show', $contract)
                ->with('success', 'Hợp đồng đã được ký thành công.');
        }

        $contract->signed_at = now();
        $contract->status = 'active';
        $contract->save();

        // Update room status to rented if not already
        if ($contract->room->getRawOriginal('status') == 0) {
            $room = $contract->room;
            $room->status = 1; // 1 = Đã thuê
            $room->save();
        }

        $redirectRoute = Auth::user()->hasRole('admin') ? 'admin.contracts.index' : 'tenant.contracts.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Đã ký hợp đồng thành công.');
    }
    /**
     * Chấm dứt hợp đồng (Admin)
     */
    public function terminate(Contract $contract)
    {
        // Direct admin role check
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action. Only administrators can access this page.');
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
}
