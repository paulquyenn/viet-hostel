<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Room
 * @package App\Models
 *
 * @property int $id
 * @property string $room_number
 * @property float $area
 * @property float $price
 * @property float $deposit
 * @property string $status Trạng thái phòng ('available' hoặc 'occupied')
 * @property int $max_person
 * @property string|null $utilities
 * @property string|null $description
 * @property int $building_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read string $status_text Văn bản hiển thị trạng thái phòng
 * @property-read int $current_tenant_count Số người đang thuê
 * @property-read bool $has_available_space Còn chỗ trống hay không
 * @property-read int $available_spots Số chỗ còn trống
 * @property-read float $average_rating Điểm đánh giá trung bình
 *
 * @property-read \App\Models\Building $building
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contract[] $contracts
 */
class Room extends Model
{
    use HasFactory;

    const STATUS_AVAILABLE = 'available';
    const STATUS_OCCUPIED = 'occupied';

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
    /**
     * Lấy số lượng người thuê hiện tại trong phòng
     */
    public function getCurrentTenantCountAttribute()
    {
        return $this->contracts()->whereIn('status', ['active', 'approved'])->count();
    }

    /**
     * Kiểm tra xem phòng có còn chỗ trống hay không
     */
    public function getHasAvailableSpaceAttribute()
    {
        return $this->current_tenant_count < $this->max_person;
    }

    /**
     * Lấy số chỗ còn trống trong phòng
     */
    public function getAvailableSpotsAttribute()
    {
        return $this->max_person - $this->current_tenant_count;
    }

    public function getStatusTextAttribute()
    {
        if ($this->status === self::STATUS_AVAILABLE) {
            return 'Còn trống';
        }
        // If room is occupied but has available spots
        return $this->has_available_space ? 'Còn ' . $this->available_spots . ' chỗ' : 'Đã đầy';
    }

    /**
     * Kiểm tra xem phòng có đang trống không
     */
    public function isAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    /**
     * Kiểm tra xem phòng có đang được thuê không
     */
    public function isOccupied()
    {
        return $this->status === self::STATUS_OCCUPIED;
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
     * Lấy danh sách đặt phòng
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Lấy danh sách hợp đồng của phòng
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
