<?php

namespace App\Model\Store;

use App\Model\Store\StoreSaleOrder;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Store\StoreManagerChallan;
use App\Model\Store\StoreSaleOrderChallanDetail;

class StoreSaleOrderChallan extends Model
{
    protected $guarded = [''];

    public function challanDetails(){
        return $this->hasMany(StoreSaleOrderChallanDetail::class,'store_sale_order_challan_id','id');
    }

    public function saleOrder(){
        return $this->belongsTo(StoreSaleOrder::class,'store_sale_order_id','id');
    }

    public function purchaseOrder(){
        return $this->belongsTo(StorePurchaseOrder::class,'store_purchase_order_id','id');
    }

    public function managerChallan(){
        return  $this->belongsTo(StoreManagerChallan::Class,'store_manager_challan_id','id');
    }
 
}
