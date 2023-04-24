<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;
use App\Http\Resources\FeatureResource;
use Gate;



class FeatureController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('features_access'), 403);
        $features=Feature::with('categore')->paginate($perPage = $request->per,$columns = ['*']);
        return BaseController::sendResponse(FeatureResource::collection($features)
            ->response()->getData(true),
        'Features sent successfully');
    }

    public function show(Feature $feature)
    {
        abort_if(Gate::denies('feature_show'), 403);
        return BaseController::sendResponse(new FeatureResource($feature
         ->load('categore','features')),
        'Feature with category sent successfully');
    }

    public function store(StoreFeatureRequest $request, Feature $feature)
    {


        abort_if(Gate::denies('feature_create'), 403);
        $feature=Feature::create($request->validated());
        return BaseController::sendResponse(new FeatureResource($feature
        ->load('categore')),
        'Feature Created successfully');

    }

    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        abort_if(Gate::denies('feature_update'), 403);
        $feature->update($request->validated());
        return BaseController::sendResponse(new FeatureResource($feature
        ->load('categore')),
        'Feature Updated successfully');
    }

    public function destroy(Feature $feature)
    {
        abort_if(Gate::denies('feature_delete'), 403);
        $feature->delete();
        return BaseController::sendResponse($feature,'Feature Deleted successfully');
    }

    public function search(Request $request){
        abort_if(Gate::denies('feature_search'), 403);

     $feature=Feature::where('name','like',"%{$request->name}%")->get();
     if($feature ==null){
         return BaseController::sendError('No Such Feature');  }
     return BaseController::sendResponse($feature,'In Feature');
        }
}
