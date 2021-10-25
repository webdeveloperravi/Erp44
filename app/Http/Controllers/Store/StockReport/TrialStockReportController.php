<?php

namespace App\Http\Controllers\Store\StockReport;

use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\AccountGroup;
use App\Services\GetUserDebitCreditAmount;

class TrialStockReportController extends Controller
{
    public function index()
    {  
        $accounts = UserStore::where('org_id',StoreHelper::getStoreId())
                            // ->whereIn('account_group_id',[12,1,17])
                            ->with('headOfficeAddress.city:id,name')
                            ->orderBy('company_name')
                            ->get()->groupBy('account_group_id'); 
        $accountGroups = AccountGroup::has('store')
        ->whereHas('store',function($q){
            $q->where('org_id',StoreHelper::getStoreId());
        }) 
        ->orderBy('name','asc')
        ->get();
        return view('store.StockReport.TrailReport.index',compact('accounts','accountGroups'));
    } 

    public function printReport()
    {  
        $myAccount = UserStore::find(StoreHelper::getStoreId());
        $accounts = UserStore::where('org_id',StoreHelper::getStoreId())
                            // ->whereIn('account_group_id',[12,1,17])
                            ->with('headOfficeAddress.city:id,name')
                            ->orderBy('company_name')
                            ->get()->groupBy('account_group_id'); 
        $accountGroups = AccountGroup::has('store')
        ->whereHas('store',function($q){
            $q->where('org_id',StoreHelper::getStoreId());
        }) 
        ->orderBy('name','asc')
        ->get();
        return view('store.StockReport.TrailReport.printReport',compact('accounts','accountGroups','myAccount'));
    } 

    public function view($accountId){
        
        $account = UserStore::find($accountId); 
        return view('store.StockReport.TrailReport.view',compact('account')); 

    } 

    public function currentView(){
        
        $account = UserStore::find(StoreHelper::getStoreId()); 
        return view('store.StockReport.TrailReport.currentView',compact('account')); 

    } 

    public function viewStock($accountId,$voucherTypeId){
        
         dd($accountId,$voucherTypeId);
         $ledger = new Ledger;
         $vouchers = Voucher::all();
         $user = UserStore::find($accountId);
         return view('store.StockReport.TrailReport.viewStock',compact('vouchers','ledger','accountId','user'));
    }

   
}