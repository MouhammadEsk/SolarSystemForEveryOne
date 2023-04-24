<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Team;
use App\Http\Resources\AppointmentResource;
use App\Http\Requests\UpdateAppointmentStatus;
use Illuminate\Support\Facades\Auth;
use Gate;
use Carbon\Carbon;
use App\Http\QueryPipelines\AppointmentPipeline\AppointmentPipeline;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('appointments_access'), 403);
        $per = $request->per;
        $appointments = Appointment::with('compane', 'order', 'team')->paginate($perPage = $per, $columns = ['*']);
        return BaseController::sendResponse(AppointmentResource::collection($appointments)
            ->response()->getData(true),
            'Appointments Sent Succesfully');
    }

    public function team(Request $request){
        $appointment = Appointment::with(['order'=>function($q){
            $q->select('id');
        }])
            ->where('team_id',$request->team_id)
            ->get()
            ->MakeHidden(['created_at','updated_at']);
        return BaseController::sendResponse($appointment,'All Team Appointment');
    }

    public function filter(Request $request){
        $per = $request->per;
        $appointments = AppointmentPipeline::make(
            builder: Appointment::query(),
            request:$request)->paginate($perpage = $per ,$columns = ['*']);
        return AppointmentResource::collection($appointments
        ->load('order'));

    }

    public function store(StoreAppointmentRequest $request){
          $order = Order::create([
              'total_voltage'=>0,
              'total_price'=>0,
              'hours_on_charge'=>0,
              'hours_on_bettary'=>0,
              'space'=>0,
              'location' =>[
                  'lat'=>$request->lat,
                  'long'=>$request->long,
                  'area'=>$request->area],
              'user_id' => Auth::id(),
          ]);
        $appointment = Appointment::create([
            'type'=>'maintenance',
            'status'=>'pending',
            'startTime'=>$request->startTime,
            'finishTime'=>Carbon::parse($request->startTime)->addDay(),
            'team_id'=>$request->team_id,
            'compane_id'=>$request->compane_id,
            'order_id'=>$order->id
        ]);
        $team = Team::find($request->team_id);
        $team->update(['FinishAt' =>Carbon::parse($request->startTime)->addDay(),'available',0]);
        return BaseController::sendResponse(new AppointmentResource($appointment
        ->load('team','compane','order.user')),'Maintenance Appointment Created Succesfully');
      }

    public function show(Appointment $appointment)
    {
        $f =$appointment->order()->first();
        abort_if(Gate::denies('appointment_show'), 403);
        return BaseController::sendResponse(new AppointmentResource($appointment
        ->load('compane','team','order','order.user'))
        ,'Appointment Sent Succesfully');

    }

    public function destroy(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_delete'), 403);
        $appointment->delete();
        return BaseController::sendResponse(new AppointmentResource($appointment),'Appointment Deleted Succesfully');
    }

    public function CompanyAppointment(Request $request){
        $appointment = Appointment::with('compane')
        ->where('compane_id',Auth::id())
        ->where('team_id',$request->team_id)->get();
        return BaseController::sendResponse(AppointmentResource::collection($appointment
        ->load('team')),
        'Company Appointment Sent Succesfully');
    }

    public function TeamAppointment(Request $request){
        $appointment = Appointment::with('compane')
            ->where('team_id', Auth::id())->get();
        return BaseController::sendResponse(AppointmentResource::collection($appointment
        ->load('compane','team','order')),
        'Team Appointment Sent Succesfully');
    }

    public function InstallationAppointment(Appointment $appointment,Request $request){
        if(Auth::user()->hasRole('Team')){
         $appointment->update([
             'type'=>'detection',
             'days'=>$request->days,
             'startTime'=>"0001-01-01"]);
         return BaseController::sendResponse(new AppointmentResource($appointment
         ->load('team')),
         'Appointment  Days Updated Succesfully');
        }
        elseif (Auth::user()->hasRole('Company')){
            $appointment->update([
                'type'=>'installation',
                'days'=>$request->days,
                'startTime'=>"0001-01-01"]);
            return BaseController::sendResponse(new AppointmentResource($appointment
                ->load('team')),
                'Appointment  Days Updated Succesfully');
        }else{
            return BaseController::sendError(403,'Token invalid');
        }
    }

    public function UpdateFinishTime(Appointment $appointment,Request $request){
        $appointment->update(['finishTime'=>$request->finishTime]);
        return BaseController::sendResponse(new AppointmentResource($appointment),
        'Finish Time Updated Succesfully');
    }

    public function OrderStatus(Appointment $appointment,UpdateAppointmentStatus $request)
    {
            $appointment->update(['status'=>$request->status]);
            return BaseController::sendResponse(new AppointmentResource($appointment),
            'Order Status Updated Succesfully');
    }

    public function UpdateAppointment(Appointment $appointment, UpdateAppointmentRequest $request){
        $days = $appointment->days;
        $appointment->update([
            'startTime'=>$request->startTime,
            'team_id'=>$request->team_id]);
        $team = Team::find($appointment->team_id);
        $appointment->update(['finishTime' =>Carbon::parse($appointment['startTime'])->addDay($days)]);
        $team->update(['FinishAt' =>Carbon::parse($appointment->finishTime),'available',0]);
        return BaseController::sendResponse(new AppointmentResource($appointment
        ->load('team')),'Appointment Updated Succesfully ');
    }


}
