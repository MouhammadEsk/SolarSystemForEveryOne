<?php

namespace App\Http\Resources;
use App\Models\Compane;



use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource

{

    public function toArray($request)
    {
        return[
             'id'=>$this->id,
             'name' => $this->name,
             'rate' => (int) $this->rate,
             'location'=>$this->WhenAppended('location'),
             'email'=>$this->WhenAppended('email'),
             'phone'=>$this->WhenAppended('phone'),
             'logo'=>$this->logo,
             'active'=>$this->WhenAppended('active'),
             'team'=>TeamResource::collection($this->whenloaded('teams')),
             'appointment'=>AppointmentResource::collection($this->whenloaded('appointment')),
             'products'=>ProductResource::collection($this->whenloaded('products')),
             'feedbacks' =>FeedbackResource::collection($this->whenloaded('feedbacks')),
        ];
    }
}
