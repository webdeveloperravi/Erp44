<?php
namespace App\Http\Controllers\Store\Payment;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Services\Balance;
use App\Model\Store\Bank; 
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\AccountGroup;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Store\PaymentDaybook\PaymentDaybook;
use App\Model\Store\PaymentLedger\PaymentReceiveLedger;
  

class PaymentReceiveController extends Controller
{
    public function index()
    {   
        return view('store.Payment.PaymentReceive.index');
    } 
    
    public function create()
    {
        $paymentModes = AccountGroup::whereIn('id',[12,1])->get();  
        $stores = StoreHelper::getStoreByZones(); 
        return view('store.Payment.PaymentReceive.create',compact('paymentModes','stores')); 
    }

    public function getPaymentModeAccounts($paymentModeId)
    {   
        if($paymentModeId == 1){
            $paymentModeAccounts = UserStore::whereId(auth()->user()->id)->get();
        }else{
            $paymentModeAccounts = Bank::where(['org_id' => StoreHelper::getStoreId(),'account_group_id' => $paymentModeId])->get();
        }  

        return view('store.Payment.PaymentReceive.getpaymentModeAccounts',compact('paymentModeAccounts'));
    }

    public function getStoreManagers($storeId)
    {   
        $accounts = UserStore::where('org_id',$storeId)->whereIn('account_group_id',[12,1])->get();
        $authUser = UserStore::find($storeId);
        $accountGroups = AccountGroup::whereIn('id',[12,1])
                         ->get(); 
        
        return view('store.Payment.PaymentReceive.getStoreAccountsList',compact('accounts','accountGroups','authUser')); 
    }

    public function save(Request $request)
    {  
        // dd($request->all());
        $validator = Validator::make($request->all() , [ 
        'date' => 'required',
        'payment_mode' => 'required|not_in:0',
        'from' => 'required|not_in:0',
        'from_store' => 'required|not_in:0', 
        'to' => 'required|not_in:0', 
        'amount' => 'required|not_in:0',  
        ]); 

        if ($validator->passes())
        { 
            // $balance = Balance::getTotalBalance($request->from);
            // if($balance['type'] == 'dr'){
            //     return response()->json(['success'=>false,'msg'=> 'Don\'t have minimum balance to make payment']);
            // }
            
            $from =StoreHelper::getUserStoreById($request->from);
            $to =StoreHelper::getUserStoreById($request->to); 
            $voucherTypeId = '9';

            $ledger = PaymentReceiveLedger::create([
                'guard_id_from' => auth('store')->user()->guard_id,
                'guard_id_to' => auth('store')->user()->guard_id,
                'voucher_type' =>  $voucherTypeId,
                // 'voucher_type_to' =>  $voucherTypeIdTo,
                'voucher_number' => StoreHelper::getVoucherNumber($request->to,$voucherTypeId), 
                'account_id' => StoreHelper::getUserStoreId($request->to), 
                'from' => $request->from,
                'to' => $request->to,  
                'total_amount' => $request->amount,
                'comment' => $request->comment, 
                'status' => '1',
                'reference_number' => $request->reference_number,
                'created_at' => Carbon::parse($request->date)->format('Y-m-d H:i:s') ?? Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => auth('store')->user()->id
        ]); 
            
            $msg = 'Your Payment Received Successfully. Transaction No. '. $ledger->voucher_number;
            return response()->json(['success' => true,'msg' => $msg]);
        }else{
            $keys = $validator->errors()->keys();
            $vals = $validator->errors()->all();
            $errors = array_combine($keys, $vals);
            return response()->json(['errors' => $errors]);
        } 
    } 

    
    public function getLastTransactions($accountId)
    {
        $authUser = UserStore::find($accountId); 
        
                 $ledgers = PaymentDaybook::query()
                            //  ->where('from',$authUser->id)
                            ->orWhere('to',$authUser->id)
                            ->limit(10)
                            ->orderBy('id','desc')
                            ->get()
                            ->reject(function($ledger){
                                return $ledger->voucher_type != '9'; 
                            }) 
                            ;
        return view('store.Payment.PaymentReceive.getLastTransactions',compact('ledgers','authUser'));
    }

    public function getAccountIdForPaymentReceive()
    {
         $authUser = UserStore::where('id',auth('store')->user()->id)->first();
    
        //dd($authUser->type);
        if($authUser->type =='user')
        {
            return $authUser->parentStore->id;
        }
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            return $authUser->id;
        }
    }


}

