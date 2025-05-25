<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    /**
     * Hiển thị danh sách người thuê trọ của chủ trọ
     */
    public function index(Request $request)
    {
        // Kiểm tra quyền admin/chủ trọ
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        // Lấy danh sách người thuê từ các hợp đồng hiện tại của chủ trọ
        $query = User::role('tenant')
            ->whereHas('contracts', function ($q) {
                $q->where('landlord_id', auth()->id())
                  ->where('status', 'active'); // Chỉ lấy hợp đồng đang hiệu lực
            })
            ->with(['contracts' => function ($q) {
                $q->where('landlord_id', auth()->id())
                  ->where('status', 'active')
                  ->with(['room.building']);
            }])
            ->orderBy('name');

        // Tìm kiếm theo tên hoặc email
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhere('phone', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter theo tòa nhà
        if ($request->has('building_filter') && !empty($request->building_filter)) {
            $query->whereHas('contracts.room.building', function ($q) use ($request) {
                $q->where('id', $request->building_filter);
            });
        }

        $tenants = $query->paginate(15);

        // Lấy danh sách tòa nhà của chủ trọ để filter
        $buildings = \App\Models\Building::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('admin.tenants.index', compact('tenants', 'buildings'));
    }

    /**
     * Hiển thị chi tiết người thuê
     */
    public function show(User $tenant)
    {
        // Kiểm tra quyền admin/chủ trọ
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        // Kiểm tra xem tenant này có thuê phòng của chủ trọ không
        $hasActiveContract = $tenant->contracts()
            ->where('landlord_id', auth()->id())
            ->where('status', 'active')
            ->exists();

        if (!$hasActiveContract) {
            abort(404, 'Không tìm thấy thông tin người thuê này.');
        }

        // Lấy thông tin tenant với các hợp đồng liên quan
        $tenant->load([
            'contracts' => function ($q) {
                $q->where('landlord_id', auth()->id())
                  ->with(['room.building'])
                  ->orderBy('created_at', 'desc');
            },
            'bookings' => function ($q) {
                $q->whereHas('room.building', function ($building) {
                    $building->where('user_id', auth()->id());
                })
                ->with(['room.building'])
                ->orderBy('created_at', 'desc');
            }
        ]);

        return view('admin.tenants.show', compact('tenant'));
    }

    /**
     * Lấy thống kê tổng quan về tenants
     */
    public function stats()
    {
        // Kiểm tra quyền admin/chủ trọ
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        $landlordId = auth()->id();

        $stats = [
            'total_active_tenants' => User::role('tenant')
                ->whereHas('contracts', function ($q) use ($landlordId) {
                    $q->where('landlord_id', $landlordId)
                      ->where('status', 'active');
                })->count(),

            'total_contracts' => Contract::where('landlord_id', $landlordId)->count(),

            'active_contracts' => Contract::where('landlord_id', $landlordId)
                ->where('status', 'active')->count(),

            'pending_contracts' => Contract::where('landlord_id', $landlordId)
                ->where('status', 'pending')->count(),
        ];

        return response()->json($stats);
    }
}
