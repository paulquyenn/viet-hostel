<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function contractManagement()
    {
        // Đảm bảo chỉ admin mới có quyền truy cập
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Đếm số lượng hợp đồng theo từng trạng thái
        $activeContractsCount = Contract::where('status', 'active')->count();
        $expiredContractsCount = Contract::where('status', 'expired')->count();
        $terminatedContractsCount = Contract::where('status', 'terminated')->count();

        return view('admin.contract-management', compact(
            'activeContractsCount',
            'expiredContractsCount',
            'terminatedContractsCount'
        ));
    }
}
