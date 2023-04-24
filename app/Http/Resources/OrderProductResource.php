<?php

namespace App\Http\Resources;
use App\Models\Order;



use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource

{

    public function toArray($request)
    {
        return[
            'product' =>new ProductResource($this->whenloaded('product')),
            'id'=>$this->product_id,
            'order_id' => $this->whenAppended('order_id'),
            'product_ammount' => $this->ammount,
           ];
    }
}
