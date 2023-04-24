<?php

namespace App\Http\Resources;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource

{

    public function toArray($request)
    {
        return[
             'id'=>$this->id,
             'name'=>$this->name,
             'location' => $this->location,
             'available' => $this->available,
             'active' => $this->active,
             'email' => $this->email,
             'phone' => $this->phone,
             'FinishAt' =>(string)$this->FinishAt->format('Y-m-d'),
             'compane'=>new CompanyResource($this->whenloaded('compane')),
            'appointment'=>AppointmentResource::collection($this->whenloaded('appointment')),

        ];
    }
}
