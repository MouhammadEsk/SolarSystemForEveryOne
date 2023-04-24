<?php

namespace App\Http\Resources;




use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource

{

    public function toArray($request)
    {
        return[
         'id'=>$this->id,
         'name' => $this->name,
         'image'=>$this->image,
         'price'=>$this->price,
         'battery_amount'=>$this->whenNotNull($this->battery_amount),
         'panel_amount'=>$this->whenNotNull($this->panel_amount),
         'available'=>$this->available,
         'categore' =>new CategoryResource($this->whenloaded('categore')),
         'features'=>FeatureResource::collection($this->whenloaded('features')),
         'company'=>CompanyResource::collection($this->whenloaded('companes')),
        ];
    }
}
