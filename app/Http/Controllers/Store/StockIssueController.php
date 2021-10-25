<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\DeliveryMode;
use App\Model\Store\StoreSaleOrder;
use App\Http\Controllers\Controller;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Support\Facades\Session;
use App\Model\Store\StoreManagerChallan;
use App\Model\Store\StoreSaleOrderDetail;
use App\Model\Store\StorePurchaseOrderDetail;
use App\Model\Warehouse\InvoiceDetailGradeProduct;


class StockIssueController extends Controller
{
   public function index($orderId){
       Session::put('purchaseOrderId',$orderId);
       return view('store.stock_issue.index');
   }

   public function create(){
       
      return view('store.stock_issue.create');
   }

   public function storeProduct(Request $request){
    
    $productStock = InvoiceDetailGradeProduct::with('grade')->where(['gin'=>$request->gin])->first();
    
    if(!empty($productStock)){

      $productExist =  $this->checkProductExistInPurchaseOrder($productStock);
      if($productExist){
         $saleOrder =  $this->getSaleOrder();
         if(!StoreSaleOrderDetail::where(['store_sale_order_id'=>$saleOrder->id,'product_stock_id'=> $productStock->id])->exists())
            $saleOrder->saleOrderDetails()->create([
                'product_stock_id' => $productStock->id,
                'rate' => $productStock->getProductPrice($productStock->id)
          ]);
          return response()->json(['success',true]);
      }else{
         return $productExist;
      }
    }else{
    return "Gin Not Found";
    }
   }

   public function allProductStock(){
       
       $saleOrder = StoreSaleOrder::where('store_purchase_order_id',Session::get('purchaseOrderId'))->first();
       $products = StoreSaleOrderDetail::where('store_sale_order_id',$saleOrder->id)->get();
       return view('store.stock_issue.allProductStock',compact('products'));
   }



   public function deleteIssueProduct($id){
            
    StoreSaleOrderDetail::findOrFail($id)->delete();
    return response()->json(['success',true]);
   }

   public function checkProductExistInPurchaseOrder($productStock){
        
        $purchaseOrderId = Session::get('purchaseOrderId');

        $productCategoryId = $productStock->grade->invoiceDetail->assign_product->id;
        $productId = $productStock->grade->invoiceDetail->product->id;
        $gradeId = $productStock->grade->id;
        $rattiId = $productStock->ratti->id;

 
    if(!StorePurchaseOrderDetail::where(['store_purchase_order_id'=> $purchaseOrderId,'product_category_id'=>$productCategoryId])->exists()){
        return response()->json(['error'=> 'Product Category Not Exist In Purchase Order']);
    }elseIf(!StorePurchaseOrderDetail::where(['store_purchase_order_id'=> $purchaseOrderId,'product_id'=>$productId])->exists()){
        return response()->json(['error'=> 'Product  Not Exist In Purchase Order']);
    }elseIf(!StorePurchaseOrderDetail::where(['store_purchase_order_id'=> $purchaseOrderId,'grade_id'=>$gradeId])->exists()){
        return response()->json(['error'=> 'Grade Not Exist In Purchase Order']);
    }elseIf(!StorePurchaseOrderDetail::where(['store_purchase_order_id'=> $purchaseOrderId,'ratti_id'=>$rattiId])->exists()){
        return response()->json(['error'=> 'Ratti Not Exist In Purchase Order']);
    }else{
        return true;
}
}

public function getSaleOrder(){
    
    $saleOrder = StoreSaleOrder::where('store_purchase_order_id',Session::get('purchaseOrderId'))->first();
 
    $purchaseOrder = StorePurchaseOrder::find(Session::get('purchaseOrderId'));
    if(!empty($saleOrder)){
        return $saleOrder;
    }else{
        $number = StoreSaleOrder::orderBy('id','desc')->first()->number ?? "122233";
         $saleOrder = new StoreSaleOrder;
         $saleOrder->store_purchase_order_id = $purchaseOrder->id;
         $saleOrder->number = $number+1 ;
         $saleOrder->seller_store_id = $purchaseOrder->seller_store_id;
         $saleOrder->buyer_store_id = $purchaseOrder->buyer_store_id;
         $saleOrder->save();
         return $saleOrder;
    }
}

public function prepareForDelivery(){

    $deliveryModes = DeliveryMode::all();
    return view('store.stock_issue.prepareForDelivery',compact('deliveryModes'));
}


public function getDeliveryManager($id){
   
    if($id==1){
           $users = UserStore::where(['org_id'=>auth('store')->user()->id,'type'=>'user'])->get();
           return view('store.stock_issue.delivery_users',compact('users'));
    }
  

}

public function createChallan(Request $request){
    
    $purchaseOrder = StorePurchaseOrder::find(Session::get('purchaseOrderId'));
     
    if($purchaseOrder)
    {
        $saleOrderId= StoreSaleOrder::where(['store_purchase_order_id'=>$purchaseOrder->id])->first()->id;
        $number = StoreManagerChallan::orderBy('id','desc')->first()->number ?? "122233";

          if(StoreManagerChallan::where(['store_sale_order_id'=>$purchaseOrder->id])->exists())
          {
            return response()->json(['success'=>'already Exist create challan']);
          }
          else{

        StoreManagerChallan::create([
           'number' => $number+1,
           'user_store_id' => $request->user_store_id,
           'store_sale_order_id' => $saleOrderId,
           'type' => 'sale_order_issue_challan',
            ]);
            return response()->json(['success'=>true]);
        }
    }
}
}





 