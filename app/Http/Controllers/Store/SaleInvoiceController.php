<?php

namespace App\Http\Controllers\Store;

use Session;
use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use Illuminate\Support\Carbon;
use App\Model\Store\StoreZone; 
use App\Model\Store\LedgerDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

use App\Model\Admin\Organization\ZoneCity;
use App\Model\Warehouse\InvoiceDetailGradeProduct;


class SaleInvoiceController extends Controller
{
    public function index()
    {   
        $managers = Helper::getManagersByTree(); 
        return view('store.SaleInvoice.index',compact('managers'));
    }
    
    public function all($userId){ 
         
        if($userId == 'all'){
        $authUser = UserStore::find(auth('store')->user()->id);
        if($authUser->type == 'lab' || $authUser->type == 'org'){
            $userId = StoreHelper::getStoreId();
            $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
            $saleInvoices  = Ledger::with(['userIssue', 'userReceipt'])->where('account_id',$userId)->where('voucher_type','3')->orderBy('id','desc')->get(); 
        }elseif($authUser->type == 'user'){
            
         $managerIds = Helper::getSubRolesManagerIds();  
                                   
        $saleInvoices  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',array_merge($managerIds,[$authUser->id]))->where('voucher_type','3')->orderBy('id','desc')->get(); 
        }
        }else{

            $saleInvoices = Ledger::with(['userIssue', 'userReceipt'])
                           ->where('voucher_type','3')
                           ->where('from',$userId)->latest()->get(); 
        }

        return view('store.SaleInvoice.all',compact('saleInvoices'));
    }


    public function view($id)
    {
       $parentStoreId = auth('store')->user()->parentStore->id ?? null; 
       if($parentStoreId == null)
       {
        $saleInvoice = Ledger::where(['account_id' => auth('store')->user()->id, 'id' => $id])->first();
       }
       else{
         $saleInvoice = Ledger::where(['from' => auth('store')->user()->id, 'id' => $id])->first();
       }

       return view('store.SaleInvoice.view', compact('saleInvoice'));
    } 
    
    public function printReport($ledgerId,$type)
    { 
        $ledger = Ledger::where('id',$ledgerId)
        ->withCount(['ledgerDetails as product_unit_qty' => function(Builder $query){ 
            $query->select(DB::raw("SUM(product_unit_qty)"));
        }])
        ->withCount(['ledgerDetails as product_unit_rate' => function(Builder $query){ 
            $query->select(DB::raw("SUM(product_unit_rate)"));
        }])
        ->first();
        // dd($ledger);
        $ledgerDetails = LedgerDetail::query()
        // ->select('id', 'ledger_id', 'gin', 'product_stock_id', 'product_unit_qty', 'product_unit_rate', 'product_amount')
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
        if($type == 'single'){
            return view('store.SaleInvoice.printReportSingle',compact('ledger','ledgerDetails','taxes','type')); }
        
        if($type == 'group'){
            return view('store.SaleInvoice.printReportInGroup',compact('ledger','ledgerDetails','taxes','type'));
        }
    }

    public function create()
    {   
        Session::forget('saleInvoice');
        Session::forget('notExistProductsSaleInvoice');
        Session::forget('notInStockProductsSaleInvoice');
        
        $myStoreId = \App\Helpers\StoreHelper::getStoreId();  
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $stores = UserStore::whereHas('addresses',function($q) use ($zoneCities){
          $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
          })->where('type','org')->orWhere('type','lab')
          ->where('id','!=',auth('store')->user()->id)
          ->with('headOfficeAddress.city:id,name')
          ->orderBy('company_name')
        ->get() 
          ;   
        return view('store.SaleInvoice.create',compact('stores'));
    }

    public function getAccounts($accountId)
    { 
        $managers = UserStore::select('id','name')
                       ->where(['org_id' => $accountId, 'type' => 'user'])
                       ->orWhere('id',$accountId) 
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
        $gins = collect($request->gins);
        $notInStockProductsSaleInvoice = [];
        $notExistProductsSaleInvoice = [];
        foreach ($gins as $gin) {
            $response = $this->saveGin($gin); 
            if ($response == 'Not In Stock') {
                $notInStockProductsSaleInvoice[] = ['gin' => $gin];
            }
            if ($response == 'Not Exist') {

                $notExistProductsSaleInvoice[] = ['gin' => $gin];
            }
        };
        $notExistProductsSaleInvoice = collect($notExistProductsSaleInvoice)->pluck('gin')->toArray();
        $notInStockProductsSaleInvoice = collect($notInStockProductsSaleInvoice)->pluck('gin')->toArray();
        Session::put('notExistProductsSaleInvoice', $notExistProductsSaleInvoice);
        Session::put('notInStockProductsSaleInvoice', $notInStockProductsSaleInvoice);
    } 

    public function getAllDetails()
    {  
        return response()->json([
            'notInStockProductsSaleInvoice' =>Session::get('notInStockProductsSaleInvoice'),
            'notExistProductsSaleInvoice'=> Session::get('notExistProductsSaleInvoice'),
            'validProducts'=> Session::get('saleInvoice'),
            'notInStockProductsCount'=> Session::has('notInStockProductsSaleInvoice') ?  count(Session::get('notInStockProductsSaleInvoice')) : 0,
            'notExistProductsCount'=> Session::has('notExistProductsSaleInvoice') ?  count(Session::get('notExistProductsSaleInvoice')) : 0,
            'validProductsCount'=> Session::has('saleInvoice') ?  count(Session::get('saleInvoice')) : 0,
        ]);
    }

    //Remove Product From Session
    public function delete($id)
    {
        $challan = Session::get('saleInvoice');
        if (isset($challan[$id]))
        {
            unset($challan[$id]);
            Session::put('saleInvoice', $challan);
        }
        return response()->json(['success' => true]);
    }

    public function save(Request $request)
    {   
          
         
        //  dd($request->date);
        if(!Session::has('saleInvoice')){
            return response()->json(['validProducts'=>true]);
        }elseif(count(Session::get('saleInvoice')) == 0){
            return response()->json(['validProducts'=>true]);
        }

        $validator = Validator::make($request->all(),[
            'store' => 'required|not_in:0', 
            'store' => [
                'required',
                'not_in:0',
                // function($attribute,$value,$fail){
                //     if($value != Session::get('saleInvoiceAccount')){
                //         $user =  UserStore::find(Session::get('saleInvoiceAccount'));
                //         $fail('Please Select '.$user->name);
                //     }
                // },
                ],
        ]);
        if($validator->passes()){

        $saleInvoice = Session::get('saleInvoice');

        $ledger = Ledger::create([
            'guard_id_from' => auth('store')->user()->guard_id,
            'guard_id_to' => auth('store')->user()->guard_id,
            'voucher_type' => '3',
            'voucher_number' => StoreHelper::getVoucherNumber(auth('store')->user()->id,3),
            'account_id' =>  StoreHelper::getStoreId(),
            'from' => auth('store')->user()->id,
            'to' => $request->store,
            'comment' => $request->comment ?? "",
            'status' => '1',
            'created_at' => Carbon::parse($request->date)->format('Y-m-d H:i:s') ?? "",
        ]); 
         
        $result = Helper::getStoreId() == StoreHelper::getUserStoreId($request->store) ? true : false;
        foreach (Session::get('saleInvoice') as $id => $product) { 
            $discount =   UserStore::find(StoreHelper::getUserStoreId($request->store))->role->retailModel->discount;
            $finalAmounts = StoreHelper::getFinalAmounts($request->store,$product,$result); 
            $item = InvoiceDetailGradeProduct::find($product['id']);
            $itemName = $item->product->name.'-'.$item->productGrade->alias.'-'.$item->ratti->rati_standard.'+';
            LedgerDetail::create([
  
                'ledger_id' => $ledger->id,
                'product_stock_id' => $product['id'],
                'gin' => $product['gin'],
                'name' => $itemName ?? "",
                'weight' => $item->weight ?? "0",
                'product_unit_qty' => $product['productStockRatti'],
                'product_unit_rate' => $product['rattiRate'],
                'ledger_status' => 1,

                'product_amount' => $product['mrpAmount'], 

                'discount_id' =>  $result ? 0 : $discount->id,
                'discount_amount' => $finalAmounts['discountAmount'] ,
                'discount_rate' => $result ? 0 : $discount->rate,
                'amount_with_discount' => $finalAmounts['amountWithDiscount'],

                'tax_type_id' =>  $finalAmounts['taxTypeId'],
                'tax_rate' =>  $finalAmounts['taxRate'],
                'tax_amount' =>  $finalAmounts['taxAmount'],
                'ratti_rate_without_tax' =>  $finalAmounts['rattiRateWithoutTax'],
                'mrp_without_tax' =>  $finalAmounts['mrpWithoutTax'],

                'total_amount' => $finalAmounts['finalAmount'],
            ]);  
            LedgerDetail::where('id', LedgerDetail::where(['gin'=>$product['gin'],'new_ledger_id'=>null])->first()->id)->update(['new_ledger_id' => $ledger->id]);
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

        Session::forget('saleInvoice');
        Session::forget('notExistProductsSaleInvoice');
        Session::forget('notInStockProductsSaleInvoice');
        // return response()->json(['redirectUrl'=> route('saleInvoice')]);
        return response()->json(['redirectUrl'=> route('ledgerMedia.index',$ledger->id)]);
    }else{
        $keys = $validator->errors()->keys();
        $vals  = $validator->errors()->all();
        $errors = array_combine($keys,$vals);
       return response()->json(['errors'=>$errors],422);
    }
    }


    public function saveGin($gin)
    {   
        $gin = $gin['gin'];
        $getGin = $this->isProductInStock($gin);  
        if ($getGin == "Invalid") {
            return 'Not Exist';
        }   
        if ($getGin == false) { 
            return 'Not In Stock';
        }

        if($getGin->gin == $gin){
            $productStock = InvoiceDetailGradeProduct::query()
            ->with('productGrade:id,alias', 'product:id,name', 'ratti:id,rati_standard,rati_big')
            ->select('id', 'gin', 'product_id', 'product_category_id', 'grade_id', 'ratti_id', 'weight', 'in_stock')
            ->where(['gin' => $getGin->gin])
            ->first() ?? false;
            $saleInvoiceSession = Session::get('saleInvoice');
            if (!$saleInvoiceSession) {
                return $this->setSessionEmptty($productStock);
            }
            if (isset($saleInvoiceSession[$productStock->id])) {
                return 'Product Already Added';
            }
            $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock);
            $saleInvoiceSession[$productStock->id] = [
                'id' => $productStock->id,
                'gin' => $productStock->gin,
                'product' => $productStock->product->name,
                'grade' => $productStock->productGrade->alias ?? '',
                'ratti' => $productStock->ratti->rati_standard ?? "",
                'productStockRatti' => $productRate['productStockRatti'],
                'rattiRate' => $productRate['rattiRate'],
                'mrpAmount' => $productRate['mrpAmount'],
                'productStockId' => $productRate['productStockId'],

            ];
            Session::put('saleInvoice', $saleInvoiceSession); 
        }
    }
 
  

    public function isProductInStock($gin)
    {  
        if(!InvoiceDetailGradeProduct::where('gin',$gin)->first() ?? false){
            return "Invalid";
        } 

        $authUser = UserStore::find(auth('store')->user()->id); 
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
                                    $q->where(['to' =>$authUser->id])->whereIn('voucher_type',[2,4]);
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

    public function setSessionEmptty($productStock)
    {
        $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock);

        $saleInvoiceSession = [
            $productStock->id => [
                'id' => $productStock->id,
                'gin' => $productStock->gin,
                'product' => $productStock->product->name,
                'grade' => $productStock->productGrade->alias ?? '',
                'ratti' => $productStock->ratti->rati_standard ?? "",
                'productStockRatti' => $productRate['productStockRatti'],
                'rattiRate' => $productRate['rattiRate'],
                'mrpAmount' => $productRate['mrpAmount'],
                'productStockId' => $productRate['productStockId'],

            ]
        ];
        Session::put('saleInvoice', $saleInvoiceSession);
        return 'Success';
    }
 

    public function getUserStoreId($id){

        $authUser = UserStore::find($id); 
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
