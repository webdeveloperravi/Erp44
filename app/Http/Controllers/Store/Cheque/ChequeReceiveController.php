<?php

namespace App\Http\Controllers\Store\Cheque;

use App\Model\Store\Cheque;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChequeReceiveController extends Controller
{
    public function index()
    {
        return view('store.Cheque.ChequeReceive.index');
    }

    public function create()
    {   
         
        $stores = StoreHelper::getStoreByZones();
        // $authUser = auth('store')->user();
        // if($authUser->type == 'lab' || $authUser->type == 'org'){
        //     $cheques1 = Cheque::where(['store_id' => $authUser->id,'in_stock'=> 1])->pluck('id')->toArray();
        //     $cheques2 = Ledger::where('voucher_type',10)->where('to',$authUser->id)->where('new_ledger_id',null)->pluck('cheque_id')->toArray(); 
        //     // dd($cheques2);
        //     $cheques = Cheque::whereIn('id',array_merge($cheques1,$cheques2))->get();
        // }
        // if(in_array($authUser->type,['user','bank'])){
        //     $cheques = Ledger::where('voucher_type',10)->where('to',$authUser->id)->where('new_ledger_id',null)->pluck('cheque_id')->toArray(); 
        //     $cheques = Cheque::whereIn('id',$cheques)->get();
        // }
        
        return view('store.Cheque.ChequeReceive.create',compact('stores'));
    }

    public function getCheques(Request $request)
    {
        $authUser = UserStore::find($request->account);
        if($authUser->type == 'lab' || $authUser->type == 'org'){
            $cheques1 = Cheque::where(['store_id' => $authUser->id,'in_stock'=> 1])->pluck('id')->toArray();
            $cheques2 = Ledger::where('voucher_type',10)->where('to',$authUser->id)->where('new_ledger_id',null)->pluck('cheque_id')->toArray(); 
            // dd($cheques2);
            $cheques = Cheque::whereIn('id',array_merge($cheques1,$cheques2))->get();
        }
        if(in_array($authUser->type,['user','bank'])){
            $cheques = Ledger::where('voucher_type',10)->where('to',$authUser->id)->where('new_ledger_id',null)->pluck('cheque_id')->toArray(); 
            $cheques = Cheque::whereIn('id',$cheques)->get();
        } 
        return view('store.Cheque.ChequeReceive.cheques',compact('cheques'));
    }

    public function store(Request $request)
    { 
        // dd($request->all());
        $validator = Validator::make($request->all(),[
                'account' => 'required',  
         ]);

        if($validator->passes()){
             
            $openingCheques = collect();
            $balanceCheques = collect(); 
            
            
            $cheques = collect($request->cheques)->toArray();  
            foreach ($cheques as $cheque){  
                $response = $this->getChequeStatus($cheque);  
                if ($response == 'opening') {
                    $openingCheques = $openingCheques->concat([$cheque]);
                }
                if ($response == 'balance') {
                    $balanceCheques = $balanceCheques->concat([$cheque]);
                } 
            };   
            foreach($openingCheques as $cheque){
                 Ledger::create([
                    'guard_id_from' => auth('store')->user()->guard_id,
                    'guard_id_to' => auth('store')->user()->guard_id,
                    'voucher_type' => '10',
                    'voucher_number' => StoreHelper::getVoucherNumber(auth('store')->user()->id,10),
                    'account_id' =>  StoreHelper::getUserStoreId($request->account),
                    'from' =>  $request->account,
                    'to' => auth('store')->user()->id,
                    'cheque_id' => $cheque,
                    'comment' => $request->comment ?? "",
                    'status' => '1',
                    'total_amount' => Cheque::find($cheque)->amount ?? ""
                 ]);
                 Cheque::whereId($cheque)->update(['in_stock'=>0]);
            }

            foreach($balanceCheques as $cheque){
                $oldLedger = Ledger::where('voucher_type',10)->where('new_ledger_id',null)->whereChequeId($cheque)->first(); 
                $ledger =   Ledger::create([
                    'guard_id_from' => auth('store')->user()->guard_id,
                    'guard_id_to' => auth('store')->user()->guard_id,
                    'voucher_type' => '10',
                    'voucher_number' => StoreHelper::getVoucherNumber(auth('store')->user()->id,10),
                    'account_id' =>  StoreHelper::getUserStoreId($request->account),
                    'from' => $request->account,
                    'to' => auth('store')->user()->id,
                    'cheque_id' => $cheque,
                    'comment' => $request->comment ?? "",
                    'status' => '1',
                    'total_amount' => Cheque::find($cheque)->amount ?? ""
                 ]);
                 $oldLedger->update(['new_ledger_id'=> $ledger->id]); 
            } 
            
            return response()->json(['success'=>true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }

    }

    public function getChequeStatus($chequeId)
    {
        // Cheque::find($chequeId);
        if(Ledger::where('cheque_id',$chequeId)->first() ?? false){
            return 'balance';
        }
        if(Cheque::whereId($chequeId)->whereInStock(1)->first() ?? false){
            return 'opening';
        }
    }

    // public function edit($chequeId)
    // {
    //     $cheque = Cheque::find($chequeId);
    //     return view('store.Cheque.ChequeIssue.edit',compact('cheque'));
    // }

    // public function update(Request $request)
    // { 
    //     // dd($request->all());
    //     $validator = Validator::make($request->all(),[
    //             'number' => 'required', 
    //             'amount' => 'required', 
    //      ]);

    //     if($validator->passes()){
    //         Cheque::where('id',$request->chequeId)->update(['number'=> $request->number,'amount'=> $request->amount]);
    //         // Cheque::create(['number'=>$request->number,'amount'=>$request->amount,'store_id'=> StoreHelper::getStoreId()]);
            
    //         return response()->json(['success'=>true]);
    //     }else{
    //         $keys = $validator->errors()->keys();
    //         $vals  = $validator->errors()->all();
    //         $errors = array_combine($keys,$vals);
    //         return response()->json(['errors'=>$errors]);
    //     }

    // }



    // public function all()
    // {
    //     $storeId = StoreHelper::getStoreId();
    //     $cheques = Cheque::where('store_id',$storeId)->get();
    //     return view('store.Cheque..ChequeIssue.all',compact('cheques'));
    // }

    public function all()
    {
        $authUser = auth('store')->user(); 
        
                $ledgers = Ledger::where('to',$authUser->id)
                            // ->orWhere('to',$authUser->id)
                            ->limit(10)
                            ->orderBy('id','desc')
                            ->get()
                            ->reject(function($ledger){
                                return $ledger->voucher_type != '10'; 
                            });

        return view('store.Cheque.ChequeReceive.all',compact('authUser','ledgers'));
    }

    // public function status($chequeId)
    // {
        
    // }
}
