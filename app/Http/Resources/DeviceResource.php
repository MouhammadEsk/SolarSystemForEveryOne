<?php

namespace App\Http\Resources;
use App\Models\Device;


use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource

{

    public function toArray($request)
    {
        return[
         'id'=>$this->id,
         'name' => $this->name,
         'image' => $this->image,
         'voltage' => $this->voltage,
         'voltagePower' => $this->voltagePower,
         'FazesNumber' => $this->FazesNumber,
         'type' =>TypeResource::collection($this->whenLoaded('types')),



        ];
    }
}
