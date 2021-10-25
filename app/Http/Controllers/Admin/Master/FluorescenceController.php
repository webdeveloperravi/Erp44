<?php

namespace App\Http\Controllers\Admin\Master;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\Fluorescence;
use Illuminate\Support\Facades\Validator;

class FluorescenceController extends Controller
{
    public function index()
    {
    
        return view('admin.amaster.fluorescence.index');
    }

    public function create()
    {
        return view('admin.amaster.fluorescence.create');
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
                    'name' => 'required|unique:fluorescences,name',
                    'alias' => 'required',
                     ]);
        if($validator->passes()){
           $fluoresecnce=Fluorescence::create([
                'name' => $request->name,
                'alias' => $request->alias,
                'description' => $request->description,
                'created_id' => auth('admin')->user()->id
                
                ]);
                $fluoresecnce->masterIds()->create([
                    'created_id' => Helper::getAdminId()
                  ]);
            return response()->json(['success'=>true]);
        }
        else{
            $keys = $validator->errors()->keys();
     $vals  = $validator->errors()->all();
     $errors = array_combine($keys,$vals);
    
    return response()->json(['errors'=>$errors]);
        }

    }

    
    public function all()
    {
       $fluorescences =Fluorescence::all();
        return view('admin.amaster.fluorescence.all',compact('fluorescences'));
    }

    
    public function edit($id)
    {
       $fluorescence= Fluorescence::find($id);
        return view('admin.amaster.fluorescence.edit',compact('fluorescence'));
    }

    
    public function update(Request $request)
    {
      
         $fluoresecnce= Fluorescence::where(['id'=>$request->fluorescenceId])->first();

         
             $validator = Validator::make($request->all(),[
                    'name' => 'required',
                    'alias' => 'required',
                     ]);

        if($validator->passes()){
 
           
            $fluoresecnce->update([
            'name' =>$request->name,
            'alias' =>$request->alias,
            'description' =>$request->description,
            'updated_id' => auth('admin')->user()->id,
            ]);

            $fluoresecnce->masterIds()->create([
                'updated_id' => Helper::getAdminId()
              ]);

           return response()->json(['success' => true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
        
        return response()->json(['errors'=>$errors]);
        }


    } 

    public function status($id)
    {
       $fluorescence = Fluorescence::find($id);
        
      $status= $fluorescence->status == 1 ? 0 : 1; 
      $fluorescence->update(['status'=>$status]);
      return redirect()->back();
  }



}
