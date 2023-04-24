<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'order_id',
        'ammount',
    ];


    /**
     * Get the order that owns the DeviceOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
