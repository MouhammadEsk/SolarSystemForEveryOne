<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>['nullable','string'],
            'phone'=>['nullable','string'],
            'location.*.lat'=>['nullable','string'],
            'location.*.long'=>['nullable','string'],
            'location.*.area'=>['nullable','string'],
            'active'=>['nullable','boolean'],
        ];
    }
}
