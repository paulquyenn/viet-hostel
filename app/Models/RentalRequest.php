<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'requested_from_date',
        'requested_to_date',
        'message',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'requested_from_date' => 'date',
        'requested_to_date' => 'date',
    ];

    /**
     * Lấy thông tin người thuê đã gửi yêu cầu
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy thông tin phòng được yêu cầu thuê
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Lấy hợp đồng thuê được tạo từ yêu cầu này (nếu có)
     */
    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    /**
     * Kiểm tra xem yêu cầu có đang chờ xử lý không
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
}
