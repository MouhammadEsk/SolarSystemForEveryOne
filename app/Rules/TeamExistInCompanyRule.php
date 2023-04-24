<?php

namespace App\Rules;
use App\Models\Compane;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

//here i copied this DataAwareRule so i can get the request passed in here
class TeamExistInCompanyRule implements Rule, DataAwareRule
{
    protected $data = [];

    public function __construct() {
    }
//here you should implement this function so you can get the data from this interface DataAwareRule the (data) mean the request passed
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
//here you should put the logic but it has to return true or false if it is true it will pass it is false it will return the message
    public function passes($attribute, $value):bool
    {
        // with the data object that we made you can get the item id that is in the request right?
        $company = Compane::where('id', $this->data['appointment']['compane_id'])->whereHas('teams',function($q){
            return $q->where('id',$this->data['team_id']);
       })->first();
        //now you have the item object and you need to but the condition like
        // dd($company);
        return $company?true:false;
        // return  $item->quantity => $this->data['quantity'];
    }

    public function message():string
    {
        return 'This Team ID Is Not Exist For This Company';
    }
}
