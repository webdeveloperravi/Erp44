<?php

namespace App\Http\Controllers\Admin\Organization;

use Auth;
use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\Unit;

class UnitController extends Controller
{
   

   
    public function index()
    {
        return view('admin.amaster.organization.units.index');
    }

    public function unitList(){
 
        $unit_list=Unit::all();
        return view('admin.amaster.organization.units.unit_list',compact('unit_list'));

    }

    public function store(Request $request)
    {   

        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:units,name|max:255',
            'alias' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
         
        if($validator->passes()){
                 
            $user_id = Auth::guard('admin')->id();
            $unit_obj=new Unit();
            $unit_obj->name=$request->name;
            $unit_obj->alias=$request->alias;
            $unit_obj->description=$request->description;
            $unit_obj->uqc=$request->uqc;
            $unit_obj->created_by=$user_id;
            $unit_obj->save();

            $unit_obj->masterIds()->create([
                'created_id' => Helper::getAdminId()
              ]);
    
        return response()->json(['success'=>true]); 
         }else{
         $keys = $validator->errors()->keys();
         $vals  = $validator->errors()->all();
         $errors = array_combine($keys,$vals);
        
        return response()->json(['errors'=>$errors]);
     }
    }

    public function update(Request $request)
    {    
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'alias' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
         
       if($validator->passes()){
                 
		$unit = Unit::where('id',$request->id)->first();
        $unit->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'alias'=>$request->alias,
            'uqc'=>$request->uqc
        ]);
        $unit->masterIds()->create([
            'updated_id' => Helper::getAdminId()
          ]);

        return response()->json(['success'=>true]); 
         
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            
            return response()->json(['errors'=>$errors]);
        } 
    }

    public function status($id,$status)
         {

             if($status==1)
             {
                $status=0;
             }
             else
             {
                $status=1;  
             }

            Unit::find($id)->update(['status'=>$status]);

             return response()->json(['success'=>'Unit Successfully Changed  Status!']);



         }




}
