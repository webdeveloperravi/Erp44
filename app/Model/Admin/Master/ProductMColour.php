<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use App\Model\Guard\UserAdmin;
use App\Model\Admin\Master\MasterCreateUpdate;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMColour extends Model
{
	use SoftDeletes;
	public $fillable = ['color','status','alias','descr'];
    protected $table='product_m_colour';
    protected $softDelete=true;
    protected $dates = ['deleted_at'];

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }    
             

	public function category()
    {
        return $this->morphToMany('App\Model\Admin\Category', 'categoryables');
    }

	public function product(){

		return $this->BelongsToMany('App\Model\Admin\ProductType');
    }
    
    
    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','color_id','id');
    }

   

    
    

    
}
