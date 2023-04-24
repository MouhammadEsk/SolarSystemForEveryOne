<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanySurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
             'team'=>TeamResource::collection($this->whenloaded('teams'))->count(),
             'appointment'=>AppointmentResource::collection($this->whenloaded('appointment'))->count(),
             'products'=>ProductResource::collection($this->whenloaded('products'))->count(),
            ];
    }
}
