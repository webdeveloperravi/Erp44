<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Product as Category;
use App\Model\Admin\Master\ProductCategory as ProductType;
use App\Model\Admin\Master\ProductMColour as Color;
use App\Model\Admin\Master\ProductMClarity as Clarity;
use App\Model\Admin\Master\ProductMShape as Shape;
use App\Model\Admin\Master\ProductMOrigin as Origin;
use App\Model\Admin\Master\ProductMGrade as Grade;
use App\Model\Admin\Master\ProductMSpecie as Specie;
use App\Model\Admin\Master\ProductMRi as Ri;
use App\Model\Admin\Master\ProductMSg as Sg;
use App\Model\Admin\Master\ProductMTreatment as Treatment;
use App\Model\Admin\Master\ProductRateProfile as RateProfile;
use App\Model\Warehouse\InvoiceDetailGradeProduct as Item;
use App\Model\Admin\Master\ProductGradeRateProfile as PGRP;
use App\Model\Admin\Master\HSNCode;
use App\Model\Admin\Organization\Unit;
use App\Tag;

class ProductController extends Controller
{
   
    public function index()
    {
        $t = Category::where('parent_id','=',0)->get();
        $n  = Category::find(4);
        $product_cate = ProductType::where('status',1)->orderBy('name','asc')->get();
        $color = Color::where('status',1)->get();
        $clarity = Clarity::where('status',1)->get();
        $shape = Shape::where('status',1)->get();
        $origin = Origin::where('status',1)->get();
        $grade = Grade::where('status',1)->get();
        $specie = Specie::where('status',1)->get();
        $hsn_code = HSNCode::where('status',1)->get();
        $unit= Unit::where('status',1)->get();
        $master['ri'] = Ri::where('status',1)->get();
        $master['sg'] = Sg::where('status',1)->get();
        $master['treatment'] = Treatment::where('status',1)->get();
        $rate_profile=RateProfile::where('status',1)->get();
        $grade_selected=PGRP::where('status',1)->select('id','product_id')->get();
        $cat = Category::where('parent_id',0)->orderBy('name','asc')->get();
      return view('admin.amaster.product.index',compact('cat', 'product_cate', 'color', 'clarity','shape','origin','grade','specie','rate_profile' ,'master','grade_selected','unit','hsn_code' ));
    }

public function assign_category(Request $request) {
      
        $type = $request->type;
       
        if($request->attach){
           foreach ($request->attach as $key => $value) {
                    $category =  Category::find($request->cat_id);
                    $count = $category->{$type}()->where(['categoryables_id'=>$value])
                    ->count();
                    // dd($count);
        if($count==0)
           {
             $category->{$type}()->attach($value);
           }
        }

  }
        if($request->detach){
           foreach ($request->detach as $dkey => $dvalue) {
                   $category =  Category::find($request->cat_id);
                   $count = $category->{$type}()->where(['categoryables_id'=>$dvalue])
                   ->count();
            if($count > 0)
               {
                 $category->{$type}()->detach($dvalue);
                }

                }
            }
            return "Successfully Attach ".$type;
    }

  public function assign_from_to(Request $request){

      
     Category::where('id', $request->cat_id )->update([$request->type =>$request->ids]);
        return "Successfully Attach ".$request->type;
       }

 public function store(Request $request)
    {
        $validatedData = $request->validate([
        'name' => "required|unique:products",
        'alias' => "required",
      ]);
 
        $cat = new Category;
        $cat->type_id = $request->type_id;
        $cat->name = $request->name;
        $cat->alias = $request->alias;
        if(!empty($request['parent_id'])){
                $cat->parent_id = $request->parent_id;
        }
        $cat->save();
        return back();
    }

 public function update(Request $request){
    
 
      $category =  Category::find($request->id)->update(['name'=>$request->name,'alias' =>$request->alias]);
      
        return response()->json(['success'=>true,'message'=>'Successfully Updated']);
    }
}
