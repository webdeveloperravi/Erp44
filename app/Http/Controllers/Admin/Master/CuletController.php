<?php

namespace App\Http\Controllers\Admin\Master;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Culet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CuletController extends Controller
{
    public function index()
    {
        return view('admin.amaster.culet.index');
    }

    public function create()
    {
        return view('admin.amaster.culet.create');
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
                    'name' => 'required|unique:culets,name',
                    'alias' => 'required',
                     ]);
        if($validator->passes()){
           $culet= Culet::create([
                'name' => $request->name,
                'alias' => $request->alias,
                'description' => $request->description,
                'created_id' =>auth('admin')->user()->id
                
                ]);
                $culet->masterIds()->create([
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
       $culets = Culet::all();
        return view('admin.amaster.culet.all',compact('culets'));
    }

    
    public function edit($id)
    {
       $culet= Culet::find($id);
        return view('admin.amaster.culet.edit',compact('culet'));
    }

    
    public function update(Request $request)
    {
      
         $culet= Culet::where(['id'=>$request->culetId])->first();

         
             $validator = Validator::make($request->all(),[
                    'name' => 'required',
                    'alias' => 'required',
                     ]);

        if($validator->passes()){
 
           
            $culet->update([
            'name' =>$request->name,
            'alias' =>$request->alias,
            'description' =>$request->description,
            'updated_id' =>auth('admin')->user()->id
            ]);

            $culet->masterIds()->create([
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
       $culet = Culet::find($id);
        
      $status= $culet->status == 1 ? 0 : 1; 
      $culet->update(['status'=>$status]);
      return redirect()->back();
    }
}
