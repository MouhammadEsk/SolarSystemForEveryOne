<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Order extends Model
{
    protected $fillable = [
        'total_voltage',
        'total_price',
        'hours_on_charge',
        'hours_on_bettary',
        'space',
        'location',
        'user_id'
    ];

    protected function location(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }


    public function OrderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }



    public function DeviceOrder()
    {
        return $this->hasMany(DeviceOrder::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

}
