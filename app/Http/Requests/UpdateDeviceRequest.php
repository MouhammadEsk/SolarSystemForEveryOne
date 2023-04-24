<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeviceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
            return [
                'name' =>['required','string'],
                'voltage' =>['required','string'],
                'voltagePower' =>['required','string'],
                'FazesNumber' =>['required','integer','max:3'],
            ];

    }
}
