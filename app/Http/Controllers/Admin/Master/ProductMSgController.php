<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductMSg as Model;
use App\Http\Requests\Master\Sg as req;
use Session;
class ProductMSgController extends Controller
{
    
    public function index()
    {
        $data = Model::all()->sortBy('from');
        return view('admin.amaster.sg.index',compact('data'));
    }

   public function status($id, $status)
   {
   
   
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


      protected function sgFromExist($name){
     //  dd("Sg From");
        $flag=0;
             $sg_del=Model::where(['from'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($sg_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {

   


          $sg_res=Model::where(['from'=>$name]);
          if($sg_res->exists())
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
       protected function sgToExist($name){
      // dd("SG To");
       $flag=0;
   
       $sg_del=Model::where(['to'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($sg_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {
         

          $sg_res=Model::where(['to'=>$name]);
          if($sg_res->exists())
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

      protected function sgFromExistEdit($id,$name){
          
           $flag=0;

    $sg_edit_del=Model::where(['from'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

       if($sg_edit_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{




        $sg_edit=Model::where(['id'=>$id,'from'=>$name]);

        if($sg_edit->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $sg_edit=Model::where(['from'=>$name]);

             if($sg_edit->exists())
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
      protected function sgToExistEdit($id,$name){
       
          
          $flag=0;
       
           $sg_edit_del=Model::where(['to'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

       if($sg_edit_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{


 

        $sg_edit=Model::where(['id'=>$id,'to'=>$name]);

        if($sg_edit->exists())
        {
            return response()->json($flag);
        }
        else
        {
             $sg_edit=Model::where(['to'=>$name]);

             if($sg_edit->exists())
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

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'from' => "required|",
        'to' => "required|",
        'desc' => "required",
    ]);

        $obj=new Model();
        $obj->from=$request->from;
        $obj->to=$request->to;
        $obj->descr=$request->desc;
        $obj->save();
         Session::flash("success"," Record Saved.");
        return back();
    }



    public function update(Request $request)
    {
      
            $sg_id=$request->id;  // get color  id

         // validation is part
        $validatedData = $request->validate([

        'from' => "required|",
        'to' => "required|",
    ]);

       Model::where(['id'=>$request->id])->update(['from'=>$request->from,'to'=>$request->to,'descr'=>$request->desc]);
        Session::flash("success"," Record Updated.");
       return back();
    }

    public function destroy($id)
    {
        $status=0;
       Model::find($id)->update(['status'=>$status]);
       Model::where('id',$id)->delete();
       Session::flash("error"," Record Deleted."); 
       return back();


    }
}
