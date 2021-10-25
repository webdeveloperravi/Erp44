<?php

namespace App\Http\Controllers\Store;

use Validator;
use App\Helpers\Helper;
use App\Model\Store\Ledger;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Model\Store\DeliveryMode;
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
    public function prepareSaleChallan($orderId)
    {
      $saleOrder = $this->existOrder($orderId);
      return view('store.prepare_order.index',compact('saleOrder'));
    }

    public function existingPurchaseOrder($orderId){
        
       $saleOrder = $this->existOrder($orderId);
       return view('store.prepare_order.existingPurchaseOrder',compact('saleOrder'));
    }

   public function creatingSaleChallan($orderId) 
   {
      $saleOrder = $this->existOrder($orderId);
      $myStoreId = \App\Helpers\Helper::getStoreId(); 
      $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
      $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
      $accounts = UserStore::whereHas('addresses',function($q) use ($zoneCities){
        $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
        })->where('type','org')->orWhere('type','lab')
      ->get() 
        ; 
    return view('store.prepare_order.create',compact('saleOrder','accounts','orderId'));
   }

   public function existOrder($orderId)
   {
     $saleOrder = StorePurchaseOrder::find($orderId);

     return $saleOrder;
   }


    public function getManagerAccounts($accountId)
    {    
    $managers = UserStore::select('id','name')->where(['org_id' => $accountId, 'type' => 'user'])->orWhere('id',$accountId)->get(); 

    return view('store.prepare_order.delivery_users',compact('managers'));
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
                            'exactRatti' => $ledgerStock->product_unit_qty, 
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
                                                'exactRatti' => $ledgerStock->product_unit_qty, 
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

     

      public function isProductInStock(Request $request)
      {
        $authUser = UserStore::find(auth('store')->user()->id);
        if($authUser->type = 'org' || $authUser->type == 'lab')
        {
            if( $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $request->gin, 'new_ledger_id' => null])
                      ->whereHas('ledger', function ($q) {
                         $q->where(['account_id' =>auth('store')->user()->id, 'voucher_type'=>'1']);
                       })->first() ?? false ){
              return $ledgerStock;
            }
            elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $request->gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q)  {
                                          $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                 return $ledgerStock;
            } else
            {
                 return false;
            }
        } else {
            $ledgerStock = LedgerDetail::with('ledger')
                         ->where(['gin' => $request->gin, 'new_ledger_id' => null])
                         ->whereHas('ledger', function ($q)  {
                                 $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'2']);
                             })->first() ?? false;
            return $ledgerStock;
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

    public function getChallanProducts($orderId){
        
         $saleOrder =  $this->existOrder($orderId);
           $challanData = Session::get('prepareChallan');

        $arrayData = collect($challanData)->pluck('productAmount')
            ->all();

        $total_amount = $this->getTotalAmount($arrayData);
        $challanProducts = collect(Session::get('prepareChallan'));
       
        return view('store.prepare_order.challanDetail',compact('total_amount','saleOrder','challanProducts'));
    }

    
    public function prepareForDelivery(){

    $deliveryModes = DeliveryMode::all();
    return view('store.prepare_order.prepareForDelivery',compact('deliveryModes'));
    }


    public function getDeliveryManager($id){

        if($id==1){
            $users = UserStore::where(['org_id'=>auth('store')->user()->id,'type'=>'user'])->get();
            return view('store.prepare_order.delivery_users',compact('users'));
        }
    }

    public function createChallan(Request $request){
        
        $validator = Validator::make($request->all() , [ 
            'manager' => 'required|not_in:0',  
        ]);

    $challanData = Session::get('prepareChallan');
    $arrayData = collect($challanData)->pluck('productAmount')->all();
   
    if ($validator->passes())
    {
        $voucherTypeId ='2';
        $debitorVoucherNumber = $this->getSaleChallanVoucherNumber();
        $ledger = Ledger::create([
            'guard_id_from' => auth('store')->user()->guard_id,
            'guard_id_to' => auth('store')->user()->guard_id,
            'voucher_type' => $voucherTypeId,
            'voucher_number' => $debitorVoucherNumber,
            'account_id' =>  Helper::getStoreId(),
            'from' =>auth('store')->user()->id,
            'to' =>$request->manager,
            'qty_total' => count(Session::get('prepareChallan')) ,
            'amount_total' => $this->getTotalAmount($arrayData) ,
            'comment' => $request->comment, 'status' => '1',

             ]);
    }
    else
    {
        $keys = $validator->errors()
            ->keys();
        $vals = $validator->errors()
            ->all();
        $errors = array_combine($keys, $vals);
        return response()->json(['errors' => $errors]);
    }

     foreach (Session::get('prepareChallan') as $id => $product)
        {

            LedgerDetail::create(['ledger_id' => $ledger->id, 'product_stock_id' => $product['productStockId'], 'gin' => $product['gin'], 'product_unit_qty' => $product['exactRatti'], 'product_unit_rate' => $product['exactRattiRate'], 'product_amount' => $product['productAmount'], 'ledger_status' => 1

            ]);

            LedgerDetail::where(['id' => $id])->update(['new_ledger_id' => $ledger->id]);

        }

        StorePurchaseOrder::where('id',$request->temp_number)->update(['ledger_id'=>$ledger->id,'so_number'=> Helper::getSoNumber(Helper::getStoreId())]);
         
        Session::forget('prepareChallan');
        return response()
            ->json(['success' => true, 'msg' => "Challan Successfully Created.{{$debitorVoucherNumber}}", 'challanNumber' => $debitorVoucherNumber]);
 
    }

    public function getSaleChallanVoucherNumber(){
        $authUser = UserStore::find(auth('store')->user()->id);
     
         if($authUser->type == 'org' || $authUser->type == 'lab'){
      
       
            if($ledger = Ledger::where(['account_id' =>$authUser->id,'voucher_type' =>'2'])->latest()->first() ?? false)
            {
               return $ledger->voucher_number+1;
     
            }else{
               return 1001;
            }
         }else{
     
             if($ledger = Ledger::where(['account_id' =>$authUser->parentStore->id,'voucher_type' =>'2'])->latest()->first() ?? false)
             {
                  return $ledger->voucher_number+1;
             }else{
                 return 1001;
             }
         }
        }

    public function getProductExactAmount($weight,$amount){
         return  $amount =number_format(($weight*$amount),2);
    }
    
     public function getTotalAmount($amount){ 

       $collection = collect($amount);
        $total_amount = $collection->reduce(function ($carry, $item)
        {
            return $carry + $item;
        });

        return $total_amount;

   }
    
}
