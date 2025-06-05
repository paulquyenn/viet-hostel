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
        // Admin hoặc chủ trọ có quyền tạo hợp đồng mới
        return $user->hasRole('admin') || $user->hasRole('landlord');
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
        // Admin có thể chỉnh sửa bất kỳ hợp đồng nào chưa được ký
        if ($user->hasRole('admin')) {
            return !$contract->isSigned();
        }

        // Chủ trọ chỉ có thể chỉnh sửa hợp đồng của property họ sở hữu và chưa được ký
        if ($user->hasRole('landlord')) {
            return $contract->room->building->user_id === $user->id && !$contract->isSigned();
        }

        return false;
    }

    /**
     * Xác định xem người dùng có quyền ký hợp đồng hay không
     */
    public function sign(User $user, Contract $contract): bool
    {
        // Hợp đồng đã được ký thì không thể ký lại
        if ($contract->isSigned()) {
            return false;
        }

        // Admin có quyền ký bất kỳ hợp đồng nào
        if ($user->hasRole('admin')) {
            return true;
        }

        // Chủ trọ có thể ký hợp đồng của property họ sở hữu
        if ($user->hasRole('landlord')) {
            return $contract->room->building->user_id === $user->id;
        }

        // Người thuê có thể ký hợp đồng của họ
        return $user->id === $contract->tenant_id;
    }

    /**
     * Xác định xem người dùng có quyền chấm dứt hợp đồng hay không
     */
    public function terminate(User $user, Contract $contract): bool
    {
        // Hợp đồng phải đã được ký và đang hiệu lực
        if (!$contract->isSigned() || $contract->status !== 'active') {
            return false;
        }

        // Admin có thể chấm dứt bất kỳ hợp đồng nào
        if ($user->hasRole('admin')) {
            return true;
        }

        // Chủ trọ có thể chấm dứt hợp đồng của property họ sở hữu
        if ($user->hasRole('landlord')) {
            return $contract->room->building->user_id === $user->id;
        }

        return false;
    }
}
