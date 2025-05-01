<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function room()
    {
        return $this->hasMany(Room::class, 'room_images');
    }

    public function roomImage()
    {
        return $this->hasOne(RoomImage::class);
    }
}
