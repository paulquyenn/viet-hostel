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
}
