<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_number',
        'area',
        'price',
        'deposit',
        'status',
        'max_person',
        'utilities',
        'description',
        'building_id'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class, 'room_images');
    }
    protected $hasActiveContractCache = null;

    public function getStatusAttribute($value)
    {
        // Kiểm tra xem có hợp đồng đang hoạt động không, nếu có thì phòng đã được thuê
        if ($this->getOriginal('status') == 1 || $this->hasActiveContract()) {
            return 'Đã thuê';
        }

        return $value == 0 ? 'Còn trống' : 'Đã thuê';
    }

    /**
     * Kiểm tra và cache việc phòng có hợp đồng đang hoạt động không
     */
    public function hasActiveContract()
    {
        if ($this->hasActiveContractCache === null) {
            // Kiểm tra có relation đã load sẵn chưa
            if ($this->relationLoaded('contracts')) {
                $this->hasActiveContractCache = $this->contracts->contains('status', 'active');
            } else {
                // Sử dụng giá trị cache cho trường hợp này để tránh n+1 query
                // Nếu không chắc chắn, trả về giá trị dựa vào status gốc
                $this->hasActiveContractCache = ($this->getOriginal('status') == 1);
            }
        }

        return $this->hasActiveContractCache;
    }

    /**
     * Lấy danh sách đánh giá của phòng
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Lấy điểm đánh giá trung bình
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Lấy danh sách yêu cầu thuê phòng
     */
    public function rentalRequests()
    {
        return $this->hasMany(RentalRequest::class);
    }

    /**
     * Lấy danh sách hợp đồng của phòng
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Lấy hợp đồng đang hoạt động của phòng (nếu có)
     */
    public function activeContract()
    {
        return $this->contracts()->where('status', 'active')->first();
    }

    /**
     * Kiểm tra xem phòng đã được thuê chưa
     */
    public function isRented()
    {
        return $this->getOriginal('status') == 1 || $this->hasActiveContract();
    }
}
