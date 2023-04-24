<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>['nullable','string'],
            'avilable' =>['nullable','boolean'],
            'price' =>['nullable','string'],
            'categore_id'=>['integer','required','exists:categores,id']
        ];
    }
}
