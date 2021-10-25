<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductMShape as Model;
use Session;
class ProductMShapeController extends Controller
{
   
     public function index(){
        
        	$data = Model::all()->sortBy('shape');
        	return view('admin.amaster.shape.index', compact('data'));
        }

        

        public function store(Request $request){
    
      
          $validatedData = $request->validate([
        'shape' => "required|unique:product_m_shapes",
        'alias' => "required|unique:product_m_shapes",
      ]);



        	$obj  = new Model;
        	$obj->shape = $request->shape;
        	$obj->alias = $request->alias;
          $obj->descr=$request->desc;
        	$obj->save();
     
          // log history 
          $obj->masterIds()->create([
         'created_id' => auth('admin')->user()->id
           ]);

           Session::flash("success"," Record Saved.");
        	return back();
        }

      
     protected function shapeExist($name){
       
          
          $flag=0;
          
          $shape_del=Model::where(['shape'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

                    if($shape_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {


          $shape_res=Model::where(['shape'=>$name]);
          if($shape_res->exists())
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
       

          $shape_del=Model::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($shape_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {

          $shape_res=Model::where(['alias'=>$name]);
          if($shape_res->exists())
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


 protected  function shapeEditExist($id,$name){
        
        $flag=0;
           

        $shape_del=MOdel::where(['shape'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

      
          if($shape_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{   



        $shape_edit=Model::where(['id'=>$id,'shape'=>$name]);

        if($shape_edit->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $shape_edit=Model::where(['shape'=>$name]);

             if($shape_edit->exists())
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
       

        $shape_del=MOdel::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

      
          if($shape_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{   



        $shape_as_edit=Model::where(['id'=>$id,'alias'=>$name]);

        if($shape_as_edit->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $shape_as_edit=Model::where(['alias'=>$name]);

             if($shape_as_edit->exists())
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

        	
          $shape_id=$request->id;  // get color  id

         // validation is part

         $validatedData = $request->validate([

        'shape' => "required|unique:product_m_shapes,shape,$shape_id",
        'alias' => "required|unique:product_m_shapes,alias,$shape_id",
    ]);

        	$shape = Model::where(['id'=>$request->id])->first();
          $shape->update(['shape'=>$request->shape,'alias'=>$request->alias,'descr'=>$request->desc]);
          
          $shape->masterIds()->create([
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
