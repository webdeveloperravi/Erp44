<?php
namespace App\Http\Controllers\Store\Payment;

use Carbon\Carbon;
use App\Model\Store\Bank; 
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\AccountGroup;
use App\Model\Admin\Organization\ZoneCity;
use Illuminate\Support\Facades\Validator;  
use App\Model\Store\PaymentJournal\PaymentJournalLedger;
  

class PaymentJournalController extends Controller
{
    public function index()
    {    

        return view('store.Payment.PaymentJournal.index'); 
    }

    public function create()
    {
        $accounts = UserStore::where('org_id',StoreHelper::getStoreId())->get();
        
        $accountGroups = AccountGroup::has('store')
                         ->whereHas('store',function($q){
                             $q->where('org_id',StoreHelper::getStoreId());
                         }) 
                         ->orderBy('name','asc')
                         ->get(); 
        return view('store.Payment.PaymentJournal.create',compact('accounts','accountGroups')); 
    }
 

    public function store(Request $request)
    {   
        
        $validator = Validator::make($request->all() , [
                'amountFrom' => 'required|not_in:0',
                // 'amountTo' => 'required|not_in:0',
                'from' => 'required|not_in:0',
                'to' => 'required|not_in:0',  
                'date' => 'required',
                ],
               [
                 'amountFrom' => 'Enter Amount',
                //  'amountTo' => 'Enter Amount',
                 'from' => 'Invalid Account',
                 'to' => 'Invalid Account', 
                 'date' => 'Invalid Date',
                 ]
            );
   
        if ($validator->passes())
        { 
            $voucherTypeId = '9';
            $ledger = PaymentJournalLedger::create([
                        'guard_id_from' => auth('store')->user()->guard_id,
                        'guard_id_to' => auth('store')->user()->guard_id,
                        'voucher_type' => $voucherTypeId,
                        // 'voucher_type_to' => 7,
                        'voucher_number' => StoreHelper::getVoucherNumber(StoreHelper::getStoreId(),$voucherTypeId),
                        'account_id' =>  StoreHelper::getStoreId(),
                        'from' => $request->from,
                        'to' =>  $request->to,
                        'total_amount' => $request->amountFrom,
                        'comment' => $request->commentFrom ?? "",  
                        'status' => '1',
                        'reference_number' => $request->reference_number ?? null,
                        'created_at' => Carbon::parse($request->date)->format('Y-m-d H:i:s') ?? Carbon::now()->format('Y-m-d H:i:s'),
                        'created_by' => auth('store')->user()->id
                        ]);
            $msg = 'Your Payment Issued Successfully. Transaction No. '. $ledger->voucher_number;
            return response()->json(['success' => true,'msg' => $msg]);
        }else{
            $keys = $validator->errors()->keys();
            $vals = $validator->errors()->all();
            $errors = array_combine($keys, $vals);
            return response()->json(['errors' => $errors]);
        }
    }
 

    // public function getAccountIdForPaymentJournal(){

    //     $authUser = UserStore::where('id',auth('store')->user()->id)->first();
    
    //     //dd($authUser->type);
    //     if($authUser->type =='user')
    //     {
    //         return $authUser->parentStore->id;
    //     }
    //     if($authUser->type == 'org' || $authUser->type == 'lab')
    //     {
    //         return $authUser->id;
    //     }
    // }



     


}

