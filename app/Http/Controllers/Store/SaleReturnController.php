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
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

use Illuminate\Database\Eloquent\Builder;


class SaleReturnController extends Controller
{
    
    public function index()
    {   
        $managers = Helper::getManagersByTree(); 
        // $saleReturns = Ledger::with(['userIssue', 'userReceipt'])->
        //                          where('voucher_type','4')
        //                         ->where('from', auth('store')->user()->id)->latest()->get();
        return view('store.SaleReturn.index',compact('managers'));
    }
    
    public function all($userId){ 
         
        if($userId == 'all'){
        $authUser = UserStore::find(auth('store')->user()->id);
        if($authUser->type == 'lab' || $authUser->type == 'org'){
            $userId = StoreHelper::getStoreId();
            $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
            $saleReturns  = Ledger::with(['userIssue', 'userReceipt'])->where('to',$userId)->where('voucher_type','4')->orderBy('id','desc')->get(); 
        }elseif($authUser->type == 'user'){
            
         $managerIds = Helper::getSubRolesManagerIds();  
                                   
        $saleReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',array_merge($managerIds,[$authUser->id]))->where('voucher_type','4')->orderBy('id','desc')->get(); 
        }
        }else{

            $saleReturns = Ledger::with(['userIssue', 'userReceipt'])
                           ->where('voucher_type','4')
                           ->where('to',$userId)->latest()->get(); 
        }

        return view('store.SaleReturn.all',compact('saleReturns'));
    }

    public function view($id)
    {    
 
        $saleReturn = Ledger::where(['id' => $id])->first();
        
        return view('store.SaleReturn.view', compact('saleReturn'));
    }

    public function create()
    {   
        Session::forget('saleReturn');
        Session::forget('notExistProductsSaleReturn');
        Session::forget('notInStockProductsSaleReturn');
        Session::forget('saleReturnAccount');
        $myStoreId = \App\Helpers\StoreHelper::getStoreId();  
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $stores = UserStore::whereHas('addresses',function($q) use ($zoneCities){
          $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
          })->where('type','org')->orWhere('type','lab')
          ->with('headOfficeAddress.city:id,name')
          ->orderBy('company_name')
        ->get() 
          ;   
        return view('store.SaleReturn.create',compact('stores'));
    } 

    public function saveGins(Request $request)
    {      
        // Session::forget('saleReturnAccount');
        $validator = Validator::make($request->all(),[
            'store' => 'required|not_in:0', 
        ]);
        if($validator->passes()){
        if(Session::has('saleReturnAccount')){
            if(Session::get('saleReturnAccount') != $request->store){
                Session::forget('saleReturn');
                Session::forget('notExistProductsSaleReturn');
                Session::forget('notInStockProductsSaleReturn');
                Session::forget('saleReturnAccount');
            }
        }else{
            Session::put('saleReturnAccount',$request->store);
        }
        $gins = collect($request->gins);
        $notInStockProductsSaleReturn = [];
        $notExistProductsSaleReturn = [];
        foreach ($gins as $gin) {
            $response = $this->saveGin($gin,$request->store); 
            if ($response == 'Not In Stock') {
                $notInStockProductsSaleReturn[] = ['gin' => $gin];
            }
            if ($response == 'Not Exist') {

                $notExistProductsSaleReturn[] = ['gin' => $gin];
            }
        };
        $notExistProductsSaleReturn = collect($notExistProductsSaleReturn)->pluck('gin')->toArray();
        $notInStockProductsSaleReturn = collect($notInStockProductsSaleReturn)->pluck('gin')->toArray();
        Session::put('notExistProductsSaleReturn', $notExistProductsSaleReturn);
        Session::put('notInStockProductsSaleReturn', $notInStockProductsSaleReturn);
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
            'notInStockProductsSaleReturn' =>Session::get('notInStockProductsSaleReturn'),
            'notExistProductsSaleReturn'=> Session::get('notExistProductsSaleReturn'),
            'validProducts'=> Session::get('saleReturn'),
            'notInStockProductsCount'=> Session::has('notInStockProductsSaleReturn') ?  count(Session::get('notInStockProductsSaleReturn')) : 0,
            'notExistProductsCount'=> Session::has('notExistProductsSaleReturn') ?  count(Session::get('notExistProductsSaleReturn')) : 0,
            'validProductsCount'=> Session::has('saleReturn') ?  count(Session::get('saleReturn')) : 0,
        ]);
    }
    
    //Remove Product From Session
    public function delete($id)
    {
        $challan = Session::get('saleReturn');
        if (isset($challan[$id]))
        {
            unset($challan[$id]);
            Session::put('saleReturn', $challan);
        }
        return response()->json(['success' => true]);
    }

    public function save(Request $request)
    {        
        if(!Session::has('saleReturn')){
            return response()->json(['validProducts'=>true]);
        }elseif(count(Session::get('saleReturn')) == 0){
            return response()->json(['validProducts'=>true]);
        }

        $validator = Validator::make($request->all(),[ 
            'store' => [
                'required', 
                 function($attribute,$value,$fail){
                    if($value != Session::get('saleReturnAccount')){
                        $user =  UserStore::find(Session::get('saleReturnAccount'));
                        $fail('Please Select '.$user->name ?? "");
                    }
                },
                ],
        ]);  
        if($validator->passes()){
            $saleReturn = Session::get('saleReturn');
            $amount = collect($saleReturn)->pluck('mrpAmount')->all();
            $total_amount = StoreHelper::countTotal($amount);

            $ledger = Ledger::create([
                'guard_id_from' => auth('store')->user()->guard_id,
                'guard_id_to' => auth('store')->user()->guard_id,
                'voucher_type' => '4',
                'voucher_number' => StoreHelper::getVoucherNumber($request->store,4),
                'account_id' =>  Helper::getUserStoreId($request->store),
                'from' => $request->store,
                'to' => auth('store')->user()->id,
                'comment' => $request->comment ?? "",
                'status' => '1'
            ]);  

        foreach (Session::get('saleReturn') as $id => $product) {
            
            $ledgerDetail = LedgerDetail::where('id',$product['ledgerDetailId'])->first(); 
            LedgerDetail::create([
                'ledger_id' => $ledger->id,
                'product_stock_id' => $ledgerDetail->product_stock_id,
                'gin' => $ledgerDetail->gin,
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

                'total_amount' => $ledgerDetail->total_amount,
            ]);  
            
            LedgerDetail::where('id', LedgerDetail::where(['id'=>$ledgerDetail->id,'new_ledger_id'=>null])->first()->id)->update(['new_ledger_id' => $ledger->id]);
        }

        $ledgerId = $ledger->id;
        
        $totalQty = $ledger->countTotalQty($ledgerId);
        $discount = $ledger->countTotalDiscount($ledgerId);
        $tax = $ledger->countTotalTax($ledgerId);
        $productsAmount = $ledger->countProductAmount($ledgerId);
        $totalAmount = $ledger->countTotalAmount($ledgerId);
        
        Ledger::where('id',$ledgerId) ->update([
            'discount_amount' => $discount,
            'tax_amount' => $tax,
            'products_amount' => $productsAmount,
            'total_amount' => $totalAmount,
            'qty_total' => $totalQty,
        ]);
        Session::forget('saleReturn');
        Session::forget('notExistProductsSaleReturn');
        Session::forget('notInStockProductsSaleReturn');
        Session::forget('saleReturnAccount');
        return response()->json(['redirectUrl'=> route('saleReturn.index')]);
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
            $saleReturnSession = Session::get('saleReturn');
            if (!$saleReturnSession){
                return $this->setSessionEmptty($productStock,$getGin);
            }
            if (isset($saleReturnSession[$productStock->id])) {
                return 'Product Already Added';
            }

            $saleReturnSession[$productStock->id] = [
                'id' => $productStock->id,
                'ledgerDetailId' => $getGin->id,
                'gin' => $productStock->gin,
                'product' => $productStock->product->name,
                'grade' => $productStock->productGrade->alias ?? '',
                'ratti' => $productStock->ratti->rati_standard ?? "",
                'productStockRatti' => $getGin->product_unit_qty,
                'rattiRate' => $getGin->product_unit_rate,
                'mrpAmount' => $getGin->productAmount, 
            ];
            Session::put('saleReturn', $saleReturnSession);  
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
            if( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q) use ($authUser) {
                                    $q->where(['to' =>$authUser->id, 'voucher_type'=>'3']);
                                 })->first() ?? false){
                 return $ledgerStock;
            }else{
                return false;
            } 
        } 

         
    }

    public function setSessionEmptty($productStock,$getGin)
    { 

        $saleReturnSession = [
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
        Session::put('saleReturn', $saleReturnSession);
        return 'Success';
    }
 

  
    public function saleReturnDetail($id)
    {
       $parentStoreId = auth('store')->user()->parentStore->id ?? null; 
       if($parentStoreId == null)
       {
        $saleReturn = Ledger::where(['account_id' => auth('store')->user()->id, 'id' => $id])->first();
       }
       else{
         $saleReturn = Ledger::where(['from' => auth('store')->user()->id, 'id' => $id])->first();
       }

       return view('store.SaleReturn.saleReturnDetail', compact('saleReturn'));
    } 
     
    public function saleReturnAll(){
        
        $authUser = UserStore::find(auth('store')->user()->id);

        if($authUser->type == 'lab' || $authUser->type == 'org'){
           
            $userId = StoreHelper::getStoreId();
            $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
            $saleReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get();

        }elseif($authUser->type == 'user'){
            
         $managerIds = Helper::getSubRolesManagerIds();  
                                   
        $saleReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get(); 

        } 
        return view('store.SaleReturn.saleReturnAll.all',compact('saleReturns'));   
    
    } 

    public function printReport($ledgerId)
    { 
        $ledger = Ledger::where('id',$ledgerId)
        ->withCount(['ledgerDetails as product_unit_qty' => function(Builder $query){ 
            $query->select(DB::raw("SUM(product_unit_qty)"));
        }])
        ->withCount(['ledgerDetails as product_unit_rate' => function(Builder $query){ 
            $query->select(DB::raw("SUM(product_unit_rate)"));
        }])
        ->first();
        
        $ledgerDetails = LedgerDetail::query() 
            ->has('ledger')
            ->with(['ledger:id,voucher_number', 'productStock'])
            ->where(['ledger_id' => $ledgerId])
            ->orderBy('product_unit_qty')
            ->get(); 
            $taxes = LedgerDetail::query()
            // ->select('id', 'ledger_id', 'gin', 'product_stock_id', 'product_unit_qty', 'product_unit_rate', 'product_amount')
                ->has('ledger')
                ->with(['ledger:id,voucher_number', 'productStock'])
                ->where(['ledger_id' => $ledgerId])->distinct()->pluck('tax_rate'); 
                $type = 'single';
            return view('store.SaleReturn.printReportSingle',compact('ledger','ledgerDetails','taxes','type')); 
        }
        
         

}
