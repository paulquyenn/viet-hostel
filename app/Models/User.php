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
     * Lấy danh sách yêu cầu thuê phòng của người dùng
     */
    public function rentalRequests()
    {
        return $this->hasMany(RentalRequest::class);
    }

    /**
     * Lấy danh sách hợp đồng của người dùng (với vai trò người thuê)
     */
    public function tenantContracts()
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }

    /**
     * Lấy danh sách hợp đồng của người dùng (với vai trò chủ trọ)
     */
    public function landlordContracts()
    {
        return $this->hasMany(Contract::class, 'landlord_id');
    }

    /**
     * Lấy danh sách tòa nhà của người dùng (chủ trọ)
     */
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
