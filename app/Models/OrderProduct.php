<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'order_id',
        'ammount',

    ];

   /**
    * Get the Order that owns the OrderProduct
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function order(){
       return $this->belongsTo(Order::class);
   }

   /**
    * Get the product that owns the OrderProduct
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function product()
   {
       return $this->belongsTo(Product::class);
   }

}
