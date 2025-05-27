<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Lấy danh sách đánh giá của người dùng
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Lấy danh sách đặt phòng của người dùng
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Lấy danh sách hợp đồng thuê phòng của người dùng (với vai trò là người thuê)
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }

    /**
     * Lấy danh sách hợp đồng của chủ trọ
     */
    public function landlordContracts()
    {
        return $this->hasMany(Contract::class, 'landlord_id');
    }

    /**
     * Kiểm tra xem người dùng có hợp đồng đang active không
     */
    public function hasActiveContract()
    {
        return $this->contracts()
            ->whereIn('status', ['active', 'pending'])
            ->where('end_date', '>', now())
            ->exists();
    }

    /**
     * Lấy hợp đồng active hiện tại (nếu có)
     */
    public function getActiveContract()
    {
        return $this->contracts()
            ->whereIn('status', ['active', 'pending'])
            ->where('end_date', '>', now())
            ->with(['room.building'])
            ->first();
    }

    /**
     * Kiểm tra xem người dùng có đơn đặt phòng đang chờ xử lý không
     */
    public function hasPendingBooking()
    {
        return $this->bookings()
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Lấy đơn đặt phòng đang chờ xử lý (nếu có)
     */
    public function getPendingBooking()
    {
        return $this->bookings()
            ->where('status', 'pending')
            ->with(['room.building'])
            ->first();
    }
}
