<?php

namespace App\Http\Controllers;

use App\Models\Compane;
use App\Models\Order;
use App\Models\Product;
use App\Models\Team;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('customers_access'), 403);
        $per =  $request->per;
        $users=User::Role('Customer')->paginate($perPage = $per, $columns = ['*']);
        return BaseController::sendResponse($users
        ,'Customers Sent Successfully');
    }

    public function show(User $user)
    {
         abort_if(Gate::denies('customer_show'), 403);
        return BaseController::sendResponse($user,'User sent Successfully');

    }

    public function userToken(User $user)
    {
         $user = User::where('id',Auth::id())->first();
        return BaseController::sendResponse($user,'User sent Successfully');

    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('customer_delete'), 403);
        $user->delete();
        return BaseController::sendResponse($user,'User Deleted Successfully');

    }

    public function orders()
    {
        abort_if(Gate::denies('order_user'), 403);
        $orders=User::with('order')
            ->where('id',Auth::id())
            ->get();
        return BaseController::sendResponse(UserResource::collection($orders
        ->load('order.appointment','order.appointment.compane')),'Orders Sent Successfully');
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

    public function editprofile(UpdateUserRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated()+
        ['location'=>[
                'lat'=>$request->lat,
                'long'=>$request->long,
                'area'=>$request->area,
            ]]);
        return BaseController::sendResponse(new UserResource($user),
        'Customer Updated Successfully');
    }

    public function survey(){
        $products = Product::all()->count();
        $companies = Compane::all()->count();
        $users = User::all()->count();
        $teams = Team::all()->count();
        $orders = Order::all()->count();

        return [
                "OurProduct"=>$products,
                "OurCompanies"=>$companies,
                "OurUsers"=>$users,
                "OurTeams"=>$teams,
                "OurOrders"=>$orders
        ];
    }
}
