<?php

namespace App\Model\Store;

use App\Model\Guard\UserStore;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Store\StoreManagerChallan;
use App\Model\Store\StoreSaleOrderDetail;
use App\Model\Store\StoreSaleOrderChallan;
use App\Model\Store\StoreSaleOrderPayment;

class StoreSaleOrder extends Model
{
    protected $guarded =[''];

    public function saleOrderDetails(){
        return $this->hasMany(StoreSaleOrderDetail::class,'store_sale_order_id','id');
    }

    public function storePurchaseOrder(){
    	return $this->belongsTo(StorePurchaseOrder::class,'store_purchase_order_id','id');
    }

    public function managerChallan(){
        return $this->hasOne(StoreManagerChallan::class,'store_sale_order_id','id');
    }

    public function saleOrderChallan(){
        return $this->hasOne(StoreSaleOrderChallan::class,'store_sale_order_id','id');
    }

    public function getTotalPaymentAmount($orderId){
        
        $totalAmount = StoreSaleOrderDetail::where(['store_sale_order_id'=>$orderId,'delivered'=>'1'])->pluck('rate')->all();
        $totalAmount = collect($totalAmount);
        $totalAmount = $totalAmount->reduce(function ($carry, $item) {
          return $carry + $item;
       });  
        return $totalAmount;
    } 

    public function storeSaleOrderPayments(){
        return $this->hasMany(StoreSaleOrderPayment::class,'store_sale_order_id','id');
    }

    public function buyerStoreName(){
       
        return $this->belongsTo(UserStore::class,'buyer_store_id','id');

   }

    public function sellerStoreName(){
       
        return $this->belongsTo(UserStore::class,'seller_store_id','id');

   }

    

    
}

