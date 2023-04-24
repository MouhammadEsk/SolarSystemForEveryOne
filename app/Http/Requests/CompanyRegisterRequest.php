<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class CompanyRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>['required','string','unique:companes,name'],
            'email' =>['required','string','unique:companes,email'],
            'phone'=>['required','string'],
            'location.*.lat'=>['required','string'],
            'location.*.long'=>['required','string'],
            'location.*.area'=>['required','string'],
            'logo'=>['nullable','file'],
            'active'=>['required','boolean'],
            'password' =>['required','confirmed'],
        ];
    }
}
