<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feature;
use App\Models\Compane;


class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'id',
        'name',
        'image',
        'price',
        'available',
        'categore_id'
    ];

   /**
    * The features that belong to the Product
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
   public function features()
   {
       return $this->belongsToMany(Feature::class)
       ->withPivot('value');
   }


   /**
    * The companes that belong to the Product
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
   public function companes()
   {
       return $this->belongsToMany(Compane::class)
       ->withTimestamps();
   }



   /**
    * Get the categore that owns the Product
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function categore()
   {
       return $this->belongsTo(Categore::class);
   }


   /**
    * Get all of the OrderProduct for the Product
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function OrderProduct()
   {
       return $this->hasMany(OrderProduct::class);
   }
}
