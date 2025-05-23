<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    // protected $guarded = [];
    protected $fillable = [
        'path',
        'name',
        'size',
        'type',
        'isMain'
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_images');
    }

    public function roomImage()
    {
        return $this->hasOne(RoomImage::class);
    }
}
