<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductMColour as Color;
use App\Model\Admin\Setting\Module;
use Illuminate\Support\Str;
use Session;
use Helper;
use Request as req;
use Route;
class ProductMColourController extends Controller
{
     
     // Fetch Record Method from Database
     public function index(Request $request){
    	        
             //dd(url()->current()); // to get full path
             $route = Route::current();

$name = Route::currentRouteName();
$action = Route::currentRouteAction();

//dd($route,$name,$action);
           
             //  echo Helper::sampleHelper();
             // dd(123);
               $meta_title=Module::where(['title'=>$name])->first();
               
               
               $data = Color::all()->sortBy('color');
              // dd($data);
           
          return view('admin.amaster.color.index',compact('data','meta_title'));
    }


    public function store(Request $request){
     
     
     // validation part
      //dd($request->all());

       $validatedData = $request->validate([
        'color' => "required",
        'alias' => "required",
    ]);
        
       // Record Inserting into Colors Table.

    	$color  = new Color;
    	$color->color = $request->color;
    	$color->alias = $request->alias;
      $color->descr = $request->desc;
      $color->save();

      $color->masterIds()->create([
          'created_id' => auth('admin')->user()->id,
      ]);
           //Alert::toast('Toast Message', 'Toast Type');

        Session::flash("success"," Record Saved.");
    	//return redirect()->route('color')->withSuccessMessage('Color Successfully Saved');
        return back();
    }


    public function update(Request $request){
      
    
         $color_id=$request->id;  // get color  id

         // validation is part

    	 $validatedData = $request->validate([

        'color' => "required|unique:product_m_colour,color,$color_id",
        'alias' => "required|unique:product_m_colour,alias,$color_id",
    ]);
         // update record 
    	$color = Color::where(['id'=>$request->id])->first();
      $color->update(['color'=>$request->color,'alias'=>$request->alias,'descr'=>$request->desc]);
      //log maintain 
        $color->masterIds()->create([
       'updated_id' => auth('admin')->user()->id,
    ]);
      Session::flash("success"," Record Updated."); 
        
    	//return back()->withSuccessMessage('Color Successfully Updated');;
         return back();

    }


    public function colorExist($name)
    {
        

         $flag=0;
          $clarity_del=Color::where(['color'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($clarity_del->isNotEmpty()){
            $flag=2;
            return response()->json($flag);
          }
          else
          {

            $clarity_res=Color::where(['color'=>$name])->withTrashed()->get();
          
          if($clarity_res->isNotEmpty())
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



    public function aliasExist($name)
    {
        
         $status=0;

        $color_alias_del=Color::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

          if($color_alias_del->isNotEmpty()){
              
              $status=2;
            return response()->json($status);
          }

          else {


         $color_name=Color::where(['alias'=>$name])->withTrashed()->get();  

         if($color_name->isNotEmpty())
         {
            $status=1;
         }
         else
         {
            $status=0;
         }

       }  
       Session::flash("success"," Status Changed."); 
         return $status;

    }

    protected function colorEditExist($id,$name){
         

      
       $flag=0;
       
        $color_del=Color::where(['color'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

      
          if($color_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{

        $clarity_edit=Color::where(['id'=>$id,'color'=>$name]);

        if($clarity_edit->exists())
        {
             $flag=0;
            return response()->json($flag);
        }
        else
        {
             $clarity_edit=Color::where(['color'=>$name]);

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

           $color_del=Color::where(['alias'=>$name,'status'=>0])->whereNotNull('deleted_at')->withTrashed()->get();

      
          if($color_del->isNotEmpty()){

              $flag=3;
            return response()->json($flag);
          }

        else{




          $status=1;
        $clarity_edit=Color::where(['id'=>$id,'alias'=>$name]);

        if($clarity_edit->exists())
        {
             $flag=0;
            return response()->json($flag);
        }
        else
        {
             $clarity_edit=Color::where(['alias'=>$name]);

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
     
     // We can change Status part

    public function status($id, $status){
   	if($status==1){
    		$status =0;
    	}else{
    		$status = 1;
    	}
    	Color::find($id)->update(['status'=>$status]);
    	return back();
    }

    // We can delete particular record this method  in database.
    public function destroy($id){
        $status=0;
        Color::find($id)->update(['status'=>$status]);
		   Color::where('id', $id)->delete();    	
           Session::flash("error"," Record deleted."); 
        
		return back();
    }


}

