<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMOrigin extends Model
{
     use SoftDeletes;

    protected $fillable = ['origin','alias','descr','origin_code','status'];
    protected $guarded =[''];
    protected $table="product_m_origins";
    
    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }


    
    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','origin_id','id');
    }

}
