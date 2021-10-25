<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductMSpecie extends Model {

	use SoftDeletes;
    protected $fillable = ['species', 'alias','descr', 'status'];
    protected $table="product_m_species";

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }

    
    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','specie_id','id');
    }

}

