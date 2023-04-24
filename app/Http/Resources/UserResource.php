<?php

namespace App\Http\Resources;
use App\Models\User;
use App\Http\Resources\OrderResource;



use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource

{

    public function toArray($request)
    {
        return[
         'id'=>$this->id,
         'name'=>$this->name,
         'location' => $this->location,
         'phone' => $this->phone,
         'email' => $this->email,
         'order' =>OrderResource::collection($this->whenloaded('order')),
        ];
    }
}
