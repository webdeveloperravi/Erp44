<?php

namespace App\Http\Controllers\Store;

use App\Model\Store\Ledger;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

 

class StockLedgerController extends Controller
{
    public function index(Request $request){

    //       $data =  Ledger::where(function ($query) {
    // $query->where('from', '=', 38)
    //       ->orWhere('to', '=', 38);
    //   })->get();

    //       dd($data->toArray());
         
        return view('store.stock_ledger.index');
    }

    // Accoiunt Selection Managers or Accounts 

    public function account($id)
    {
      // current Asset
      if($id==1)
      {
        $accounts = UserStore::where(['account_group_id' => $id,'org_id'=>auth('store')->user()->id])->get();
       return view('store.stock_ledger.accountList',compact('accounts','id'));
      } 
      else
      {
        $accounts = UserStore::where(['account_group_id' => $id,'org_id'=>auth('store')->user()->id])->get();
       return view('store.stock_ledger.accountList',compact('accounts','id'));
      }
        
    }    
    
    //Issue Stock
    public function createIssueStock(){
        // $accounts = UserStore::with('store')->where('type','user')->get();
        $accounts = UserStore::with('store')->get();
        return view('store.stock_ledger.issue_stock.create',compact('accounts'));
    }

    public function selectAccount($id){
      
        $storeVoucherNumber = $this->generateVoucherNumber(); 
        $voucherTypeId = Voucher::where('name','Challan')->first()->id; 
        $ledger = Ledger::create([
            'from_voucher_type_id' => $voucherTypeId,
            'to_voucher_type_id' =>$voucherTypeId,
            'from_voucher_number' => $storeVoucherNumber,
            'account_id_from' => auth('store')->user()->id,
            'account_id_to' => $id,
        ]);
        $updateVoucherNumber = UserStore::where('id',auth('store')->user()->id)->first()->update(['from_voucher_number' => $storeVoucherNumber]);
        
        return view('store.stock_ledger.issue_stock.gin',compact('ledger'));
    }

    public function addGin(Request $request){
        
        $productStock = InvoiceDetailGradeProduct::where('gin',$request->gin)->first();
        $exist = LedgerDetail::where(['ledger_id'=>$request->ledgerId,'product_stock_id'=>$productStock->id ])->exists();
        if(!$exist){
            $stockLedgerDetail = LedgerDetail::create([
              'ledger_id' => $request->ledgerId,
              'product_stock_id' => $productStock->id,
              'amount' => $productStock->getProductPrice($productStock->id)
            ]);
        }
        return response()->json(['success',true]);
    }

    public function getGins($id){
        $ledgerDetails = LedgerDetail::where('ledger_id',$id)->get();
        return view('store.stock_ledger.issue_stock.allGins',compact('ledgerDetails'));
    }

    public function saveAll($ledgerId){
        
        $ledger = Ledger::where('id',$ledgerId)->first();
        $ledgerDetails = LedgerDetail::where('ledger_id',$ledgerId)->get();
        
        $totalAmount = $this->getTotalAmount($ledgerId);
        $totalQty = LedgerDetail::where('ledger_id',$ledgerId)->count();
        $ledger->update([
           'qty' => $totalQty,
           'amount' => $totalAmount,
           'status' => '1'
        ]);
    }

    public function getTotalAmount($ledgerId){
        
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck("amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }
    
    public function saveIssueStock(Request $request){
        
        $issueStock = Ledger::create([
            'debit_by' => auth('store')->user()->id, 
            'credit_to' => $request->credit_to,
            'amount' => $request->amount
        ]);

        return response()->json(['success' => true]);
    }
    
    //Receive Stock
    public function createReceiveStock(){
        
        $accounts = UserStore::all();
        return view('store.stock_ledger.receive_stock.create',compact('accounts'));
    }
    
    public function saveReceiveStock(Request $request){
        
        $receiveStock = Ledger::create([
            'debit_by' => $request->debit_by,
            'credit_to' => auth('store')->user()->id,
            'amount' => $request->amount
        ]);

        return response()->json(['success' => true]);
    }

    //Ledger View

    public function view(){
        $accounts = UserStore::all();
        return view('store.stock_ledger.view',compact('accounts'));
    }

    public function all($accountId){
         
        // dd($accountId);
        //  $stockLedgers = Ledger::where(['status'=>1,'debit_by'=>$accountId])->orWhere('credit_to', $accountId)->get();

// $data = DB::select("SELECT * FROM `ledgers` WHERE status=1 and credit_to=31 or debit_by =31");
//dd($data);

// $data = Ledger::where('status', 1)
//         ->where(function($q) {
//           $q->where('credit_to', 31)
//             ->orWhere('debit_by', 31);
//       })
//       ->get();

//       dd($data->toArray());

   
        // $ids1 = Ledger::where(['manager_id_to'=>$accountId,'account_id_from'=>auth('store')->user()->id, 'manager_id_from'=>null, 'status' => '1'])->pluck('id')->toArray();
        // $ids2 = Ledger::where(['manager_id_from'=>$accountId,'account_id_to'=>auth('store')->user()->id,'status' => '1'])->pluck('id')->toArray();

        // // dd($ids1,$ids2);
        // $ids3 = [0,0,0];
        // $ids = array_merge($ids1,$ids2,$ids3);
        // //  dd(array_values($ids));
        // $stockLedgers = Ledger::whereIn('id',$ids1)->get();
        // dd($stockLedgers);
        // dd($stockLedgers['0']->comment);
       // dd($stockLedgers);
        // where(['debit_by'=>$accountId,'credit_to'=>auth('store')->user()->id])->or
        
        // $ids1 = Ledger::where(['from'=>$accountId])->pluck('id')->toArray();
        // $ids2 = Ledger::where(['to'=>$accountId])->pluck('id')->toArray();
        // $ids3 = [0,0,0];
        // $ids = array_merge($ids1,$ids2,$ids3); 
        // $stockLedgers = Ledger::whereIn('id',$ids1)->get();
        
        $accountId1 = '1';
        $accountId2 = '10';
        $store1Accounts = UserStore::where('org_id',$accountId1)->pluck('id')->toArray();
        $store2Accounts = UserStore::where('org_id',$accountId2)->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[1]); 
        $store2Accounts = array_merge($store2Accounts,[10]); 
        // dd($store1Accounts,$store2Accounts);
        $ids1 = Ledger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
        $ids2 = Ledger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
        $ids = array_merge($ids1,$ids2); 
        $stockLedgers = Ledger::whereIn('id',$ids)->get();
        
        
        $stockLedgers = ledger::where('from',$accountId)->orWhere('to',$accountId)->get(); 

        return view('store.stock_ledger.all',compact('stockLedgers','accountId'));
    }

    public function stockTransactionsDetails($id)
    {
        $stockTransactionDetails = LedgerDetail::with('ledger')->where('ledger_id',$id)->get();
       
        return view('store.stock_ledger.stockTransactionDetails',compact('stockTransactionDetails'));
    }
    
}
