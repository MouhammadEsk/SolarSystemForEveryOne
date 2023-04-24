<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>['required','string'],
            'location.*.lat'=>['required','string'],
            'location.*.long'=>['required','string'],
            'location.*.area'=>['required','string'],
            'rate'=>['required','integer','between:1,5'],
            'available'=>['required','boolean'],
            'active'=>['required','boolean'],
            'phone'=>['required','string'],
            'company_id'=>['integer','required','exists:companes,id']

        ];
    }
}
