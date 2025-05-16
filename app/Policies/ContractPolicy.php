<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContractPolicy
{
    /**
     * Xác định xem người dùng có quyền tạo hợp đồng hay không
     */
    public function create(User $user): bool
    {
        // Chỉ admin/chủ trọ mới có quyền tạo hợp đồng mới
        return $user->hasRole('admin');
    }

    /**
     * Xác định xem người dùng có quyền xem hợp đồng hay không
     */
    public function view(User $user, Contract $contract): bool
    {
        // Người thuê chỉ có thể xem hợp đồng của họ
        // Admin/chủ trọ có thể xem tất cả hợp đồng
        return $user->id === $contract->tenant_id || $user->id === $contract->landlord_id || $user->hasRole('admin');
    }

    /**
     * Xác định xem người dùng có quyền chỉnh sửa hợp đồng hay không
     */
    public function update(User $user, Contract $contract): bool
    {
        // Chỉ admin/chủ trọ mới có quyền chỉnh sửa và hợp đồng chưa được ký
        return $user->hasRole('admin') && !$contract->isSigned();
    }

    /**
     * Xác định xem người dùng có quyền ký hợp đồng hay không
     */
    public function sign(User $user, Contract $contract): bool
    {
        // Chỉ admin/chủ trọ hoặc người thuê mới có quyền ký
        return ($user->id === $contract->tenant_id || $user->id === $contract->landlord_id || $user->hasRole('admin'))
            && !$contract->isSigned();
    }

    /**
     * Xác định xem người dùng có quyền chấm dứt hợp đồng hay không
     */
    public function terminate(User $user, Contract $contract): bool
    {
        // Chỉ admin/chủ trọ mới có quyền chấm dứt và hợp đồng phải đã được ký và đang hiệu lực
        return $user->hasRole('admin') && $contract->isSigned() && $contract->status === 'active';
    }
}
