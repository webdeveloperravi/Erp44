<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductMShape extends Model
{
     use SoftDeletes;

     protected $fillable = ['shape','alias','descr','status'];
     protected $table = "product_m_shapes";
    
     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }
 
     
    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','shape_id','id');
    }

      

}
