<?php

namespace App\Http\Resources;
use App\Models\Appointment;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\OrderResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{

    public function toArray($request)
    {
        return[
         'id'=>$this->id,
         'type' => $this->type,
         'status' => $this->status,
         'startTime' => (string) $this->startTime->format('Y-m-d'),
         'finishTime' =>(string) $this->finishTime->format('Y-m-d'),
         'days' => $this->days,
         'compane'=>new CompanyResource($this->whenloaded('compane')),
         'team'=>new TeamResource($this->whenloaded('team')),
         'order'=>new OrderResource($this->whenloaded('order')),
        ];
    }
}
