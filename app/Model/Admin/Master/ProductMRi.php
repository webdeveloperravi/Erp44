<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductMRi extends Model
{
	use SoftDeletes;
    protected $fillable = ['from', 'to','descr', 'status'];
    protected $table='product_m_ri'; 


    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }

         
    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','ri','id');
    }
}
