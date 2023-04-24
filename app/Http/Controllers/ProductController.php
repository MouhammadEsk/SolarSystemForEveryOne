<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Feature;
use App\Models\Compane;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;
use Gate;

class ProductController extends Controller
{
    public function index(Request $request){
        abort_if(Gate::denies('products_access'), 403);
        $per =  $request->per;
        $products=Product::with('categore','companes','features')->paginate( $perPage = $per, $columns = ['*']);
        return BaseController::sendResponse(ProductResource::collection($products)->response()->getData(true),
         'Products Sent Successfully');
    }

    public function store(StoreProductRequest $request)
    {

        abort_if(Gate::denies('product_create'), 403);
        $file          = $request->file('image');
        $filefirstname = substr($file->getClientOriginalName(),0,-5);
        $extension     = $file->getClientOriginalExtension();
        $filename      = $filefirstname.time().'.'.$extension;
        $file->move('storage/Uploads/Products',$filename);
        $product=Product::create([
            'name'=>$request->name,
            'image'=>"storage/Uploads/Products/".$filename,
            'price'=>$request->price,
            'categore_id'=>$request->categore_id,
            'available'=>$request->available,
        ]);
        $feature=Feature::where('categore_id',$product->categore_id)->get();
        if(!$request->company_id >0){

            $company_id=Compane::where('id',Auth::id())->first();
            $product->companes()->attach($company_id);
            $product->features()->attach($feature);

        }
        else{
        $product->companes()->attach($request->company_id);
        $product->features()->attach($feature);
    }

        return BaseController::sendResponse(new ProductResource($product
         ->load('features','categore')),'Product Created Successfully');
    }

    public function show(Product $product,Request $request)
    {

        abort_if(Gate::denies('product_show'), 403);
   $product=Product::where('id',$request->id)->get();
   return BaseController::sendResponse(ProductResource::collection($product
    ->load('categore','features','companes'))
    ,'Product With Features Sent Successfully');


    }

//request for updating proooooooooooooooduct
    public function update(ProductUpdateRequest $request,Product $product){

        abort_if(Gate::denies('product_update'), 403);
        if($request->hasFile('image')){
            unlink(public_path($product->image));
            $file=$product->image=$request->file('image');
            $filefirstname = substr($file->getClientOriginalName(),0,-5);
            $extension     = $file->getClientOriginalExtension();
            $filename      = $filefirstname.time().'.'.$extension;
            $file->move('storage/Uploads/Products',$filename);
        }
        $product->update($request->validated()+
        ['image'=>"storage/Uploads/Products/".$filename]);
        return BaseController::sendResponse(new ProductResource($product
        ->load('features','categore','companes')),
        'Product Updated Successfully');
    }

     // request for updaaaaaaaaaaaaaaating features
    public function productFeatureUpdate(UpdateProductRequest $request, Product $product)
        {
           abort_if(Gate::denies('product_update'), 403);
            $product->update($request->validated());
            foreach($request->features as $feature){
                $product->features()->detach($feature['feature_id']);
                $product->features()
                ->attach([$feature['feature_id']
                =>['value' => $feature['value']]]);

                // $product->features()
                // ->sync([$feature['feature_id'] => ['value' => $feature['value']]]);
            }
         return BaseController::sendResponse(new ProductResource($product
         ->load('categore','features','companes')),
         'Product Features Updated Successfully');
        }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), 403);
        $product->delete();
        return BaseController::sendResponse(new ProductResource($product
        ->load('categore','features')),
        'Product Deleted Successfully');
    }
}
