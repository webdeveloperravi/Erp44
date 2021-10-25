<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductMClarity as Clarity;
use App\Model\Admin\Setting\Module;
use Route;
use Session;


class ProductMClarityController extends Controller

{
    
     public function index(){
               $name = Route::currentRouteName();  
               $meta_title=Module::where(['route'=>$name])->first();
              $data = Clarity::select('id','clarity','alias','descr','parent_sort','status')->get();
            	return view('admin.amaster.clarity.index',compact('data','meta_title'));
        }

    

        public function store(Request $request){

        	 $validatedData = $request->validate([
        'clarity' => "required|unique:product_m_clarities",
        'alias' => "required|unique:product_m_clarities",
    ]);
            
           // to fetch parent_sort Max Value
           $parentsort_value=Clarity::latest()->value('id'); 
           if($parentsort_value=='')
           {
             $flag=1;
           } 
           else
           {
            $flag=$parentsort_value+1;
           }
          

            $obj  = new Clarity;
        	$obj->clarity = $request->clarity;
        	$obj->alias = $request->alias;
         $obj->descr = $request->desc;
          $obj->parent_sort=$flag;
        	$obj->save();

          $obj->masterIds()->create([
            'created_id' => auth('admin')->user()->id
          ]);

             Session::flash("success"," Record Saved.");
        	return back();
        }


        public function update(Request $request){
        
          $clarity_id=$request->id;  // get color  id

        

         // validation is part

         $validatedData = $request->validate([

        'clarity' => "required|unique:product_m_clarities,clarity,$clarity_id",
        'alias' => "required|unique:product_m_clarities,alias,$clarity_id",
    ]);
        
        	$clarity = Clarity::where(['id'=>$request->id])->first();
          $clarity->update(['clarity'=>$request->clarity,'alias'=>$request->alias,'descr'=>$request->desc]);
          
          $clarity->masterIds()->create([
            'updated_id' => auth('admin')->user()->id
          ]);

           Session::flash("success"," Record Updated.");
        	return back();

        }

     protected function clarityExist($name){
       
          $flag=0;

          $clarity_del=Clarity::where(['clarity'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($clarity_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else{


          $clarity_res=Clarity::where(['clarity'=>$name]);
          if($clarity_res->exists())
          {
              $flag=1;
            return response()->json($flag);
          }
          else
          {
            $flag=0;
           return response()->json($flag);
          }

         } 

     }

     protected function aliasExist($name){
     
        $flag=0;

       $clarity_as_del=Clarity::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($clarity_as_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else{


          $clarity_res=Clarity::where(['alias'=>$name]);
          if($clarity_res->exists())
          {
              $flag=1;
            return response()->json($flag);
          }
          else
          {
            $flag=0;
           return response()->json($flag);
          }

         } 
     }

     protected  function clarityEditExist($id,$name){
        
        $flag=0;

          $clarity_del=Clarity::where(['clarity'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

      
          if($clarity_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{



        $clarity_edit=Clarity::where(['id'=>$id,'clarity'=>$name]);

        if($clarity_edit->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $clarity_edit=Clarity::where(['clarity'=>$name]);

             if($clarity_edit->exists())
             {
                $flag=1;
                return response()->json($flag);
             }
             else
             {
                $flag=2;

                return response()->json($flag);
             }
             $flag=0;
        }

     }

}

     protected function aliasEditExist($id,$name){
       $flag=0;

         $clarity_del=Clarity::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

      
          if($clarity_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{






        $clarity_edit=Clarity::where(['id'=>$id,'alias'=>$name]);

        if($clarity_edit->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $clarity_edit=Clarity::where(['alias'=>$name]);

             if($clarity_edit->exists())
             {
                $flag=1;
                return response()->json($flag);
             }
             else
             {
                $flag=2;

                return response()->json($flag);
             }
             $flag=0;
        }

     }

}

     protected function parentSort(Request $request){
          $psort=$request->parent_id;
           $parentsort=1;
       
        foreach ($psort as $ps_key => $ps_val) {
      
          Clarity::where(['id'=>$ps_val])->update(['parent_sort'=>$parentsort]);
          $parentsort++;
    }

    return response()->json(["success"=>"Parent Sort Updated"]);
   }


        public function status($id, $status){


        	if($status==1){
        		$status =0;
        	}else{
        		$status = 1;
        	}
        	
          Clarity::find($id)->update(['status'=>$status]);
          Session::flash("warning"," Status Changed.");  	
        	return back();
        }

        public function destroy($id){
          
          
        Clarity::find($id)->update(['status'=>$status]);
    
             Session::flash("warning"," Status Changed.");  	
    		return back();
        }




}
