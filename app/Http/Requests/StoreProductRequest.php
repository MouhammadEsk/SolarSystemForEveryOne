<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>['required','string'],
            'price' =>['required','string'],
            'available' =>['required','boolean'],
            'categore_id'=>['required','exists:categores,id'],
            'image' =>['required','file']
        ];
    }
}
