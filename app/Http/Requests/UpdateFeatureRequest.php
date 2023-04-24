<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' =>['required','string'],
            'categore_id'=>['integer','required','exists:categores,id'],
            'type'=>['required','string'],
            'suffix'=>['nullable','string'],

           ];
    }
}
