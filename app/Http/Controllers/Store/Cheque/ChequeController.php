<?php

namespace App\Http\Controllers\Store\Cheque;

use App\Model\Store\Cheque;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChequeController extends Controller
{
    public function index()
    {
        return view('store.Cheque.index');
    }

    public function create()
    {
        return view('store.Cheque.create');
    }

    public function store(Request $request)
    { 
        
        $validator = Validator::make($request->all(),[
                'number' => 'required', 
                'amount' => 'required', 
         ]);

        if($validator->passes()){
            Cheque::create(['number'=>$request->number,'amount'=>$request->amount,'store_id'=> StoreHelper::getStoreId()]);
            
            return response()->json(['success'=>true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }

    }

    public function edit($chequeId)
    {
        $cheque = Cheque::find($chequeId);
        return view('store.cheque.edit',compact('cheque'));
    }

    public function update(Request $request)
    { 
        // dd($request->all());
        $validator = Validator::make($request->all(),[
                'number' => 'required', 
                'amount' => 'required', 
         ]);

        if($validator->passes()){
            Cheque::where('id',$request->chequeId)->update(['number'=> $request->number,'amount'=> $request->amount]);
            // Cheque::create(['number'=>$request->number,'amount'=>$request->amount,'store_id'=> StoreHelper::getStoreId()]);
            
            return response()->json(['success'=>true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }

    }



    public function all()
    {
        $storeId = StoreHelper::getStoreId();
        $cheques = Cheque::where('store_id',$storeId)->latest()->get();
        return view('store.Cheque.all',compact('cheques'));
    }

    public function status($chequeId)
    {
        
    }
}
