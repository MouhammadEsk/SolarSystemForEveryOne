<?php


namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Compane;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;


    class Team extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable, HasRoles;
        protected $guard_name = 'web';

        protected $fillable = [
            'name',
            'location',
            'available',
            'active',
            'phone',
            'rate',
            'email',
            'password',
            'company_id',
            'FinishAt'
        ];

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var array<int, string>
         */
        protected $hidden = [
            'password',
            'remember_token',
            'email_verified_at'
        ];

        /**
         * The attributes that should be cast.
         *
         * @var array<string, string>
         */
        protected $casts = [
            'FinishAt' => 'date',
            'email_verified_at' => 'datetime',
        ];





    /**
     * Get the compane that owns the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function compane()
    {
        return $this->belongsTo(Compane::class,'company_id');
    }


    /**
     * Get the role that owns the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class,);
    }

    protected function location(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    /**
     * Get all of the appointment for the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }

}
