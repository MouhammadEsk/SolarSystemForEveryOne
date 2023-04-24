<?php

namespace App\Http\Resources;
use App\Models\Feedback;
use App\Http\Resources\UserResource;
use App\Http\Resources\CompanyResource;


use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource

{

    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'title' => $this->title,
            'message' => $this->message,
            'rate' => (int) $this->rate,
            'user_id' => $this->user_id,
             'compane_id' => $this->compane_id,
             'user' =>new UserResource($this->whenloaded('user')),
             'compane'=>new CompanyResource($this->whenloaded('compane'))
        ];
    }
}
