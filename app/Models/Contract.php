<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $fillable = [
        'contract_number',
        'booking_id',
        'room_id',
        'tenant_id',
        'landlord_id',
        'start_date',
        'end_date',
        'monthly_rent',
        'deposit_amount',
        'terms_and_conditions',
        'status',
        'file_path',
        'signature_path',
        'signed_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'signed_at' => 'datetime',
    ];

    /**
     * Đơn đặt phòng liên quan
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Phòng trong hợp đồng
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Người thuê phòng
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Chủ trọ
     */
    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    /**
     * Lấy trạng thái hiển thị cho người dùng
     */
    public function getStatusTextAttribute()
    {
        return [
            'active' => 'Đang hiệu lực',
            'expired' => 'Đã hết hạn',
            'terminated' => 'Đã chấm dứt',
            'pending' => 'Đang chờ người thuê xác nhận',
            'tenant_approved' => 'Đã được người thuê xác nhận',
        ][$this->status] ?? $this->status;
    }

    /**
     * Kiểm tra xem hợp đồng có thể được xác nhận bởi tenant hay không
     */
    public function canBeConfirmedByTenant()
    {
        return $this->status === 'pending' && !$this->isSigned();
    }

    /**
     * Xác nhận hợp đồng bởi tenant
     */
    public function confirmByTenant()
    {
        if ($this->canBeConfirmedByTenant()) {
            $this->status = 'active';
            $this->signed_at = now();
            $this->save();

            // Cập nhật trạng thái phòng thành đã thuê
            if ($this->room && $this->room->status === 'available') {
                $this->room->status = 'occupied';
                $this->room->save();
            }

            return true;
        }

        return false;
    }

    /**
     * Kiểm tra xem hợp đồng đã được ký hay chưa
     */
    public function isSigned()
    {
        return !is_null($this->signed_at);
    }

    /**
     * Tính số tháng trong hợp đồng
     */
    public function getDurationInMonthsAttribute()
    {
        $start = $this->start_date;
        $end = $this->end_date;

        $years = $end->year - $start->year;
        $months = $end->month - $start->month;

        return $years * 12 + $months;
    }
}
