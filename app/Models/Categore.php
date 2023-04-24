<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Feature;

class Categore extends Model
{
    use HasFactory;

    protected $fillable=[
        'id',
        'name'
    ];


    /**
     * Get all of the features for the Categore
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features()
    {
        return $this->hasMany(Feature::class,'categore_id');
    }
    /**
     * Get all of the products for the Categore
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
