<?php

namespace App\Http\Controllers;

use App\Models\Categore;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;



use Gate;

class CategoreController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('categories_access'), 403);
        $category=Categore::paginate($per = $request->per);
        return BaseController::sendResponse(CategoryResource::collection($category)
         ->response()->getData(true),
        'Categories sent successfully');
    }

    public function show(Categore $category,Request $request)
    {
        abort_if(Gate::denies('category_show'), 403);
        $category=Categore::with('features')->where('id',$request->category_id)->get();
        return BaseController::sendResponse($category,
        'Category with features sent successfully');
    }

    public function store(StoreCategoryRequest $request, Categore $category)
    {
        abort_if(Gate::denies('category_create'), 403);

        $category=Categore::create($request->validated());
        return BaseController::sendResponse(new CategoryResource($category),
        'Category Created successfully');
    }

    public function update(UpdateCategoryRequest $request, Categore $category)
    {
        abort_if(Gate::denies('category_update'), 403);
        $category->update($request->validated());
        return BaseController::sendResponse(new CategoryResource($category),
        'Categore Updated successfully');
    }

    public function destroy( Categore $category)
    {
        abort_if(Gate::denies('category_delete'), 403);
        $category->delete();
        return BaseController::sendResponse($category,'Category Deleted successfully');

    }

    public function products(Request $request){
    $category=Categore::where('id',$request->id)->get();
    return BaseController::sendResponse(CategoryResource::collection($category
    ->load('products.features','products.companes')),
    'Category With Products Sent Successfully ');
    }

}
