<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Services\CalculationService;
use App\Http\Services\PanelCalcService;
use App\Models\Feature;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Team;
use App\Models\Compane;
use App\Models\OrderProduct;
use App\Models\DeviceOrder;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Gate;
use Carbon\Carbon;
use App\Http\Controllers\ProductController;


class OrderController extends Controller
{

    public function index(Request $request)
    {
        $per =  $request->per;
        abort_if(Gate::denies('orders_access'), 403);
        $orders = Order::with('user','OrderProduct','DeviceOrder')->paginate( $perPage = $per, $columns = ['*']);
        return BaseController::sendResponse(
            OrderResource::collection($orders)
                ->response()->getData(true),
                'Orders Sent Succesfully'
        );
    }

    public function available(Request $request)
    {
        $company = Compane::where('id',$request->company_id)->where('active',1)->first();
        $teams= Team::where('active',1)->where('location->area',$request->area)->first();
        if($teams) {
            if ($company) {
                if ($teams->available == 1) {
                    $times = $company->teams()->where('active', 1)->get(['FinishAt AS Time', 'id']);
                    return BaseController::sendResponse($times, 'Available  dd Times And this teams is Active');
                }
                $team = Team::where('active', 1)->orderby('FinishAt', 'DESC')->get(['FinishAt AS Time', 'id']);
                return BaseController::sendResponse($team, 'Available Times And This Teams Is Active');
            }
            return BaseController::sendError("Invalid Company ID");
        }
            return BaseController::sendError('There IS No In This Area');

    }

    public function store(StoreOrderRequest $request, Order $order)
    {
        abort_if(Gate::denies('order_create'), 403);
        $order = Order::create([
            'total_voltage' => $request->order['total_voltage'],
            'total_price' => $request->order['total_price'],
            'hours_on_charge' => $request->order['hours_on_charge'],
            'hours_on_bettary' => $request->order['hours_on_bettary'],
            'space' => $request->order['space'],
            'location' =>[
                'lat'=>$request->order['lat'],
                'long'=>$request->order['long'],
                'area'=>$request->order['area']
            ],
            'user_id' => Auth::id(),
        ]);

        foreach ($request->products as $product) {
            $Product = OrderProduct::create([
                'product_id' => $product['product_id'],
                'order_id' => $order->id,
                'ammount'  => $product['ammount']
            ]);
        }

        foreach ($request->devices as $device) {
            $Device = DeviceOrder::create([
                'device_id' => $device['device_id'],
                'order_id' => $order->id,
                'ammount'  => $device['ammount']
            ]);
        }


        $team = Team::find($request->team_id);
        $StartDate =Carbon::parse($request->appointment['startTime']);
        $TeamFin = $team->FinishAt;
        if($StartDate->gte($TeamFin)){
                $appointment = Appointment::create([
                    'startTime' => $request->appointment['startTime'],
                    'finishTime' => Carbon::parse($request->appointment['startTime'])->addDay(),
                    'team_id' => $request->team_id,
                    'order_id' => $order->id,
                    'compane_id' => $request->appointment['compane_id']]);
                $team->update(['FinishAt' =>Carbon::parse($request->appointment['startTime'])->addDay(),'available',0]);
                    return BaseController::sendResponse(
                        new OrderResource($order
                        ->load('appointment')),
                        'Order Created Succesfully');
        }
                return BaseController::sendError('This Date Is Invalid');
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), 403);
        return BaseController::sendResponse(new OrderResource($order
                ->load('OrderProduct.product',
                        'OrderProduct.product.features',
                        'OrderProduct.product.categore',
                        'DeviceOrder.device',
                        'appointment.compane.feedbacks',
                        'user',
                        'appointment.team',
                    )), 'Order Sent Succesfully');
    }

    public function update(UpdateOrderRequest $request, Order $order, OrderProduct $s)
    {
        abort_if(Gate::denies('order_update'), 403);
        $order->update([
            'total_voltage' => $request->order['total_voltage'],
            'total_price' => $request->order['total_price'],
            'hours_on_charge' => $request->order['hours_on_charge'],
            'hours_on_bettary' => $request->order['hours_on_bettary'],
            'space' => $request->order['space'],
            'location' => [
                'lat' => $request->order['lat'],
                'long' => $request->order['long'],
                'area' => $request->order['area']

            ],
        ]);

        $products = $order->OrderProduct()->get();
        $products->each->delete();

        $devices = $order->DeviceOrder()->get();
        $devices->each->delete();

        foreach ($request->products as $product) {
            $Product = OrderProduct::create([
                'product_id' => $product['product_id'],
                'order_id' => $order->id,
                'ammount'  => $product['ammount']
            ]);
        }

        foreach ($request->devices as $device) {
            $Device = DeviceOrder::create([
                'device_id' => $device['device_id'],
                'order_id' => $order->id,
                'ammount'  => $device['ammount']
            ]);
        }
        return BaseController::sendResponse(new OrderResource($order
        ->load('user','OrderProduct','DeviceOrder')), 'Order Updated Succesfully');
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), 403);
        $order->delete();
        return BaseController::sendResponse($order, 'Order Deleted Succesfully');
    }

    public function calculateBatteryNumber(Request $request)
    {
        $companies = Compane::with('products')->where('active',1)->whereHas('teams', function ($q) use ($request) {
            $q->where('active',1)->where('location->area', $request->area);
        })->get();
        $data = [];
        foreach ($companies as $companie) {
            $batteries = $companie->products()->where('categore_id', 4)->limit(5)->get();
            $panels = $companie->products()->where('categore_id', 2)->limit(5)->get();
            $inverters = $companie->products()->where('categore_id', 3)
                ->whereHas('features', function ($q) use ($request) {
                    $q->where('feature_id', 5)->where('value', '>=' ,(int)$request->InverterWatt);
                })->get();

            $batteryRes = ['data' => ProductResource::collection($batteries->load('companes'))];
            $panelRes =   ['data' => ProductResource::collection($panels->load('companes'))];

            $service = new CalculationService($request->totalWhatt, $request->day_automation, $batteryRes, $panelRes, $request->sunAvgHours);
            $numberOfBatteries = $service->getNumberOfBattares();
            foreach ($batteries as $key => $item) {
                $item->battery_amount = $numberOfBatteries['bat'][$key];
            }

            foreach ($panels as $key => $item) {
                $item->panel_amount = $numberOfBatteries['panal'][$key];
            }

            $data[] = [
                'batteries' => ProductResource::collection($batteries),
                'panels' => ProductResource::collection($panels),
                'inverters' => ProductResource::collection($inverters->load('companes','features')),
            ];
        }
        return $data;
    }
}
