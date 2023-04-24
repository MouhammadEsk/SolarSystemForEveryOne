<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'features.*.feature_id'=>'required|integer',
            'features.*.value'=>['string','nullable'],
        ];
    }
}
