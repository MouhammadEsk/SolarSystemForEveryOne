<?php

namespace App\Http\Resources;
use App\Models\Feature;


use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource

{

    public function toArray($request)
    {
        return[
         'id'=>$this->id,
         'name' => $this->name,
         'type' => $this->type,
         'suffix' => $this->suffix,
         'value'=>$this->whenPivotLoaded('feature_product',function(){
             return $this->pivot->value;
            }),
        'categore' =>new CategoryResource($this->whenloaded('categore')),

        ];
    }
}
