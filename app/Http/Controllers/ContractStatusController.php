<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContractStatusController extends Controller
{
    /**
     * Cập nhật trạng thái các hợp đồng đã hết hạn
     * Có thể được gọi thủ công hoặc từ cron job
     */
    public function updateExpiredContracts(Request $request)
    {
        // Chỉ cho phép admin truy cập trực tiếp endpoint này
        if (!$request->user() || !$request->user()->hasRole('admin')) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        $today = Carbon::today();

        // Tìm tất cả hợp đồng đang active nhưng đã hết hạn
        $expiredContracts = Contract::where('status', 'active')
            ->where('end_date', '<', $today)
            ->get();

        $count = 0;

        foreach ($expiredContracts as $contract) {
            $contract->status = 'expired';
            $contract->save();
            $count++;
        }

        return response()->json([
            'success' => true,
            'message' => "Đã cập nhật {$count} hợp đồng hết hạn."
        ]);
    }
}
