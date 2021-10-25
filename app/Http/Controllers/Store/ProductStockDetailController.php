<?php

namespace App\Http\Controllers\Store;

use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Store\LedgerDetail;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductStockDetailController extends Controller
{
    public function index(){
        return view('store.ProductStockDetail.index');
    }

    public function getTimeline($gin)
    {    
        $product = InvoiceDetailGradeProduct::where('gin',$gin)->first();
        $result = StoreHelper::getProductGradeRattiRattiRateMrpAmount2($product);
        if($result){
            $price = $result['mrpAmount'];
        }else{
            $price = "Error";
        }
        if($product){
            return view('store.ProductStockDetail.view',compact('product','price'));
        }else{
            return view('store.ProductStockDetail.viewEmpty',compact('product')); 
        } 
    }
}
