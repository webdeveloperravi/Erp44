<?php

namespace App\Model\Store;

use App\Model\Guard\UserStore;
use App\Model\Admin\Master\Voucher;
use Illuminate\Database\Eloquent\Model;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class LedgerDetailTemp extends Model
{
    protected $guarded =[''];

    public function store()
    {
        return $this->belongsTo(UserStore::class,'store_id','id');
    }

    public function user()
    {
        return $this->belongsTo(UserStore::class,'user_id','id');
    }
    
    public function voucher()
    {
        return $this->belongsTo(Voucher::class,'voucher_type_id','id');
    }
    
    public function productStock()
    {
        return $this->belongsTo(InvoiceDetailGradeProduct::class,'product_stock_id','id');
    }
}
