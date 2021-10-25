<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTaxProfile extends Model
{
   use SoftDeletes;
    protected $fillable = ['hsn_code', 'sgst', 'cgst', 'igst', 'status' ];
     protected $table="product_tax_profiles";

    

    public function product(){

    	return  $this->belongsTo('App\Model\Admin\Master\ProductCategory','hsn_code','hsn_code');
    }
}
