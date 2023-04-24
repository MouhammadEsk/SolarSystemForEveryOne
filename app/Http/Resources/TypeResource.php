<?php

namespace App\Http\Resources;
use App\Models\Type;


use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource

{

    public function toArray($request)
    {
        return[
         'id'=>$this->id,
         'name' => $this->name,
         'devices' =>new DeviceResource($this->whenloaded('devices')),

        ];
    }
}
