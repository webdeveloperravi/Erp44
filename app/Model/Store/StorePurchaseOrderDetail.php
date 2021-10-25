<?php

namespace App\Model\Store;

use App\Model\Front\OrderAddOn;
use App\Model\Admin\Master\Product;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\ProductCategory;
use App\Model\Admin\Master\ProductMWeightRange;

class StorePurchaseOrderDetail extends Model
{
    protected $guarded = [''];

    public function purchaseOrder()
    {
        return $this->belongsTo(StorePurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function grade()
    {
        return $this->belongsTo(ProductMGrade::class, 'grade_id', 'id');
    }

    public function ratti()
    {
        return $this->belongsTo(ProductMWeightRange::class, 'ratti_id', 'id');
    }

    public function getLeftQtyToAdd($id)
    {
        $orderDetail = \App\Model\Store\StorePurchaseOrderDetail::find($id);
        return $orderDetail->confirmed_qty - $orderDetail->insert_qty;
    }

    function addOns()
    {
        return $this->hasMany(OrderAddOn::class, 'order_details_id', 'id');
    }
}
