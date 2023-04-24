<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        'oldpassword'=> ['required'],
        'newpassword'=> ['required', 'confirmed', Rules\Password::defaults()],
    ];
    }
}
