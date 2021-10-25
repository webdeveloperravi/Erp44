<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductMSpecie as Model;
use Session;

class ProductMSpeciesController extends Controller
{
    //
    public function index(){
        

        	$data = Model::all()->sortBy('species');
        
        	return view('admin.amaster.species.index', compact('data'));
        }

        

        public function store(Request $request){
            

             $validatedData = $request->validate([
        'species' => "required|unique:product_m_species",
        'alias' => "required|unique:product_m_species",
    ]);
             
         
        	$obj  = new Model;
        	$obj->species = $request->species;
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

     protected function specieExist($name){
       
          
          $flag=0;
                  
        $specie_del=Model::where(['species'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($specie_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {


          $specie_res=Model::where(['species'=>$name]);
          if($specie_res->exists())
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
       $specie_del=Model::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($specie_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {

          $specie_res=Model::where(['alias'=>$name]);
          if($specie_res->exists())
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


 protected  function specieEditExist($id,$name){
        
        $flag=0;
          $specie_del=Model::where(['species'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($specie_del->isNotEmpty()){
            $flag=3;
            return response()->json($flag);
          }
          else
          {



        $specie_res=Model::where(['id'=>$id,'species'=>$name]);

        if($specie_res->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $specie_res=Model::where(['species'=>$name]);

             if($specie_res->exists())
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
          $specie_del=Model::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($specie_del->isNotEmpty()){
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

        	 $species_id=$request->id;  // get color  id

         // validation is part

         $validatedData = $request->validate([

        'species' => "required|unique:product_m_species,species,$species_id",
        'alias' => "required|unique:product_m_species,alias,$species_id",
    ]);
        	 $specie = Model::where(['id'=>$request->id])->first();
           $specie->update(['species'=>$request->species,'alias'=>$request->alias,'descr'=>$request->desc]);
           
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
