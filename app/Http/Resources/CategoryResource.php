<?php

namespace App\Http\Resources;
use App\Models\Categore;



use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource

{

    public function toArray($request)
    {
        return[
         'id'=>$this->id,
         'name' => $this->name,
         'features'=>FeatureResource::collection($this->whenloaded('features')),
         'products'=>ProductResource::collection($this->whenloaded('products')),

        ];
    }
}
