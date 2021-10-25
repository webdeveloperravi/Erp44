<?php

namespace App\Http\Controllers\Admin\Master;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Polish;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PolishController extends Controller
{
      
    public function index()
    {
        return view('admin.amaster.polish.index');
    }

    public function create()
    {
        return view('admin.amaster.polish.create');
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
                    'name' => 'required|unique:polishs,name',
                    'alias' => 'required',
                     ]);
        if($validator->passes()){
           $polish= Polish::create([
                'name' => $request->name,
                'alias' => $request->alias,
                'description' => $request->description,
                
                
                ]);
                $polish->masterIds()->create([
             
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
       $polishes = Polish::all();
        return view('admin.amaster.polish.all',compact('polishes'));
    }

    
    public function edit($id)
    {
        $polish= Polish::find($id);
        return view('admin.amaster.polish.edit',compact('polish'));
    }

    
    public function update(Request $request)
    {  
        
        $polish=Polish::where(['id'=>$request->polishId])->first();

       
             $validator = Validator::make($request->all(),[
                    'name' => 'required',
                    'alias' => 'required',
                     ]);

        if($validator->passes()){
        
           
            $polish->update([
            'name' =>$request->name,
            'alias' =>$request->alias,
            'description' =>$request->description,
            ]);
            $polish->masterIds()->create([
             
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
       $polish = Polish::find($id);
        
      $status= $polish->status == 1 ? 0 : 1; 
      $polish->update(['status'=>$status]);
      return redirect()->back();

    
      

    }
    
    


}
