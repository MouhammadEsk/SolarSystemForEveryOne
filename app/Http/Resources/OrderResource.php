<?php

namespace App\Http\Resources;
use App\Models\Order;
use App\Http\Resources\OrderProductResource;
use App\Http\Resources\DeviceOrderResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\AppointmentResource;






use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource

{

    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'total_voltage'=>$this->total_voltage,
            'total_price' => $this->total_price,
            'hours_on_charge'=>$this->hours_on_charge,
            'hours_on_bettary'=>$this->hours_on_bettary,
            'space'=>$this->space,
            'location'=>$this->location,
            'user' =>new UserResource($this->whenloaded('user')),
            'products'=>OrderProductResource::collection($this->whenloaded('OrderProduct')),
            'devices'=>DeviceOrderResource::collection($this->whenloaded('DeviceOrder')),
            'appointment'=>new AppointmentResource($this->whenloaded('appointment')),
        ];
    }
}
