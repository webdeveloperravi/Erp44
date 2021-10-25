<?php

namespace App\Http\Controllers\Admin\Master;

use Session;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\WeightRange as req;
use App\Model\Admin\Master\ProductMWeightRange as Model;

class ProductMWeightRangeController extends Controller
{
    
     public function index(){
      
       $data=Model::all();
       
       return view('admin.amaster.weight_range.index', compact('data'));
     }

     public function store(req $request)
     {
     //dd($request->all());  
     $obj= new Model();
     $obj->from=$request->from;
     $obj->to=$request->to;
     $obj->rati_code=$request->rati_code;
     $obj->save();

     
       

      Session::flash("success"," Record Saved.");
     return back();


     }

     public function update(req $request){
       
        //dd($request->all());  
         Model::where(['id'=>$request->id])->update(['from'=>$request->from,'to'=>$request->to,'rati_code'=>$request->rati_code]);

        	return back();

     }
     public function status($id, $status)
     {
          if ($status==1) {
          	$status=0;
          }
          else
          {
          	$status=1;
          }
          Model::find($id)->update(['status'=>$status]);
        	return back();
     }
     public function destroy($id){
      
      Model::where('id', $id)->delete();    	
    		return back();
     }

     public function add_new_weight_range(){
         $weight =  Model::orderBy('id','desc')->first();
          
          if(is_null($weight))
          {

        $obj  =  new Model();
        $obj->from = 0; 
        $obj->to = 110; 
        $obj->rati_standard =' 0';
        $obj->rati_big ='0';
        $obj->carat ='0'; 
        $obj->save();
         return back();
          }

          else
          {
              // from division 

         $from = ($weight->from + 120);
         $to = ($weight->to + 120);

         $from_rati_standard = round($from/120,2);
         $from_rati_big = round($from/180,2);
         $from_carat =round ($from/200,2); 
         
            // to Division
        
         $to_rati_standard = round($to/120,2);
         $to_rati_big = round($to/180,2);
         $to_carat =round ($to/200,2); 

  
            
        
         // To save data
         
           $obj  =  new Model();
           $obj->from = $from; 
           $obj->to = $to; 
          $obj->rati_standard =(int)$to_rati_standard;
          $obj->rati_big =(int)($to_rati_big);
          $obj->carat =(int)($to_carat); 
          $obj->save();

          $obj->masterIds()->create([
            'created_id' => Helper::getAdminId()
           ]);
    
           Session::flash("success"," Record Saved.");
         return back();
      }
  }
}
