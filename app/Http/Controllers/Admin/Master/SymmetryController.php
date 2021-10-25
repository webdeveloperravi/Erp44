<?php

namespace App\Http\Controllers\Admin\Master;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\Symmetry;
use Illuminate\Support\Facades\Validator;

class SymmetryController extends Controller
{
    public function index()
    {
        return view('admin.amaster.symmetry.index');
    }

    public function create()
    {
        return view('admin.amaster.symmetry.create');
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
                    'name' => 'required|unique:symmetries,name',
                    'alias' => 'required',
                     ]);
        if($validator->passes()){
           $symmetry= Symmetry::create([
                'name' => $request->name,
                'alias' => $request->alias,
                'description' => $request->description,
                'created_id' => auth('admin')->user()->id,
                
                ]);
            $symmetry->masterIds()->create([
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
       $symmetries = Symmetry::all();
        return view('admin.amaster.symmetry.all',compact('symmetries'));
    }

    
    public function edit($id)
    {
       $symmetry= Symmetry::find($id);
        return view('admin.amaster.symmetry.edit',compact('symmetry'));
    }

    
    public function update(Request $request)
    {
      
         $symmetry= Symmetry::where(['id'=>$request->symmetryId])->first();

         
             $validator = Validator::make($request->all(),[
                    'name' => 'required',
                    'alias' => 'required',
                     ]);

        if($validator->passes()){
 
           
            $symmetry->update([
            'name' =>$request->name,
            'alias' =>$request->alias,
            'description' =>$request->description,
            'updated_id' => auth('admin')->user()->id
            ]);

            $symmetry->masterIds()->create([
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
      $symmetry = Symmetry::find($id);
      $status= $symmetry->status == 1 ? 0 : 1; 
      $symmetry->update(['status'=>$status]);
      return redirect()->back();
    }

}
