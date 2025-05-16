<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'contract_id',
        'payment_number',
        'amount',
        'payment_date',
        'payment_period_start',
        'payment_period_end',
        'payment_method',
        'payment_status',
        'notes',
        'paid_at',
        'created_by',
        'paid_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'payment_period_start' => 'date',
        'payment_period_end' => 'date',
        'paid_at' => 'datetime',
    ];

    /**
     * Lấy thông tin hợp đồng liên quan đến khoản thanh toán
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Lấy thông tin người tạo khoản thanh toán
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Lấy thông tin người thanh toán
     */
    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    /**
     * Kiểm tra xem khoản thanh toán đã được thanh toán chưa
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Kiểm tra xem khoản thanh toán có bị quá hạn không
     */
    public function isOverdue()
    {
        return $this->payment_status === 'pending' && now()->gt($this->payment_date);
    }
}
