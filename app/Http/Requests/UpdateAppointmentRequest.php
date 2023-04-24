<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'startTime'=>['required','date_format:Y-m-d'],
            'team_id'=>['required','integer','exists:teams,id'],
        ];
    }
}
