<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Type;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Http\Resources\DeviceResource;



use Gate;

class DeviceController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('devices_access'), 403);
        $per =  $request->per;
        $devices=Device::with('types')->paginate( $perPage = $per, $columns = ['*']);
        return BaseController::sendResponse(DeviceResource::collection($devices)->response()->getData(true),
        'Devices Sent successfully');
    }

    public function store(StoreDeviceRequest $request)
    {
        abort_if(Gate::denies('device_create'), 403);


        $file          = $request->file('image');
        $filefirstname = substr($file->getClientOriginalName(),0,-5);
        $extension     = $file->getClientOriginalExtension();
        $filename      = $filefirstname.time().'.'.$extension;
        $file->move('storage/Uploads/Devices',$filename);

        $device=Device::create([
            'name'=>$request->name,
            'image'=>"storage/Uploads/Devices/".$filename,
            'voltage'=>$request->voltage,
            'voltagePower'=>$request->voltagePower,
            'FazesNumber'=>$request->FazesNumber,
        ]);


        $device->types()->attach($request->type_id);

        return BaseController::sendResponse(new DeviceResource($device
        ->load('types')),
        'Device Created Successfully');


    }

    public function show(Device $device)
    {
        abort_if(Gate::denies('device_show'), 403);
        return BaseController::sendResponse($device->load('types'),
        'Device sent successfully ');
    }

    public function update(UpdateDeviceRequest $request, Device $device)
    {
        abort_if(Gate::denies('device_update'), 403);
        if($request->hasFile('image')){
            unlink(public_path($device->image));
            $file=$device->image=$request->file('image');
            $filefirstname = substr($file->getClientOriginalName(),0,-5);
            $extension     = $file->getClientOriginalExtension();
            $filename      = $filefirstname.time().'.'.$extension;
            $file->move('storage/Uploads/Devices',$filename);
        }
        $device->update($request->validated()+
        ['image'=>"storage/Uploads/Devices/".$filename]);
        return BaseController::sendResponse(new DeviceResource($device
         ->load('types')),
        'Device Updated successfully');
    }

    public function destroy(Device $device,Type $type)
    {
        abort_if(Gate::denies('device_delete'), 403);
        $device->delete();
        return BaseController::sendResponse($device,
        'Device Deleted successfully');


    }
}
