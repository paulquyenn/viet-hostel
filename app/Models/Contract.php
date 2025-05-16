<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number',
        'room_id',
        'tenant_id',
        'landlord_id',
        'rental_request_id',
        'start_date',
        'end_date',
        'monthly_rent',
        'deposit',
        'payment_day',
        'terms_and_conditions',
        'status',
        'termination_reason',
        'tenant_signed',
        'landlord_signed',
        'tenant_signed_at',
        'landlord_signed_at',
        'document_path',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'tenant_signed' => 'boolean',
        'landlord_signed' => 'boolean',
        'tenant_signed_at' => 'date',
        'landlord_signed_at' => 'date',
    ];

    /**
     * Lấy thông tin phòng trong hợp đồng
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Lấy thông tin người thuê
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Lấy thông tin chủ trọ
     */
    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    /**
     * Lấy thông tin yêu cầu thuê (nếu có)
     */
    public function rentalRequest()
    {
        return $this->belongsTo(RentalRequest::class);
    }

    /**
     * Kiểm tra xem hợp đồng đã được ký bởi cả hai bên chưa
     */
    public function isFullySigned()
    {
        return $this->tenant_signed && $this->landlord_signed;
    }

    /**
     * Kiểm tra xem hợp đồng có đang hoạt động không
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Lấy danh sách các khoản thanh toán liên quan đến hợp đồng
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
