<?php

namespace App\Http\Controllers\Admin\Master;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Gridle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GridleController extends Controller
{
    public function index()
    {
        return view('admin.amaster.gridle.index');
    }

    public function create()
    {
        return view('admin.amaster.gridle.create');
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
                    'name' => 'required|unique:gridles,name',
                    'alias' => 'required',
                     ]);
        if($validator->passes()){
           $gridle= Gridle::create([
                'name' => $request->name,
                'alias' => $request->alias,
                'description' => $request->description,
                'created_id' => auth('admin')->user()->id
                
                ]);
                            
 $gridle->masterIds()->create([
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
       $gridles = Gridle::all();
        return view('admin.amaster.gridle.all',compact('gridles'));
    }

    
    public function edit($id)
    {
       $gridle= Gridle::find($id);
        return view('admin.amaster.gridle.edit',compact('gridle'));
    }

    
    public function update(Request $request)
    {
      
         $gridle= Gridle::where(['id'=>$request->gridleId])->first();

         
             $validator = Validator::make($request->all(),[
                    'name' => 'required',
                    'alias' => 'required',
                     ]);

        if($validator->passes()){
 
           
            $gridle->update([
            'name' =>$request->name,
            'alias' =>$request->alias,
            'description' =>$request->description,
            'updated_id' => auth('admin')->user()->id
            ]);
            
 $gridle->masterIds()->create([
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
      $gridle = Gridle::find($id);
      $status= $gridle->status == 1 ? 0 : 1; 
      $gridle->update(['status'=>$status]);
      return redirect()->back();
 }
    

}
