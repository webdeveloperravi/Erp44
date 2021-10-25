<?php

namespace App\Model\Store;

use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use Illuminate\Database\Eloquent\Model;
use App\Model\Store\StoreSaleOrderChallan;
use App\Model\Store\StorePurchaseOrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorePurchaseOrder extends Model
{
    use SoftDeletes;
    protected $guarded = [''];

    public function purchaseOrderDetail()
    {
        return $this->hasMany(StorePurchaseOrderDetail::class, 'store_purchase_order_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(UserStore::class, 'seller_store_id', 'id');
    }

    public function buyerStoreName()
    {

        return $this->belongsTo(UserStore::class, 'buyer_store_id', 'id');
    }

    public function saleOrderChallan()
    {
        return $this->hasOne(StoreSaleOrderChallan::class, 'store_purchase_order_id', 'id');
    }

    public function ledgerDetails()
    {
        return $this->hasMany(LedgerDetail::class, 'temp_number', 'id');
    }

    public function getTotalPurchaseOrderQty($orderId)
    {

        $totalAmount = StorePurchaseOrderDetail::where(['store_purchase_order_id' => $orderId])->pluck('confirmed_qty')->all();
        $totalAmount = collect($totalAmount);
        $totalAmount = $totalAmount->reduce(function ($carry, $item) {
            return $carry + $item;
        });
        return $totalAmount;
    }

    public  function createChallanReady($orderId)
    {

        $confirmed_qty = $this->getConfirmedQty($orderId);
        $insert_qty = $this->getInsertedQty($orderId);
        if ($confirmed_qty == $insert_qty) {
            return true;
        } else {
            return false;
        }
    }

    public function getConfirmedQty($orderId)
    {
        $purchaseOrder = StorePurchaseOrder::find($orderId);
        $totalConfirmedQty = StorePurchaseOrderDetail::where(['store_purchase_order_id' => $purchaseOrder->id])->pluck('confirmed_qty');
        $totalConfirmedQty = collect($totalConfirmedQty);
        $totalConfirmedQty = $totalConfirmedQty->reduce(function ($carry, $item) {
            return $carry + $item;
        });
        return $totalConfirmedQty;
    }

    public function getInsertedQty($orderId)
    {
        $purchaseOrder = StorePurchaseOrder::find($orderId);
        $totalInsertedQty = StorePurchaseOrderDetail::where(['store_purchase_order_id' => $purchaseOrder->id])->pluck('insert_qty');
        $totalInsertedQty = collect($totalInsertedQty);
        $totalInsertedQty = $totalInsertedQty->reduce(function ($carry, $item) {
            return $carry + $item;
        });
        return $totalInsertedQty;
    }
}
