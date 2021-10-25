<?php

namespace App\Http\Controllers\Store;
use Session;
use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone; 
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Voucher;
use App\Model\Store\StoreSaleOrder;
use App\Http\Controllers\Controller;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Store\StoreSaleOrderChallan;
use App\Model\Store\StorePurchaseOrderDetail;
use App\Model\Admin\Organization\StoreAddress;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ReceiveChallanController extends Controller
{   
    public function index()
    {   
        $managers = Helper::getManagersByTree();
        return view('store.ReceiveChallan.index',compact('managers'));
    }

    public function all($userId){ 
        if($userId == 'all'){
        $authUser = UserStore::find(auth('store')->user()->id);
        if($authUser->type == 'lab' || $authUser->type == 'org'){
            $userId = StoreHelper::getStoreId();
            $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
            $receiveChallans  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',array_merge($managerIds,[$authUser->id]))->where('voucher_type','2')->latest()->get();
 
        }elseif($authUser->type == 'user'){
            
            $managerIds = Helper::getSubRolesManagerIds();  
                                   
            $receiveChallans  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',array_merge($managerIds,[$authUser->id]))->where('voucher_type','2')->latest()->get(); 
        }
        }else{

            $receiveChallans = Ledger::with(['userIssue', 'userReceipt'])->
                        where('voucher_type','2')
                    ->where('to', $userId)->latest()->get(); 
        }

        return view('store.ReceiveChallan.all',compact('receiveChallans'));
    }

    public function view($id)
    {
       
        $receiveChallan = Ledger::where(['id' => $id])->first();
       return view('store.ReceiveChallan.view', compact('receiveChallan'));
    } 

    public function create()
    {    
        Session::forget('receiveChallan');
        Session::forget('notExistProductsReceiveChallan');
        Session::forget('notInStockProductsReceiveChallan');
        Session::forget('receiveChallanAccount');
        $myStoreId = \App\Helpers\StoreHelper::getStoreId();  
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $stores = UserStore::with('primaryAddress')->whereHas('addresses',function($q) use ($zoneCities){
          $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
          })->where('type','org')->orWhere('type','lab')
          ->with('headOfficeAddress.city:id,name')
          ->orderBy('company_name')
        ->get() 
          ;   
        return view('store.ReceiveChallan.create',compact('stores'));
    }
    
    public function getAccounts($accountId)
    { 
        // dd(request());
        $managers = UserStore::select('id','name')
                       ->where(['org_id' => $accountId, 'type' => 'user'])
                       ->orWhere('id',$accountId)
                    //    ->where('id','!=',auth('store')->user()->id)
                       ->get() 
                       ->reject(function ($record) {
                        return $record->id == auth('store')->user()->id;
                     })
                     ;
        
        return response()->json(['accounts'=> $managers]); 
    }

    public function saveGins(Request $request)
    {     
        $validator = Validator::make($request->all(),[
            'account' => 'required|not_in:0', 
        ]);
        if($validator->passes()){
        if(Session::has('receiveChallanAccount')){
            if(Session::get('receiveChallanAccount') != $request->account){
                Session::forget('receiveChallan');
                Session::forget('notExistProductsReceiveChallan');
                Session::forget('notInStockProductsReceiveChallan');
            }
        }else{
            Session::put('receiveChallanAccount',$request->account);
        }
        $gins = collect($request->gins);
        $notInStockProductsReceiveChallan = [];
        $notExistProductsReceiveChallan = [];
        foreach ($gins as $gin) {
            $response = $this->saveGin($gin,$request->account); 
            if ($response == 'Not In Stock') {
                $notInStockProductsReceiveChallan[] = ['gin' => $gin];
            }
            if ($response == 'Not Exist') {

                $notExistProductsReceiveChallan[] = ['gin' => $gin];
            }
        };
        $notExistProductsReceiveChallan = collect($notExistProductsReceiveChallan)->pluck('gin')->toArray();
        $notInStockProductsReceiveChallan = collect($notInStockProductsReceiveChallan)->pluck('gin')->toArray();
        Session::put('notExistProductsReceiveChallan', $notExistProductsReceiveChallan);
        Session::put('notInStockProductsReceiveChallan', $notInStockProductsReceiveChallan);
    }else{
        $keys = $validator->errors()->keys();
        $vals  = $validator->errors()->all();
        $errors = array_combine($keys,$vals);
       return response()->json(['errors'=>$errors],422);
    }

    } 

    public function getAllDetails()
    {  
        return response()->json([
            'notInStockProductsReceiveChallan' =>Session::get('notInStockProductsReceiveChallan'),
            'notExistProductsReceiveChallan'=> Session::get('notExistProductsReceiveChallan'),
            'validProducts'=> Session::get('receiveChallan'),
            'notInStockProductsCount'=> Session::has('notInStockProductsReceiveChallan') ?  count(Session::get('notInStockProductsReceiveChallan')) : 0,
            'notExistProductsCount'=> Session::has('notExistProductsReceiveChallan') ?  count(Session::get('notExistProductsReceiveChallan')) : 0,
            'validProductsCount'=> Session::has('receiveChallan') ?  count(Session::get('receiveChallan')) : 0,
        ]);
    }

    

    //Remove Product From Session
    public function delete($id)
    {
        $challan = Session::get('receiveChallan');
        if (isset($challan[$id]))
        {
            unset($challan[$id]);
            Session::put('receiveChallan', $challan);
        }
        return response()->json(['success' => true]);
    }

    public function save(Request $request)
    {       
        if(!Session::has('receiveChallan')){
            return response()->json(['validProducts'=>true]);
        }elseif(count(Session::get('receiveChallan')) == 0){
            return response()->json(['validProducts'=>true]);
        }

        $validator = Validator::make($request->all(),[
            'store' => 'required|not_in:0', 
            'account' => [ 
                function($attribute,$value,$fail){
                    if($value != Session::get('receiveChallanAccount')){
                        $user =  UserStore::find(Session::get('receiveChallanAccount'));
                        $fail('Please Select '.$user->name);
                    }
                },
                ],
        ]); 
        if($validator->passes()){

        $receiveChallan = Session::get('receiveChallan');
        $amount = collect($receiveChallan)->pluck('mrpAmount')->all();
        $total_amount = StoreHelper::countTotal($amount);

        $ledger = Ledger::create([
            'guard_id_from' => auth('store')->user()->guard_id,
            'guard_id_to' => auth('store')->user()->guard_id,
            'voucher_type' => '2',
            'voucher_number' => StoreHelper::getVoucherNumber($request->account,2),
            'account_id' =>  Helper::getUserStoreId($request->account),
            'from' => $request->account,
            'to' => auth('store')->user()->id,
            'comment' => $request->comment ?? "",
            'status' => '1'
        ]); 

        foreach (Session::get('receiveChallan') as $product) {  
            $ledgerDetail = LedgerDetail::where('id',$product['ledgerDetailId'])->first();

            LedgerDetail::create([
                'ledger_id' => $ledger->id,
                'product_stock_id' => $ledgerDetail->product_stock_id,
                'gin' => $ledgerDetail->gin,
                'weight' => $ledgerDetail->weight ?? 0,
                'product_unit_qty' => $ledgerDetail->product_unit_qty,
                'product_unit_rate' => $ledgerDetail->product_unit_rate,
                'ledger_status' => $ledgerDetail->ledger_status,

                'product_amount' => $ledgerDetail->product_amount,

                'discount_id' =>  $ledgerDetail->discount_id,
                'discount_amount' => $ledgerDetail->discount_amount,
                'discount_rate' =>  $ledgerDetail->discount_rate,

                'tax_type_id' =>  $ledgerDetail->tax_type_id,
                'tax_rate' =>  $ledgerDetail->tax_rate,
                'tax_amount' =>  $ledgerDetail->tax_amount,
                'ratti_rate_without_tax' => $ledgerDetail->ratti_rate_without_tax,
                'mrp_without_tax' =>  $ledgerDetail->mrp_without_tax,

                'total_amount' => $ledgerDetail->total_amount,
            ]); 
            LedgerDetail::where('id', LedgerDetail::where(['id'=>$ledgerDetail->id,'new_ledger_id'=>null])->first()->id)->update(['new_ledger_id' => $ledger->id]);
        }

        $ledgerId = $ledger->id;
        
        $productsAmount = $ledger->countProductAmount($ledgerId);
        $rattiRateWithoutTax = $ledger->countRattiRateWithoutTax($ledgerId);
        $mrpWithoutTax = $ledger->countMrpWithoutTax($ledgerId);
        $discount = $ledger->countTotalDiscount($ledgerId);
        $amountWithDiscount = $ledger->countAmountWithDiscount($ledgerId);
        $tax = $ledger->countTotalTax($ledgerId);
        $totalAmount = $ledger->countTotalAmount($ledgerId);
        $totalQty = $ledger->countTotalQty($ledgerId);
        
        Ledger::where('id',$ledgerId) ->update([
            'products_amount' => $productsAmount,
            'ratti_rate_without_tax' => $rattiRateWithoutTax,
            'mrp_without_tax' => $mrpWithoutTax,
            'discount_amount' => $discount,
            'amount_with_discount' => $amountWithDiscount,
            'tax_amount' => $tax,
            'total_amount' => $totalAmount,
            'qty_total' => $totalQty,
        ]);

        Session::forget('receiveChallan');
        Session::forget('notExistProductsReceiveChallan');
        Session::forget('notInStockProductsReceiveChallan');
        Session::forget('receiveChallanAccount');
        // return response()->json(['redirectUrl'=> route('receiveChallan.index')]);
        return response()->json(['redirectUrl'=> route('ledgerMedia.index',$ledger->id)]);
    }else{
        $keys = $validator->errors()->keys();
        $vals  = $validator->errors()->all();
        $errors = array_combine($keys,$vals);
       return response()->json(['errors'=>$errors],422);
    }
    }

    public function saveGin($gin,$accountId)
    {    
        $gin = $gin['gin'];
        $getGin = $this->isProductInStock($gin,$accountId);  
        if ($getGin == "Invalid") {
            return 'Not Exist';
        }   
        if ($getGin == false) { 
            return 'Not In Stock';
        }

        if($getGin->gin == $gin){ 
            $productStock = InvoiceDetailGradeProduct::where(['gin'=>$getGin->gin])->first() ?? false;
            $receiveChallanSession = Session::get('receiveChallan');
            if (!$receiveChallanSession) {
                return $this->setSessionEmptty($productStock,$getGin);
            }
            if (isset($receiveChallanSession[$getGin->id])) {
                return 'Product Already Added';
            } 
            $receiveChallanSession[$productStock->id] = [
                'id' => $productStock->id,
                'ledgerDetailId' => $getGin->id,
                'gin' => $productStock->gin,
                'product' => $productStock->product->name,
                'grade' => $productStock->productGrade->alias ?? '',
                'ratti' => $productStock->ratti->rati_standard ?? "",
                'productStockRatti' => $getGin->product_unit_qty,
                'rattiRate' => $getGin->product_unit_rate,
                'mrpAmount' => $getGin->product_amount,  
            ];
            // dd($receiveChallanSession);
            Session::put('receiveChallan', $receiveChallanSession); 
        }
    }
 
 

    public function isProductInStock($gin,$accountId)
    {  
        if(!InvoiceDetailGradeProduct::where('gin',$gin)->first() ?? false){
            return "Invalid";
        } 

        $authUser = UserStore::find($accountId); 
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            if( $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $gin, 'new_ledger_id' => null])
                      ->whereHas('ledger', function ($q) use ($authUser){
                        $q->where(['account_id' => $authUser->id, 'voucher_type'=>'1']);
                       })->first() ?? false ){
              return $ledgerStock;
            }
            elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q) use ($authUser) {
                                    $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                 return $ledgerStock;
            }else{
                return false;
            } 
        }else{
            $ledgerStock = LedgerDetail::with('ledger')
                         ->where(['gin' => $gin, 'new_ledger_id' => null])
                         ->whereHas('ledger', function ($q) use ($authUser) {
                            $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                             })->first() ?? false;
            return $ledgerStock;
        }
    }

    public function setSessionEmptty($productStock,$getGin)
    {
        // $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock);
    //    dd($getGin);
        $receiveChallanSession = [
            $productStock->id => [
                'id' => $productStock->id,
                'ledgerDetailId' => $getGin->id,
                'gin' => $productStock->gin,
                'product' => $productStock->product->name,
                'grade' => $productStock->productGrade->alias ?? '',
                'ratti' => $productStock->ratti->rati_standard ?? "",
                'productStockRatti' => $getGin->product_unit_qty,
                'rattiRate' => $getGin->product_unit_rate,
                'mrpAmount' => $getGin->product_amount, 
            ]
        ];
        // dd($receiveChallanSession);
        Session::put('receiveChallan', $receiveChallanSession); 
        return 'Success';
    }
 
      
  
}

