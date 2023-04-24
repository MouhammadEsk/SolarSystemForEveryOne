<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRegisterRequest extends FormRequest
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
            'rate'=>['nullable','integer','between:1,5'],
            'available'=>['required','boolean'],
            'FinishAt'=>['date','required'],
            'phone'=>['required|string'],
            'active'=>['required','boolean'],
            'email' =>['required','string','unique:teams,email'],
            'password' =>['required','confirmed'],
            'company_id'=>['integer','nullable','exists:companes,id']

        ];
    }
}
