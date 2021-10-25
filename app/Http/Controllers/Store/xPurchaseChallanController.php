<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Store\StoreSaleOrder;
use App\Http\Controllers\Controller;
use App\Model\Store\StorePurchaseOrder;
use App\Model\Store\StoreSaleOrderChallan;
use App\Model\Store\StorePurchaseOrderDetail;

class PurchaseChallanController extends Controller
{
    public function index()
    {
        return view('store.purchase_challan.index');
    }

    public function all()
    {
        // $saleOrderChallans = StoreSaleOrderChallan::with('saleOrder')->get();
        $ids = StoreSaleOrder::where('buyer_store_id',auth('store')->user()->id)->get()->pluck('id');
        // dd($ids);q
        $purchaseChallans = StoreSaleOrderChallan::whereIn('store_sale_order_id',$ids)->orderBy('id','desc')->get();
        // dd($saleOrderChallans[0]->saleOrder->saleOrderDetails);
        return view('store.purchase_challan.all', compact('purchaseChallans'));
    }

    public function view($id)
    {

        $purchaseChallan = StoreSaleOrderChallan::find($id);
        return view('store.purchase_challan.view', compact('purchaseChallan'));

    }

     
}
