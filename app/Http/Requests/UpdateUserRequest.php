<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>['required','string'],
            'DOB'=>['date','date_format:Y-m-d'],
            'email' =>['required','string','unique:users,email'],
            'phone'=>['required','string'],
            'location.*.lat'=>['required','string'],
            'location.*.long'=>['required','string'],
            'location.*.area'=>['required','string'],
        ];
    }
}
