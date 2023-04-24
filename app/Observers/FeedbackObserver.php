<?php

namespace App\Observers;

use App\Models\Compane;
use App\Models\Feedback;

class FeedbackObserver
{

    public function created(Feedback $feedback)
    {
        //
    }

    public function updated(Feedback $feedback)
    {
        $company = Compane::where('id',$feedback->compane_id)->first();
        $companyAvgRate = $company->feedbacks()->avg('rate');
        $company->update(['rate'=>$companyAvgRate]);
    }

    public function updateMonthlyRatings(Feedback $feedback,)
    {
        $company = Compane::where('id',$feedback->compane_id)->first();
        $companyAvgRate = $company->feedbacks()->avg('rate');
        $company->update(['rate'=>$companyAvgRate]);
    }

    public function deleted(Feedback $feedback)
    {
          //
    }

    public function restored(Feedback $feedback)
    {
        //
    }

    public function forceDeleted(Feedback $feedback)
    {
        //
    }
}
