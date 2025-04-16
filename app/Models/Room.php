<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'area',
        'price',
        'deposit',
        'status',
        'max-person',
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
        return $this->hasMany(RoomImage::class);
    }
    public function primaryImage()
    {
        return $this->hasOne(RoomImage::class)->where('is_main', 1);
    }
    public function getStatusAttribute($value)
    {
        return $value == 0 ? 'Còn trống' : 'Đã thuê';
    }
}
