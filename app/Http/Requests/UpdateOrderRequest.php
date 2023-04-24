<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'order.total_voltage'=>['required','string'],
            'order.total_price'=>['required','string'],
            'order.hours_on_charge'=>['required','string'],
            'order.hours_on_bettary'=>['required','string'],
            'order.space'=>['required','string'],
            'order.location.*.lat'=>['required','string'],
            'order.location.*.long'=>['required','string'],
            'order.location.*.area'=>['required','string'],
            'products.*.product_id'=>['required','integer'],
            'products.*.ammount'=>['required','integer'],
            'device.*.device_id'=>['required','integer'],
            'devices.*.ammount'=>['required','integer'],
        ];
    }
}
