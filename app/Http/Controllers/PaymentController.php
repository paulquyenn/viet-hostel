<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Payment;
use App\Notifications\PaymentNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Bắt đầu query dựa trên vai trò người dùng
        if ($user->role == 'admin') {
            // Admin xem tất cả các khoản thanh toán
            $query = Payment::with(['contract', 'contract.room', 'contract.tenant', 'contract.landlord']);
        } elseif ($user->role == 'landlord') {
            // Chủ trọ xem các khoản thanh toán của hợp đồng họ quản lý
            $query = Payment::whereHas('contract', function ($q) use ($user) {
                $q->where('landlord_id', $user->id);
            })->with(['contract', 'contract.room', 'contract.tenant']);
        } else {
            // Người thuê xem các khoản thanh toán của hợp đồng của họ
            $query = Payment::whereHas('contract', function ($q) use ($user) {
                $q->where('tenant_id', $user->id);
            })->with(['contract', 'contract.room', 'contract.landlord']);
        }

        // Lọc theo trạng thái thanh toán
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Lọc theo thời gian
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'current_month':
                    $query->whereMonth('payment_period_start', now()->month)
                        ->whereYear('payment_period_start', now()->year);
                    break;

                case 'overdue':
                    $query->where('payment_status', 'pending')
                        ->where('payment_date', '<', now());
                    break;

                case 'upcoming':
                    $query->where('payment_status', 'pending')
                        ->where('payment_date', '>=', now())
                        ->where('payment_date', '<=', now()->addDays(30));
                    break;
            }
        }

        // Lọc theo hợp đồng cụ thể nếu có
        if ($request->filled('contract_id')) {
            $query->where('contract_id', $request->contract_id);
        }

        $payments = $query->latest()->paginate(10)->withQueryString();

        // Thống kê tổng quan
        $stats = [
            'total' => $query->sum('amount'),
            'paid' => $query->clone()->where('payment_status', 'paid')->sum('amount'),
            'pending' => $query->clone()->where('payment_status', 'pending')->sum('amount'),
            'overdue' => $query->clone()->where('payment_status', 'pending')
                ->where('payment_date', '<', now())
                ->sum('amount'),
        ];

        return view('payments.index', compact('payments', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Chỉ cho phép chủ trọ hoặc admin tạo khoản thanh toán
        if (!Auth::user()->role == 'landlord' && !Auth::user()->role == 'admin') {
            abort(403, 'Bạn không có quyền tạo khoản thanh toán.');
        }

        // Kiểm tra xem đã cung cấp contract_id chưa
        if (!$request->filled('contract_id')) {
            return redirect()->route('contracts.index')
                ->with('error', 'Bạn cần chọn một hợp đồng để tạo khoản thanh toán.');
        }

        // Lấy thông tin hợp đồng
        $contract = Contract::with(['room', 'tenant', 'landlord'])->findOrFail($request->contract_id);

        // Kiểm tra quyền truy cập
        if (!Auth::user()->role == 'admin' && $contract->landlord_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền tạo khoản thanh toán cho hợp đồng này.');
        }

        // Tính toán đề xuất cho khoản thanh toán mới
        $latestPayment = $contract->payments()->latest('payment_period_end')->first();
        $periodStart = $latestPayment ? $latestPayment->payment_period_end->addDay() : $contract->start_date;
        $periodEnd = $periodStart->copy()->addMonth()->subDay();

        $paymentDate = Carbon::now();
        $amount = $contract->monthly_rent;
        $paymentDay = $contract->payment_day;

        return view('payments.create', compact('contract', 'periodStart', 'periodEnd', 'paymentDate', 'amount', 'paymentDay'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Chỉ cho phép chủ trọ hoặc admin tạo khoản thanh toán
        if (!Auth::user()->role == 'landlord' && !Auth::user()->role == 'admin') {
            abort(403, 'Bạn không có quyền tạo khoản thanh toán.');
        }

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_period_start' => 'required|date',
            'payment_period_end' => 'required|date|after:payment_period_start',
            'payment_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Kiểm tra hợp đồng và quyền truy cập
        $contract = Contract::findOrFail($request->contract_id);
        if (!Auth::user()->role == 'admin' && $contract->landlord_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền tạo khoản thanh toán cho hợp đồng này.');
        }

        // Tạo mã thanh toán
        $paymentNumber = 'PAY-' . Str::upper(Str::random(8));

        // Tạo khoản thanh toán mới
        $payment = Payment::create([
            'contract_id' => $request->contract_id,
            'payment_number' => $paymentNumber,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_period_start' => $request->payment_period_start,
            'payment_period_end' => $request->payment_period_end,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'notes' => $request->notes,
            'created_by' => Auth::id(),
        ]);

        // Gửi thông báo cho người thuê
        $contract = Contract::findOrFail($request->contract_id);
        $tenant = $contract->tenant;
        $tenant->notify(new \App\Notifications\PaymentNotification($payment, 'created'));

        // Redirect với thông báo thành công
        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Khoản thanh toán đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with(['contract', 'contract.room', 'contract.tenant', 'contract.landlord', 'creator', 'payer'])
            ->findOrFail($id);

        // Kiểm tra quyền truy cập
        $user = Auth::user();
        if (
            !$user->role == 'admin' &&
            $payment->contract->landlord_id !== $user->id &&
            $payment->contract->tenant_id !== $user->id
        ) {
            abort(403, 'Bạn không có quyền xem khoản thanh toán này.');
        }

        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::with(['contract', 'contract.room', 'contract.tenant', 'contract.landlord'])
            ->findOrFail($id);

        // Chỉ cho phép chủ trọ hoặc admin chỉnh sửa khoản thanh toán chưa được thanh toán
        if (
            !Auth::user()->role == 'admin' &&
            ($payment->contract->landlord_id !== Auth::id() || $payment->payment_status === 'paid')
        ) {
            abort(403, 'Bạn không có quyền chỉnh sửa khoản thanh toán này.');
        }

        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);

        // Chỉ cho phép chủ trọ hoặc admin chỉnh sửa khoản thanh toán chưa được thanh toán
        if (
            !Auth::user()->role == 'admin' &&
            ($payment->contract->landlord_id !== Auth::id() || $payment->payment_status === 'paid')
        ) {
            abort(403, 'Bạn không có quyền chỉnh sửa khoản thanh toán này.');
        }

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_period_start' => 'required|date',
            'payment_period_end' => 'required|date|after:payment_period_start',
            'payment_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cập nhật thông tin khoản thanh toán
        $payment->update([
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_period_start' => $request->payment_period_start,
            'payment_period_end' => $request->payment_period_end,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        // Redirect với thông báo thành công
        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Khoản thanh toán đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);

        // Chỉ cho phép chủ trọ hoặc admin xóa khoản thanh toán chưa được thanh toán
        if (
            !Auth::user()->role == 'admin' &&
            ($payment->contract->landlord_id !== Auth::id() || $payment->payment_status === 'paid')
        ) {
            abort(403, 'Bạn không có quyền xóa khoản thanh toán này.');
        }

        $payment->delete();

        // Redirect với thông báo thành công
        return redirect()->route('payments.index')
            ->with('success', 'Khoản thanh toán đã được xóa thành công.');
    }

    /**
     * Đánh dấu khoản thanh toán là đã thanh toán
     */
    public function markAsPaid(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);

        // Kiểm tra quyền truy cập
        $user = Auth::user();
        if (
            !$user->role == 'admin' &&
            $payment->contract->landlord_id !== $user->id &&
            $payment->contract->tenant_id !== $user->id
        ) {
            abort(403, 'Bạn không có quyền cập nhật khoản thanh toán này.');
        }

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cập nhật trạng thái khoản thanh toán
        $payment->update([
            'payment_status' => 'paid',
            'payment_method' => $request->payment_method,
            'notes' => $request->filled('notes') ? $payment->notes . "\n" . $request->notes : $payment->notes,
            'paid_at' => now(),
            'paid_by' => $user->id,
        ]);

        // Gửi thông báo cho cả chủ trọ và người thuê
        $landlord = $payment->contract->landlord;
        $tenant = $payment->contract->tenant;

        // Thông báo cho chủ trọ nếu người thanh toán là người thuê
        if ($user->id === $tenant->id) {
            $landlord->notify(new \App\Notifications\PaymentNotification($payment, 'paid'));
        }

        // Thông báo xác nhận cho người thuê nếu người đánh dấu thanh toán là chủ trọ
        if ($user->id === $landlord->id) {
            $tenant->notify(new \App\Notifications\PaymentNotification($payment, 'paid'));
        }

        // Redirect với thông báo thành công
        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Khoản thanh toán đã được đánh dấu là đã thanh toán.');
    }

    /**
     * Tạo hóa đơn hàng tháng tự động cho một hợp đồng
     */
    public function generateMonthlyPayment(Contract $contract)
    {
        // Chỉ cho phép chủ trọ hoặc admin tạo khoản thanh toán
        if (!Auth::user()->role == 'landlord' && !Auth::user()->role == 'admin') {
            abort(403, 'Bạn không có quyền tạo khoản thanh toán.');
        }

        // Kiểm tra quyền truy cập
        if (!Auth::user()->role == 'admin' && $contract->landlord_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền tạo khoản thanh toán cho hợp đồng này.');
        }

        // Kiểm tra xem hợp đồng có đang hoạt động không
        if (!$contract->isActive()) {
            return back()->with('error', 'Chỉ có thể tạo khoản thanh toán cho các hợp đồng đang hoạt động.');
        }

        // Tính toán kỳ thanh toán mới
        $latestPayment = $contract->payments()->latest('payment_period_end')->first();
        $periodStart = $latestPayment ? $latestPayment->payment_period_end->addDay() : $contract->start_date;
        $periodEnd = $periodStart->copy()->addMonth()->subDay();

        // Tính ngày thanh toán dựa trên ngày thanh toán trong hợp đồng
        $paymentDay = $contract->payment_day ?: Carbon::now()->day;
        $paymentMonth = $periodStart->month;
        $paymentYear = $periodStart->year;

        // Nếu ngày thanh toán đã qua trong tháng, chuyển sang tháng sau
        if ($periodStart->day > $paymentDay) {
            if ($paymentMonth == 12) {
                $paymentMonth = 1;
                $paymentYear++;
            } else {
                $paymentMonth++;
            }
        }

        $paymentDate = Carbon::createFromDate($paymentYear, $paymentMonth, $paymentDay);

        // Tạo mã thanh toán
        $paymentNumber = 'PAY-' . Str::upper(Str::random(8));

        // Tạo khoản thanh toán mới
        $payment = Payment::create([
            'contract_id' => $contract->id,
            'payment_number' => $paymentNumber,
            'amount' => $contract->monthly_rent,
            'payment_date' => $paymentDate,
            'payment_period_start' => $periodStart,
            'payment_period_end' => $periodEnd,
            'payment_status' => 'pending',
            'notes' => 'Tiền thuê nhà tháng ' . $periodStart->format('m/Y'),
            'created_by' => Auth::id(),
        ]);

        // Gửi thông báo cho người thuê
        $tenant = $contract->tenant;
        $tenant->notify(new \App\Notifications\PaymentNotification($payment, 'created'));

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Khoản thanh toán tháng đã được tạo thành công.');
    }
}
