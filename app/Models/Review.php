<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'rating',
        'comment'
    ];

    /**
     * Lấy phòng trọ được đánh giá
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Lấy người dùng đã đánh giá
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
