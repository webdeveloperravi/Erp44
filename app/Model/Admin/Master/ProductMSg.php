<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductMSg extends Model
{
	  use SoftDeletes;
      protected $fillable=['from', 'to', 'status','descr'];
      protected $table='product_m_sg';

      
    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','sg','id');
    }

}
