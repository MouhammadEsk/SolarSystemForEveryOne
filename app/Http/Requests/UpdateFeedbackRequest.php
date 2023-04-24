<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' =>'required|string',
            'message' =>'required|string|max:600',
            'company_id'=>['integer','required','exists:companes,id'],
            'user_id'=>['integer','required','exists:users,id']
        ];
    }
}
