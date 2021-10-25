<?php

namespace App\Http\Controllers\Store;

use Validator;
use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone; 
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Store\StorePurchaseOrderDetail;
use App\Model\Admin\Organization\StoreAddress;
use App\Model\Warehouse\InvoiceDetailGradeProduct;


class SaleOrderPrepareController extends Controller
{
    public function index($orderId)
    {
      $saleOrder = StorePurchaseOrder::with('purchaseOrderDetail','purchaseOrderDetail.product','purchaseOrderDetail.grade','purchaseOrderDetail.ratti')->where('id',$orderId)->first();
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
      return view('store.SaleOrderPrepare.index',compact('saleOrder','stores'));
    } 

    public function refreshSaleOrder($orderId){
        
        $saleOrder = StorePurchaseOrder::with('purchaseOrderDetail','purchaseOrderDetail.product','purchaseOrderDetail.grade','purchaseOrderDetail.ratti')->where('id',$orderId)->first(); 
        // dd($saleOrder);
        return response()->json(['saleOrder'=> $saleOrder]); 
    }
    
    public function getAccounts($accountId)
    { 
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
        $gins = collect($request->gins);
        $notInStockProductsPrepareChallan = [];
        $notExistProductsPrepareChallan = [];
        $notRequiredProductsPrepareChallan = [];
        $limitExceededProductsPrepareChallan = [];
        foreach ($gins as $gin) {
            $response = $this->saveGin($gin,$request->saleOrderId); 
            // dd($response);
            if ($response == 'Not In Stock') {
                $notInStockProductsPrepareChallan[] = ['gin' => $gin];
            }
            if ($response == 'Not Exist') {

                $notExistProductsPrepareChallan[] = ['gin' => $gin];
            }
            if ($response == 'Not Required') {

                $notRequiredProductsPrepareChallan[] = ['gin' => $gin];
            }
            if ($response == 'Limit Exceeded') {

                $limitExceededProductsPrepareChallan[] = ['gin' => $gin];
            }
            
        };
        $notExistProductsPrepareChallan = collect($notExistProductsPrepareChallan)->pluck('gin')->toArray();
        $notInStockProductsPrepareChallan = collect($notInStockProductsPrepareChallan)->pluck('gin')->toArray();
        $notRequiredProductsPrepareChallan = collect($notRequiredProductsPrepareChallan)->pluck('gin')->toArray();
        $limitExceededProductsPrepareChallan = collect($limitExceededProductsPrepareChallan)->pluck('gin')->toArray();
        Session::put('notExistProductsPrepareChallan', $notExistProductsPrepareChallan);
        Session::put('notInStockProductsPrepareChallan', $notInStockProductsPrepareChallan);
        Session::put('notRequiredProductsPrepareChallan', $notRequiredProductsPrepareChallan);
        Session::put('limitExceededProductsPrepareChallan', $limitExceededProductsPrepareChallan);
    } 

    public function getAllDetails()
    {  
        return response()->json([
            'notInStockProductsPrepareChallan' =>Session::get('notInStockProductsPrepareChallan'),
            'notExistProductsPrepareChallan'=> Session::get('notExistProductsPrepareChallan'),
            'notRequiredProductsPrepareChallan'=> Session::get('notRequiredProductsPrepareChallan'),
            'limitExceededProductsPrepareChallan'=> Session::get('limitExceededProductsPrepareChallan'),
            'validProducts'=> Session::get('prepareChallan'),
            
            'notInStockProductsCount'=> Session::has('notInStockProductsPrepareChallan') ?  count(Session::get('notInStockProductsPrepareChallan')) : 0,
            'notExistProductsCount'=> Session::has('notExistProductsPrepareChallan') ?  count(Session::get('notExistProductsPrepareChallan')) : 0,
            'notRequiredProductsCount'=> Session::has('notRequiredProductsPrepareChallan') ?  count(Session::get('notRequiredProductsPrepareChallan')) : 0,
            'limitExceededProductsCount'=> Session::has('limitExceededProductsPrepareChallan') ?  count(Session::get('limitExceededProductsPrepareChallan')) : 0,
            'validProductsCount'=> Session::has('prepareChallan') ?  count(Session::get('prepareChallan')) : 0,
        ]);
    }
    
    //Remove Product From Session
    public function delete(Request $request)
    {    
        $prepareChallan = Session::get('prepareChallan');
         
        
        if (isset($prepareChallan[$request->productId]))
        {
          $productStockGin = InvoiceDetailGradeProduct::with('product','productGrade','ratti')
                             ->where(['id' => $prepareChallan[$request->productId]['id']])
                             ->first() ?? null;  
          $storePurchaseOrderDetail = StorePurchaseOrderDetail::where([
            'store_purchase_order_id' => $request->saleOrderId,
            'product_id' => $productStockGin->product->id,
            'grade_id' => $productStockGin->productGrade->id,
            'ratti_id' => $productStockGin->ratti->id,
            ])->first() ?? null; 
        if($storePurchaseOrderDetail){
            $storePurchaseOrderDetail->update(['insert_qty' => $storePurchaseOrderDetail->insert_qty - 1]);

            unset($prepareChallan[$request->productId]);
            Session::put('prepareChallan', $prepareChallan);
        }
            return response()->json(['success' => true]);

        }

        $challan = Session::get('prepareChallan');
        if (isset($challan[$id]))
        {
            unset($challan[$id]);
            Session::put('prepareChallan', $challan);
        }
        return response()->json(['success' => true]);
    }

    
    public function save(Request $request)
    {       
        if(!Session::has('prepareChallan')){
            return response()->json(['validProducts'=>true]);
        }elseif(count(Session::get('prepareChallan')) == 0){
            return response()->json(['validProducts'=>true]);
        }
        
        $validator = Validator::make($request->all(),[
            'store' => 'required|not_in:0',
            'account' => 'required|not_in:0', 
        ]);
        if($validator->passes()){

        $prepareChallan = Session::get('prepareChallan'); 
        
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
            'created_by' => auth('store')->user()->id,
        ]);

        $result = Helper::getStoreId() == Helper::getUserStoreId($request->account) ? true : false;


        foreach (Session::get('prepareChallan') as  $product) { 

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

            StorePurchaseOrder::where('id',$request->saleOrderId)->update(['ledger_id'=>$ledger->id,'so_number'=> Helper::getSoNumber(StoreHelper::getStoreId())]); 
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

        Session::forget('prepareChallan');
        Session::forget('notExistProductsPrepareChallan');
        Session::forget('notInStockProductsPrepareChallan');
        Session::forget('notRequiredProductsPrepareChallan');
        Session::forget('limitExceededProductsPrepareChallan');
        return response()->json(['redirectUrl'=> route('ledgerMedia.index',$ledger->id)]);
    }else{
        $keys = $validator->errors()->keys();
        $vals  = $validator->errors()->all();
        $errors = array_combine($keys,$vals);
       return response()->json(['errors'=>$errors],422);
    }
    }

    public function saveGin($gin,$saleOrderId)
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
           

            $storePurchaseOrderDetail = StorePurchaseOrderDetail::where([
                'store_purchase_order_id' => $saleOrderId,
                'product_id' => $productStock->product->id,
                'grade_id' => $productStock->productGrade->id,
                'ratti_id' => $productStock->ratti->id,
            ])->first() ?? false;

            if($storePurchaseOrderDetail){

                $model = new StorePurchaseOrderDetail();
                $leftQty =  $model->getLeftQtyToAdd($storePurchaseOrderDetail->id);
                if($leftQty != 0){
                
                $prepareChallanSession = Session::get('prepareChallan');
                if (!$prepareChallanSession) {
                    return $this->setSessionEmptty($productStock,$storePurchaseOrderDetail);
                }
                if (isset($prepareChallanSession[$productStock->id])) {
                    return 'Product Already Added';
                } 
                    $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock);
                    $prepareChallanSession[$productStock->id] = [
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
                    Session::put('prepareChallan', $prepareChallanSession); 
                    $updateQty = $storePurchaseOrderDetail->insert_qty + 1;
                    $storePurchaseOrderDetail->update(['insert_qty' => $updateQty ]);  
                }else{
                     $prepareChallanSession = Session::get('prepareChallan'); 
                     
                    if (isset($prepareChallanSession[$productStock->id])) { 
                        return 'Product Already Added';
                    } 
                    
                    return 'Limit Exceeded';
                }
            
            }else{
                return 'Not Required';
            }
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

    public function setSessionEmptty($productStock,$storePurchaseOrderDetail)
    {
        $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock);

        $prepareChallanSession = [
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
        Session::put('prepareChallan', $prepareChallanSession);
        $updateQty = $storePurchaseOrderDetail->insert_qty + 1;
        $storePurchaseOrderDetail->update(['insert_qty' => $updateQty ]);
        return 'Success'; 
    }
   
    public function all()
    {
        $prepareChallans = Ledger::with(['userIssue', 'userReceipt'])->
                                 where('voucher_type','2')
                                ->where('from', auth('store')->user()->id)->latest()->get(); 
        return view('store.SaleChallan.all', compact('prepareChallans'));
    }

    public function prepareChallanDetail($id)
    {
       $parentStoreId = auth('store')->user()->parentStore->id ?? null; 
       if($parentStoreId == null)
       {
        $prepareChallan = Ledger::where(['account_id' => auth('store')->user()->id, 'id' => $id])->first();
       }
       else{
         $prepareChallan = Ledger::where(['from' => auth('store')->user()->id, 'id' => $id])->first();
       }

       return view('store.SaleChallan.prepareChallanDetail', compact('prepareChallan'));
    }

    public function saveProduct(request $request){ 
        
        $validator = Validator::make($request->all() , 
        [
            'gin' => 'required', 
            
        ]); 
        if ($validator->passes())
        {    
            $productStockGin =InvoiceDetailGradeProduct::with('product','productGrade','ratti')->where('gin',$request->gin)->first(); 
            $ledgerStock = $this->isProductInStock($request);
                if ($ledgerStock)
                {  
                    $storePurchaseOrderDetail = StorePurchaseOrderDetail::where([
                        'store_purchase_order_id' => $request->temp_number,
                        'product_id' => $productStockGin->product->id,
                        'grade_id' => $productStockGin->productGrade->id,
                        'ratti_id' => $productStockGin->ratti->id,
                    ])->first() ?? null; 
                if($storePurchaseOrderDetail){
                    $model = new StorePurchaseOrderDetail();
                    $leftQty =  $model->getLeftQtyToAdd($storePurchaseOrderDetail->id);
                    // if($storePurchaseOrderDetail->insert_qty <= $storePurchaseOrderDetail->confirmed_qty){
                    if($leftQty != 0){

                    
                    $challan = Session::get('prepareChallan');
                    if (!$challan)
                    {
                    $challan = [$ledgerStock->id => [
                            'gin' => $ledgerStock->gin, 
                            'productStockId' => $ledgerStock->product_stock_id, 
                            'product'  => $ledgerStock->productStock->product->name, 
                            'grade' => $ledgerStock->productStock->productGrade->grade, 
                            'ratti' => $ledgerStock->productStock->ratti->rati_standard, 
                            'productStockRatti' => $ledgerStock->product_unit_qty, 
                            'exactRattiRate' => $ledgerStock->product_unit_rate, 
                            'productAmount' => $ledgerStock->product_amount
                            ]];
                            Session::put('prepareChallan', $challan);
                            $updateQty = $storePurchaseOrderDetail->insert_qty + 1;
                            $storePurchaseOrderDetail->update(['insert_qty' => $updateQty ]);
                            return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
                    }
                    elseif (isset($challan[$ledgerStock->id]))
                    {
                        return response()->json(['exist' => true, 'msg' => 'Product Already Added']);
                    }
                    $challan[$ledgerStock->id] = ['gin' => $ledgerStock->gin, 
                                                'productStockId' => $ledgerStock->product_stock_id, 
                                                'product' => $ledgerStock->productStock->product->name, 
                                                'grade' => $ledgerStock->productStock->productGrade->grade,
                                                'ratti' => $ledgerStock->productStock->ratti->rati_standard, 
                                                'productStockRatti' => $ledgerStock->product_unit_qty, 
                                                'exactRattiRate' => $ledgerStock->product_unit_rate,
                                                'productAmount' => $ledgerStock->product_amount];
                    Session::put('prepareChallan', $challan);
                    $updateQty = $storePurchaseOrderDetail->insert_qty + 1;
                    $storePurchaseOrderDetail->update(['insert_qty' => $updateQty ]);
                    return response()->json(['success'=>true,'msg'=> "Product Inserted Success"]);
                }else{
                    return response()->json(['success'=>false,'msg'=> "Qty Limit Exceed"]);
                }
 
                   }
                 else{
                            return response()->json(['success'=>false, 'msg'=> " Product Requirement Not Exist "]);
                    }
                }else
                {
                return response()->json(['success' => false, 'msg' => "GIN Does Not Exists"]);
                }
     
    }else
    {
        $keys = $validator->errors()
            ->keys();
        $vals = $validator->errors()
            ->all();
        $errors = array_combine($keys, $vals);
        return response()->json(['errors' => $errors]);
    }
    }   
 

    public function deleteProduct(Request $request){
        
         $prepareChallan = Session::get('prepareChallan');
        
        if (isset($prepareChallan[$request->productId]))
        {
          $productStockGin = InvoiceDetailGradeProduct::with('product','productGrade','ratti')
                                ->where(['id'=>$prepareChallan[$request->productId]['productStockId']])->first() ?? null; 
          $storePurchaseOrderDetail = StorePurchaseOrderDetail::where([
            'store_purchase_order_id' => $request->temp_number,
            'product_id' => $productStockGin->product->id,
            'grade_id' => $productStockGin->productGrade->id,
            'ratti_id' => $productStockGin->ratti->id,
            ])->first() ?? null;
        if($storePurchaseOrderDetail){
            $storePurchaseOrderDetail->update(['insert_qty' => $storePurchaseOrderDetail->insert_qty - 1]);

            unset($prepareChallan[$request->productId]);
            Session::put('prepareChallan', $prepareChallan);
        }
            return response()->json(['success' => true]);

        }
    } 
 
  

    public function getProductExactAmount($weight,$amount){
         return  $amount =number_format(($weight*$amount),2);
    }
  

   public function getLeftQtyToAdd($detailId)
   {
    $model = new StorePurchaseOrderDetail();
    return  $model->getLeftQtyToAdd($detailId);
   }
    
}
