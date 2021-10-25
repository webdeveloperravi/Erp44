<?php

namespace App\Http\Controllers\Store\PaymentLedger;
 
use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail; 
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller; 
use App\Model\Admin\Master\AccountGroup;
use App\Model\Store\PaymentDaybook\PaymentDaybook;
use App\Model\Store\PaymentLedger\StoreCheckManagerPaymentLedger;

class ManagerPaymentLedgerController extends Controller
{
    public function index(Request $request){

        // $managers = Helper::getManagersByTree();
        $managers = UserStore::whereIn('id',StoreHelper::getUsersIdsByStoreId(StoreHelper::getStoreId()))->get();
        $accountGroups = AccountGroup::all();
        return view('store.PaymentLedger.Manager.index',compact('managers','accountGroups')); 
    } 

    public function all($managerId)
    {
        // $paymentLedgers = PaymentDaybook::where('from',$managerId)
        //                                 ->orWhere('to',$managerId)
        //                                 // ->whereIn('voucher_type','5') 
        //                                 ->get()->reject(function($ledger){
        //                                     return  $ledger->voucher_type != 9; 
        //                                 })
        //                                  ; 
        //  $authUser = UserStore::find($managerId);
        $account = UserStore::find($managerId);


        return view('store.PaymentLedger.Manager.allTransactions',compact('account'));
    }
 
    
}
