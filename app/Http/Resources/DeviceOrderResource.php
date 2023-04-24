<?php

namespace App\Http\Resources;



use Illuminate\Http\Resources\Json\JsonResource;

class DeviceOrderResource extends JsonResource

{

    public function toArray($request)
    {
        return[
            'device' =>new DeviceResource($this->whenloaded('device')),
            'id'=>$this->device_id,
            'order_id' => $this->whenAppended('order_id'),
            'device_ammount' => $this->ammount,
           ];
    }
}
