<?php

namespace App\Model\Front;

use Illuminate\Database\Eloquent\Model;

class OrderAddOn extends Model
{

    public $table = "order_add_ons";
    public $fillable = ['order_details_id', 'add_on_name', 'add_on_master_id', 'status'];


    function OrderDetail()
    {
        return $this->belongsTo(StorePurchaseOrderDetail::class, 'order_details_id', 'id');
    }
}
