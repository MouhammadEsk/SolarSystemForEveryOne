<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Compane;


class Feedback extends Model
{
    use HasFactory;
    protected $table='feedbacks';
    protected $fillable=[
        'id',
        'title',
        'message',
        'rate',
        'user_id',
        'compane_id'
    ];



    /**
     * Get the user that owns the Feedback
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function compane()
    {
        return $this->belongsTo(Compane::class);
    }
}
