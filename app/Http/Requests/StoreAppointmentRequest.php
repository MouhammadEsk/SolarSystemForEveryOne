<?php

namespace App\Http\Requests;

use App\Rules\TeamExistInCompanyRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'startTime'=>['required','date_format:Y-m-d'],
            'team_id'=>['required','exists:teams,id'],
            'compane_id'=>['required','exists:companes,id'],
            'location.*.lat'=>['required','string'],
            'location.*.long'=>['required','string'],
            'location.*.area'=>['required','string'],
        ];
    }
}
