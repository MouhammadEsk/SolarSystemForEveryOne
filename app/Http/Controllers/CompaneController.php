<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\CompanySurveyResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Models\Compane;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CompanyResource;
use App\Http\Requests\UpdateCompanyActiveRequest;
use Gate;
use Illuminate\Support\Facades\Hash;

class CompaneController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('companies_access'), 403);

        $per =  $request->per;
        $compane=Compane::paginate( $perPage = $per, $columns = ['*']);;
        return BaseController::sendResponse($compane,'Companeies sent successfully');

    }

    public function indexUser(Request $request)
    {
        abort_if(Gate::denies('companies_access'), 403);
        $per =  $request->per;
        $compane=Compane::where('active',1)->paginate( $perPage = $per, $columns = ['*']);;
        return BaseController::sendResponse($compane,'Companeies sent successfully');
    }

    public function show(Compane $compane)
    {
        abort_if(Gate::denies('company_show'), 403);
        return BaseController::sendResponse(new CompanyResource($compane
            ->append('email','location','logo','phone','active')
            ->load('teams','appointment','products')),
            'Company sent successfully ');
    }

    public function update(UpdateCompanyRequest $request, Compane $compane)
    {
        abort_if(Gate::denies('company_update'), 403);
        $compane->update($request->validated()+
        ['location'=>[
            'lat'=>$request->lat,
            'long'=>$request->long,
            'area'=>$request->area,
            ]]);
        if($request->hasFile('logo')){
            $file=$compane->logo=$request->file('logo');
            $filefirstname = substr($file->getClientOriginalName(),0,-5);
            $extension     = $file->getClientOriginalExtension();
            $filename      = $filefirstname.time().'.'.$extension;
            $file->move('storage/Uploads/CompanyLogo',$filename);
            $compane->update(['logo'=>"storage/Uploads/CompanyLogo/".$filename]);
        }
        return BaseController::sendResponse($compane,'Company Updated successfully');
    }

    public function destroy(Compane $compane)
    {
        abort_if(Gate::denies('company_delete'), 403);
        $compane->products()->delete();
        $compane->delete();
        return BaseController::sendResponse($compane,'Company Deleted successfully');

    }

    public function search(Request $request){
        abort_if(Gate::denies('company_search'), 403);

     $compane = Compane::where('name','like',"%{$request->name}%")->get();
     if($compane ==null){
         return BaseController::sendError('No Such Company');  }
     return BaseController::sendResponse($compane,'In Company');
        }

    public function teams(){
        abort_if(Gate::denies('teams_access'), 403);
            $company=Compane::with('teams')->where('id','=',Auth::id())->get();
            return BaseController::sendResponse($company,'Company Teams ');

        }

    public function feedbacks(){
            abort_if(Gate::denies('feedbacks_show'), 403);
            $compane=Compane::where('id','=',Auth::id())->get();
            return BaseController::sendResponse(CompanyResource::collection($compane
            ->load('feedbacks.user')),
            'Company Feedbacks ');
        }

    public function productToken(Request $request){
            $products=Compane::where('id',Auth::id())->get();
            return BaseController::sendResponse(CompanyResource::collection($products
            ->load('products.categore','products.features')),
             'Products Sent Successfully');
    }

    public function productID(Request $request){
        $products=Compane::with('products')->where('id',$request->company_id)->get();
        return BaseController::sendResponse(CompanyResource::collection($products
            ->append(['location','email','phone','logo','active'])
            ->load('products.categore','products.features')),
           'Products Sent Successfully');
}

    public function active(Compane $company, UpdateCompanyActiveRequest $request){
        $company->update(['active'=>$request->active]);
        return BaseController::sendResponse($company,'Company Active Has Been Updated successfully');
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

    public function survey(Request $request){
        if($request->company_id > 0){
        $survey = Compane::where('id',$request->company_id)->first();
        return BaseController::sendResponse(new CompanySurveyResource($survey
            ->load('teams','appointment','products')),
            'Survey Of This Company');
        }else{
            $survey = Compane::where('id',Auth::id())->first();
            return BaseController::sendResponse(new CompanySurveyResource($survey
                ->load('teams','appointment','products')),
                'Survey Of This Company');
        }
    }

    public function appointment(){
        $company = Compane::with('appointment')->where('id',Auth::id())->get();
        return BaseController::sendResponse($company,'Company Appointment Sent Successfully');
    }
    public function companyByToken(){
        $company = Compane::where('id',Auth::id())->first();
        return BaseController::sendResponse(new CompanyResource($company
        ->append(['location','email','phone','logo','active'])),
            'Company Sent Successfully');
    }
}
