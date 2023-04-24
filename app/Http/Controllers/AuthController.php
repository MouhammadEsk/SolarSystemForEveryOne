<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Compane;
use App\Models\Team;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\CompanyRegisterRequest;
use App\Http\Requests\TeamRegisterRequest;
use App\Http\Requests\LoginRequest;
use Gate;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController ;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $input=$request->validated()+
        ['location'=>[
            'lat'=>$request->lat,
            'long'=>$request->long,
            'area'=>$request->area
            ]];
        $input['password']=Hash::make($input['password']);

        $user=User::create($input);
       $user->assignRole('Customer');
        $token['token']=$user->createtoken('yaya yoyo yeye')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token,
        ];
        return BaseController::sendResponse($response,'user registed successfully');
    }

    public function companyregister(CompanyRegisterRequest $request)
    {

        abort_if(Gate::denies('company_create'), 403);
        $input = $request->validated();
        $rate = 1;
        $company = Compane::create([
            'name' => $request->name,
            'rate' => $rate,
            'location' => [
                'lat' => $request->lat,
                'long' => $request->long,
                'area' => $request->area
            ],

            'phone' => $request->phone,
            'active' => $request->active,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($request->hasFile('logo')){
            $file = $request->file('logo');
        $filefirstname = substr($file->getClientOriginalName(), 0, -5);
        $extension = $file->getClientOriginalExtension();
        $filename = $filefirstname . time() . '.' . $extension;
        $file->move('storage/Uploads/CompanyLogo', $filename);
        $company->update(['logo'=>"storage/Uploads/CompanyLogo/".$filename]);
    }
        $company->assignRole('Company');
        $token['token']=$company->createtoken('yaya yoyo yeye')->plainTextToken;
        $response=[
            'company'=>$company,
            'token'=>$token,
        ];
        return BaseController::sendResponse($response,'Company registed successfully');
    }

    public function teamregister(TeamRegisterRequest $request)
    {
        abort_if(Gate::denies('team_create'), 403);

        $input=$request->validated();
        $input['password']=Hash::make($input['password']);

        $team=Team::create([
            'name'=>$request->name,
            'location'=>[
                'lat'=>$request->lat,
                'long'=>$request->long,
                'area'=>$request->area
                ],
                'rate'=>$request->rate,
            'available'=>$request->available,
            'active'=>$request->active,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'FinishAt'=>$request->FinishAt,
            'company_id'=>Auth::id(),
            'password' => Hash::make($request->password),

        ]);

        $team->assignRole('Team');
        $token['token']=$team->createtoken('yaya yoyo yeye')->plainTextToken;
        $response=[
            'team'=>$team,
            'token'=>$token,
        ];
        return BaseController::sendResponse($response,'Team registed successfully');
    }

    public function login(LoginRequest $request){
        $user = User::where('email',$request->email)->first();

        if($user){
            if(! Hash::check($request->password , $user->password)){
                return BaseController::sendError("wrong password");
            }else{
                $token['token'] = $user->createtoken('yaya yoyo yeye')->plainTextToken;
                $response=[
                    'user'=>$user,
                    'token'=>$token,
                    'Role'=>$user->getRoleNames(),
                ];
                return BaseController::sendResponse($response,"you logged in");
            }

        }

        $compane = Compane::where('email',$request->email)->first();

        if($compane){
            if(! Hash::check($request->password , $compane->password)){
                return BaseController::sendError("wrong password");
            }else{
                $token['token'] = $compane->createtoken('yaya yoyo yeye')->plainTextToken;
                $response=[
                    'compane'=>$compane,
                    'token'=>$token,
                    'Role'=>$compane->getRoleNames(),
                ];
                return BaseController::sendResponse($response,"you logged in");
            }

        }

        $team = Team::where('email',$request->email)->first();

        if($team){
            if(! Hash::check($request->password , $team->password)){
                return BaseController::sendError("wrong password");
            }else{
                $token['token'] = $team->createtoken('yaya yoyo yeye')->plainTextToken;
                $response=[
                    'team'=>$team,
                    'token'=>$token,
                    'Role'=>$team->getRoleNames(),
                ];
                return BaseController::sendResponse($response,"you logged in");
            }

        }
        else{
            return BaseController::sendError("No such Email");
        }
    }

    public function grant(Request $request)
    {

        $user = User::with('roles')->where('id','!=',1)->findOrFail($request->user_id);
        $user->removeRole('Customer');
        $user->assignRole($request->role);
        return BaseController::sendResponse($user,'Role granted sussesfully');
    }

    public function index(){
        $per=Role::with('permissions')->paginate(1);
        return BaseController::sendResponse($per,'Permissions');


    }

}
