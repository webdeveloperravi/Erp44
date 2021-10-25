<?php

namespace App\Http\Controllers\Admin\Master;

use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use  App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;

class VoucherController extends Controller
{
    
    public function index()
    {
        return view('admin.amaster.voucher.index');
    }

    public function create()
    {
        return view('admin.amaster.voucher.create');
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
                    'name' => 'required|unique:vouchers,name',
                    'alias' => 'required',
                     ]);
        if($validator->passes()){
            $voucher = Voucher::create([
                'name' => $request->name,
                'alias' => $request->alias,
                'description' => $request->description,
                
                ]);

                $voucher->masterIds()->create([
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
       $vouchers = Voucher::all();
        return view('admin.amaster.voucher.all',compact('vouchers'));
    }

    
    public function edit($id)
    {
        $voucher = Voucher::find($id);
        return view('admin.amaster.voucher.edit',compact('voucher'));
    }

    
    public function update(Request $request)
    {
      
          $voucher = Voucher::where(['id'=>$request->voucherId])->first();

         
             $validator = Validator::make($request->all(),[
                    'name' => 'required',
                    'alias' => 'required',
                     ]);

        if($validator->passes()){
 
           
            $voucher->update([
            'name' =>$request->name,
            'alias' =>$request->alias,
            'description' =>$request->description,
            ]);
            $voucher->masterIds()->create([
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
}
