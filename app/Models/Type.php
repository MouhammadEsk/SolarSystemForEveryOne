<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class Type extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'name'
    ];

    /**
     * The devices that belong to the Type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }
}
