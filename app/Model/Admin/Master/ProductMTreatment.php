<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductMTreatment extends Model
{
    use SoftDeletes;
     protected $fillable=['treatment','description','status'];
     protected $table="product_m_treatments";

     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }
      

    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','treatment_id','id');
    }

}
