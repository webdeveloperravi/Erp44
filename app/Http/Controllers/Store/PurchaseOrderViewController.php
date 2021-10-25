<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Store\StorePurchaseOrder;

class PurchaseOrderViewController extends Controller
{
   
   public function index($orderId){
      $order = StorePurchaseOrder::find($orderId);
      return view('store.PurchaseOrder.purchaseOrderView.index',compact('order'));
    }

   public function orderDetails($orderId)
    {
      $order = StorePurchaseOrder::find($orderId);
      return view('store.PurchaseOrder.purchaseOrderView.view',compact('order'));
   

    }


}
