<?php

namespace App\Http\Controllers\Warehouse;

use App\Helpers\StoreHelper;
use Illuminate\Http\Request; 
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\ProductCategory;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Admin\Master\ProductGradeRateProfile;

class ProductStockUpdateController extends Controller
{
    public function index(){
        
        return view('warehouse.ProductStockUpdate.index');
    }

    public function getTimeline($gin)
    {    
        $product = InvoiceDetailGradeProduct::where('gin',$gin)->first();
          
        $products = ProductCategory::find(2)->Product;
        $grades = Product::find($product->product_id)->grade;
        $ratties = ProductMWeightRange::get();
        $colors = Product::find($product->product_id)->colors;
        $clarities = Product::find($product->product_id)->clarity;
        $origins = Product::find($product->product_id)->origin;
        $shapes = Product::find($product->product_id)->shape; 
        $treatments = Product::find($product->product_id)->treatment; 


        $result = StoreHelper::getProductGradeRattiRattiRateMrpAmount2($product);
        if($result){
            $price = $result['mrpAmount'];
        }else{
            $price = "Error";
        }
        if($product){
            return view('warehouse.ProductStockUpdate.view',compact('product','price','products','grades','ratties','colors','clarities','origins','shapes','treatments'));
        }else{
            return view('warehouse.ProductStockUpdate.viewEmpty',compact('product')); 
        } 
    }

    public function update(Request $request)
    {     
        $product = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
        
        if($product){

            if($request->productRadio == 'on'){
                $oldValue = $product->product->name ?? "";
                $product->product_id = $request->product;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Product Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->productGrade->alias ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);

                    //UpdateRateProfileId 
                     $rateProfileId =  ProductGradeRateProfile::where([
                        'product_id' => $product->product_id,
                        'grade_id'=> $product->grade_id,
                        'status'=> 1
                    ])->first()->assignRateProfile->id ?? false; 
                    if($rateProfileId){
                            $product->update(['rate_profile_id' => $rateProfileId]); 
                     } 
                }
            }

            if($request->gradeRadio == 'on'){
                $oldValue = $product->productGrade->alias ?? "";
                $product->grade_id = $request->grade;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Grade Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->productGrade->alias ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);

                    //UpdateRateProfileId 
                     $rateProfileId =  ProductGradeRateProfile::where([
                        'product_id' => $product->product_id,
                        'grade_id'=> $product->grade_id,
                        'status'=> 1
                    ])->first()->assignRateProfile->id ?? false; 
                    if($rateProfileId){
                            $product->update(['rate_profile_id' => $rateProfileId]); 
                     } 
                }
            }

            if($request->rattiRadio == 'on'){
                $oldValue = $product->ratti->rati_standard ?? "";
                $product->ratti_id = $request->ratti;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Ratti Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->ratti->rati_standard ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            }

            if($request->colorRadio == 'on'){
                $oldValue = $product->color->color ?? "";
                $product->color_id = $request->color;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Color Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->color->color ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            }

            if($request->clarityRadio == 'on'){
                $oldValue = $product->clarity->clarity ?? "";
                $product->clarity_id = $request->clarity;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Clarity Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->clarity->clarity ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            }

            if($request->originRadio == 'on'){
                $oldValue = $product->origin->origin ?? "";
                $product->origin_id = $request->origin;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Origin Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->origin->origin ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            }

            if($request->shapeRadio == 'on'){
                $oldValue = $product->shape->shape ?? "";
                $product->shape_id = $request->shape;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Shape Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->shape->shape ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            }

            if($request->treatmentRadio == 'on'){
                $oldValue = $product->treatment->treatment ?? "";
                $product->treatment_id = $request->treatment;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Treatment Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->treatment->treatment ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            }

            if($request->lengthRadio == 'on'){
                $oldValue = $product->length ?? "";
                $product->length = $request->length;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Length Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->length ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            }

            if($request->widthRadio == 'on'){
                $oldValue = $product->width ?? "";
                $product->width = $request->width;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Width Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->width ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            } 

            if($request->depthRadio == 'on'){
                $oldValue = $product->depth ?? "";
                $product->depth = $request->depth;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Depth Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->depth ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            }  

            if($request->weightRadio == 'on'){
                $oldValue = $product->weight ?? "";
                $product->weight = $request->weight;
                $product->save();  
                if($product->wasChanged()){
                    $updatedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first() ?? false;
                    $name = 'Weight Updated';
                    $description ='Old Value : '.$oldValue.' New Value : '.$updatedProduct->weight ?? ""; 
                    $product->logs()->create(['name' => $name ,'description' => $description,'created_by' => auth('warehouse')->user()->id]);
                }
            }  
         return response()->json(['success'=>true, 'msg' => 'Successfully Updated']);        
        }
        return response()->json(['success'=>false, 'msg' => 'Failed']);        

    }
}
