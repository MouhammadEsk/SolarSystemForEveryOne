<?php

namespace App\Http\Controllers;

use App\Http\QueryPipelines\TeamPipeline\TeamPipeline;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TeamResource;
use Gate;
use App\Http\Requests\UpdateTeamActiveRequest;
use Illuminate\Support\Facades\Hash;


class TeamController extends Controller
{
    public function companyid(Request $request)
    {
        abort_if(Gate::denies('teams_access'), 403);
        $team=Team::where('company_id',$request->company_id)->get();
        return BaseController::sendResponse($team,'Teams sent successfully');
    }

    public function index(Request $request)
    {
        $per =  $request->per;

        $teams=Team::with('compane')->paginate( $perPage = $per, $columns = ['*']);
         return BaseController::sendResponse(TeamResource::collection($teams)->response()->getData(true)
         ,'Team Sent Successfully');
    }

    public function show(Team $team)
    {
        abort_if(Gate::denies('team_show'), 403);
        return BaseController::sendResponse($team,'Team sent successfully ');
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        abort_if(Gate::denies('team_update'), 403);
        $team->update($request->validated()+
        ['location'=>[
            'lat'=>$request->lat,
            'long'=>$request->long,
            'area'=>$request->area,
            ]]);
        return BaseController::sendResponse($team,'Team Updated successfully');
    }

    public function destroy(Team $team)
    {
        abort_if(Gate::denies('team_delete'), 403);
        $team->delete();
        return BaseController::sendResponse($team,'Team Deleted successfully');
    }

    public function search(Request $request){
        abort_if(Gate::denies('team_search'), 403);
     $team=Team::where('name','like',"%{$request->name}%")->get();
     if($team==null){
         return BaseController::sendError('No Such Team');
    }

     return BaseController::sendResponse($team,'In Team');
    }

    public function active(Team $team, UpdateTeamActiveRequest $request){
        $team->update(['active'=>$request->active]);
        return BaseController::sendResponse($team,'Team Active Has Been Updated successfully');
    }

    public function appointments(Request $request){
        abort_if(Gate::denies('appointments_access'), 403);
        $team = Team::where('id',Auth::id())->first();
        $appointment = TeamPipeline::make(
            builder: $team->query(),
            request: $request)->paginate();
       return TeamResource::collection($appointment);

    }

    public function changepassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        if (Hash::check($request->oldpassword,$user->password)) {
            $user->update(['password' => Hash::make($request->newpassword)]);
            return BaseController::sendResponse(new UserResource($user),
                'Your password Updated Successfully');
        }
        return BaseController::sendError('the OldPassword is wrong');
    }

    public function teamByToken(){
        $team = Team::where('id',Auth::id())->first();
        return BaseController::sendResponse(new TeamResource($team),'Team Sent Successfully');
    }


}
