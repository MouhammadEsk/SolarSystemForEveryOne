<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Http\Resources\TypeResource;


use Gate;

class TypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('types_access'), 403);
        $types=Type::with('devices')->get();
        return BaseController::sendResponse($types,
        'Types Sent successfully');
    }

    public function store(StoreTypeRequest $request)
    {
        abort_if(Gate::denies('type_create'), 403);

        $type=Type::create($request->validated());
        return BaseController::sendResponse($type,
        'Type Created successfully');
    }

    public function show(Type $type)
    {

        abort_if(Gate::denies('type_show'), 403);
        return BaseController::sendResponse($type
        ->load('devices'),
        'Type sent successfully ');


    }

    public function update(UpdateTypeRequest $request, Type $type)
    {
        abort_if(Gate::denies('type_update'), 403);
        $type->update($request->validated());
        return BaseController::sendResponse($type,
        'Type Updated successfully');

    }

    public function destroy(Type $type,Device $device)
    {
        abort_if(Gate::denies('type_delete'), 403);

        $type->devices()->delete();
        $type->delete();
        return BaseController::sendResponse($type,
        'Type Deleted Successfully');

    }
}
