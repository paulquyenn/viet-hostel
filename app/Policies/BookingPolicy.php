<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Xác định xem người dùng có quyền xem đơn đặt phòng hay không
     */
    public function view(User $user, Booking $booking): bool
    {
        // Người dùng chỉ có thể xem đơn đặt phòng của họ hoặc admin có thể xem tất cả
        return $user->id === $booking->user_id || $user->hasRole('admin');
    }

    /**
     * Xác định xem người dùng có quyền hủy đơn đặt phòng hay không
     */
    public function cancel(User $user, Booking $booking): bool
    {
        // Người dùng chỉ có thể hủy đơn đặt phòng của họ và trạng thái là 'pending'
        return $user->id === $booking->user_id && $booking->status === 'pending';
    }

    /**
     * Xác định xem admin có quyền duyệt đơn đặt phòng hay không
     */
    public function approve(User $user, Booking $booking): bool
    {
        // Chỉ admin mới có quyền duyệt
        return $user->hasRole('admin');
    }

    /**
     * Xác định xem admin có quyền từ chối đơn đặt phòng hay không
     */
    public function reject(User $user, Booking $booking): bool
    {
        // Chỉ admin mới có quyền từ chối
        return $user->hasRole('admin');
    }
}
