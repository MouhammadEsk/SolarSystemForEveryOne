<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'name',
        'image',
        'voltage',
        'voltagePower',
        'FazesNumber',
    ];


    public function types()
    {
        return $this->belongsToMany(Type::class);
    }



    public function DeviceOrder()
    {
        return $this->hasMany(DeviceOrder::class);
    }
}
