<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMClarity extends Model
{
    use SoftDeletes;
    protected $fillable = ['clarity','alias','status','descr','parent_sort'];
    protected $table="product_m_clarities";

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }


    
    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','clarity_id','id');
    }

}
