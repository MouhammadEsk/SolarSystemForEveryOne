<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Compane;
use App\Http\Resources\FeedbackResource;
use Illuminate\Support\Facades\Auth;
use Gate;
use App\Http\Requests\UpdateFeedbackRatingRequest;

class FeedbackController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('feedbacks_access'), 403);
        $feedbacks=Feedback::all();
        return BaseController::sendResponse(FeedbackResource::collection($feedbacks
        ->load('user','compane')),
        'Feedbacks Sent Successfully');
    }

    public function showbyid (Feedback $feedback){
        return BaseController::sendResponse(new FeedbackResource($feedback
        ->load('compane'))
        ,'In Feedback');
    }

    public function CompanyUserFeedbacks(Request $request){
        $feedback = Feedback::where('user_id',Auth::id())
                            ->where('compane_id',$request->compane_id)
                            ->get();
        return BaseController::sendResponse(FeedbackResource::collection($feedback
        ->load('compane')),'Company Feedbacks Sent Successfully');
    }

    public function company(Request $request){
        abort_if(Gate::denies('feedbacks_show'), 403);
        $feedbacks=Feedback::where('compane_id',$request->compane_id)->get();
        return BaseController::sendResponse(FeedbackResource::collection($feedbacks
         ->load('user','compane')),
        'FeedBacks Sent Successfully');

    }

    public function store(StoreFeedbackRequest $request)
    {
        abort_if(Gate::denies('feedback_create'), 403);
        $feedback=Feedback::create([
            'id'=>$request->id,
            'title'=>$request->title,
            'message'=>$request->message,
            'user_id'=>Auth::id(),
            'compane_id'=>$request->compane_id,


        ]);
        return BaseController::sendResponse(new FeedbackResource($feedback),
        'Feedback Created Successfully');
    }

    public function update(Feedback $feedback,UpdateFeedbackRatingRequest $request){
        $feedback->update(['rate'=>$request->rate]);
        return BaseController::sendResponse(new FeedbackResource($feedback),
            'Rating Updated Successfully');

    }

    public function destroy(Feedback $feedback)
    {
        abort_if(Gate::denies('feedback_delete'), 403);
        $feedback->delete();
        return BaseController::sendResponse(new FeedbackResource($feedback),
        'Feedback Deleted Successfully');

    }

}
