<?php

namespace App\Http\Controllers\Store\Cheque;

use App\Model\Store\Cheque;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;
use App\Services\Cheque\ChequeFind;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ChequeClearController extends Controller
{
    public function index()
    {
        return view('store.Cheque.ChequeClear.index');
    }

    public function create()
    {   
         
        $stores = StoreHelper::getStoreByZones();
        return view('store.Cheque.ChequeClear.create',compact('stores'));
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
        
        $stores = StoreHelper::getStoreByZones();
        return view('store.Cheque.ChequeClear.cheques',compact('cheques','stores'));
    }

    public function store(Request $request)
    { 
       
       
        $validator = Validator::make($request->all(),[
                'accountTo' => 'required',  
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
            
            
         
            // foreach($openingCheques as $cheque){
            //      Ledger::create([
            //         'guard_id_from' => auth('store')->user()->guard_id,
            //         'guard_id_to' => auth('store')->user()->guard_id,
            //         'voucher_type' => '10',
            //         'voucher_number' => StoreHelper::getVoucherNumber(auth('store')->user()->id,10),
            //         'account_id' =>  StoreHelper::getUserStoreId($request->account),
            //         'from' =>  $request->account,
            //         'to' => auth('store')->user()->id,
            //         'cheque_id' => $cheque,
            //         'comment' => $request->comment ?? "",
            //         'status' => '1',
            //         'total_amount' => Cheque::find($cheque)->amount ?? ""
            //      ]);
            //      Cheque::whereId($cheque)->update(['in_stock'=>0]);
            // }
 
         
            $voucherTypeId = '9';
      
      



            foreach($balanceCheques as $cheque){
              
                    $oldLedger=ChequeFind::chequeFindFromLedger($cheque);
                    $oldCheque=ChequeFind::chequeFindFromCheque($cheque);
                    $ledger =   Ledger::create([
                    'guard_id_from' => auth('store')->user()->guard_id,
                    'guard_id_to' => auth('store')->user()->guard_id,
                    'voucher_type' => $voucherTypeId,
                    'voucher_number' => StoreHelper::getVoucherNumber($oldCheque->store_id,$voucherTypeId),
                    'voucher_number_to' => StoreHelper::getVoucherNumber(auth('store')->user()->id,$voucherTypeId),
                    'voucher_number' => StoreHelper::getVoucherNumber(auth('store')->user()->id,10),
                    'account_id' =>  StoreHelper::getUserStoreId($request->accountTo),
                    'from' => $oldCheque->store_id,
                    'to' => $request->accountTo,
                    'cheque_id' => $cheque,
                    'comment' => $request->comment ?? "",
                    'status' => '1',
                    'total_amount' => $oldCheque->amount ?? "",
                    'created_at' => Carbon::parse($request->date)->format('Y-m-d H:i:s') ?? Carbon::now()->format('Y-m-d H:i:s'),
                    'created_by' => auth('store')->user()->id
                 ]);
                 $oldLedger->update(['new_ledger_id'=> $ledger->id]);
                 $oldCheque->update(['cleared'=> 1,'ledger_id'=>$ledger->id]); 
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



    public function all()
    {
        $authUser = auth('store')->user(); 
        
                $ledgers = Ledger::where('created_by',$authUser->id)
                            ->where('cheque_id','>','0')
                            ->limit(10)
                            ->orderBy('id','desc')
                            ->get()
                            ->reject(function($ledger){
                                return $ledger->voucher_type != '9'; 
                            });
        return view('store.Cheque.ChequeClear.all',compact('authUser','ledgers'));
    }

    // public function status($chequeId)
    // {
        
    // }
}
