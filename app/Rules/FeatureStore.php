<?php

namespace App\Rules;
use App\Models\Feature;
use App\Models\Categore;
use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class FeatureStore implements Rule
{

    public function __construct(private array $data)
    {
        $this->data = $data;
    }

    public function passes($attribute, $value): bool
    {
        $category = Categore::find($this->data['categore_id']);
        $feature =  $category->features()->where('name', $this->data['name'])->first();

        return $feature ? false:true;
    }

    public function message(): string
    {
        return "This Feature Already Exist In This Category";
    }
}
