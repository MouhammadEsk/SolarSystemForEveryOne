<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Compane extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;
    protected $guard_name = 'web';


    protected $fillable = [
        'id',
        'name',
        'location',
        'phone',
        'logo',
        'rate',
        'active',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   public function teams()
    {
        return $this->hasMany(Team::class,'company_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class,);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }

    protected function location(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
