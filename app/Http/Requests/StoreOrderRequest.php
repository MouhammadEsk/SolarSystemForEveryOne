<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\TeamExistInCompanyRule;

class StoreOrderRequest extends FormRequest
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
            'products'=>['required'],
            'devices'=>['required'],
            'appointment.startTime'=>['required','date_format:Y-m-d'],
            'appointment.compane_id'=>['required','integer','exists:companes,id'],
            'team_id'=>['required','integer','exists:teams,id',new TeamExistInCompanyRule()],





        ];
    }
}
