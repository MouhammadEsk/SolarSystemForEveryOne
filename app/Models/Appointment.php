<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'status',
        'startTime',
        'finishTime',
        'days',
        'team_id',
        'order_id',
        'compane_id',
    ];


    protected $casts = [
        'startTime' => 'date:Y-m-d',
        'finishTime'=> 'date:Y-m-d',
        'created_at'=> 'date:Y-m-d',
        'updated_at'=> 'date:Y-m-d'
    ];
    /**
     * Get the order associated with the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the compane that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function compane()
    {
        return $this->belongsTo(Compane::class);
    }

    /**
     * Get the team that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }




}
