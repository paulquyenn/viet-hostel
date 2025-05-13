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
    public function getStatusAttribute($value)
    {
        return $value == 0 ? 'Còn trống' : 'Đã thuê';
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
}
