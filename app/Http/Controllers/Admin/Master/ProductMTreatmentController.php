<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductMTreatment as Model;
use App\Http\Requests\Master\Treatment as req;
use Session;
class ProductMTreatmentController extends Controller
{
   
   public function index(){
       
     $data=Model::all()->sortBy('treatment');

     return view('admin.amaster.treatment.index',compact('data'));


      }

      public function store(Request $request){
      
       $validatedData = $request->validate([
        'treatment' => "required|unique:product_m_treatments",
        'description' => "required|unique:product_m_treatments",
    ]);

      
        $obj=new Model();
       $obj->treatment=$request->treatment;
       $obj->description=$request->description;
       $obj->save();

       //log history      
       $obj->masterIds()->create([
       'created_id' => auth('admin')->user()->id
        ]);
        Session::flash("success"," Record Saved.");
       return back();

      }

      protected function treatmentNameExist($name){
      // dd("treatmet Name");
        $flag=0;
          $treatment_del=Model::where(['treatment'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($treatment_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {


          $treatmet_res=Model::where(['treatment'=>$name]);
          if($treatmet_res->exists())
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
        
       protected function treatmentDescExist($name){
      // dd("treatmet Desc");
        $flag=0;

          $treatment_del=Model::where(['description'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($treatment_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {

          $treatmet_res=Model::where(['description'=>$name]);
          if($treatmet_res->exists())
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

      protected function treatmentNameExistEdit($id,$name){
          // dd("treatment edit name");
           $flag=0;
  
              $treatment_edit_del=Model::where(['treatment'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

      
          if($treatment_edit_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{



        $treat_edit=Model::where(['id'=>$id,'treatment'=>$name]);

        if($treat_edit->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $treat_edit=Model::where(['treatment'=>$name]);

             if($treat_edit->exists())
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

      protected function treatmentDescExistEdit($id,$name){
         // dd("treatment edit desc");

        $flag=0;

          $treatment_edit_del=Model::where(['description'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

      
          if($treatment_edit_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{

        $treat_edit=Model::where(['id'=>$id,'description'=>$name]);

        if($treat_edit->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $treat_edit=Model::where(['description'=>$name]);

             if($treat_edit->exists())
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
    

           $treatment_id=$request->id;  // get color  id

          // validation is part

         $validatedData = $request->validate([

        'treatment' => "required|unique:product_m_treatments,treatment,$treatment_id",
        'description' => "required|unique:product_m_treatments,description,$treatment_id",
    ]);

     $treatment = Model::where(['id'=>$request->id])->first();
     $treatment->update(['treatment'=>$request->treatment,'description'=>$request->description]);
       $treatment->masterIds()->create([
                  'updated_id' => auth('admin')->user()->id
                ]);   

     Session::flash("success"," Record Updated.");

        	return back();

      }

      public function status($id, $status){
       
       //dd($id);
       if($status==1)
       {
       	$status=0;

       }
       else
       {
       	$status=1;
       }

        Model::find($id)->update(['status'=>$status]);
        	return back();
      }

      public function destroy($id)
      {
          $status=0;
        Model::find($id)->update(['status'=>$status]);
        Model::where('id', $id)->delete();  
        Session::flash("error"," Record Deleted.");     
        return back();

      
      }




}
