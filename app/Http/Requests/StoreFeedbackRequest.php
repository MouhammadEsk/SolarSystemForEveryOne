<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' =>['required','string'],
            'message' =>['required','string','max:600'],
            'rate'=>['integer','nullable'],
            'compane_id'=>['integer','required','exists:companes,id'],
            'user_id'=>['integer','nullable','exists:users,id']




        ];
    }
}
