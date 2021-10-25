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
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;   
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class SaleChallanController extends Controller
{
    public function index()
    {    
        $managers = Helper::getManagersByTree();
        return view('store.SaleChallan.index',compact('managers'));
    }

    public function all($userId){ 
         
        if($userId == 'all'){
        $authUser = UserStore::find(auth('store')->user()->id);
        if($authUser->type == 'lab' || $authUser->type == 'org'){
            $userId = StoreHelper::getStoreId();
            $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
            $saleChallans  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',array_merge($managerIds,[$authUser->id]))->where('voucher_type','2')->orderBy('id','desc')->get(); 
        }elseif($authUser->type == 'user'){
            
         $managerIds = Helper::getSubRolesManagerIds();  
                                   
        $saleChallans  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',array_merge($managerIds,[$authUser->id]))->where('voucher_type','2')->orderBy('id','desc')->get(); 
        }
        }else{

            $saleChallans = Ledger::with(['userIssue', 'userReceipt'])
                           ->where('voucher_type','2')
                           ->where('from',$userId)->latest()->get(); 
        }

        return view('store.SaleChallan.all',compact('saleChallans'));
    }

    public function view($id)
    {
       $parentStoreId = auth('store')->user()->parentStore->id ?? null; 
       if($parentStoreId == null)
       {
        $saleChallan = Ledger::where(['account_id' => auth('store')->user()->id, 'id' => $id])->first();
       }
       else{
         $saleChallan = Ledger::where(['from' => auth('store')->user()->id, 'id' => $id])->first();
       }
       return view('store.SaleChallan.view', compact('saleChallan'));
    }
    
    public function printReport($chllanId,$type)
    {
        $ledger = Ledger::find($chllanId); 
        $ledgerDetails = LedgerDetail::query()
        // ->select('id', 'ledger_id', 'gin', 'product_stock_id', 'product_unit_qty', 'product_unit_rate', 'product_amount')
            ->has('ledger')
            ->with(['ledger:id,voucher_number', 'productStock','productStock.product','productStock.productGrade'])
            ->where(['ledger_id' => $chllanId]) 
            ->get(); 
        return view('store.SaleChallan.printReport',compact('ledger','ledgerDetails','type'));
    }
    
    public function detailsPrint($ledgerId)
    {
        $ledger = Ledger::find($ledgerId); 
        $ledgerDetails = LedgerDetail::query()
        // ->select('id', 'ledger_id', 'gin', 'product_stock_id', 'product_unit_qty', 'product_unit_rate', 'product_amount')
            ->has('ledger')
            ->with(['ledger:id,voucher_number', 'productStock'])
            ->where(['ledger_id' => $ledgerId])
            ->orderBy('product_unit_qty')
            ->get();
        return view('store.SaleChallan.detailsPrint',compact('ledger','ledgerDetails'));
    }
    

    public function create()
    {   
        Session::forget('saleChallan');
        Session::forget('notExistProductsSaleChallan');
        Session::forget('notInStockProductsSaleChallan');
        
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
        return view('store.SaleChallan.create',compact('stores'));
    }
 
    
    public function getAccounts($accountId)
    { 
        $managers = UserStore::select('id','name')
                       ->where(['org_id' => $accountId, 'type' => 'user'])
                       ->orWhere('id',$accountId)
                    //    ->where('id','!=',auth('store')->user()->id)
                       ->orderBy('name')
                       ->get()
                       ->reject(function ($record) {
                       return $record->id == auth('store')->user()->id;
                    })
                    ;
        
        return response()->json(['accounts'=> $managers]); 
    }

    public function saveGins(Request $request)
    {        
        $gins = collect($request->gins);
        $notInStockProductsSaleChallan = [];
        $notExistProductsSaleChallan = [];
        foreach ($gins as $gin) {
            $response = $this->saveGin($gin); 
            if ($response == 'Not In Stock') {
                $notInStockProductsSaleChallan[] = ['gin' => $gin];
            }
            if ($response == 'Not Exist') {

                $notExistProductsSaleChallan[] = ['gin' => $gin];
            }
        };

        $notExistProductsSaleChallan = collect($notExistProductsSaleChallan)->pluck('gin')->toArray();
        $notInStockProductsSaleChallan = collect($notInStockProductsSaleChallan)->pluck('gin')->toArray();
        Session::put('notExistProductsSaleChallan', $notExistProductsSaleChallan);
        Session::put('notInStockProductsSaleChallan', $notInStockProductsSaleChallan);
    } 

    public function getAllDetails()
    {
        return response()->json([
            'notInStockProductsSaleChallan' =>Session::get('notInStockProductsSaleChallan'),
            'notExistProductsSaleChallan'=> Session::get('notExistProductsSaleChallan'),
            'validProducts'=> Session::get('saleChallan'), 

            'notInStockProductsCount'=> Session::has('notInStockProductsSaleChallan') ?  count(Session::get('notInStockProductsSaleChallan')) : 0,
            'notExistProductsCount'=> Session::has('notExistProductsSaleChallan') ?  count(Session::get('notExistProductsSaleChallan')) : 0,
            'validProductsCount'=> Session::has('saleChallan') ?  count(Session::get('saleChallan')) : 0,
        ]);
    }
    
    
    public function delete($id)
    {
        $challan = Session::get('saleChallan');
        if (isset($challan[$id]))
        {
            unset($challan[$id]);
            Session::put('saleChallan', $challan);
        }
        return response()->json(['success' => true]);
    }

    public function save(Request $request)
    {        
         
        if(!Session::has('saleChallan')){
            return response()->json(['validProducts'=>true]);
        }elseif(count(Session::get('saleChallan')) == 0){
            return response()->json(['validProducts'=>true]);
        }
        $validator = Validator::make($request->all(),[
            'store' => 'required|not_in:0',
            'account' => 'required|not_in:0', 
        ]);
        if($validator->passes()){

        $saleChallan = Session::get('saleChallan'); 

        $ledger = Ledger::create([
            'guard_id_from' => auth('store')->user()->guard_id,
            'guard_id_to' => auth('store')->user()->guard_id,
            'voucher_type' => '2',
            'voucher_number' => StoreHelper::getVoucherNumber(auth('store')->user()->id,2),
            'account_id' =>  StoreHelper::getStoreId(),
            'from' => auth('store')->user()->id,
            'to' => $request->account,
            'comment' => $request->comment ?? "",
            'status' => '1',
        ]);


        $result = Helper::getStoreId() == Helper::getUserStoreId($request->account) ? true : false;
          
        foreach (Session::get('saleChallan') as $product) {  
            $discount =   UserStore::find(Helper::getUserStoreId($request->account))->role->retailModel->discount;
            $finalAmounts = StoreHelper::getFinalAmounts($request->account,$product,$result); 

            LedgerDetail::create([

                'ledger_id' => $ledger->id,
                'product_stock_id' => $product['id'],
                'gin' => $product['gin'],
                'weight' => InvoiceDetailGradeProduct::find($product['id'])->weight ?? "0",
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

                'total_amount' => $finalAmounts['finalAmount']
            ]); 

            LedgerDetail::where('id', LedgerDetail::where(['gin'=>$product['gin'],'new_ledger_id'=>null])
                        ->first()->id)->update(['new_ledger_id' => $ledger->id]);
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

        Session::forget('saleChallan');
        Session::forget('notExistProductsSaleChallan');
        Session::forget('notInStockProductsSaleChallan');
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
             
            $saleChallanSession = Session::get('saleChallan');
            if (!$saleChallanSession) {
                return $this->setSessionEmptty($productStock);
            }
            if (isset($saleChallanSession[$productStock->id])) {
                return 'Product Already Added';
            }
            $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock); 
            $saleChallanSession[$productStock->id] = [
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
            Session::put('saleChallan', $saleChallanSession); 
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
                      ->whereHas('ledger', function ($q) {
                         $q->where(['account_id' =>auth('store')->user()->id, 'voucher_type'=>'1']);
                       })->first() ?? false ){
              return $ledgerStock;
            }
            elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q)  {
                                          $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                 return $ledgerStock;
            }else{
                return false;
            } 
        }else{
            $ledgerStock = LedgerDetail::with('ledger')
                         ->where(['gin' => $gin, 'new_ledger_id' => null])
                         ->whereHas('ledger', function ($q)  {
                                 $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'2']);
                             })->first() ?? false;
            return $ledgerStock;
        }
    }

    public function setSessionEmptty($productStock)
    {
        $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock); 

        $saleChallanSession = [
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
        Session::put('saleChallan', $saleChallanSession);
        return 'Success';
    }

    public function getDiscountRateId($storeId)
    {
        return UserStore::find(Helper::getStoreId($storeId))->role->retailModel->discount->id;
    }

 
 
}

