<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductMSpecie as Model;
use Session;

class ProductMSpeicesController extends Controller
{
    //
    public function index(){
        

        	$data = Model::all()->sortBy('speices');
        
        	return view('admin.amaster.species.index', compact('data'));
        }

        

        public function store(Request $request){
            

             $validatedData = $request->validate([
        'speices' => "required|unique:product_m_species",
        'alias' => "required|unique:product_m_species",
    ]);
             
         
        	$obj  = new Model;
        	$obj->speices = $request->speices;
        	$obj->alias = $request->alias;
          $obj->descr = $request->desc;
        	$obj->save();

          //log history
          $obj->masterIds()->create([
          'created_id' => auth('admin')->user()->id
           ]);
           Session::flash("success"," Record Saved.");
        	return back();
        }

     protected function speiceExist($name){
       
          
          $flag=0;
                  
        $speice_del=Model::where(['speices'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($speice_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {


          $speice_res=Model::where(['speices'=>$name]);
          if($speice_res->exists())
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
       $speice_del=Model::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($speice_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {

          $speice_res=Model::where(['alias'=>$name]);
          if($speice_res->exists())
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


 protected  function speiceEditExist($id,$name){
        
        $flag=0;
          $speice_del=Model::where(['speices'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($speice_del->isNotEmpty()){
            $flag=3;
            return response()->json($flag);
          }
          else
          {



        $speice_res=Model::where(['id'=>$id,'speices'=>$name]);

        if($speice_res->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $speice_res=Model::where(['speices'=>$name]);

             if($speice_res->exists())
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
          $speice_del=Model::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($speice_del->isNotEmpty()){
            $flag=3;
            return response()->json($flag);
          }
          else
          {

        $clarity_edit=Model::where(['id'=>$id,'alias'=>$name]);

        if($clarity_edit->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $clarity_edit=Model::where(['alias'=>$name]);

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


        public function update(Request $request){

        	 $speices_id=$request->id;  // get color  id

         // validation is part

         $validatedData = $request->validate([

        'speices' => "required|unique:product_m_species,speices,$speices_id",
        'alias' => "required|unique:product_m_species,alias,$speices_id",
    ]);
        	 $specie = Model::where(['id'=>$request->id])->first();
           $specie->update(['speices'=>$request->speices,'alias'=>$request->alias,'descr'=>$request->desc]);
           
           //log history
           $specie->masterIds()->create([
          'updated_id' => auth('admin')->user()->id
            ]);

          Session::flash("success"," Record Updated.");
        	return back();
        }



        public function status($id, $status){

	        	if($status==1){
	        		$status =0;
	        	}else{
	        		$status = 1;
	        	}
	        	Model::find($id)->update(['status'=>$status]);
        	return back();
        }



        public function destroy($id){

        $status=0;
        Model::find($id)->update(['status'=>$status]);
      	Model::where('id', $id)->delete();  
        Session::flash("error"," Record Deleted.");  	
    		return back();
        }
}
