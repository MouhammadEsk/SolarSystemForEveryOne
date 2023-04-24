<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categore;
use App\Models\Product;


class Feature extends Model
{
    use HasFactory;

    protected $fillable=[
        'id',
        'name',
        'type',
        'suffix',
        'categore_id'
    ];

    /**
     * Get the categore that owns the Feature
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categore()
    {
        return $this->belongsTo(Categore::class,'categore_id');
    }



    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->withPivot('value');

    }




}
