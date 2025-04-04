<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'name',
        'address',
        'ward_id',
        'district_id',
        'province_id'
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->ward->name . ', ' . $this->district->name . ', ' . $this->province->name;
    }
}
